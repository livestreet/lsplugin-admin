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
 *	Работа с шаблонами
 */

class PluginAdmin_ActionAdmin_EventSkin extends Event {

	/**
	 * Показать список шаблонов
	 *
	 * @return mixed
	 */
	public function EventSkins() {
		$this->SetTemplateAction('skin/list');

		/*
		 * получить список шаблонов и отдельно - текущий скин
		 */
		$aSkinsData = $this->PluginAdmin_Skin_GetSkinList(array(
			'separate_current_skin' => true,
			'delete_current_skin_from_list' => true
		));
		/*
		 * список шаблонов
		 */
		$aSkinList = $aSkinsData['skins'];
		/*
		 * текущий скин
		 */
		$oCurrentSkin = $aSkinsData['current'];

		/*
		 * проверка разрешенных действий и корректности имени шаблона
		 */
		if ($sAction = $this->getParam(1) and in_array($sAction, array('use', 'preview', 'turnoffpreview'))) {
			/*
			 * указан и есть ли такой шаблон
			 */
			if ($sSkinName = $this->getParam(2) and isset($aSkinList[$sSkinName])) {
				$this->Security_ValidateSendForm();
				/*
				 * выполнить нужную операцию
				 */
				$sMethodName = ucfirst($sAction) . 'Skin';
				$this->{$sMethodName}($sSkinName);

				return $this->RedirectToReferer();
			} else {
				$this->Message_AddError($this->Lang('errors.skin.unknown_skin'));
			}
		}
		$this->Viewer_Assign('aSkins', $aSkinList);
		$this->Viewer_Assign('oCurrentSkin', $oCurrentSkin);
	}


	/**
	 * Изменить тему активного шаблона
	 */
	public function EventChangeSkinTheme() {
		$this->Security_ValidateSendForm();
		/*
		 * получить имя нужной темы
		 */
		$sTheme = getRequestStr('theme');
		/*
		 * получить список шаблонов и отдельно - текущий скин
		 */
		$aSkinsData = $this->PluginAdmin_Skin_GetSkinList(array(
			'separate_current_skin' => true,
			'delete_current_skin_from_list' => true
		));
		/*
		 * получить описание темы из xml файла
		 */
		$oInfo = $aSkinsData['current']->getInfo();
		/*
		 * проверить есть ли такая тема текущего шаблона
		 */
		if ($oInfo and in_array($sTheme, $this->PluginAdmin_Skin_GetSkinThemesByInfo($oInfo))) {
			/*
			 * установить тему
			 */
			if ($this->PluginAdmin_Skin_ChangeTheme($sTheme)) {
				$this->Message_AddNotice($this->Lang('notices.theme_changed'), '', true);
			}
		}
		return $this->RedirectToReferer();
	}


	/**
	 * Включить шаблон
	 *
	 * @param $sSkinName	имя шаблона
	 */
	private function UseSkin($sSkinName) {
		if ($this->PluginAdmin_Skin_ChangeSkin($sSkinName)) {
			$this->Message_AddNotice($this->Lang('notices.template_changed'), '', true);
		}
	}


	/**
	 * Предпросмотр шаблона
	 *
	 * @param $sSkinName	имя шаблона
	 */
	private function PreviewSkin($sSkinName) {
		if ($this->PluginAdmin_Skin_PreviewSkin($sSkinName)) {
			$this->Message_AddNotice($this->Lang('notices.template_preview_set'), '', true);
		}
	}


	/**
	 * Выключить предпросмотр
	 *
	 * @param $sSkinName	имя шаблона
	 */
	private function TurnoffpreviewSkin($sSkinName) {
		$this->PluginAdmin_Skin_TurnOffPreviewSkin();
		$this->Message_AddNotice($this->Lang('notices.template_preview_turned_off'), '', true);
	}
	
}

?>