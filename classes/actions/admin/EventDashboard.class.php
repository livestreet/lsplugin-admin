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
		$this->PluginAdmin_Stats_GatherAndBuildDataForGraph($this->GetDataFromFilter('graph_type'), $this->GetDataFromFilter('graph_period'));

		/*
		 * период для показа прироста новых топиков, комментариев и т.п.
		 */
		$sItemsAddedPeriod = $this->GetDataFromFilter('newly_added_items_period');

		/*
		 * получить прирост и линейку голосов топиков, комментариев, блогов и пользователей за указанный период
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
		$this->Viewer_Assign('iUserGrowth', $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(
			PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS, PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK,
			false
		));

		/*
		 * получить события
		 */
		$this->GetStreamAll();
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


}

?>