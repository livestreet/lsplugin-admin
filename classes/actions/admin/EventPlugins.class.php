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
 * Работа с плагинами
 *
 */

class PluginAdmin_ActionAdmin_EventPlugins extends Event {


	/**
	 * Список плагинов
	 */
	public function EventPluginsList() {
		$this->SetTemplateAction('plugins/list');
		/*
		 * получить информацию по обновлениям плагинов
		 */
		$aUpdatesInfo = $this->PluginAdmin_Catalog_GetUpdatesInfo();
		/*
		 * проверить тип фильтра
		 */
		$aPluginsInfo = array();
		switch (getRequestStr('type')) {
			/*
			 * активные плагины
			 */
			case '':
			case 'activated':
				$aPluginsInfo = $this->PluginAdmin_Plugins_GetPluginsList(array('active' => true));
				break;
			/*
			 * деактивированные
			 */
			case 'deactivated':
				$aPluginsInfo = $this->PluginAdmin_Plugins_GetPluginsList(array('active' => false));
				break;
			/*
			 * весь список
			 */
			case 'all':
				$aPluginsInfo = $this->PluginAdmin_Plugins_GetPluginsList();
				break;
			/*
			 * с обновлениями
			 */
			case 'updates':
				$aPluginsInfo = $this->PluginAdmin_Plugins_GetPluginsList(array('plugins_codes' => is_array($aUpdatesInfo) ? array_keys($aUpdatesInfo) : array()));
				break;
			/*
			 * неизвестный тип
			 */
			default:
				$this->Message_AddError($this->Lang('errors.plugins.unknown_filter_type'), $this->Lang_Get('error'));
		}

		$this->Viewer_Assign('aPluginsInfo', $aPluginsInfo);
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
		$this->SetTemplateAction('plugins/instructions');
		if (!$oPlugin = $this->PluginAdmin_Plugins_GetPluginByCode(getRequestStr('plugin'))) {
			return $this->Message_AddError($this->Lang('errors.plugins.plugin_not_found'), $this->Lang_Get('error'));
		}
		$this->Viewer_Assign('oPlugin', $oPlugin);
	}


	/**
	 * Установка плагинов (каталог)
	 *
	 * @return mixed
	 */
	public function EventPluginsInstall() {
		$this->SetTemplateAction('plugins/install');
		/*
		 * тип плагинов (все, платные, бесплатные)
		 */
		$sType = $this->GetDataFromFilter('type');
		/*
		 * если сортировка не указана - использовать сортировку каталога по-умолчанию
		 */
		if (!$sOrder = $this->GetDataFromFilter('order')) {
			$sOrder = Config::Get('plugin.admin.catalog.remote.plugins.default_sorting');
		}

		$this->SetPagingForApi();
		/*
		 * передать весь фильтр в запрос серверу (считаем что он сам корректно распознает все свои get параметры)
		 */
		$mData = $this->PluginAdmin_Catalog_GetPluginsListFromCatalogByFilter($this->GetDataFromFilter());						// todo: пагинацию добавить
		/*
		 * есть ли корректный ответ
		 */
		if (is_array($mData)) {
			$aPaging = $mData['paging'];
			$aAddonsArray = $mData['addons'];
		} else {
			$aPaging = array();
			$aAddonsArray = array();
			/*
			 * показать текст ошибки
			 */
			$this->Message_AddError($mData, $this->Lang_Get('error'));
		}

		/*
		 * --- пост обработка данных ---
		 */
		/*
		 * подставить путь в пагинации на админку
		 * tip: пагинаци добавляет слеш, потому выходит "install//page1", пришлось вынести
		 */
		$aPaging['sBaseUrl'] = Router::GetPath('admin/plugins') . 'install';
		/*
		 * переделаем массив данных каждого плагина в сущность
		 */
		$aAddons = array();
		foreach($aAddonsArray as $aAddon) {
			$aAddons[$aAddon['code']] = Engine::GetEntity('PluginAdmin_Catalog_Addon', $aAddon);
		}

		$this->Viewer_Assign('sPluginTypeCurrent', $sType);
		$this->Viewer_Assign('sSortOrderCurrent', $sOrder);

		$this->Viewer_Assign('aPaging', $aPaging);
		$this->Viewer_Assign('aAddons', $aAddons);
	}


	/**
	 * Задать страницу и количество элементов в пагинации
	 *
	 * @param int	$iParamNum			номер параметра, в котором нужно искать номер страницы
	 * @param int 	$iCustomPerPage		задаваемое количество элементов на страницу
	 */
	protected function SetPagingForApi($iParamNum = 1, $iCustomPerPage = 15) {
		if (!$this->iPage = intval(preg_replace('#^page(\d+)$#iu', '$1', $this->GetParam($iParamNum)))) {
			$this->iPage = 1;
		}
		$this->iPerPage = $iCustomPerPage;
	}

}

?>