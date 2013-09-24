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

class PluginAdmin_ModuleUsers extends Module {

	/*
	 * типы правила бана
	 */
	const BAN_BLOCK_TYPE_USER_ID = 1;
	const BAN_BLOCK_TYPE_IP = 2;
	const BAN_BLOCK_TYPE_IP_RANGE = 4;

	/*
	 * типы времени бана (постоянный и на период)
	 */
	const BAN_TIME_TYPE_PERMANENT = 1;
	const BAN_TIME_TYPE_PERIOD = 2;

	/*
	 * имя параметра хранилища для сбора статистики по банам
	 */
	const BAN_STATS_PARAM_NAME = 'users_bans_stats';

	/*
	 * Ключ хранилища, в котором хранится время последнего входа в админку и айпи последнего входа
	 */
	const ADMIN_LAST_VISIT_DATA_STORAGE_KEY = 'admin_last_visit_data';

	protected $oMapper = null;

	/*
	 * направление сортировки по-умолчанию (если она не задана или некорректна)
	 */
	protected $sSortingWayByDefault = 'desc';

	/*
	 * корректные направления сортировки
	 * (не менять порядок!)
	 */
	protected $aSortingOrderWays = array('desc', 'asc');


	public function Init() {
		$this->oMapper = Engine::GetMapper(__CLASS__);
	}


	/**
	 * Возвращает список пользователей по фильтру
	 *
	 * @param array 	$aFilter		Фильтр
	 * @param array 	$aOrder			Сортировка
	 * @param int 		$iCurrPage		Номер страницы
	 * @param int 		$iPerPage		Количество элментов на страницу
	 * @param array 	$aAllowData		Список типов данных для подгрузки к пользователям
	 * @return array('collection'=>array,'count'=>int)
	 */
	public function GetUsersByFilter($aFilter = array(), $aOrder = array(), $iCurrPage = 1, $iPerPage = PHP_INT_MAX, $aAllowData = null) {
		if (is_null ($aAllowData)) {
			$aAllowData = array ('session');
		}
		$sOrder = $this -> GetCorrectSortingOrder(
			$aOrder,
			Config::Get('plugin.admin.correct_sorting_order_for_users'),
			Config::Get('plugin.admin.default_sorting_order_for_users')
		);
		$mData = $this -> oMapper -> GetUsersByFilter($aFilter, $sOrder, $iCurrPage, $iPerPage);

		$mData['collection'] = $this -> User_GetUsersAdditionalData($mData['collection'], $aAllowData);
		return $mData;
	}


	/**
	 * Проверяет корректность сортировки и возращает часть sql запроса для сортировки
	 *
	 * @param array 	$aOrder						поля, по которым нужно сортировать вывод пользователей
	 * 												(array('login' => 'desc', 'rating' => 'desc'))
	 * @param array 	$aCorrectSortingOrderList	список разрешенных сортировок
	 * @param			$sSortingOrderByDefault		строка сортировки по-умолчанию
	 * @return string								часть sql запроса
	 */
	protected function GetCorrectSortingOrder($aOrder = array (), $aCorrectSortingOrderList = array(), $sSortingOrderByDefault) {
		$sOrder = '';
		foreach($aOrder as $sRow => $sDir) {
			if (!in_array($sRow, $aCorrectSortingOrderList)) {
				unset($aOrder[$sRow]);
			} elseif (in_array($sDir, $this -> aSortingOrderWays)) {
				$sOrder .= " {$sRow} {$sDir},";
			}
		}
		$sOrder = rtrim($sOrder, ',');
		if (empty($sOrder)) {
			$sOrder = $sSortingOrderByDefault;
		}
		return $sOrder;
	}


	/**
	 * Получить сортировку наоборот
	 *
	 * @param $sWay			текущий тип сортировки
	 * @return string		противоположный
	 */
	public function GetReversedOrderDirection($sWay) {
		if ($sDefaultWay = $this->GetDefaultOrderDirectionIfIncorrect($sWay) !== $sWay) return $sDefaultWay;
		return $this -> aSortingOrderWays[(int) ($sWay == $this->sSortingWayByDefault)];
	}


