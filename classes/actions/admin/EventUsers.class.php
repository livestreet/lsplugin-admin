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

class PluginAdmin_ActionAdmin_EventUsers extends Event {

	/*
	 * страница результатов
	 */
	protected $iPage = 1;

	/*
	 * результатов на страницу
	 */
	protected $iPerPage = 20;


	/**
	 * Список пользователей
	 */
	public function EventUsersList() {
		$this->SetTemplateAction('users/list');
		$this->SetPaging();

		$aFilter = getRequest('filter');

		/*
		 * сортировка
		 */
		$sOrder = @$aFilter['order_field'];
		$sWay = @$aFilter['order_way'];

		/*
		 * поиск по полям
		 */
		$sSearchQuery = @$aFilter['q'];
		$aSearchFields = @$aFilter['field'];

		if (!is_array($aSearchFields)) {
			$aSearchFields = (array) $aSearchFields;
		}

		/*
		 * получить правила (фильтр для поиска)
		 */
		$aSearchRules = $this->GetSearchRule($sSearchQuery, $aSearchFields);

		/*
		 * получение пользователей
		 */
		$aResult = $this->PluginAdmin_Users_GetUsersByFilter(
			$aSearchRules,
			array($sOrder => $sWay),
			$this->iPage,
			$this->iPerPage
		);
		$aUsers = $aResult['collection'];

		/*
		 * Формируем постраничность
		 */
		$aPaging = $this->Viewer_MakePaging(
			$aResult['count'],
			$this->iPage,
			$this->iPerPage,
			Config::Get('pagination.pages.count'),
			Router::GetPath('admin') . Router::GetActionEvent() . '/list',
			$this->GetPagingAdditionalParamsByArray(array(
				'q' => $sSearchQuery,
				'field' => $aSearchFields,
				'order_field' => $sOrder,
				'order_way' => $sWay
			))
		);

		$this->Viewer_Assign('aPaging', $aPaging);
		$this->Viewer_Assign('aUsers', $aUsers);

		/*
		 * сортировка
		 */
		$this->Viewer_Assign('sReverseOrder', $this->PluginAdmin_Users_GetReversedOrderDirection ($sWay));
		$this->Viewer_Assign('sOrder', $sOrder);
		$this->Viewer_Assign('sWay', $this->PluginAdmin_Users_GetDefaultOrderDirectionIfIncorrect ($sWay));

		/*
		 * поиск
		 */
		$this->Viewer_Assign('sSearchQuery', $sSearchQuery);
		$this->Viewer_Assign('aSearchFields', $aSearchFields);
	}


	/**
	 * Изменить количество пользователей на странице
	 */
	public function EventAjaxUsersOnPage () {
		$this->Viewer_SetResponseAjax('json');
		$this->PluginAdmin_Users_ChangeUsersPerPage(getRequestStr('onpage'));
	}


