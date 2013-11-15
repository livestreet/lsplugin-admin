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

/**
 *
 *	Модуль работы с шаблонами движка
 *
*/

class PluginAdmin_ModuleSkin extends Module {

	/*
	 * файлы описания и превью шаблона, которые должны быть в корне папки шаблона
	 */
	const SKIN_PREVIEW_FILE = 'template_preview.png';
	const SKIN_XML_FILE = 'template_info.xml';

	/*
	 * ключ сессии, в котором хранится имя шаблона для предпросмотра
	 */
	const PREVIEW_SKIN_SESSION_PARAM_NAME = 'admin_preview_skin';
	
	/*
	 * путь к шаблонам в системе
	 */
	protected $sSkinPath = null;

	/*
	 * текущий язык сайта (для получения данных с описаний шаблонов)
	 */
	protected $sLang = null;
	
	
	public function Init() {
		$this->sSkinPath = Config::Get('path.application.server') . '/frontend/skin/';
		$this->sLang = $this->Lang_GetLang();
	}


	/**
	 * Полный путь к xml файлу для скина
	 *
	 * @param $sSkinName	Имя шаблона
	 * @return string 		Полный путь к файлу и его имя
	 */
	protected function GetSkinXmlFile($sSkinName) {
		return $this->sSkinPath . $sSkinName . '/' . self::SKIN_XML_FILE;
	}


	/**
	 * Полный путь к файлу превью шаблона (изображение)
	 *
	 * @param $sSkinName	Имя шаблона
	 * @return string		Полный путь к файлу и его имя
	 */
	protected function GetSkinPreviewFile($sSkinName) {
		return $this->sSkinPath . $sSkinName . '/' . self::SKIN_PREVIEW_FILE;
	}


	/**
	 * Список имен всех шаблонов
	 *
	 * @return array
	 */
	protected function GetSkinNames() {
		return array_map('basename', glob($this->sSkinPath . '*', GLOB_ONLYDIR));
	}


	/**
	 * Получает информацию из файла шаблона на основе основного языка сайта
	 *
	 * @param $sSkinXmlFile 			Имя шаблона
	 * @return null|SimpleXMLElement
	 */
	protected function GetSkinXmlData($sSkinXmlFile) {
		if ($oXml = @simplexml_load_file($sSkinXmlFile)) {
			/*
			 * задать новые свойства "data" со значениями атрибутов согласно настроек языка сайта
			 */
			$this->Xlang($oXml, 'name', $this->sLang);
			$this->Xlang($oXml, 'author', $this->sLang);
			$this->Xlang($oXml, 'description', $this->sLang);

			$oXml->homepage = $this->Text_Parser((string) $oXml->homepage);
			if ($oXml->themes) {
				foreach ($oXml->themes->children() as $oTheme) {
					$this->Xlang($oTheme, 'description', $this->sLang);
				}
			}
			return $oXml;
		}
		return null;
	}


	/**
	 * Получить описание шаблона из xml файла (если возможно)
	 * 
	 * @param $sSkinName				имя шаблона
	 * @return null|SimpleXMLElement	обьект данных
	 */
	protected function GetSkinXmlObject($sSkinName) {
		$sSkinXmlFile = $this->GetSkinXmlFile($sSkinName);
		if (file_exists($sSkinXmlFile)) {
			return $this->GetSkinXmlData($sSkinXmlFile);
		}
		return null;
	}


	/**
	 * Получить полный путь к изображению превью шаблона
	 * 
	 * @param $sSkinName				имя шаблона
	 * @return string|null				путь к изображению
	 */
	protected function GetSkinPreviewImage($sSkinName){
		$sSkinPreviewFile = $this->GetSkinPreviewFile($sSkinName);
		if (file_exists($sSkinPreviewFile)) {
			return $this->GetWebPath($sSkinPreviewFile);
		}
		return null;
	}
	


	/**
	 * Получает список шаблонов
	 *
	 * @param array $aFilter	Фильтр
	 * @return array
	 */
	public function GetSkinList($aFilter = array()) {
		$aSkins = array();
		foreach($this->GetSkinNames() as $sSkinName) {
			$aSkinInfo = array();
			/*
			 * имя шаблона
			 */
			$aSkinInfo['name'] = $sSkinName;
			/*
			 * информация о шаблоне
			 */
			$aSkinInfo['info'] = $this->GetSkinXmlObject($sSkinName);
			/*
			 * превью шаблона
			 */
			$aSkinInfo['preview'] = $this->GetSkinPreviewImage($sSkinName);
			/*
			 * получить обьект шаблона, ключ массива - имя папки шаблона
			 */
			$aSkins[$sSkinName] = Engine::GetEntity('PluginAdmin_Skin', $aSkinInfo);
		}
		
		/*
		 * сортировка списка шаблонов
		 */
		if (isset($aFilter['order']) and $aFilter['order'] == 'name') {
			//natsort($aSkins);//todo:
		}

		/*
		 * фильтр: отдельно вернуть данные текущего скина
		 * tip: фильтр меняет формат возвращаемых данных
		 */
		if (isset($aFilter['separate_current_skin'])) {
			$aCurrentSkinData = $aSkins[$this->GetOriginalSkinName()];
			if (isset($aFilter['delete_current_skin_from_list'])) {
				unset($aSkins[$this->GetOriginalSkinName()]);
			}
			return array(
				'skins' => $aSkins,
				'current' => $aCurrentSkinData
			);
		}
		return $aSkins;
	}
	
	
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