	/**
	 * Получить сортировку по-умолчанию, если она не задана или некорректна
	 *
	 * @param $sWay			текущий тип сортировки
	 * @return string		текущий или по-умолчанию (если не корректен)
	 */
	public function GetDefaultOrderDirectionIfIncorrect($sWay) {
		if (!in_array($sWay, $this -> aSortingOrderWays)) return $this->sSortingWayByDefault;
		return $sWay;
	}


	/**
	 * Установить количество пользователей на странице
	 *
	 * @param $iPerPage		количество
	 */
	public function ChangeUsersPerPage($iPerPage) {
		/*
		 * установить количество пользователей на странице
		 */
		$aData = array(
			'user' => array(
				'per_page' => $iPerPage,
			)
		);
		$this->PluginAdmin_Settings_SaveConfigByKey('admin', $aData);
	}


	/**
	 * Получить статистическую информацию о том, за что, как и сколько раз голосовал пользователь
	 *
	 * @param $oUser		объект пользователя
	 * @return array		ассоциативный массив голосований за обьекты
	 */
	public function GetUserVotingStats($oUser) {
		$sCacheKey = 'get_user_voting_stats_' . $oUser->getId();
		if (($aData = $this->Cache_Get($sCacheKey)) === false) {
			$aData = $this->CalcUserVotingStats($oUser);
			$this->Cache_Set($aData, $sCacheKey, array(
				'vote_update_topic',
				'vote_update_comment',
				'vote_update_blog',
				'vote_update_user'
			), 60 * 30);			// reset every 30 min
		}
		return $aData;
	}


	/**
	 * Рассчитать статистику голосования пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @return array
	 */
	protected function CalcUserVotingStats($oUser) {
		/*
		 * заполнить значениями по-умолчанию
		 */
		$aVotingStats = array(
			'topic' => array('plus' => 0, 'minus' => 0),
			'comment' => array('plus' => 0, 'minus' => 0),
			'blog' => array('plus' => 0, 'minus' => 0),
			'user' => array('plus' => 0, 'minus' => 0),
		);
		$aResult = $this->oMapper->GetUserVotingStats ($oUser->getId());
		/*
		 * собрать данные в удобном виде
		 */
		foreach ($aResult as $aData) {
			$aVotingStats[$aData['target_type']][$aData['vote_direction'] == '1' ? 'plus' : 'minus'] = $aData['count'];
		}
		return $aVotingStats;
	}


	/**
	 * Получить списки голосований пользователя по фильтру
	 *
	 * @param		 	$oUser			объект пользователя
	 * @param		 	$aFilter		фильтр
	 * @param			$aOrder			сортировка
	 * @param int 		$iPage			номер страницы
	 * @param int 		$iPerPage		результатов на страницу
	 * @return mixed					коллекция и количество
	 */
	public function GetUserVotingByFilter($oUser, $aFilter, $aOrder = array(), $iPage = 1, $iPerPage = PHP_INT_MAX) {
		$sCacheKey = 'get_user_voting_list_' . implode('_', array($oUser->getId(), serialize($aFilter), serialize($aOrder), $iPage, $iPerPage));
		if (($aData = $this->Cache_Get($sCacheKey)) === false) {
			$aData = $this->oMapper->GetUserVotingListByFilter(
				$oUser->getId(),
				$this->BuildFilterForVotingList($aFilter),
				$this->GetCorrectSortingOrder(
					$aOrder,
					Config::Get('plugin.admin.correct_sorting_order_for_votes'),
					Config::Get('plugin.admin.default_sorting_order_for_votes')
				),
				$iPage,
				$iPerPage
			);
			$this->Cache_Set($aData, $sCacheKey, array(
				'vote_update_topic',
				'vote_update_comment',
				'vote_update_blog',
				'vote_update_user'
			), 60 * 30);			// reset every 30 min
		}
		return $aData;
	}


