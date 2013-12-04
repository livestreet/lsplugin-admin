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
	 * файлы xml-описания и лого плагина, которые должны быть в корне папки плагина
	 */
	const LOGO_FILE = 'logo.png';
	const XML_FILE = 'plugin.xml';

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
	 * @return string 		Полный путь к файлу и его имя
	 */
	protected function GetXmlFileFullPath($sPluginCode) {
		return $this->GetPluginRootFolderFileFullPath($sPluginCode, self::XML_FILE);
	}


	/**
	 * Полный путь к файлу лого плагина (изображение)
	 *
	 * @param $sPluginCode	код плагина
	 * @return string		Полный путь к файлу и его имя
	 */
	protected function GetLogoFileFullPath($sPluginCode) {
		return $this->GetPluginRootFolderFileFullPath($sPluginCode, self::LOGO_FILE);
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
			return $this->GetWebPath($sLogoFile);
		}
		/*
		 * получить лого из каталога
		 */
		return $this->PluginAdmin_Catalog_RequestDataForPluginLogo($sPluginCode);
	}


	/**
	 * Получает список плагинов по фильтру
	 *
	 * @param array $aFilter			Фильтр
	 * @return array
	 */
	public function GetPluginsList($aFilter = array()) {
		$aPlugins = array();
		$aActivePluginsCodes = $this->GetActivePlugins();
		foreach($this->GetAllPluginsCodes() as $sPluginCode) {
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
			 * информация о плагине из xml данных
			 */
			$aPluginInfo['xml'] = $this->GetXmlObject($sPluginCode);
			/*
			 * лого плагина
			 */
			$aPluginInfo['logo'] = $this->GetLogoImage($sPluginCode);
			/*
			 * получить сущность плагина, ключ массива - имя папки плагина
			 */
			$aPlugins[$sPluginCode] = Engine::GetEntity('PluginAdmin_Plugins', $aPluginInfo);
		}

		/*
		 * todo: filter
		 */

		return $aPlugins;
	}


	/**
	 * Возвращает список активированных плагинов в системе
	 *
	 * @return array
	 */
	public function GetActivePlugins() {
		/**
		 * Читаем данные из файла PLUGINS.DAT
		 */
		$aPlugins = @file($this->sPluginPath . Config::Get('sys.plugins.activation_file'));
		$aPlugins = (is_array($aPlugins)) ? array_unique(array_map('trim', $aPlugins)) : array();
		return $aPlugins;
	}




	/*
	 *
	 * todo: вынести этот метод в тулс и заменить из модуля шаблонов такой же метод аналог
	 *
	 */
	/**
	 * Возвращает веб-путь из серверного
	 *
	 * @param $sPath	серверный путь
	 * @return mixed	веб путь
	 */
	protected function GetWebPath($sPath) {
		return $this->Image_GetWebPath($sPath);											// todo: in engine export this funcs into tools module
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