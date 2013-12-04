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
 *	Работа с плагинами
 */

class PluginAdmin_ActionAdmin_EventPlugins extends Event {

	/**
	 * Список плагинов
	 */
	public function EventPluginsList() {
		$this->Viewer_Assign('aPluginsInfo', $this->GetAllPluginLists());
		$this->SetTemplateAction('plugins');
	}


	/**
	 * Получить список плагинов по имени
	 * @return mixed
	 */
	private function GetAllPluginLists() {
		//return $this->Plugin_GetList(array('order' => 'name'));
		return $this->PluginAdmin_Plugins_GetPluginsList();
	}


	/**
	 * Активация/деактивация плагина
	 *
	 * @return mixed
	 */
	public function EventTogglePlugin() {
		$this->Security_ValidateSendForm();
		$sAction = getRequestStr('action');
		$sPlugin = getRequestStr('plugin');
		/*
		 * проверить тип действия над плагином
		 */
		if(!in_array($sAction, array('activate', 'deactivate'))) {
			$this->Message_AddError($this->Lang('errors.plugins.unknown_action'), $this->Lang_Get('error'), true);
			return $this->RedirectToReferer();
		}

		if($bResult = $this->Plugin_Toggle($sPlugin, $sAction)) {
			$this->Message_AddNotice('Ok', '', true);
		} else {
			/*
			 * проверить вывел ли ошибку сам плагин (метод активации класса плагина или движок из-за версии, например) или просто сообщить "ошибка"
			 */
			if (!$aMessages = $this->Message_GetErrorSession() or !count($aMessages)) {
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'), $this->Lang_Get('error'), true);
			}
		}
		$this->RedirectToReferer();
	}

}

?>