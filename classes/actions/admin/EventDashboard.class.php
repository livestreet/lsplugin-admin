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
 * Главная страница админки
 *
 */

class PluginAdmin_ActionAdmin_EventDashboard extends Event {


	/**
	 * Дашборд (главная страница админки)
	 */
	public function EventIndex() {
		$this->SetTemplateAction('index/index');
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
		 * получить прирост, линейку голосов и рейтингов топиков, комментариев, блогов и пользователей за указанный период (период по-умолчанию)
		 */
		$this->Viewer_Assign('aDataGrowth', array(
			PluginAdmin_ModuleStats::DATA_TYPE_TOPICS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_TOPICS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_BLOGS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_BLOGS, $sItemsAddedPeriod),
			PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS, $sItemsAddedPeriod),
		));

		/*
		 * получить прирост пользователей за месяц (для отображения в шапке шаблона, без линейки голосов и рейтингов)
		 */
		$this->Viewer_Assign('aUserGrowth', $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(
			PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS,
			PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK,
			false,
			false
		));

		/*
		 * получить все события
		 */
		$this->GetStreamAll();
		/*
		 * получить список всех событий для отображения фильтра
		 */
		$this->Viewer_Assign('aEventTypes', array_keys($this->Stream_getEventTypes()));

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
		$this->GetLastVisitMessageAndCompareIp();
		/*
		 * получить информацию по обновлениям плагинов
		 */
		$this->PluginAdmin_Catalog_GetUpdatesInfo();
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
		 * получить прирост, линейку голосов и рейтингов топиков, комментариев, блогов и пользователей за указанный период
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
	 * Получить всю последнюю активность
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
	 * Аякс получение последней активности по фильтру (первая порция после смены фильтра)
	 */
	public function EventAjaxGetIndexActivity() {
		$this->ProcessAjaxStreamContentLoading();
	}


	/**
	 * Аякс загрузка следующей порции активности на основе фильтра
	 */
	public function EventAjaxGetIndexActivityMore() {
		$this->ProcessAjaxStreamContentLoading(true);
	}


	/**
	 * Выполнить загрузку данных для ленты активности
	 *
	 * @param bool $bUseFromIdValue		использовать ли смещение
	 * @return bool
	 */
	protected function ProcessAjaxStreamContentLoading($bUseFromIdValue = false) {
		$this->Viewer_SetResponseAjax('json');
		/*
		 * получить фильтр со списком событий, которые нужно показать
		 */
		if (!$aFilterData = $this->GetDataFromFilter()) {
			$this->Message_AddError($this->Lang('errors.index.empty_activity_filter'), $this->Lang_Get ('error'));
			return false;
		}
		/*
		 * нужно ли использовать ид последнего, ранее показанного события
		 */
		$iFromId = null;
		if ($bUseFromIdValue and !$iFromId = getRequestStr ('iLastId')) {
			$this->Message_AddError ($this->Lang_Get ('system_error'), $this->Lang_Get ('error'));
			return false;
		}
		/*
		 * прочитать нужные события
		 */
		$aEvents = $this->Stream_ReadEvents(array_keys($aFilterData), null, Config::Get ('plugin.admin.dashboard.stream.count_default'), $iFromId);
		/*
		 * получить ленту с событиями в виде хтмл-кода
		 */
		$oViewer = $this->Viewer_GetLocalViewer();
		$oViewer->Assign('aStreamEvents', $aEvents);
		$this->Viewer_AssignAjax('result', $oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__) . 'actions/ActionAdmin/index/activity/events.tpl'));
		/*
		 * установить ид последнего события
		 */
		if (count($aEvents)) {
			$oEvenLast = end($aEvents);
			$this->Viewer_AssignAjax('iStreamLastId', $oEvenLast->getId());
		} else {
			/*
			 * сообщить что по выбранному фильтру нет данных
			 */
			$this->Message_AddError($this->Lang('notices.index.no_results'));
		}
		$this->Viewer_AssignAjax('events_count', count($aEvents));
		/*
		 * отключить ли кнопку "показать ещё события"
		 */
		$this->Viewer_AssignAjax('bDisableGetMoreButton', count($aEvents) < Config::Get('plugin.admin.dashboard.stream.count_default'));
	}


	/**
	 * Получить данные последнего входа в админку
	 */
	protected function GetLastVisitMessageAndCompareIp() {
		$aLastVisitData = $this->PluginAdmin_Users_GetLastVisitData();
		/*
		 * если это первый вход - сделать приветствие
		 */
		if (!$aLastVisitData) {
			$this->Message_AddNotice($this->Lang('hello.first_run'));
		} elseif (!$aLastVisitData['same_ip']) {
			$this->Message_AddNotice($this->Lang('hello.last_visit_ip_not_match_current', array('last_ip' => $aLastVisitData['ip'], 'current_ip' => func_getIp())));
		}
		$this->Viewer_Assign ('aLastVisitData', $aLastVisitData);
	}


}

?>