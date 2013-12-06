<?php
/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 * 
 * ------------------------------------------------------
 * 
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 * 
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * 
 * ------------------------------------------------------
 * 
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Serge Pustovit (PSNet) <light.feel@gmail.com>
 * 
 */

/*
 *
 * Модуль работы с установленными плагинами
 *
 */

class PluginAdmin_ModulePlugins extends Module {

	/*
	 * файлы xml-описания, лого и файла описания установки плагина, которые должны быть в корне папки плагина
	 */
	const LOGO_FILE = 'logo.png';
	const XML_FILE = 'plugin.xml';
	const INSTALL_TXT_FILE = 'install.txt';

	/*
	 * путь к плагинам
	 */
	protected $sPluginPath = null;

	/*
	 * текущий язык сайта (для получения данных с xml файлов)
	 */
	protected $sLang = null;


	public function Init() {
		$this->sPluginPath = Config::Get('path.application.plugins.server') . '/';
		$this->sLang = $this->Lang_GetLang();
	}


	/**
	 * Получить полный путь к файлу из корневой папки плагина по его имени
	 *
	 * @param $sPluginCode	код плагина
	 * @param $sFilename	имя файла
	 * @return string		полный путь с именем файла
	 */
	protected function GetPluginRootFolderFileFullPath($sPluginCode, $sFilename) {
		return $this->sPluginPath . $sPluginCode . '/' . $sFilename;
	}


	/**
	 * Полный путь к xml файлу плагина
	 *
	 * @param $sPluginCode	код плагина
	 * @return string 		полный путь к файлу и его имя
	 */
	protected function GetXmlFileFullPath($sPluginCode) {
		return $this->GetPluginRootFolderFileFullPath($sPluginCode, self::XML_FILE);
	}


	/**
	 * Полный путь к файлу лого плагина (изображение)
	 *
	 * @param $sPluginCode	код плагина
	 * @return string		полный путь к файлу и его имя
	 */
	protected function GetLogoFileFullPath($sPluginCode) {
		return $this->GetPluginRootFolderFileFullPath($sPluginCode, self::LOGO_FILE);
	}


	/**
	 * Полный путь к файлу описания установки плагина (текстовый файл)
	 *
	 * @param $sPluginCode	код плагина
	 * @return string		полный путь к файлу и его имя
	 */
	protected function GetInstallTxtFileFullPath($sPluginCode) {
		return $this->GetPluginRootFolderFileFullPath($sPluginCode, self::INSTALL_TXT_FILE);
	}


	/**
	 * Список кодов всех плагинов в каталоге плагинов
	 *
	 * @return array
	 */
	protected function GetAllPluginsCodes() {
		return array_map('basename', glob($this->sPluginPath . '*', GLOB_ONLYDIR));
	}


	/**
	 * Задать новые свойства "data" со значениями из атрибутов согласно настроек языка сайта
	 *
	 * @param $oXml			объект xml
	 * @return mixed		объект xml с новыми свойствами
	 */
	protected function SetXmlPropertiesForLang($oXml) {
		$this->Xlang($oXml, 'name', $this->sLang);
		$this->Xlang($oXml, 'author', $this->sLang);
		$this->Xlang($oXml, 'description', $this->sLang);

		/*
		 * пропустить прямо только через парсер текста т.к. другие методы парсинга (флеш, видео, тег кода и наследование через плагины) не нужны
		 */
		$oXml->homepage = $this->Text_JevixParser((string) $oXml->homepage);
		$oXml->settings = preg_replace('#{([^}]+)}#', Router::GetPath('$1'), $oXml->settings);
		return $oXml;
	}


	/**
	 * Получает информацию из xml файла плагина на основе основного языка сайта
	 *
	 * @param $sXmlFile 				Путь к xml файлу
	 * @return null|SimpleXMLElement
	 */
	protected function GetPluginXmlData($sXmlFile) {
		if ($oXml = @simplexml_load_file($sXmlFile)) {
			return $this->SetXmlPropertiesForLang($oXml);
		}
		return null;
	}


	/**
	 * Получить описание плагина из xml файла (если возможно)
	 *
	 * @param $sPluginCode				код плагина
	 * @return null|SimpleXMLElement	обьект данных
	 */
	protected function GetXmlObject($sPluginCode) {
		$sXmlFile = $this->GetXmlFileFullPath($sPluginCode);
		if (file_exists($sXmlFile)) {
			return $this->GetPluginXmlData($sXmlFile);
		}
		return null;
	}


	/**
	 * Получить полный путь к лого плагина
	 *
	 * @param $sPluginCode				код плагина
	 * @return string|null				путь к лого
	 */
	protected function GetLogoImage($sPluginCode){
		$sLogoFile = $this->GetLogoFileFullPath($sPluginCode);
		if (file_exists($sLogoFile)) {
			return $this->PluginAdmin_Tools_GetWebPath($sLogoFile);
		}
		/*
		 * получить лого из каталога
		 */
		return $this->PluginAdmin_Catalog_RequestDataForPluginLogo($sPluginCode);
	}


	/**
	 * Получает список плагинов по фильтру
	 *
	 * @param array $aFilter			фильтр
	 * @return array
	 */
	public function GetPluginsList($aFilter = array()) {
		$aPlugins = array();
		/*
		 * коды активных плагинов (так быстрее)
		 */
		$aActivePluginsCodes = $this->GetActivePlugins();
		/*
		 * коды всех плагинов
		 */
		$aAllPluginsCodes = $this->GetAllPluginsCodes();
		foreach($aAllPluginsCodes as $sPluginCode) {
			/*
			 * получить сущность плагина
			 */
			if (($oPlugin = $this->GetPluginByCode($sPluginCode, $aActivePluginsCodes, $aFilter, false, false)) === false) {
				continue;
			}
			/*
			 * ключ массива - имя папки (код) плагина
			 */
			$aPlugins[$sPluginCode] = $oPlugin;
		}
		return array(
			'collection' => $aPlugins,
			'count' => count($aPlugins),
			'count_all' => count($aAllPluginsCodes)
		);
	}