	/**
	 * Показать страницу информации о пользователе
	 *
	 * @return string
	 */
	public function EventUserProfile () {
		$this->SetTemplateAction('users/profile');
		/*
		 * проверяем корректность id пользователя
		 */
		if (!$iUserId = (int) $this->GetParam(1) or !$oUser = $this->User_GetUserById($iUserId)) {
			return Router::Action('error');
		}
		/*
		 * получить гео-запись данных пользователя, которые он указал в профиле
		 */
		$oGeoTarget = $this->Geo_GetTargetByTarget('user', $oUser->getId());

		/*
		 * создал топиков и комментариев
		 */
		$iCountTopicUser = $this->Topic_GetCountTopicsPersonalByUser($oUser->getId(), 1);
		$iCountCommentUser = $this->Comment_GetCountCommentsByUserId($oUser->getId(), 'topic');
		
		/*
		 * топиков и комментариев в избранном
		 */
		$iCountTopicFavourite = $this->Topic_GetCountTopicsFavouriteByUserId($oUser->getId());
		$iCountCommentFavourite = $this->Comment_GetCountCommentsFavouriteByUserId($oUser->getId());

		/*
		 * создал заметок
		 */
		//$iCountNoteUser = $this->User_GetCountUserNotesByUserId($oUser->getId());

		/*
		 * записей на стене
		 */
		//$iWallItemsCount = $this->Wall_GetCountWall (array ('wall_user_id' => $oUser->getId (), 'pid' => null));
		/*
		 * получаем количество созданных блогов
		 */
		$iCountBlogsUser = count($this->Blog_GetBlogsByOwnerId($oUser->getId(), true));

		/*
		 * количество читаемых блогов
		 */
		$iCountBlogReads = count($this->Blog_GetBlogUsersByUserId($oUser->getId(), ModuleBlog::BLOG_USER_ROLE_USER, true));

		/*
		 * количество друзей у пользователя
		 */
		$iCountFriendsUser = $this->User_GetCountUsersFriend ($oUser->getId ());

		/*
		 * переменные в шаблон
		 */
		$this->Viewer_Assign('iCountTopicUser', $iCountTopicUser);
		$this->Viewer_Assign('iCountCommentUser', $iCountCommentUser);
		$this->Viewer_Assign('iCountBlogsUser', $iCountBlogsUser);

		$this->Viewer_Assign('iCountTopicFavourite', $iCountTopicFavourite);
		$this->Viewer_Assign('iCountCommentFavourite', $iCountCommentFavourite);

		$this->Viewer_Assign('iCountBlogReads', $iCountBlogReads);

		$this->Viewer_Assign('iCountFriendsUser', $iCountFriendsUser);

		//$this->Viewer_Assign('iCountNoteUser', $iCountNoteUser);
		//$this->Viewer_Assign('iCountWallUser', $iWallItemsCount);
		/*
		 * общее число публикаций и избранного
		 */
		/*
		$this->Viewer_Assign('iCountCreated',
			(($this->oUserCurrent and $this->oUserCurrent->getId() == $oUser->getId()) ? $iCountNoteUser : 0) + $iCountTopicUser + $iCountCommentUser
		);
		$this->Viewer_Assign('iCountFavourite', $iCountCommentFavourite + $iCountTopicFavourite);
		/*
		 * заметка текущего пользователя о юзере
		 */
		/*
		if ($this->oUserCurrent) {
			$this->Viewer_Assign('oUserNote', $oUser->getUserNote());
		}
		*/

		/*
		 * подсчитать за что, как и сколько раз голосовал пользователь
		 */
		$aVotedStats = $this->PluginAdmin_Users_GetUserVotingStats ($oUser);


		$this->Viewer_Assign('aUserVotedStat', $aVotedStats);
		$this->Viewer_Assign('oGeoTarget', $oGeoTarget);
		$this->Viewer_Assign('oUser', $oUser);
	}


	/**
	 * Задать страницу и количество элементов в пагинации
	 *
	 * @param int    $iParamNum					номер параметра, в котором нужно искать номер страницы
	 * @param string $sConfigKeyPerPage			ключ конфига, в котором хранится количество элементов на страницу
	 */
	protected function SetPaging ($iParamNum = 1, $sConfigKeyPerPage = 'user.per_page') {
		if (!$this->iPage = intval(preg_replace('#^page(\d+)$#iu', '$1', $this->GetParam ($iParamNum)))) {
			$this->iPage = 1;
		}
		$this->iPerPage = Config::Get('plugin.admin.' . $sConfigKeyPerPage);
	}


	/**
	 * Получить правила для поиска по полям
	 *
	 * @param string|array	$aSearchQueries		запросы
	 * @param array 		$aSearchFields		имена полей, по которым будет происходить поиск
	 * @return array							правило для фильтра
	 */
	protected function GetSearchRule ($aSearchQueries, $aSearchFields) {
		$aUserSearchFieldsRules = Config::Get('plugin.admin.user_search_allowed_types');
		$aQueries = array();
		foreach ($aSearchFields as $sField) {
			/*
			 * если имя поля для поиска разрешено
			 */
			if (in_array($sField, array_keys($aUserSearchFieldsRules))) {
				// todo: review: the same query for all fields if not array
				if (is_array($aSearchQueries)) {
					$sQuery = $aSearchQueries [$sField];
				} else {
					$sQuery = $aSearchQueries;
				}
				/*
				 * экранировать спецсимволы
				 */
				$sQuery = str_replace(array('_', '%'), array('\_', '\%'), $sQuery);
				/*
				 * если разрешено искать по данному параметру как по части строки
				 */
				if ($aUserSearchFieldsRules[$sField]['search_as_part_of_string']) {
					/*
					 * искать в любой части строки
					 */
					$sQuery = '%' . $sQuery . '%';
				}
				$aQueries [$sField] = $sQuery;
			}
		}
		return $aQueries;
	}