	/**
	 * Возвращает веб-путь из серверного
	 *
	 * @param $sPath	серверный путь
	 * @return mixed	веб путь
	 */
	protected function GetWebPath($sPath) {
		return $this->Image_GetWebPath($sPath);											// todo: in engine export this funcs into tools module
	}


	/**
	 *
	 * Управление шаблонами
	 *
	 */


	/**
	 * Проверяет зависимости шаблонов (версия движка и необходимые активированные плагины)
	 *
	 * @param $sSkinName	имя шаблона
	 * @return bool
	 */
	protected function CheckSkinDependencies($sSkinName) {
		/*
		 * если нет файла описания шаблона - просто нечего сверять
		 */
		if (!$oXml = $this->GetSkinXmlObject($sSkinName)) return true;
		/*
		 * проверить совместимость с версией LS
		 */
		if (defined('LS_VERSION') and version_compare(LS_VERSION, (string) $oXml->requires->livestreet, '<')) {
			$this->Message_AddError(
				$this->Lang_Get('plugin.admin.errors.skin.activation_version_error', array('version'=>$oXml->requires->livestreet)),
				$this->Lang_Get('error'),
				true
			);
			return false;
		}
		/*
		 * проверить наличие активированных необходимых плагинов
		 */
		if($oXml->requires->plugins) {
			$aActivePlugins = $this->Plugin_GetActivePlugins();
			$iConflict = 0;
			foreach ($oXml->requires->plugins->children() as $sReqPlugin) {
				if (!in_array($sReqPlugin,$aActivePlugins)) {
					$iConflict++;
					$this->Message_AddError(
						$this->Lang_Get('plugin.admin.errors.skin.activation_requires_error', array('plugin'=>func_camelize($sReqPlugin))),
						$this->Lang_Get('error'),
						true
					);
				}
			}
			if ($iConflict) return false;
		}

		return true;
	}


	/**
	 * Включить новый шаблон
	 *
	 * @param $sSkinName	шаблон
	 * @return bool
	 */
	public function ChangeSkin($sSkinName) {
		/*
		 * проверить зависимости
		 */
		if (!$this->CheckSkinDependencies($sSkinName)) {
			return false;
		}
		/*
		 * установить шаблон
		 */
		$aData = array(
			'view' => array(
				'skin' => $sSkinName,
				'theme' => null
			)
		);
		$this->PluginAdmin_Settings_SaveConfigByKey(ModuleStorage::DEFAULT_KEY_NAME, $aData);
		/*
		 * выключить превью
		 */
		$this->TurnOffPreviewSkin();
		return true;
	}


	/**
	 * Задать значение шаблона для предпросмотра для текущего пользователя
	 *
	 * @param $sSkinName	шаблон
	 * @return bool
	 */
	public function PreviewSkin($sSkinName) {
		/*
		 * проверить зависимости
		 */
		if (!$this->CheckSkinDependencies($sSkinName)) {
			return false;
		}
		$this->Session_Set(self::PREVIEW_SKIN_SESSION_PARAM_NAME, $sSkinName);
		return true;
	}


	/**
	 * Получить имя шаблона для предпросмотра (если есть) для текущего пользователя
	 *
	 * @return string
	 */
	public function GetPreviewSkinName() {
		return $this->Session_Get(self::PREVIEW_SKIN_SESSION_PARAM_NAME);
	}


	/**
	 * Включить шаблон для предпросмотра (если есть) текущему пользователю
	 */
	public function LoadPreviewTemplate() {
		if ($sPreviewSkin = $this->GetPreviewSkinName()) {
			/*
			 * сохранить оригинальное значение шаблона чтобы получить его при предпросмотре другого шаблона
			 */
			Config::Set('view.skin_original', Config::Get('view.skin'));
			Config::Set('view.skin', $sPreviewSkin);
		}
	}


	/**
	 * Получить оригинальное имя шаблона (даже если включен режим предпросмотра другого шаблона)
	 *
	 * @return string
	 */
	public function GetOriginalSkinName() {
		if ($this->GetPreviewSkinName()) {
			return Config::Get('view.skin_original');
		}
		return Config::Get('view.skin');
	}
	
	
	/**
	 * Выключить предпросмотр шаблона
	 */
	public function TurnOffPreviewSkin() {
		$this->Session_Drop(self::PREVIEW_SKIN_SESSION_PARAM_NAME);
		Config::Set('view.skin_original', null);
	}


	/**
	 * Получить список имен тем шаблона из его информации (из xml файла)
	 *
	 * @param $oInfo
	 * @return array
	 */
	public function GetSkinThemesByInfo($oInfo) {
		if (!is_object($oInfo)) return array();
		$aThemes = array();
		foreach($oInfo->themes->children() as $oTheme) {
			$aThemes[] = $oTheme->value;
		}
		return $aThemes;
	}


	/**
	 * Установить тему шаблона
	 *
	 * @param $sTheme	имя темы шаблона
	 * @return bool
	 */
	public function ChangeTheme($sTheme) {
		/*
		 * установить тему
		 */
		$aData = array(
			'view' => array(
				'theme' => $sTheme
			)
		);
		$this->PluginAdmin_Settings_SaveConfigByKey(ModuleStorage::DEFAULT_KEY_NAME, $aData);
		/*
		 * выключить превью
		 */
		$this->TurnOffPreviewSkin();
		return true;
	}


}

?>