	/**
	 * Построить фильтр для запроса списка голосований пользователя
	 *
	 * @param $aFilter			фильтр
	 * @return string			строка sql запроса
	 */
	protected function BuildFilterForVotingList($aFilter) {
		$sWhere = '';
		if (isset($aFilter['type']) and $aFilter['type']) {
			$sWhere .= ' AND `target_type` = "' . $aFilter['type'] . '"';
		}
		if (isset($aFilter['direction']) and $aFilter['direction']) {
			$sWhere .= ' AND `vote_direction` = ' . ($aFilter['direction'] == 'plus' ? '1' : '-1');
		}
		return $sWhere;
	}


	/**
	 * Для списка голосов получить объект и задать новые универсализированные параметры (заголовок и ссылку на сам обьект)
	 *
	 * @param array $aVotingList	массив голосов
	 * @throws Exception
	 */
	public function GetTargetObjectsFromVotingList($aVotingList) {
		foreach($aVotingList as $oVote) {
			switch ($oVote->getTargetType()) {
				case 'topic':
					if ($oTopic = $this->Topic_GetTopicById($oVote->getTargetId())) {
						$oVote->setTargetTitle($oTopic->getTitle());
						$oVote->setTargetFullUrl($oTopic->getUrl());
					}
					break;
				case 'blog':
					if ($oBlog = $this->Blog_GetBlogById($oVote->getTargetId())) {
						$oVote->setTargetTitle($oBlog->getTitle());
						$oVote->setTargetFullUrl($oBlog->getUrlFull());
					}
					break;
				case 'user':
					if ($oUser = $this->User_GetUserById($oVote->getTargetId())) {
						$oVote->setTargetTitle($oUser->getLogin());
						$oVote->setTargetFullUrl($oUser->getUserWebPath());
					}
					break;
				case 'comment':
					if ($oComment = $this->Comment_GetCommentById($oVote->getTargetId())) {
						$oVote->setTargetTitle($oComment->getText());
						/*
						 * пока только для топиков
						 */
						if ($oComment->getTargetType() == 'topic') {
							$oVote->setTargetFullUrl($oComment->getTarget()->getUrl() . 'comment' . $oComment->getId());
						}
					}
					break;
				default:
					throw new Exception('Admin: error: unsupported target type: "' . $oVote->getTargetType() . '"');
					break;
			}
		}
	}


	/**
	 * Добавить запись о бане
	 *
	 * @param $oBan		объект бана
	 * @return mixed
	 */
	public function AddBanRecord($oBan) {
		// todo: cache
		return $this->oMapper->AddBanRecord ($oBan);
	}


	/**
	 * Возвращает список банов по фильтру
	 *
	 * @param array 	$aFilter		Фильтр
	 * @param array 	$aOrder			Сортировка
	 * @param int 		$iPage			Номер страницы
	 * @param int 		$iPerPage		Количество элментов на страницу
	 * @return array('collection'=>array,'count'=>int)
	 */
	public function GetBansByFilter($aFilter = array(), $aOrder = array(), $iPage = 1, $iPerPage = PHP_INT_MAX) {
		$sOrder = $this -> GetCorrectSortingOrder(
			$aOrder,
			Config::Get('plugin.admin.correct_sorting_bans'),
			Config::Get('plugin.admin.default_sorting_bans')
		);
		$mData = $this -> oMapper -> GetBansByFilter($aFilter, $sOrder, $iPage, $iPerPage);
		return $mData;
	}


	/**
	 * Установить количество банов на странице
	 *
	 * @param $iPerPage		количество
	 */
	public function ChangeBansPerPage($iPerPage) {
		/*
		 * установить количество банов на странице
		 */
		$aData = array(
			'bans' => array(
				'per_page' => $iPerPage,
			)
		);
		$this->PluginAdmin_Settings_SaveConfigByKey('admin', $aData);
	}


