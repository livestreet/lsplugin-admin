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
		$this->GetUsersListByRules(Router::GetPath('admin/users/list'));
	}


	/**
	 * Список админов
	 */
	public function EventAdminsList() {
		$this->GetUsersListByRules(Router::GetPath('admin/users/admins'), array('admins_only' => true));
	}


	/**
	 * Получить список пользователей по фильтру из формы и доп. фильтру, добавить постраничность и вывести списком с сортировкой
	 *
	 * @param       $sFullPagePathToEvent		путь к екшену
	 * @param array $aAdditionalUsersFilter		дополнительный фильтр поиска по пользователям
	 */
	protected function GetUsersListByRules($sFullPagePathToEvent, $aAdditionalUsersFilter = array()) {
		$this->SetTemplateAction('users/list');
		$this->SetPaging();

		/*
		 * получить фильтр, хранящий в себе все параметры (поиска и сортировки)
		 */
		$aFilter = getRequest('filter');

		/*
		 * сортировка
		 */
		$sOrder = @$aFilter['order_field'];
		$sWay = @$aFilter['order_way'];

		/*
		 * поиск по полям - отобрать корректные поля для поиска среди кучи других параметров
		 */
		$aValidatedSearchRules = $this->GetSearchRule($aFilter);
		/*
		 * получить правила (фильтр для поиска)
		 */
		$aSearchRules = $aValidatedSearchRules ['filter_queries'];
		/*
		 * получить правила только с оригинальными тектовыми запросами
		 */
		$aSearchRulesWithOriginalQueries = $aValidatedSearchRules ['filter_queries_with_original_values'];

		/*
		 * получение пользователей
		 */
		$aResult = $this->PluginAdmin_Users_GetUsersByFilter(
			array_merge($aSearchRules, $aAdditionalUsersFilter),
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
			$sFullPagePathToEvent,
			$this->GetPagingAdditionalParamsByArray(
				array_merge(
					array(
						'order_field' => $sOrder,
						'order_way' => $sWay
					),
					$aSearchRulesWithOriginalQueries
				)
			)
		);

		$this->Viewer_Assign('aPaging', $aPaging);
		$this->Viewer_Assign('aUsers', $aUsers);
		$this->Viewer_Assign('sFullPagePathToEvent', $sFullPagePathToEvent);

		/*
		 * сортировка
		 */
		$this->Viewer_Assign('sReverseOrder', $this->PluginAdmin_Users_GetReversedOrderDirection ($sWay));
		$this->Viewer_Assign('sOrder', $sOrder);
		$this->Viewer_Assign('sWay', $this->PluginAdmin_Users_GetDefaultOrderDirectionIfIncorrect ($sWay));

		/*
		 * поиск
		 */
		$this->Viewer_Assign('aSearchRulesWithOriginalQueries', $aSearchRulesWithOriginalQueries);
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
	 * @param string|array	$aFilter			имена полей и запросы, по которым будет происходить поиск
	 * @return array							правило для фильтра
	 */
	protected function GetSearchRule($aFilter) {
		$aUserSearchFieldsRules = Config::Get('plugin.admin.user_search_allowed_types');
		/*
		 * здесь будут пары "поле=>запрос" для запроса через фильтр
		 */
		$aQueries = array();
		/*
		 * здесь будут хранится проверенные поля по которым можно искать, но с оригинальными данными значений для поиска
		 */
		$aCorrectFieldsWithOriginalValues = array();
		/*
		 * набор правил для поиска представляет собой массив поле_поиска => запрос (в данном массиве хранится все вместе)
		 */
		foreach ((array) $aFilter as $sField => $sQuery) {
			/*
			 * если имя поля для поиска разрешено (получить корректное поле среди остальных данных)
			 */
			if (in_array($sField, array_keys($aUserSearchFieldsRules))) {
				/*
				 * до начала обработки поискового запроса сохранить оригинал для каждого корректного поля из данных фильтра
				 */
				$aCorrectFieldsWithOriginalValues [$sField] = $sQuery;
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
				/*
				 * добавить новую поисковую пару "поле=>запрос" для фильтра
				 */
				$aQueries [$sField] = $sQuery;
			}
		}
		return array(
			'filter_queries' =>  $aQueries,
			'filter_queries_with_original_values' => $aCorrectFieldsWithOriginalValues
		);
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


	/**
	 * Изменить рейтинг и силу пользователя
	 */
	public function EventAjaxEditUserRatingAndSkill () {
		$this->Viewer_SetResponseAjax('json');
		if ($oUser = $this->User_GetUserById((int) getRequest('user_id'))) {
			$oUser->setRating((float) getRequestStr('user-rating'));
			$oUser->setSkill((float) getRequestStr('user-skill'));
			$this->User_Update($oUser);
			$this->Message_AddNotice('Ok');
		}
	}


	public function EventBansList() {
		$this->SetTemplateAction('users/bans');
		$this->SetPaging();


	}

	public function EventAddBan() {
		$this->SetTemplateAction('users/bans.add');
		$this->SetPaging();

		/*
		 * если была нажата кнопка
		 */
		if (isPost('submit_add_ban')) {
			$this->Security_ValidateSendForm();

			/*
			 * получить идентификацию пользователя
			 */
			$sUserSign = getRequestStr('user_sign');
			/*
			 * тип бана
			 */
			$sBanType = getRequest('bantype');	// unlimited, period, days

			/*
			 * получить временные интервалы для типа бана "period"
			 */
			$sPeriodFrom = getRequestStr('period_from');
			$sPeriodTo = getRequestStr('period_to');

			/*
			 * получить количество дней бана для типа бана "days"
			 */
			$sDaysCount = getRequestStr('period_to');

			/*
			 * получить причину бана (отображается для пользователя)
			 */
			$sBlockingReasonForUser = getRequestStr('reason_for_user');
			/*
			 * комментарий для админа
			 */
			$sBlockingComment = getRequestStr('reason_comment');

			print_r ($_POST); die ();	// test debug, todo: delete


		}

	}

}

?>