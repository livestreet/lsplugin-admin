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
		$this->BuildGraph();
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


	/**
	 * Получить данные для графика
	 */
	protected function BuildGraph() {
		/*
		 * тип периода для графика
		 */
		if (!$sGraphPeriod = $this->GetDataFromFilter('graph_period') or !in_array($sGraphPeriod, array('yesterday', 'today', 'week', 'month'))) {
			$sGraphPeriod = 'month';
		}

		/*
		 * тип графика
		 */
		if (!$sGraphType = $this->GetDataFromFilter('graph_type') or !in_array($sGraphType, array('regs', 'topics', 'comments', 'votings'))) {
			$sGraphType = 'regs';
		}

		// todo: попробовать универсализировать получение и вынести в модуль статистики и заменить из эвента юзеров

		/*
		 *
		 * график
		 *
		 */
		/*
		 * получить период дат от и до для названия интервала если не был выбран ручной интервал дат
		 */
		$aPeriod = $this->PluginAdmin_Stats_GetStatsGraphPeriod($sGraphPeriod);
		/*
		 * получить пустой интервал дат для графика
		 */
		$aFilledWithZerosPeriods = $this->PluginAdmin_Stats_FillDatesRangeForPeriod($aPeriod);
		/*
		 * получить существующие данные о типе
		 */
		$aDataStats = $this->GetStatsDataForGraphCorrespondingOnType($sGraphType, $aPeriod);
		/*
		 * объеденить данные
		 */
		$aDataStats = $this->PluginAdmin_Stats_MixEmptyPeriodsWithData($aFilledWithZerosPeriods, $aDataStats);

		/*
		 * статистика регистраций
		 */
		$this->Viewer_Assign('aDataStats', $aDataStats);
		/*
		 * тип текущего периода
		 */
		$this->Viewer_Assign('sCurrentGraphPeriod', $sGraphPeriod);
		/*
		 * тип текущего графика
		 */
		$this->Viewer_Assign('sCurrentGraphType', $sGraphType);
	}


	/**
	 * Получить реальные существующие данные о типе на основе периода
	 *
	 * @param $sGraphType		тип данных (графика)
	 * @param $aPeriod			данные периода
	 * @return mixed			данные
	 * @throws Exception
	 */
	protected function GetStatsDataForGraphCorrespondingOnType($sGraphType, $aPeriod) {
		switch ($sGraphType) {
			case 'regs':
				return $this->PluginAdmin_Users_GetUsersRegistrationStats($aPeriod);
			case 'topics':
				return $this->PluginAdmin_Topics_GetTopicsStats($aPeriod);
			case 'comments':
				return $this->PluginAdmin_Comments_GetCommentsStats($aPeriod);
			case 'votings':
				return $this->PluginAdmin_Votings_GetVotingsStats($aPeriod);
			default:
				throw new Exception('admin: error: unknown graph type');
		}
	}

}

?>