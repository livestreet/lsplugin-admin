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
		if (is_null($aAllowData)) {
			$aAllowData = array('session');
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
							$oVote->setTargetFullUrl($oComment->getTarget()->getUrl() . '#comment' . $oComment->getId());
						}
					}
					break;
				default:
					throw new Exception('Admin: error: unsupported target type: "' . $oVote->getTargetType() . '" in ' . __METHOD__);
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
		return $this->oMapper->AddBanRecord($oBan);
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
	 * Получить объект бана по id
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
	 * Удалить бан по id
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
		/*
		 * кешированию не подлежит
		 */
		$oUserCurrent = $this->User_GetUserCurrent();
		$mIp = convert_ip2long(func_getIp());
		$sCurrentDate = date('Y-m-d H:i:s');
		return $this->oMapper->IsThisUserBanned($oUserCurrent, $mIp, $sCurrentDate);
	}


	/**
	 * Проверить является ли указанный пользователь забаненным по его сущности, айпи последнего захода или айпи регистрации
	 *
	 * @param $oUser	объект пользователя
	 * @return mixed
	 */
	public function GetUserBannedByUser($oUser) {
		/*
		 * кешированию не подлежит
		 */
		if ($oSession = $oUser->getSession()) {
			$mIp = $oSession->getIpLast();
		} else {
			$mIp = $oUser->getIpRegister();
		}
		$mIp = convert_ip2long($mIp);
		$sCurrentDate = date('Y-m-d H:i:s');
		return $this->oMapper->IsThisUserBanned($oUser, $mIp, $sCurrentDate);
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
		 * отключить ограничение по времени для обработки
		 */
		set_time_limit(0);
		/*
		 * блокировать пользователя перед удалением данных. Например, если это бот,
		 * то чтобы не получилось одновременно удаление его данных и набивание им контента на сайте
		 */
		$iBanId = $this->BanUserPermanently($oUser);
		/*
		 * отключить проверку внешних связей
		 * (каждая таблица будет чиститься вручную)
		 */
		$this->PluginAdmin_Deletecontent_DisableForeignKeysChecking();
		/*
		 * выполнить непосредственное удаление контента
		 */
		$this->DeleteUserContent($oUser, $bDeleteUser);
		/*
		 * удаление самого пользователя из сайта
		 */
		if ($bDeleteUser) {
			$this->DeleteUser($oUser);
		}
		/*
		 * включить проверку внешних связей
		 */
		$this->PluginAdmin_Deletecontent_EnableForeignKeysChecking();
		/*
		 * удалить весь кеш - слишком много зависимостей
		 */
		$this->Cache_Clean();
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
		$oEnt->setEditDate($oEnt->getAddDate());
		/*
		 * причина бана и комментарий
		 */
		$oEnt->setReasonForUser('admin: auto blocking before deleting content');
		$oEnt->setComment($oEnt->getReasonForUser());

		/*
		 * валидация внесенных данных
		 */
		if (!$oEnt -> _Validate()) {
			$this -> Message_AddError($oEnt -> _getValidateError ());
			return false;
		}
		return $this->AddBanRecord($oEnt);
	}


	/**
	 * Удалить весь контент пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $bDeleteUser	флаг удаления пользователя (нужен для удаления личного блога)
	 */
	protected function DeleteUserContent($oUser, $bDeleteUser) {
		/*
		 * вызов хука для удаления контента от плагинов сторонних разработчиков ПЕРЕД удалением внутренних данных
		 */
		$this->Hook_Run('admin_delete_content_before', array('oUser' => $oUser));
		/*
		 * удаление контента формируемого и управляемого движком
		 */
		$this->DeleteInternalUserContent($oUser, $bDeleteUser);
		/*
		 * вызов хука для удаления контента от плагинов сторонних разработчиков ПОСЛЕ удаления внутренних данных
		 * (запись пользователя в таблице prefix_user ещё существует)
		 */
		$this->Hook_Run('admin_delete_content_after', array('oUser' => $oUser));
	}


	/**
	 * Удалить весь контент пользователя, который обрабатывается и управляется движком (все блоги, топики, сообщения и т.п.)
	 *
	 * @param $oUser		объект пользователя
	 * @param $bDeleteUser	флаг удаления пользователя (нужен для удаления личного блога)
	 */
	protected function DeleteInternalUserContent($oUser, $bDeleteUser) {
		/*
		 *
		 * удалить блоги пользователя и все дочерние элементы блога
		 *
		 */
		/*
		 * получить ид всех блогов пользователя (кроме персонального)
		 */
		if ($aBlogsId = $this -> Blog_GetBlogsByOwnerId($oUser->getId(), true)) {
			foreach ($aBlogsId as $iBlogId) {
				/*
				 * удалить блог
				 * 		его топики (связанные данные топиков:
				 * 			контент топика
				 * 			комментарии к топику (
				 * 				удаляются из избранного,
				 * 				прямого эфира
				 * 				голоса за них
				 * 			)
				 * 			из избранного
				 * 			из прочитанного
				 * 			голосование к топику
				 * 			теги
				 * 			фото у топика-фотосета
				 * 		)
				 * 		связи пользователей блога
				 *		голосование за блог
				 * 		уменьшение счетчика в категории блога
				 */
				$this->Blog_DeleteBlog($iBlogId);
			}
		}

		/*
		 * удалить персональный блог (только если удаляется и сам пользователь)
		 */
		if ($bDeleteUser and $oBlog = $this->Blog_GetPersonalBlogByUserId($oUser->getId())) {
			/*
			 * удаляет все тоже самое что и из предыдущего списка
			 */
			$this->Blog_DeleteBlog($oBlog);
		}

		/*
		 * удаление личных сообщений
		 */
		$aTalks = $this->Talk_GetTalksByFilter(array('user_id' => $oUser->getId()), 1, PHP_INT_MAX);
		if ($aTalks ['count']) {
			/*
			 * получить ид всех личных сообщений
			 */
			$aTalkIds = array();
			foreach ($aTalks['collection'] as $oTalk) {
				$aTalkIds[] = $oTalk->getId();
			}
			if ($aTalkIds) {
				$this->Talk_DeleteTalkUserByArray($aTalkIds, $oUser->getId());
			}
		}

		/*
		 * удалить голоса за профиль пользователя
		 */
		$this->Vote_DeleteVoteByTarget($oUser->getId(), 'user');

		/*
		 * todo: review: если будут проблемы с удалением объектов выше - можно весь процесс удаления перевести на модуль удаления (как в вызовах ниже)
		 */

		/*
		 *
		 * Удаление каждого типа контента по очереди через модуль удаления контента.
		 * Методы для удаления контента идут в алфавитном порядке т.е. в порядке вывода таблиц в пхпмайадмин по-умолчанию,
		 * также сгруппированы логически (например, "удаление записей друзей у пользователя" и рядом "удаление записи пользователя как друга у других пользователей")
		 *
		 */

		/*
		 * удалить избранное пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserFavourite($oUser);
		/*
		 * удалить избранные теги пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserFavouriteTag($oUser);

		/*
		 * удалить друзей пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUsersFriends($oUser);
		/*
		 * удалить пользователя как друга у других пользователей
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserIsFriendForOtherUsers($oUser);

		/*
		 * удалить гео-данные пользователя (запись с указанием его страны, области и города)
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserGeoTargets($oUser);

		/*
		 * удалить записи про инвайты: кого пригласил этот пользователь
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserInviteFrom($oUser);
		/*
		 * удалить записи про инвайты: кем был приглашен этот пользователь
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserInviteTo($oUser);

		/*
		 * удалить записи рассылки уведомлений
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserNotifyTask($oUser);

		/*
		 * удалить напоминания про пароль
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserReminder($oUser);

		/*
		 * удалить события активности пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserStreamEvents($oUser);
		/*
		 * удалить подписку активности пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserStreamSubscribe($oUser);
		/*
		 * удалить опции типов на что подписался в активности пользователь
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserStreamUserType($oUser);

		/*
		 * удалить подписку пользователя на разные события (оповещения)
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserSubscribe($oUser);

		/*
		 * удалить подписку фида пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserFeedSubscribe($oUser);

		/*
		 * удалить смену почты пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserChangeMail($oUser);

		/*
		 * удалить данные произвольных полей профиля пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserFieldValue($oUser);

		/*
		 * удалить заметки пользователя о других пользователях
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserOwnNotes($oUser);
		/*
		 * удалить заметки других пользователей об этом пользователе
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserNotesFromOtherUsers($oUser);

		/*
		 * удалить голоса пользователя за другие объекты
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserVotes($oUser);

		/*
		 * удалить стену пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserWall($oUser);


		/*
		 *
		 * Удаление комментариев
		 *
		 * Комментарии - не линейная структура, поэтому процесс удаления будет состоять из удаления комментариев пользователя,
		 * очистки оставшихся дочерних комментариев (ответов) и перестроения структуры дерева (если используется "nested set").
		 * И удаляения записей голосований и избранного для удаленных веток комментариев
		 *
		 */

		/*
		 * удалить комментарии пользователя и все дочерние ответы на них
		 */
		$this->DeleteUserCommentsTree($oUser);

		/*
		 * очистить другие таблицы от записей, указывающих на удаленные комментарии
		 */
		$this->CleanUpAfterCommentsDeleting();
	}


	/**
	 * Удалить комментарии пользователя и все дочерние комментарии к ним
	 *
	 * @param $oUser	объект пользователя
	 */
	protected function DeleteUserCommentsTree($oUser) {
		/*
		 * удаление комментариев - процесс весьма сложный т.к. на комментарий могут быть ответы,
		 * поэтому комментарии нужно удалять вместе со всеми дочерними комментариями
		 *
		 * Как это работает:
		 * здесь будет удалены сначала прямые комментарии пользователя,
		 * а потом циклом, пока не закончатся, будут удаляться комментарии у которых pid не существует в БД
		 * (это нормально т.к. проверка ключей должна быть отключена на момент удаления)
		 */

		/*
		 * первое - удалить все комментарии пользователя
		 * (они не все были удалены ранее т.к. часть из них может находится в топиках других пользователей)
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserOwnComments($oUser);

		/*
		 * теперь в таблице комментариев могут быть ответы у которых comment_pid указывает на несуществующий комментарий этого пользователя.
		 * порция за порцией, удалять дочерние комментарии от верхнего уровня к нижнему (к самому дальнему ответу)
		 */
		$this->PluginAdmin_Deletecontent_DeleteAllCommentsWithBrokenChains();

		/*
		 * теперь нужно очистить таблицу прямого эфира - там могут быть записи, указывающие на несуществующие комментарии, которые только что были удалены
		 */
		$this->PluginAdmin_Deletecontent_DeleteOnlineCommentsNotExists();
	}


	/**
	 * Произвести очистку после удаления комментариев
	 */
	protected function CleanUpAfterCommentsDeleting() {
		/*
		 * для структуры "nested set" комментариев нужно пересчитать дерево комментариев (всю цепочку справа от первой удаляемой ветви)
		 * todo: данный механизм не протестирован до конца
		 */
		if (Config::Get('module.comment.use_nested')) {
			$this->Comment_RestoreTree();
		}

		/*
		 * очистить таблицы голосований от записей, указывающих на несуществующие комментарии, целые ветки которых были удалены
		 */
		$this->PluginAdmin_Deletecontent_DeleteVotingsTargetingCommentsNotExists();

		/*
		 *  очистить таблицы избранного от записей, указывающих на несуществующие комментарии, целые ветки которых были удалены
		 */
		$this->PluginAdmin_Deletecontent_DeleteFavouriteTargetingCommentsNotExists();

		/*
		 *  очистить таблицы тегов избранного от записей, указывающих на несуществующие комментарии, целые ветки которых были удалены
		 */
		$this->PluginAdmin_Deletecontent_DeleteFavouriteTagsTargetingCommentsNotExists();
	}


	/**
	 * Удалить запись пользователя из БД
	 *
	 * @param $oUser	объект пользователя
	 * @return mixed
	 */
	protected function DeleteUser($oUser) {
		/*
		 * удалить пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserItself($oUser);
		/*
		 * удалить сессию пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserSession($oUser);
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
	 * Поле таблицы для сортировки и направление в зависимости от типа сортировки
	 *
	 * @param $sSorting			тип сортировки
	 * @return string			поле таблицы и направление сортировки
	 */
	protected function GetLivingStatsSQLSortingCondition($sSorting) {
		if ($sSorting == 'alphabetic') {
			/*
			 * сортировка по полю группировки
			 */
			return array('field' => 'item', 'way' => 'ASC');
		}
		/*
		 * сортировка по количеству пользователей страны или города
		 */
		return array('field' => 'count', 'way' => 'DESC');
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


	/**
	 * Получить количество пользователей с позитивным и негативным рейтингом
	 *
	 * @return array
	 */
	public function GetCountGoodAndBadUsers() {
		$aData = $this->oMapper->GetCountGoodAndBadUsers();
		$aData['total'] = $aData['good_users'] + $aData['bad_users'];
		return $aData;
	}

}

?>