	/**
	 * Получить сущность плагина по коду (папке плагина)
	 *
	 * @param       $sPluginCode				код плагина
	 * @param array $aActivePluginsCodes		массив кодов активированных плагинов (для метода "active"), может быть пропущен
	 * @param array $aFilter					фильтр (для проверки активированности плагина и прерывания сбора дальнейшей информации, если не подходит для фильтра), может быть пропущен
	 * @param bool $bCheckPluginFolder			нужно ли проверять есть ли такой плагин в системе
	 * @param bool $bThrowExceptionOnWrongXml	бросать исключение если xml файл плагина поврежден
	 * @return bool|Entity						сущность плагина или false в случае ошибки или не попадание под условия фильтра
	 * @throws Exception
	 */
	public function GetPluginByCode($sPluginCode, $aActivePluginsCodes = array(), $aFilter = array(), $bCheckPluginFolder = true, $bThrowExceptionOnWrongXml = true) {
		/*
		 * нужно ли проверять есть ли такой плагин в системе
		 */
		if ($bCheckPluginFolder and !in_array($sPluginCode, $this->GetAllPluginsCodes())) return false;
		/*
		 * если список активных плагинов не был передан - получить коды активных плагинов
		 */
		$aActivePluginsCodes = empty($aActivePluginsCodes) ? $this->GetActivePlugins() : $aActivePluginsCodes;
		/*
		 * собрать данные по плагину
		 */
		$aPluginInfo = array();
		/*
		 * код плагина
		 */
		$aPluginInfo['code'] = $sPluginCode;
		/*
		 * включен ли
		 */
		$aPluginInfo['active'] = in_array($sPluginCode, $aActivePluginsCodes);
		/*
		 * проверка отбора только активных или неактивных плагинов
		 */
		if (isset($aFilter['active']) and $aPluginInfo['active'] !== $aFilter['active']) {
			/*
			 * по фильтру нужны только активные или неактивные плагины
			 */
			return false;
		}
		/*
		 * информация о плагине из xml данных
		 */
		if (!$aPluginInfo['xml'] = $this->GetXmlObject($sPluginCode)) {
			/*
			 * если xml файл плагина некорректен или поврежден - исключить из списка
			 */
			if ($bThrowExceptionOnWrongXml) {
				throw new Exception('Admin: error: plugin`s xml file is incorrect for plugin "' . $sPluginCode . '" in ' . __METHOD__);
			}
			return false;
		}
		/*
		 * лого плагина
		 */
		$aPluginInfo['logo'] = $this->GetLogoImage($sPluginCode);
		/*
		 * получить серверный путь к файлу install.txt
		 */
		$aPluginInfo['install_instructions_path'] = $this->CheckInstallTxtFile($sPluginCode);
		/*
		 * получить сущность плагина
		 */
		return Engine::GetEntity('PluginAdmin_Plugins', $aPluginInfo);
	}


	/**
	 * Возвращает список активированных плагинов в системе
	 *
	 * @return array
	 */
	protected function GetActivePlugins() {
		/*
		 * данные из файла PLUGINS.DAT
		 */
		$aPlugins = @file($this->sPluginPath . Config::Get('sys.plugins.activation_file'));
		$aPlugins = (is_array($aPlugins)) ? array_unique(array_map('trim', $aPlugins)) : array();
		return $aPlugins;
	}


	/**
	 * Проверить урл файла описания установки плагина
	 *
	 * @param $sPluginCode				код плагина
	 * @return null|SimpleXMLElement	обьект данных
	 */
	protected function CheckInstallTxtFile($sPluginCode) {
		$sInstallTxtFile = $this->GetInstallTxtFileFullPath($sPluginCode);
		if (file_exists($sInstallTxtFile)) {
			return $sInstallTxtFile;
		}
		return null;
	}


	/**
	 * Получить текст файла описания установки
	 *
	 * @param $sPluginCode				код плагина
	 * @return null|string
	 */
	public function GetInstallFileText($sPluginCode) {
		if ($sInstallTxtFilePath = $this->CheckInstallTxtFile($sPluginCode) and ($sText = @file_get_contents($sInstallTxtFilePath)) !== false) {
			return $sText;
		}
		return null;
	}




	/*
	 *
	 * todo: вынести этот метод в тулс и заменить из модуля шаблонов такой же метод аналог
	 *
	 */
	/**
	 * Получает значение параметра из XML на основе языковой разметки
	 *
	 * @param SimpleXMLElement $oXml		XML узел
	 * @param string						$sProperty	Свойство, которое нужно вернуть
	 * @param string						$sLang	Название языка
	 */
	protected function Xlang($oXml, $sProperty, $sLang) {								// todo: copy from plugin module, todo: reuse from plugin?
		$sProperty=trim($sProperty);

		if (!count($data=$oXml->xpath("{$sProperty}/lang[@name='{$sLang}']"))) {
			$data=$oXml->xpath("{$sProperty}/lang[@name='default']");
		}
		$oXml->$sProperty->data=$this->Text_Parser(trim((string)array_shift($data)));
	}

}

?>