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

	/*
	 * страница для получения списка плагинов из каталога
	 */
	private $iPage = null;


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
			 * весь список плагинов
			 */
			case null:
				$aPluginsInfo = $this->PluginAdmin_Plugins_GetPluginsList();
				break;
			/*
			 * активные
			 */
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
			$this->Message_AddNotice($this->Lang('notices.plugins.' . $sAction), '', true);
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
		$aFilter = (array) $this->GetDataFromFilter();
		/*
		 * тип аддонов (все, платные, бесплатные)
		 */
		$sType = $this->GetDataFromFilter('type');
		/*
		 * если сортировка не указана - использовать сортировку каталога по-умолчанию
		 */
		$sOrder = $this->GetDataFromFilter('order') ? $this->GetDataFromFilter('order') : Config::Get('plugin.admin.catalog.remote.addons.default_sorting');
		/*
		 * версия дополнений
		 */
		$sVersion = $this->GetDataFromFilter('version');
		/*
		 * секция
		 */
		$sSection = $this->GetDataFromFilter('section');

		$this->SetPagingForApi();
		/*
		 * передать весь фильтр в запрос серверу (считаем что он сам корректно распознает все свои get параметры)
		 */
		$mData = $this->PluginAdmin_Catalog_GetAddonsListFromCatalogByFilterCached(array_merge(
			$aFilter,
			array(
				'page' => $this->iPage,
				/*
				 * показывать только плагины
				 */
				'category' => 1
			)
		));
		/*
		 * есть ли корректный ответ
		 */
		if (is_array($mData)) {
			$aPaging = $mData['paging'];
			$aAddons = $mData['addons'];
		} else {
			$aPaging = array();
			$aAddons = array();
			/*
			 * показать текст ошибки
			 */
			$this->Message_AddError($mData, $this->Lang_Get('error'));
		}

		/*
		 * подставить путь в пагинации на админку
		 * tip: пагинация добавляет спереди слеш "/page1/, поэтому выходит "install//page1", пришлось вынести из метода
		 */
		$aPaging['sBaseUrl'] = Router::GetPath('admin') . 'plugins/install';
		/*
		 * подставить сам фильтр в пагинацию, чтобы, например, корректно работала сортировка
		 * tip: каталог устанавливает свои параметры типа и сортировки, которые есть в фильтре,
		 * 		админке эти параметры не нужны т.к. она их получает из фильтра, поэтому параметры заменяются
		 */
		$aPaging['sGetParams'] = $aFilter ? '?' . http_build_query(array('filter' => $aFilter)) : null;

		$this->Viewer_Assign('sPluginTypeCurrent', $sType);
		$this->Viewer_Assign('sSortOrderCurrent', $sOrder);
		$this->Viewer_Assign('sVersionCurrent', $sVersion);
		$this->Viewer_Assign('sSectionCurrent', $sSection);

		$this->Viewer_Assign('aPaging', $aPaging);
		$this->Viewer_Assign('aAddons', $aAddons);
	}


	/**
	 * Задать страницу в пагинации (к-во на страницу фиксировано каталогом)
	 *
	 * @param int	$iParamNum			номер параметра, в котором нужно искать номер страницы
	 */
	protected function SetPagingForApi($iParamNum = 1) {
		if (!$this->iPage = intval(preg_replace('#^page(\d+)$#iu', '$1', $this->GetParam($iParamNum)))) {
			$this->iPage = 1;
		}
	}


	/**
	 * Сброс кеша списка дополнений из каталога
	 */
	public function EventPluginsResetCache() {
		$this->Security_ValidateSendForm();
		$this->PluginAdmin_Catalog_ResetCatalogCache();
		$this->Message_AddNotice($this->Lang('notices.plugins.reset_catalog_cache_done'), '', true);
		$this->RedirectToReferer();
	}

}

?>