	/**
	 * Получить списки голосований пользователя
	 *
	 * @return string
	 */
	public function EventUserVotesList () {
		$this->SetTemplateAction('users/votes');
		$this->SetPaging(2, 'votes.per_page');

		$aFilter = getRequest('filter');

		/*
		 * сортировка
		 */
		$sOrder = @$aFilter['order_field'];
		$sWay = @$aFilter['order_way'];


		/*
		 * проверяем корректность id пользователя
		 */
		if (!$iUserId = (int) $this->GetParam(1) or !$oUser = $this->User_GetUserById($iUserId)) {
			return Router::Action('error');
		}
		/*
		 * проверяем корректность типа обьекта, голоса по которому нужно показать
		 */
		if (!$sVotingTargetType = @$aFilter['type'] or !in_array($sVotingTargetType, array('topic', 'comment', 'blog', 'user'))) {
			return Router::Action('error');
		}
		/*
		 * проверяем направление голосования
		 */
		if ($sVotingDirection = @$aFilter['dir'] and !in_array($sVotingDirection, array('plus', 'minus'))) {
			return Router::Action('error');
		}
		/*
		 * строим фильтр
		 */
		$aFilter = array(
			'type' => $sVotingTargetType,
			'direction' => $sVotingDirection,
		);


		/*
		 * получаем данные голосований
		 */
		$aResult = $this->PluginAdmin_Users_GetUserVotingByFilter (
			$oUser,
			$aFilter,
			array($sOrder => $sWay),
			$this->iPage,
			$this->iPerPage
		);

		/*
		 * дополнить данные голосований названиями обьектов и ссылками на них
		 */
		$this->PluginAdmin_Users_GetTargetObjectsFromVotingList($aResult ['collection']);

		/*
		 * Формируем постраничность
		 */
		$aPaging = $this->Viewer_MakePaging(
			$aResult['count'],
			$this->iPage,
			$this->iPerPage,
			Config::Get('pagination.pages.count'),
			Router::GetPath('admin') . Router::GetActionEvent() . '/votes/' . $oUser->getId(),
			$this->GetPagingAdditionalParamsByArray(array(
				'type' => $sVotingTargetType,
				'dir' => $sVotingDirection,
				'order_field' => $sOrder,
				'order_way' => $sWay
			))
		);

		$this->Viewer_Assign('aPaging', $aPaging);
		$this->Viewer_Assign('aVotingList', $aResult ['collection']);
		$this->Viewer_Assign('oUser', $oUser);
		$this->Viewer_Assign('sVotingTargetType', $sVotingTargetType);


		/*
		 * сортировка
		 */
		$this->Viewer_Assign('sReverseOrder', $this->PluginAdmin_Users_GetReversedOrderDirection ($sWay));
		$this->Viewer_Assign('sOrder', $sOrder);
		$this->Viewer_Assign('sWay', $this->PluginAdmin_Users_GetDefaultOrderDirectionIfIncorrect ($sWay));
	}


	/**
	 * Построить дополнительные параметры для пагинации
	 *
	 * @param array $aParams		набор параметров ключ=>значение
	 * @return array|null			массив параметров, которые имеют значение
	 */
	protected function GetPagingAdditionalParamsByArray ($aParams = array()) {
		$aFilter = array();
		foreach ($aParams as $sKey => $mData) {
			if ($mData) {
				$aFilter[$sKey] = $mData;
			}
		}
		return ($aFilter ? array('filter' => $aFilter) : null);
	}

}

?>