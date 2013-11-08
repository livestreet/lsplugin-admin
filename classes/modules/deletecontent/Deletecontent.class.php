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
 * Модуль, который будет удалять контент из БД при удалении пользователя
 *
 * Специфика удаления контента такова, что нужно удалить большое количество данных из БД при помощи простых однотипных методов,
 * поэтому не хочется создавать кучу почти одинаковых модулей для каждого типа данных (активность, избранное и т.п.) с похожими методами удаления контента.
 * Данный модуль призван дать универсальный интерфейс для удаления данных из БД.
 */

class PluginAdmin_ModuleDeletecontent extends Module {

	private $oMapper = null;

	/*
	 * ключ фильтра условий
	 */
	const FILTER_CONDITIONS = 'conditions';

	/*
	 * ключ фильтра таблицы
	 */
	const FILTER_TABLE = 'table';

	/*
	 * ключ фильтра связанного поля для запроса (используется при чистки других таблиц, ссылающихся на таблицу комментариев)
	 */
	const FILTER_CONNECTED_FIELD = 'field';


	public function Init() {
		$this->oMapper = Engine::GetMapper(__CLASS__);
	}


	/**
	 * Удаление данных из БД по фильтру
	 *
	 * @param $aFilter	фильтр
	 * @return mixed
	 */
	protected function DeleteContentByFilter($aFilter) {
		return $this->oMapper->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление стены пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserWall($oUser) {
		/*
		 * построить фильтр
		 */
		$aFilter = array(
			/*
			 * условие WHERE
			 */
			self::FILTER_CONDITIONS => array(
				/*
				 * перечисление полей таблицы и их значения
				 */
				'wall_user_id' => $oUser->getId(),
			),
			/*
			 * таблица из которой нужно удалить записи
			 */
			self::FILTER_TABLE => Config::Get('db.table.wall')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление записей пользователя на других стенах
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserWroteOnWalls($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.wall')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление избранного пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserFavourite($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.favourite')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление тегов избранного пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserFavouriteTag($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.favourite_tag')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление друзей пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUsersFriends($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_from' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.friend')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление пользователя как друга у других пользователей
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserIsFriendForOtherUsers($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_to' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.friend')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление гео-данных пользователя (запись с указанием его страны, области и города)
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserGeoTargets($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'target_type' => 'user',
				'target_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.geo_target')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление записей про инвайты: кого пригласил этот пользователь
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserInviteFrom($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_from_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.invite')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление записей про инвайты: кем был приглашен этот пользователь
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserInviteTo($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_to_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.invite')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление записей рассылки уведомлений
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserNotifyTask($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				/*
				 * почта!
				 */
				'user_mail' => $oUser->getMail(),
			),
			self::FILTER_TABLE => Config::Get('db.table.notify_task')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление напоминаний про пароль
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserReminder($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.reminder')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление событий активности, созданной пользователем
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserStreamEvents($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.stream_event')
		);
		return $this->DeleteContentByFilter($aFilter);
	}

	/*
	 * todo: стрим нужно чистить также как с таблицей комментариев
	 * там может остаться куча мусора
	 */


	/**
	 * Удаление подписки активности пользователя на других пользователей
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserStreamSubscribe($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.stream_subscribe')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление подписки активности других пользователей на этого пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserStreamSubscribeTarget($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'target_user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.stream_subscribe')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление опций что показывать в персональной активности пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserStreamUserType($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.stream_user_type')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление подписки пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserSubscribe($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.subscribe')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление подписки фида пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserFeedSubscribe($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.userfeed_subscribe')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление подписки фида других пользователей на этого пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserFeedSubscribeTarget($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'target_id' => $oUser->getId(),
				'subscribe_type' => ModuleUserfeed::SUBSCRIBE_TYPE_USER
			),
			self::FILTER_TABLE => Config::Get('db.table.userfeed_subscribe')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление изменения почты пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserChangeMail($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.user_changemail')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление данных произвольных полей профиля пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserFieldValue($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.user_field_value')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление заметок пользователя о других пользователях
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserOwnNotes($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.user_note')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление заметок других пользователей об этом пользователе
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserNotesFromOtherUsers($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'target_user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.user_note')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserItself($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.user')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление сессии пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserSession($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.session')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление комментариев пользователя
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserOwnComments($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.comment')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление голосов пользователя за другие объекты
	 *
	 * @param $oUser	объект пользователя
	 * @return bool
	 */
	public function DeleteUserVotes($oUser) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'user_voter_id' => $oUser->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.vote')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/**
	 * Удаление комментария
	 *
	 * @param $oComment	объект комментария
	 * @return bool
	 */
	public function DeleteComment($oComment) {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'comment_id' => $oComment->getId(),
			),
			self::FILTER_TABLE => Config::Get('db.table.comment')
		);
		return $this->DeleteContentByFilter($aFilter);
	}


	/*
	 *
	 * --- Чистка таблицы комментариев ---
	 *
	 */


	/**
	 * Удаляет комментарии у которых указаны несуществующие родительские ид комментариев в comment_pid
	 * (выполнять пока возвращает результат чтобы удалить всю поврежденную цепочку)
	 *
	 * @return int		количество удаленных комментариев
	 */
	protected function DeleteCommentsWithBrokenParentLinks() {
		return $this->oMapper->DeleteCommentsWithBrokenParentLinks();
	}


	/**
	 * Удаляет все комментарии у которых повреждена цепочка связи "родитель-ребенок".
	 * Работает через цикл, порция за порцией, будут удаляться дочерние (поврежденные) комментарии от верхнего уровня к нижнему
	 */
	protected function DeleteAllCommentsWithBrokenChains() {
		while ($this->DeleteCommentsWithBrokenParentLinks());
	}


	/*
	 *
	 * --- Удаление записей в других таблицах, которые ссылаются на таблицу комментариев ---
	 *
	 */

	/**
	 * Удаление по фильтру записей в таблицах, которые ссылаются на таблицу комментариев, где нет нет таких комментариев
	 *
	 * @param $aFilter	фильтр
	 * @return mixed
	 */
	protected function DeleteReferenceToCommentsNotExists($aFilter) {
		return $this->oMapper->DeleteReferenceToCommentsNotExists($aFilter);
	}


	/**
	 * Удаляет записи из прямого эфира, которые ссылаются на несуществующие комментарии
	 *
	 * @return bool
	 */
	protected function DeleteOnlineCommentsNotExists() {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(),
			self::FILTER_TABLE => Config::Get('db.table.comment_online'),
			self::FILTER_CONNECTED_FIELD => 'comment_id'
		);
		return $this->DeleteReferenceToCommentsNotExists($aFilter);
	}


	/**
	 * Удаляет записи голосований, указывающие на несуществующие комментарии
	 *
	 * @return bool
	 */
	protected function DeleteVotingsTargetingCommentsNotExists() {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'target_type' => 'comment',
			),
			self::FILTER_TABLE => Config::Get('db.table.vote'),
			self::FILTER_CONNECTED_FIELD => 'target_id'
		);
		return $this->DeleteReferenceToCommentsNotExists($aFilter);
	}


	/**
	 * Удаляет записи избранного, указывающие на несуществующие комментарии
	 *
	 * @return bool
	 */
	protected function DeleteFavouriteTargetingCommentsNotExists() {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'target_type' => 'comment',
			),
			self::FILTER_TABLE => Config::Get('db.table.favourite'),
			self::FILTER_CONNECTED_FIELD => 'target_id'
		);
		return $this->DeleteReferenceToCommentsNotExists($aFilter);
	}


	/**
	 * Удаляет записи тегов избранного, указывающие на несуществующие комментарии
	 *
	 * @return bool
	 */
	protected function DeleteFavouriteTagsTargetingCommentsNotExists() {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'target_type' => 'comment',
			),
			self::FILTER_TABLE => Config::Get('db.table.favourite_tag'),
			self::FILTER_CONNECTED_FIELD => 'target_id'
		);
		return $this->DeleteReferenceToCommentsNotExists($aFilter);
	}


	/**
	 * Удаляет записи активности типа "добавление комментариев", указывающие на несуществующие комментарии
	 *
	 * @return bool
	 */
	protected function DeleteStreamCommentEventsTargetingCommentsNotExists() {
		$aFilter = array(
			self::FILTER_CONDITIONS => array(
				'event_type' => 'add_comment',
			),
			self::FILTER_TABLE => Config::Get('db.table.stream_event'),
			self::FILTER_CONNECTED_FIELD => 'target_id'
		);
		return $this->DeleteReferenceToCommentsNotExists($aFilter);
	}


	/**
	 * Произвести очистку голосований, избранного и тегов избранного после удаления комментариев
	 */
	protected function CleanUpOtherTablesAfterCommentsDeleting() {
		/*
		 * для структуры "nested set" комментариев нужно пересчитать дерево комментариев (всю цепочку справа от первой удаляемой ветви)
		 * todo: данный момент не протестирован до конца
		 */
		if (Config::Get('module.comment.use_nested')) {
			$this->Comment_RestoreTree();
		}

		/*
		 * очистить таблицы голосований от записей, указывающих на несуществующие комментарии, целые ветки которых были удалены
		 */
		$this->DeleteVotingsTargetingCommentsNotExists();

		/*
		 *  очистить таблицы избранного от записей, указывающих на несуществующие комментарии, целые ветки которых были удалены
		 */
		$this->DeleteFavouriteTargetingCommentsNotExists();

		/*
		 *  очистить таблицы тегов избранного от записей, указывающих на несуществующие комментарии, целые ветки которых были удалены
		 */
		$this->DeleteFavouriteTagsTargetingCommentsNotExists();

		/*
		 * очистить таблицу активности (стрима) от записей типа "добавление комментария", которые ссылаются на удаленные комментарии
		 */
		$this->DeleteStreamCommentEventsTargetingCommentsNotExists();
	}


	/**
	 * Удаление ветвей комментариев, которые являются ответами на несуществующие комментарии, очистка прямого эфира от несуществующих записей и данных связанных таблиц
	 */
	public function DeleteBrokenChainsFromCommentsTreeAndOnlineCommentsAndCleanUpOtherTables() {
		/*
		 * удалить в таблице комментариев ответы у которых comment_pid указывает на несуществующий комментарий,
		 * удаление дочерних комментариев от верхнего уровня к нижнему (к самому дальнему ответу)
		 */
		$this->DeleteAllCommentsWithBrokenChains();

		/*
		 * очистка таблицы прямого эфира - там могут быть записи, указывающие на несуществующие комментарии
		 */
		$this->DeleteOnlineCommentsNotExists();

		/*
		 * очистить другие таблицы от записей, указывающих на удаленные комментарии
		 */
		$this->CleanUpOtherTablesAfterCommentsDeleting();
	}


	/*
	 *
	 * --- Работа с флагом проверки внешних ключей ---
	 *
	 */

	/**
	 * Установить новое значение для флага проверки внешних связей с предварительной проверкой установленного типа таблиц
	 *
	 * @param $iValue		значение флага
	 */
	protected function ChangeForeignKeysCheckingTo($iValue) {
		/*
		 * только если тип таблиц InnoDB
		 */
		if (Config::Get('db.tables.engine') == 'InnoDB') {
			$this->oMapper->SetForeignKeysChecking($iValue);
		}
	}


	/**
	 * Выключить проверку внешних ключей
	 */
	public function DisableForeignKeysChecking() {
		$this->ChangeForeignKeysCheckingTo(0);
	}


	/**
	 * Включить проверку внешних ключей
	 */
	public function EnableForeignKeysChecking() {
		$this->ChangeForeignKeysCheckingTo(1);
	}


}

?>