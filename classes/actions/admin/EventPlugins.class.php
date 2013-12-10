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
		$this->SetTemplateAction('plugins/list');
		/*
		 * проверить тип фильтра
		 */
		$aFilter = array();
		switch (getRequestStr('type')) {
			/*
			 * активные плагины
			 */
			case '':
			case 'activated':
				$aFilter['active'] = true;
				break;
			/*
			 * деактивированные
			 */
			case 'deactivated':
				$aFilter['active'] = false;
				break;
			/*
			 * весь список
			 */
			case 'all':
				break;
			/*
			 * с обновлениями
			 */
			case 'updates':

				// todo

				break;
			/*
			 * неизвестный тип
			 */
			default:
				$this->Message_AddError($this->Lang('errors.plugins.unknown_filter_type'), $this->Lang_Get('error'));
		}
		$this->GetUpdatesInfo();
		$this->Viewer_Assign('aPluginsInfo', $this->PluginAdmin_Plugins_GetPluginsList($aFilter));
	}


	/**
	 * Получить список плагинов у которых есть более новые версии в каталоге чем текущая установленная
	 */
	protected function GetUpdatesInfo() {
		$aUpdatesList = $this->PluginAdmin_Catalog_GetPluginUpdatesCached();
		switch (gettype($aUpdatesList)) {
			/*
			 * ошибка соединения или сервера
			 */
			case 'string':
				$this->Message_AddError($aUpdatesList);
				break;
			/*
			 * есть обновления
			 */
			case 'array':
				$this->Viewer_Assign('aPluginUpdates', $aUpdatesList);										// todo: wait for plugin codes in answer
				$this->Viewer_Assign('iPluginUpdates', count($aUpdatesList));
				break;
			/*
			 * обновлений нет
			 */
			default:
				$this->Viewer_Assign('iPluginUpdates', 0);
		}
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
		/*
		 * выполнить (де)активацию плагина
		 */
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


	/**
	 * Показать страницу с инструкциями по установке плагина
	 *
	 * @return mixed
	 */
	public function EventPluginInstructions() {
		$this->SetTemplateAction('plugins/show_install_txt');
		if (!$oPlugin = $this->PluginAdmin_Plugins_GetPluginByCode(getRequestStr('plugin'))) {
			return $this->Message_AddError($this->Lang('errors.plugins.plugin_not_found'), $this->Lang_Get('error'));
		}
		$this->Viewer_Assign('oPlugin', $oPlugin);
	}

}

?>