	/**
	 * Установить количество голосов на странице
	 *
	 * @param $iPerPage		количество
	 */
	public function ChangeVotesPerPage($iPerPage) {
		/*
		 * установить количество голосов на странице
		 */
		$aData = array(
			'votes' => array(
				'per_page' => $iPerPage,
			)
		);
		$this->PluginAdmin_Settings_SaveConfigByKey('admin', $aData);
	}


	/**
	 * Получить объект бана по ид
	 *
	 * @param $iId		ид бана
	 * @return mixed
	 */
	public function GetBanById($iId) {
		$aFilter = array(
			'id' => $iId,
		);
		$sOrder = $this -> GetCorrectSortingOrder(
			array(),
			Config::Get('plugin.admin.correct_sorting_bans'),
			Config::Get('plugin.admin.default_sorting_bans')
		);
		$aData = $this->oMapper->GetBansByFilter($aFilter, $sOrder, 1, 1);
		return ($aData['count'] ? array_shift($aData['collection']) : null);
	}


	/**
	 * Удалить бан по ид
	 *
	 * @param $iId		ид бана
	 * @return mixed
	 */
	public function DeleteBanById($iId) {
		// todo: cache
		return $this->oMapper->DeleteBanById($iId);
	}


	/**
	 * Проверить является ли текущий пользователь забаненным
	 *
	 * @return object	объект бана
	 */
	public function IsThisUserBanned() {
		// todo: cache
		$oUserCurrent = $this->User_GetUserCurrent();
		$mIp = convert_ip2long(func_getIp());
		$sCurrentDate = date('Y-m-d H:i:s');
		return $this->oMapper->IsThisUserBanned($oUserCurrent, $mIp, $sCurrentDate);
	}


	/**
	 * Удалить старые записи банов, дата окончания которых уже прошла
	 */
	public function DeleteOldBanRecords() {
		// todo: cache
		$this->oMapper->DeleteOldBanRecords();
	}


	/**
	 * Добавить запись о срабатывании бана в статистику
	 *
	 * @param $oBan
	 */
	public function AddBanStat($oBan) {
		/*
		 * получить статистику по банам
		 */
		$aStats = $this->GetBanStats();
		/*
		 * увеличить счетчик статистики на единицу
		 */
		$aStats[$oBan->getId()] = (isset($aStats[$oBan->getId()]) ? $aStats[$oBan->getId()] + 1 : 1);
		/*
		 * сохранить данные статистики
		 */
		$this->Storage_Set(self::BAN_STATS_PARAM_NAME, $aStats, $this);
	}


	/**
	 * Получить статистику по банам
	 *
	 * @return array
	 */
	public function GetBanStats() {
		return (array) $this->Storage_Get(self::BAN_STATS_PARAM_NAME, $this);
	}


	/**
	 * Удалить статистику бана
	 *
	 * @param $oBan		объект бана
	 */
	public function DeleteBanStats($oBan) {
		/*
		 * получить статистику по банам
		 */
		$aStats = $this->GetBanStats();
		/*
		 * удалить счетчик статистики бана
		 */
		unset($aStats[$oBan->getId()]);
		/*
		 * сохранить данные статистики
		 */
		$this->Storage_Set(self::BAN_STATS_PARAM_NAME, $aStats, $this);
	}


