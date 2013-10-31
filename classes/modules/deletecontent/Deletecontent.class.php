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


	public function Init() {
		$this->oMapper = Engine::GetMapper(__CLASS__);
	}


	/**
	 * Удаление данных из БД по фильтру
	 *
	 * @param $aFilter	фильтр
	 * @return mixed
	 */
	protected function DeleteUserContentByFilter($aFilter) {
		return $this->oMapper->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
	}


	/**
	 * Удаление событий активности пользователя
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
		return $this->DeleteUserContentByFilter($aFilter);
	}


	/**
	 * Удаление подписки активности пользователя
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
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
		return $this->DeleteUserContentByFilter($aFilter);
	}

}

?>