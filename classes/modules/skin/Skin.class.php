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
 * @author PSNet <light.feel@gmail.com>
 * 
 */

/**
 *
 *	Модуль работы с шаблонами движка
 *
*/

class PluginAdmin_ModuleSkin extends Module {
	
	const SKIN_PREVIEW_FILE = 'template_preview.png';
	const SKIN_XML_FILE = 'template_info.xml';
	
	const PREVIEW_SKIN_SESSION_PARAM_NAME = 'admin_preview_skin';
	
	
	protected $sSkinPath = null;
	protected $sLang = null;
	
	
	public function Init() {
		$this->sSkinPath = Config::Get('path.root.server') . '/templates/skin/';
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
	 * @param $sSkinXmlFile 			Имя шаблона
	 * @return null|SimpleXMLElement
	 */
	protected function GetSkinXmlData($sSkinXmlFile) {
		if ($oXml = @simplexml_load_file($sSkinXmlFile)) {
			$this->Xlang($oXml, 'name', $this->sLang);
			$this->Xlang($oXml, 'author', $this->sLang);
			$this->Xlang($oXml, 'description', $this->sLang);

			$oXml->homepage = $this->Text_Parser((string) $oXml->homepage);
			return $oXml;
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
			// имя шаблона
			$aSkinInfo ['name'] = $sSkinName;
			// информация о шаблоне
			$sSkinXmlFile = $this->GetSkinXmlFile($sSkinName);
			if (file_exists($sSkinXmlFile)) {
				$aSkinInfo ['info'] = $this->GetSkinXmlData($sSkinXmlFile);
			}
			// превью шаблона
			$sSkinPreviewFile = $this->GetSkinPreviewFile($sSkinName);
			if (file_exists($sSkinPreviewFile)) {
				$aSkinInfo ['preview'] = $this->GetWebPath($sSkinPreviewFile);
			}
			$aSkins [$sSkinName] = Engine::GetEntity('PluginAdmin_Skin', $aSkinInfo);
		}
		
		// сортировка
		if (isset($aFilter ['order']) and $aFilter ['order'] == 'name') {
			//natsort($aSkins);//todo:
		}

		/*
		 * отдельно вернуть данные текущего скина
		 * данный фильтр меняет формат возвращаемых данных
		 */
		if (isset($aFilter ['separate_current_skin'])) {
			$aCurrentSkinData = $aSkins [$this->GetOriginalSkinName()];
			if (isset($aFilter ['delete_current_skin_from_list'])) {
				unset($aSkins [$this->GetOriginalSkinName()]);
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
	 * @param SimpleXMLElement $oXml	XML узел
	 * @param string           $sProperty	Свойство, которое нужно вернуть
	 * @param string           $sLang	Название языка
	 */
	protected function Xlang($oXml, $sProperty, $sLang) {														// todo: copy from plugin module, todo: reuse from plugin?
		$sProperty=trim($sProperty);

		if (!count($data=$oXml->xpath("{$sProperty}/lang[@name='{$sLang}']"))) {
			$data=$oXml->xpath("{$sProperty}/lang[@name='default']");
		}
		$oXml->$sProperty->data=$this->Text_Parser(trim((string)array_shift($data)));
	}


	/**
	 * Возвращает путь веб-путь из серверного
	 *
	 * @param $sPath	серверный путь
	 * @return mixed	веб путь
	 */
	protected function GetWebPath($sPath) {
		return $this->Image_GetWebPath($sPath);																			// todo: in engine export this funcs into tools module
	}
	
	
	/*
	 *
	 *	Управление шаблонами
	 *
	*/


	/**
	 * Установить шаблон
	 *
	 * @param $sSkinName	шаблон
	 */
	public function ChangeSkin($sSkinName) {
		$aData = array(
			'view' => array(
				'skin' => $sSkinName
			)
		);
		$this->PluginAdmin_Settings_SaveConfigByKey(ModuleStorage::DEFAULT_KEY_NAME, $aData);
		$this->TurnOffPreviewSkin();
	}


	/**
	 * Установить шаблон для предпросмотра для текущего пользователя
	 *
	 * @param $sSkinName	шаблон
	 */
	public function PreviewSkin($sSkinName) {
		$this->Session_Set(self::PREVIEW_SKIN_SESSION_PARAM_NAME, $sSkinName);
	}


	/**
	 * Получить имя шаблона для предпросмтора(если есть) для текущего пользователя
	 *
	 * @return string
	 */
	public function GetPreviewSkinName() {
		return $this->Session_Get(self::PREVIEW_SKIN_SESSION_PARAM_NAME);
	}

	/**
	 * Установить шаблон для предпросмотра(если есть) текущему пользователю
	 */
	public function LoadPreviewTemplate() {
		if ($sPreviewSkin = $this->GetPreviewSkinName()) {
			Config::Set('view.skin_original', Config::Get('view.skin'));		// for receiving original skin name while previewing other template
			Config::Set('view.skin', $sPreviewSkin);
		}
	}


	/**
	 * Получить оригинальное имя шаблона(даже если включен режим предпросмотра другого шаблона)
	 *
	 * @return string
	 */
	public function GetOriginalSkinName() {
		if ($sPreviewSkin = $this->GetPreviewSkinName()) {
			return Config::Get('view.skin_original');
		}
		return Config::Get('view.skin');
	}
	
	
	/**
	 *	Выключить предпросмотр шаблона
	*/
	public function TurnOffPreviewSkin() {
		$this->Session_Drop(self::PREVIEW_SKIN_SESSION_PARAM_NAME);
		Config::Set('view.skin_original', null);
	}


}

?>