	/**
	 * Добавить права админа пользователю
	 *
	 * @param $oUser		объект пользователя
	 * @return mixed
	 */
	public function AddAdmin($oUser) {
		$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('user_update'));
		$this->Cache_Delete("user_{$oUser->getId()}");
		return $this->oMapper->AddAdmin($oUser->getId());
	}


	/**
	 * Удалить права админа у пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @return mixed
	 */
	public function DeleteAdmin($oUser) {
		$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('user_update'));
		$this->Cache_Delete("user_{$oUser->getId()}");
		return $this->oMapper->DeleteAdmin($oUser->getId());
	}


	/**
	 * Удалить контент пользователя и самого пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $bDeleteUser	удалять ли самого пользователя
	 */
	public function PerformUserContentDeletion($oUser, $bDeleteUser = false) {
		/*
		 * блокировать пользователя перед удалением данных. Например, если это бот,
		 * то чтобы не получилось одновременно удаление и набивание им контента на сайте
		 */
		$iBanId = $this->BanUserPermanently($oUser);
		/*
		 * выполнить непосредственное удаление контента
		 */
		$this->DeleteUserContent($oUser);
		/*
		 * удаление самого пользователя из сайта
		 */
		if ($bDeleteUser) {
			$this->oMapper->DeleteUser($oUser->getId());
		}
		/*
		 * удалить временную блокировку пользователя
		 */
		$this->DeleteBanById($iBanId);
	}


	/**
	 * Заблокировать пользователя (постоянный бан)
	 *
	 * @param $oUser			объект пользователя
	 * @return bool|mixed
	 */
	protected function BanUserPermanently($oUser) {
		$oEnt = Engine::GetEntity('PluginAdmin_Users_Ban');
		/*
		 * тип блокировки
		 */
		$oEnt->setBlockType(PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID);
		$oEnt->setUserId($oUser->getId());
		/*
		 * тип временного интервала блокировки
		 */
		$oEnt->setTimeType(PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT);
		$oEnt->setDateStart('2000-01-01');
		$oEnt->setDateFinish('2030-01-01');
		/*
		 * дата создания и редактирования
		 */
		$oEnt->setAddDate(date('Y-m-d H:i:s'));
		$oEnt->setEditDate(date('Y-m-d H:i:s'));
		/*
		 * причина бана и комментарий
		 */
		$oEnt->setReasonForUser('admin: auto blocking before deleting content');
		$oEnt->setComment($oEnt->getReasonForUser());

		/*
		 * валидация внесенных данных
		 */
		if (!$oEnt -> _Validate ()) {
			$this -> Message_AddError ($oEnt -> _getValidateError ());
			return false;
		}
		return $this->AddBanRecord($oEnt);
	}


	/**
	 * Удалить весь контент пользователя
	 *
	 * @param $oUser		объект пользователя
	 */
	protected function DeleteUserContent($oUser) {
		/*
		 * вызов хука для удаления контента от плагинов сторонних разработчиков
		 */
		$this->Hook_Run('admin_delete_content_before', array('oUser' => $oUser));
		/*
		 * сначала удалить блоги и топики чтобы избежать самоблокировок таблиц
		 */
		if ($aBlogsId = $this -> Blog_GetBlogsByOwnerId($oUser->getId(), true)) {
			foreach ($aBlogsId as $iBlogId) {
				$this->Blog_DeleteBlog($iBlogId);
			}
		}
		/*
		 * удалить персональный блог
		 */
		if ($oBlog = $this->Blog_GetPersonalBlogByUserId($oUser->getId())) {
			$this->Blog_DeleteBlog($oBlog->GetId());
		}
		/*
		 * удаление личных сообщений
		 */
		$aTalks = $this->Talk_GetTalksByFilter(array('user_id' => $oUser->getId()), 1, PHP_INT_MAX);
		if ($aTalks ['count']) {
			$aTalksId = array();
			foreach ($aTalks['collection'] as $oTalk) {
				$aTalksId[] = $oTalk->getId();
			}
			if ($aTalksId) {
				$this->Talk_DeleteTalkUserByArray($aTalksId, $oUser->getId());
			}
		}
		/*
		 * удалить голоса пользователя
		 */
		$this -> Vote_DeleteVoteByTarget ($oUser->getId(), 'user');
		/*
		 * вызов хука для удаления контента от плагинов сторонних разработчиков
		 */
		$this->Hook_Run('admin_delete_content_after', array('oUser' => $oUser));
		/*
		 * удалить весь кеш - слишком много зависимостей
		 */
		$this->Cache_Clean();
	}


	/**
	 * Возвращает данные последнего входа на основе даты и ip
	 *
	 * @return array
	 */
	public function GetLastVisitData() {
		$aData = (array) $this->Storage_Get($this->GetAdminLastVisitKeyForUser(), $this);
		if (isset($aData['ip'])) {
			/*
			 * текущий ip не изменился с момента прошлого входа
			 */
			$aData['same_ip'] = func_getIp() == $aData['ip'];
		}
		return $aData;
	}


	/**
	 * Возвращает имя параметра данных последнего визита хранилища для текущего пользователя
	 *
	 * @return string
	 */
	protected function GetAdminLastVisitKeyForUser() {
		return self::ADMIN_LAST_VISIT_DATA_STORAGE_KEY . '_' . $this->User_GetUserCurrent()->getId();
	}


	/**
	 * записать данные последнего входа пользователя в админку
	 */
	public function SetLastVisitData() {
		$aData = array(
			/*
			 * дата последнего входа
			 */
			'date' => date("Y-m-d H:i:s"),
			/*
			 * ip последнего входа
			 */
			'ip' => func_getIp(),
		);
		$this->Storage_Set($this->GetAdminLastVisitKeyForUser(), $aData, $this);
	}


	/**
	 * Получить статистику пользователей по возрасту
	 *
	 * @return mixed
	 */
	public function GetUsersBirthdaysStats() {
		/*
		 * кешировать здесь нечего - т.к. выборка идет по всей таблице, а данные пользователей меняются очень часто,
		 * то смысла в кешировании нет, т.к. кеш будет постоянно сбрасываться, только лишние операции
		 */
		$aData = $this->oMapper->GetUsersBirthdaysStats();
		/*
		 * получить максимальное значение пользователей одного возраста для расчетов при выводе графиков
		 */
		$iMaxOneAgeUsersCount = 0;
		foreach ($aData as $aItem) {
			if ($aItem['count'] > $iMaxOneAgeUsersCount) $iMaxOneAgeUsersCount = $aItem['count'];
		}
		return array(
			'collection' => $aData,
			'max_one_age_users_count' => $iMaxOneAgeUsersCount
		);
	}


	/**
	 * Получить статистику стран или городов
	 *
	 * @param $sLivingSection	тип разреза: страны или города
	 * @param $sSorting			сортировка
	 * @return mixed
	 */
	public function GetUsersLivingStats($sLivingSection, $sSorting) {
		/*
		 * кешировать здесь нечего - т.к. выборка идет по всей таблице, а данные пользователей меняются очень часто,
		 * то смысла в кешировании нет, т.к. кеш будет постоянно сбрасываться, только лишние операции
		 */
		return array(
			'collection' => $this->oMapper->GetUsersLivingStats(
				$this->GetLivingStatsSQLGroupCondition($sLivingSection),
				$this->GetLivingStatsSQLSortingCondition($sSorting)
			)
		);
	}


	/**
	 * Получение поля таблицы по которому нужно отобрать и сгруппировать данные для показа статистики по странам/городам
	 *
	 * @param $sLivingSection	разрез отбора
	 * @return string
	 */
	protected function GetLivingStatsSQLGroupCondition($sLivingSection) {
		if ($sLivingSection == 'cities') {
			return 'user_profile_city';
		}
		return 'user_profile_country';
	}


	/**
	 * Поле таблицы для сортировки в зависимости от типа сортировки
	 *
	 * @param $sSorting			тип сортировки
	 * @return string			поле таблицы
	 */
	protected function GetLivingStatsSQLSortingCondition($sSorting) {
		if ($sSorting == 'alphabetic') {
			/*
			 * сортировка по полю группировки
			 */
			return 'item';
		}
		/*
		 * сортировка по количеству пользователей страны или города
		 */
		return 'count';
	}


	/**
	 * Получить статистику регистраций пользователей
	 *
	 * @param $aPeriod		период
	 * @return mixed
	 */
	public function GetUsersRegistrationStats($aPeriod) {
		return $this->oMapper->GetUsersRegistrationStats($aPeriod, $this->PluginAdmin_Stats_BuildDateFormatFromPHPToMySQL($aPeriod['format']));
	}

}

?>