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
	 * @throws Exception
	 * @return array
	 */
	protected function CalcUserVotingStats($oUser) {
		/*
		 * заполнить значениями по-умолчанию
		 */
		$aVotingStats = array(
			'topic' => array('plus' => 0, 'minus' => 0, 'abstain' => 0),
			'comment' => array('plus' => 0, 'minus' => 0, 'abstain' => 0),
			'blog' => array('plus' => 0, 'minus' => 0, 'abstain' => 0),
			'user' => array('plus' => 0, 'minus' => 0, 'abstain' => 0),
		);
		$aResult = $this->oMapper->GetUserVotingStats ($oUser->getId());
		/*
		 * собрать данные в удобном виде
		 */
		foreach ($aResult as $aData) {
			switch ($aData['vote_direction']) {
				case 1:
					$aVotingStats[$aData['target_type']]['plus'] = $aData['count'];
					break;
				case -1:
					$aVotingStats[$aData['target_type']]['minus'] = $aData['count'];
					break;
				case 0:
					$aVotingStats[$aData['target_type']]['abstain'] = $aData['count'];
					break;
				default:
					throw new Exception('admin: error: unknown voting direction in ' . __METHOD__);
			}
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


	/*
	 *
	 * --- Изменение количества элементов на страницу ---
	 *
	 */


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


	/*
	 *
	 * --- Баны ---
	 *
	 */


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
		// todo: cache
		$sOrder = $this -> GetCorrectSortingOrder(
			$aOrder,
			Config::Get('plugin.admin.correct_sorting_bans'),
			Config::Get('plugin.admin.default_sorting_bans')
		);
		$mData = $this->oMapper->GetBansByFilter($aFilter, $sOrder, $iPage, $iPerPage);
		return $mData;
	}


	/**
	 * Получить объект бана по id
	 *
	 * @param $iId		ид бана
	 * @return mixed
	 */
	public function GetBanById($iId) {
		// todo: cache
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
	 * Удалить старые записи банов, дата окончания которых уже прошла
	 */
	public function DeleteOldBanRecords() {
		// todo: cache
		$this->oMapper->DeleteOldBanRecords();
	}


	/*
	 *
	 * --- Проверка бана ---
	 *
	 */


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


	/*
	 *
	 * --- Статистика по банам ---
	 *
	 */


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


	/*
	 *
	 * --- Назначение/удаление администраторов ---
	 *
	 */


	/**
	 * Добавить права админа пользователю
	 *
	 * @param $oUser		объект пользователя
	 * @return mixed
	 */
	public function AddAdmin($oUser) {
		$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('user_update'));
		$this->Cache_Delete('user_' . $oUser->getId());
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
		$this->Cache_Delete('user_' . $oUser->getId());
		return $this->oMapper->DeleteAdmin($oUser->getId());
	}


	/*
	 *
	 * --- Удаление контента ---
	 *
	 */


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
		 * review: если будут проблемы с удалением объектов выше - можно весь процесс удаления перевести на модуль удаления (как в вызовах ниже)
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
		 * удалить подписку активности пользователя на других пользователей
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserStreamSubscribe($oUser);
		/*
		 * удалить подписку активности других пользователей на этого пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserStreamSubscribeTarget($oUser);
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
		 * удалить подписку фида других пользователей на этого пользователя
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserFeedSubscribeTarget($oUser);

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
		 * удалить записи пользователя на других стенах
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserWroteOnWalls($oUser);


		/*
		 *
		 * Удаление комментариев
		 *
		 * Комментарии - не линейная структура, поэтому процесс удаления будет состоять из удаления комментариев пользователя,
		 * очистки оставшихся дочерних комментариев (ответов) и перестроения структуры дерева (если используется "nested set")
		 * и удаляения записей голосований и избранного для удаленных веток комментариев
		 *
		 */

		/*
		 * удалить комментарии пользователя и все дочерние ответы на них и связанные с ними данные
		 */
		$this->DeleteUserCommentsTree($oUser);


		/*
		 *
		 * Очистка активности (стрима) от ссылок на записи, которых больше нет
		 *
		 */
		$this->PluginAdmin_Deletecontent_CleanStreamForEventsNotExists();
	}


	/**
	 * Удалить комментарии пользователя, все дочерние комментарии к ним и связанные данные
	 *
	 * @param $oUser	объект пользователя
	 */
	protected function DeleteUserCommentsTree($oUser) {
		/*
		 * удалить все прямые комментарии пользователя
		 * (они не все были удалены ранее т.к. часть из них может находится в топиках других пользователей)
		 */
		$this->PluginAdmin_Deletecontent_DeleteUserOwnComments($oUser);

		/*
		 * теперь в таблице комментариев могут быть ответы у которых comment_pid указывает на несуществующие комментарии этого пользователя
		 * (это нормально т.к. проверка ключей должна быть отключена на момент удаления).
		 * очистка таблицы прямого эфира - там могут быть записи, указывающие на несуществующие комментарии, которые только что были удалены,
		 * очистка других связанных данных
		 */
		$this->PluginAdmin_Deletecontent_DeleteBrokenChainsFromCommentsTreeAndOnlineCommentsAndCleanUpOtherTables();
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


	/*
	 *
	 * --- Последний визит ---
	 *
	 */


	/**
	 * Возвращает данные последнего входа на основе даты и ip персонально для каждого пользователя
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
	 * записать данные последнего входа пользователя в админку персонально для каждого пользователя
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


	/*
	 *
	 * --- Статистика ---
	 *
	 */


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


	/*
	 *
	 * --- Редактирование данных пользователя ---
	 *
	 */


	/**
	 * Выполнить изменение данных в таблице пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $aChanges		массив необходимых изменений field => value
	 */
	protected function ModifyUserData($oUser, $aChanges) {
		$this->oMapper->Update($oUser, $aChanges);
		$this->Cache_Clean();
	}


	/**
	 * Сменить логин пользователя на новый
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserLogin($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_login' => $sNewValue));
	}


	/**
	 * Сменить имя пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserName($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_profile_name' => $sNewValue));
	}


	/**
	 * Сменить почту пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserMail($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_mail' => $sNewValue));
	}


	/**
	 * Сменить пароль пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserPassword($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_password' => func_encrypt($sNewValue)));
	}


	/**
	 * Сменить рейтинг пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserRating($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_rating' => $sNewValue));
	}


	/**
	 * Сменить силу пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserSkill($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_skill' => $sNewValue));
	}


	/**
	 * Сменить описание пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserAbout($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_profile_about' => $sNewValue));
	}


	/**
	 * Сменить стать пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserSex($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_profile_sex' => $sNewValue));
	}


	/**
	 * Сменить дату рождения пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $sNewValue	новое значение
	 */
	protected function ChangeUserBirthday($oUser, $sNewValue) {
		$this->ModifyUserData($oUser, array('user_profile_birthday' => $sNewValue));
	}


	/**
	 * Сменить geo-данные пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @param $oGeo			новое значение
	 */
	protected function ChangeUserGeo($oUser, $oGeo) {
		/*
		 * установить связь "пользователь - гео-привязка"
		 */
		$this->Geo_CreateTarget($oGeo, 'user', $oUser->getId());
		/*
		 * задать страну
		 */
		if ($oCountry = $oGeo->getCountry()) {
			$oUser->setProfileCountry($oCountry->getName());
		} else {
			$oUser->setProfileCountry(null);
		}
		/*
		 * задать регион
		 */
		if ($oRegion = $oGeo->getRegion()) {
			$oUser->setProfileRegion($oRegion->getName());
		} else {
			$oUser->setProfileRegion(null);
		}
		/*
		 * задать город
		 */
		if ($oCity = $oGeo->getCity()) {
			$oUser->setProfileCity($oCity->getName());
		} else {
			$oUser->setProfileCity(null);
		}
		$this->User_Update($oUser);
	}


	/**
	 * Задать для пользователя гео-данные на основе типа
	 *
	 * @param $oUser		объект пользователя
	 * @param $sType		тип ('country', 'region', 'city')
	 * @param $iId			ид объекта (типа)
	 * @throws Exception
	 * @return string
	 */
	protected function SetUserGeoToType($oUser, $sType, $iId) {
		/*
		 * проверить тип
		 */
		if (!in_array($sType, array('country', 'region', 'city'))) {
			throw new Exception('Admin: error: unknown geo type "' . $sType . '" in ' . __METHOD__);
		}
		/*
		 * установить связь "пользователь - гео-запись" и обновить профиль пользователя
		 */
		if ($oGeo = $this->Geo_GetGeoObject($sType, $iId)) {
			$this->ChangeUserGeo($oUser, $oGeo);
			/*
			 * вернуть отображаемое значение
			 */
			return $oGeo->getName();
		}
		return null;
	}


	/**
	 * Задать для пользователя гео-данные на основе страны
	 *
	 * @param $oUser	объект пользователя
	 * @param $iId		ид страны
	 * @return string
	 */
	protected function SetUserGeoToCountry($oUser, $iId) {
		return $this->SetUserGeoToType($oUser, 'country', $iId);
	}


	/**
	 * Задать для пользователя гео-данные на основе региона
	 *
	 * @param $oUser	объект пользователя
	 * @param $iId		ид региона
	 * @return string
	 */
	protected function SetUserGeoToRegion($oUser, $iId) {
		return $this->SetUserGeoToType($oUser, 'region', $iId);
	}


	/**
	 * Задать для пользователя гео-данные на основе города
	 *
	 * @param $oUser	объект пользователя
	 * @param $iId		ид города
	 * @return string
	 */
	protected function SetUserGeoToCity($oUser, $iId) {
		return $this->SetUserGeoToType($oUser, 'city', $iId);
	}


	/**
	 * Изменить данные пользователя
	 *
	 * @param $sType	тип поля для редактирования
	 * @param $oUser	объект пользователя
	 * @param $sValue	новое значение
	 * @return mixed
	 */
	public function PerformUserDataModification($sType, $oUser, $sValue) {
		$sReturnValue = $sValue;
		/*
		 * выполнить действие на основе его типа
		 */
		switch($sType) {
			/*
			 * редактировать логин пользователя
			 */
			case 'login':
				$this->ChangeUserLogin($oUser, $sValue);
				break;
			/*
			 * редактировать имя пользователя
			 */
			case 'profile_name':
				$this->ChangeUserName($oUser, $sValue);
				break;
			/*
			 * редактировать почту пользователя
			 */
			case 'mail':
				$this->ChangeUserMail($oUser, $sValue);
				break;
			/*
			 * редактировать пароль пользователя
			 */
			case 'password':
				$this->ChangeUserPassword($oUser, $sValue);
				break;
			/*
			 * редактировать рейтинг пользователя
			 */
			case 'rating':
				$this->ChangeUserRating($oUser, $sValue);
				break;
			/*
			 * редактировать силу пользователя
			 */
			case 'skill':
				$this->ChangeUserSkill($oUser, $sValue);
				break;
			/*
			 * редактировать описание о себе пользователя
			 */
			case 'about':
				$this->ChangeUserAbout($oUser, $sValue);
				break;
			/*
			 * редактировать стать пользователя
			 */
			case 'sex':
				$this->ChangeUserSex($oUser, $sValue);
				/*
				 * вернуть текстовое отображение
				 */
				$sReturnValue = $this->Lang_Get('plugin.admin.users.sex.' . $this->ReloadUserData($oUser)->getProfileSex());
				break;


			/*
			 * др пользователя (день)
			 */
			case 'birthday_day':
				$this->ChangeUserBirthday($oUser, date('Y-m-d H:i:s', mktime(0, 0, 0,
					date('m', strtotime($oUser->getProfileBirthday())),
					$sValue,
					date('Y', strtotime($oUser->getProfileBirthday()))
				)));
				break;
			/*
			 * др пользователя (месяц)
			 */
			case 'birthday_month':
				$this->ChangeUserBirthday($oUser, date('Y-m-d H:i:s', mktime(0, 0, 0,
					$sValue,
					date('d', strtotime($oUser->getProfileBirthday())),
					date('Y', strtotime($oUser->getProfileBirthday()))
				)));
				/*
				 * вернуть текстовое отображение
				 */
				$sReturnValue = $this->Lang_Get('month_array.' . (string) $sValue . '.0');
				break;
			/*
			 * др пользователя (год)
			 */
			case 'birthday_year':
				$this->ChangeUserBirthday($oUser, date('Y-m-d H:i:s', mktime(0, 0, 0,
					date('m', strtotime($oUser->getProfileBirthday())),
					date('d', strtotime($oUser->getProfileBirthday())),
					$sValue
				)));
				break;

			/*
			 * место проживания: страна
			 */
			case 'living_country':
				$sReturnValue = $this->SetUserGeoToCountry($oUser, $sValue);
				break;
			/*
			 * место проживания: регион
			 */
			case 'living_region':
				$sReturnValue = $this->SetUserGeoToRegion($oUser, $sValue);
				break;
			/*
			 * место проживания: город
			 */
			case 'living_city':
				$sReturnValue = $this->SetUserGeoToCity($oUser, $sValue);
				break;

			/*
			 * действие не найдено
			 */
			default:
				return false;
		}
		return $sReturnValue;
	}


	/**
	 * Обновить сущность пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return mixed	акуальная сущность
	 */
	protected function ReloadUserData($oUser) {
		return $this->User_GetUserById($oUser->getId());
	}


	/*
	 *
	 * --- Получение данных пользователя ---
	 *
	 */


	/**
	 * Сравнить ключ и текущее значение. Вернуть 'selected' если ключ и текущее значение совпадают, иначе вернуть ключ
	 *
	 * @param $sKey			ключ
	 * @param $sCurrentKey	текущее значение
	 * @return string
	 */
	protected function GetArrayKeyComparedWithCurrentValue($sKey, $sCurrentKey) {
		return $sKey == $sCurrentKey ? 'selected' : $sKey;
	}


	/**
	 * Получить массив данных для выбора стати пользователя
	 *
	 * @param $oUser		объект пользователя
	 * @return array
	 */
	protected function GetDataForUserSexAndSelectedByUser($oUser) {
		return array(
			$this->GetArrayKeyComparedWithCurrentValue('man', $oUser->getProfileSex()) => $this->Lang_Get('plugin.admin.users.sex.man'),
			$this->GetArrayKeyComparedWithCurrentValue('woman', $oUser->getProfileSex()) => $this->Lang_Get('plugin.admin.users.sex.woman'),
			$this->GetArrayKeyComparedWithCurrentValue('other', $oUser->getProfileSex()) => $this->Lang_Get('plugin.admin.users.sex.other'),
		);
	}


	/**
	 * Получить массив данных для выбора даты рождения пользователя по частям
	 *
	 * @param $oUser		объект пользователя
	 * @param $sPart		часть даты ('day', 'month', 'year')
	 * @return array
	 * @throws Exception
	 */
	protected function GetDataForUserBirthdayAndSelectedByUserAndPart($oUser, $sPart) {
		/*
		 * набор частей даты
		 */
		$aDates = array();
		/*
		 * текущая, установленная пользователем, часть (число дня, месяца или года)
		 */
		$sCurrentDatePart = null;
		/*
		 * найти параметры даты для нужной её части (текущее значение, границы от и до)
		 * tip: цикл специально внесен в каждый кейс т.к. для месяцев нужно отображать их названия, а не числа
		 */
		switch ($sPart) {
			case 'day':
				/*
				 * если пользователь указал дату рождения - получить текущее значение
				 */
				if ($oUser->getProfileBirthday()) {
					$sCurrentDatePart = date('d', strtotime($oUser->getProfileBirthday()));
				}
				/*
				 * заполнить набор нужных частей даты
				 */
				for ($i = 1; $i <= 31; $i ++) {
					$aDates[$this->GetArrayKeyComparedWithCurrentValue($i, $sCurrentDatePart)] = $i;
				}
				break;
			case 'month':
				/*
				 * если пользователь указал дату рождения - получить текущее значение
				 */
				if ($oUser->getProfileBirthday()) {
					$sCurrentDatePart = date('m', strtotime($oUser->getProfileBirthday()));
				}
				/*
				 * заполнить набор нужных частей даты
				 */
				for ($i = 1; $i <= 12; $i ++) {
					$aDates[$this->GetArrayKeyComparedWithCurrentValue($i, $sCurrentDatePart)] = $this->Lang_Get('month_array.' . (string) $i . '.0');
				}
				break;
			case 'year':
				/*
				 * если пользователь указал дату рождения - получить текущее значение
				 */
				if ($oUser->getProfileBirthday()) {
					$sCurrentDatePart = date('Y', strtotime($oUser->getProfileBirthday()));
				}
				/*
				 * заполнить набор нужных частей даты
				 */
				for ($i = 1940; $i <= date('Y'); $i ++) {
					$aDates[$this->GetArrayKeyComparedWithCurrentValue($i, $sCurrentDatePart)] = $i;
				}
				break;
			default:
				throw new Exception('Admin: error: unknown birthday part "' . $sPart . '" in ' . __METHOD__);
		}
		return $aDates;
	}


	/**
	 * Получить массив данных для выбора места проживания пользователя по частям
	 *
	 * @param $oUser		объект пользователя
	 * @param $sPart		часть места проживания ('country', 'region', 'city')
	 * @return array
	 * @throws Exception
	 */
	protected function GetDataForUserLivingAndSelectedByUserAndPart($oUser, $sPart) {
		/*
		 * набор данных
		 */
		$aData = array();
		/*
		 * найти параметры для нужного типа
		 */
		switch ($sPart) {
			case 'country':
				$aCountries = $this->Geo_GetCountries(array(), array('sort' => 'asc'), 1, 300);
				/*
				 * получить набор данных, пометив текущий ключ
				 */
				foreach ($aCountries['collection'] as $oCountry) {
					/*
					 * tip: гео-данные автоматически были подгружены при получении пользователя по ид
					 */
					$aData[$this->GetArrayKeyComparedWithCurrentValue($oCountry->getId(), $this->_GetUserGEODataOrNull($oUser, 'country_id'))] = $oCountry->getName();
				}
				break;
			case 'region':
				/*
				 * tip: гео-данные автоматически были подгружены при получении пользователя по ид
				 */
				$aRegions = $this->Geo_GetRegions(array('country_id' => $this->_GetUserGEODataOrNull($oUser, 'country_id')), array('sort' => 'asc'), 1, 500);
				/*
				 * получить набор данных, пометив текущий ключ
				 */
				foreach ($aRegions['collection'] as $oRegion) {
					/*
					 * tip: гео-данные автоматически были подгружены при получении пользователя по ид
					 */
					$aData[$this->GetArrayKeyComparedWithCurrentValue($oRegion->getId(), $this->_GetUserGEODataOrNull($oUser, 'region_id'))] = $oRegion->getName();
				}
				break;
			case 'city':
				/*
				 * tip: гео-данные автоматически были подгружены при получении пользователя по ид
				 */
				$aCities = $this->Geo_GetCities(array('region_id' => $this->_GetUserGEODataOrNull($oUser, 'region_id')), array('sort' => 'asc'), 1, 500);
				/*
				 * получить набор данных, пометив текущий ключ
				 */
				foreach ($aCities['collection'] as $oCity) {
					/*
					 * tip: гео-данные автоматически были подгружены при получении пользователя по ид
					 */
					$aData[$this->GetArrayKeyComparedWithCurrentValue($oCity->getId(), $this->_GetUserGEODataOrNull($oUser, 'city_id'))] = $oCity->getName();
				}
				break;
			default:
				throw new Exception('Admin: error: unknown living part "' . $sPart . '" in ' . __METHOD__);
		}
		return $aData;
	}


	/**
	 * Получить ид страны, региона или города гео-данных пользователя или null если их нет
	 *
	 * @param $oUser	объект пользователя
	 * @param $sType	тип запроса (ид страны, региона или города)
	 * @return int|null
	 * @throws Exception
	 */
	protected function _GetUserGEODataOrNull($oUser, $sType) {
		if (!$oUser->getGeoTarget()) return null;
		switch ($sType) {
			case 'country_id':
				return $oUser->getGeoTarget()->getCountryId();
			case 'region_id':
				return $oUser->getGeoTarget()->getRegionId();
			case 'city_id':
				return $oUser->getGeoTarget()->getCityId();
			default:
				throw new Exception('Admin: error: unknown living type "' . $sType . '" in ' . __METHOD__);
		}
	}


	/**
	 * Получить данные пользователя на основе типа вместе с текущим значением (ключ "selected")
	 *
	 * @param $sType	тип
	 * @param $oUser	объект пользователя
	 * @return mixed
	 */
	public function GetUserDataByType($sType, $oUser) {
		switch ($sType) {
			/*
			 * пол пользователя
			 */
			case 'sex':
				return $this->GetDataForUserSexAndSelectedByUser($oUser);
			/*
			 * др пользователя (день)
			 */
			case 'birthday_day':
				return $this->GetDataForUserBirthdayAndSelectedByUserAndPart($oUser, 'day');
			/*
			 * др пользователя (месяц)
			 */
			case 'birthday_month':
				return $this->GetDataForUserBirthdayAndSelectedByUserAndPart($oUser, 'month');
			/*
			 * др пользователя (год)
			 */
			case 'birthday_year':
				return $this->GetDataForUserBirthdayAndSelectedByUserAndPart($oUser, 'year');
			/*
			 * место проживания: страна
			 */
			case 'living_country':
				return $this->GetDataForUserLivingAndSelectedByUserAndPart($oUser, 'country');
			/*
			 * место проживания: регион
			 */
			case 'living_region':
				return $this->GetDataForUserLivingAndSelectedByUserAndPart($oUser, 'region');
			/*
			 * место проживания: город
			 */
			case 'living_city':
				return $this->GetDataForUserLivingAndSelectedByUserAndPart($oUser, 'city');
			/*
			 * действие не найдено
			 */
			default:
				return false;
		}
	}

}

?>