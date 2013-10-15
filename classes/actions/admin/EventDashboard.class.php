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

class PluginAdmin_ActionAdmin_EventDashboard extends Event {

	/**
	 * Дашборд (главная страница админки)
	 */
	public function EventIndex() {
		$this->SetTemplateAction('index');
		/*
		 * данные для графика
		 */
		$this->PluginAdmin_Stats_GatherAndBuildDataForGraph(
			$this->GetDataFromFilter('graph_type'),
			$this->GetDataFromFilter('graph_period'),
			$this->GetDataFromFilter('date_start'),
			$this->GetDataFromFilter('date_finish')
		);

		/*
		 * период для показа прироста новых топиков, комментариев и т.п.
		 */
		$sItemsAddedPeriod = $this->GetDataFromFilter('newly_added_items_period');

		/*
		 * получить прирост и линейку голосов топиков, комментариев, блогов и пользователей за указанный период (период по-умолчанию)
		 */
		$this->Viewer_Assign('aDataGrowth', array(
			PluginAdmin_ModuleStats::DATA_TYPE_TOPICS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_TOPICS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_BLOGS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_BLOGS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS, $sItemsAddedPeriod),
		));

		/*
		 * получить прирост пользователей за месяц (для отображения в шапке шаблона, без линейки голосов)
		 */
		$this->Viewer_Assign('aUserGrowth', $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(
			PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS,
			PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK,
			false
		));

		/*
		 * получить события
		 */
		$this->GetStreamAll();
		/*
		 * получить список всех событий для отображения фильтра
		 */
		$this->Viewer_Assign('aEventTypes', $this->Stream_getEventTypes());

		/*
		 * получить базовую статистику
		 */
		$this->Viewer_Assign('aStats', $this->User_GetStatUsers());
		/*
		 * количество топиков всего
		 */
		$this->Viewer_Assign('iTotalTopicsCount', $this->Topic_GetCountTopicsByFilter(array('published' => 1)));
		/*
		 * количество блогов всего
		 */
		$this->Viewer_Assign('iTotalBlogsCount', $this->PluginAdmin_Blogs_GetCountBlogs());
		/*
		 * количество комментариев всего
		 */
		$this->Viewer_Assign('iTotalCommentsCount', $this->PluginAdmin_Comments_GetCountCommentsTotal());
		/*
		 * получить данные последнего входа в админку
		 */
		$this->Viewer_Assign('aLastVisitData', $this->PluginAdmin_Users_GetLastVisitData());
	}


	/**
	 * Получить последнюю активность
	 */
	protected function GetStreamAll() {
		$aEvents = $this->Stream_ReadAll(Config::Get('plugin.admin.dashboard.stream.count_default'));
		$this->Viewer_Assign('bDisableGetMoreButton', $this->Stream_GetCountAll() < Config::Get('plugin.admin.dashboard.stream.count_default'));
		$this->Viewer_Assign('aStreamEvents', $aEvents);
		if (count($aEvents)) {
			$oEvenLast = end($aEvents);
			$this->Viewer_Assign('iStreamLastId', $oEvenLast->getId());
		}
	}


	/**
	 * Получить обработанный блок для показа при смене периода через аякс для новых объектов
	 */
	public function EventAjaxGetNewItemsBlock() {
		$this->Viewer_SetResponseAjax('json');
		/*
		 * период для показа прироста новых топиков, комментариев и т.п.
		 */
		$sItemsAddedPeriod = $this->GetDataFromFilter('newly_added_items_period');

		$oViewer = $this->Viewer_GetLocalViewer();
		/*
		 * получить прирост и линейку голосов топиков, комментариев, блогов и пользователей за указанный период
		 */
		$oViewer->Assign('aDataGrowth', array(
			PluginAdmin_ModuleStats::DATA_TYPE_TOPICS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_TOPICS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_BLOGS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_BLOGS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS, $sItemsAddedPeriod),
		));
		$this->Viewer_AssignAjax('sText', $oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__) . 'actions/ActionAdmin/index/new_items_table.tpl'));
	}


	/**
	 * Получить последнюю активность по фильтру
	 */
	public function EventAjaxGetIndexActivity() {
		$this->Viewer_SetResponseAjax('json');
		/*
		 * список событий, которые нужно показать
		 */
		$aEventsToShow = array_keys($this->GetDataFromFilter());
		/*
		 * ид последнего, ранее показанного события
		 */
		if (!$iFromId = getRequestStr('iLastId')) {
			$this->Message_AddError($this->Lang_Get('system_error'), $this->Lang_Get('error'));
			return;
		}
		//print_r ($aEventsToShow); die ();	// test debug, todo: delete

		/*
		 * прочитать нужные события
		 */
		$aEvents = $this->Stream_ReadEvents($aEventsToShow, null, Config::Get('plugin.admin.dashboard.stream.count_default'), $iFromId);

		$oViewer = $this->Viewer_GetLocalViewer();
		/*
		 * отключить ли кнопку "ещё" (есть ли ещё события)
		 */
		$oViewer->Assign('bDisableGetMoreButton', $this->Stream_GetCount($aEventsToShow) < Config::Get('plugin.admin.dashboard.stream.count_default'));
		$oViewer->Assign('aStreamEvents', $aEvents);
		$oViewer->Assign('sDateLast', getRequestStr('sDateLast'));
		/*
		 * ид последнего события
		 */
		if (count($aEvents)) {
			$oEvenLast = end($aEvents);
			$this->Viewer_AssignAjax('iStreamLastId', $oEvenLast->getId());
		}

		$this->Viewer_AssignAjax('result', $oViewer->Fetch('actions/ActionStream/events.tpl'));
		$this->Viewer_AssignAjax('events_count', count($aEvents));
	}


}

?>