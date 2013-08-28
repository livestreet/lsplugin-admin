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

class PluginAdmin_ModuleUsers_MapperUsers extends Mapper {

	/**
	 * Возвращает список пользователей по фильтру
	 *
	 * @param array $aFilter	Фильтр
	 * @param array $sOrder		Сортировка
	 * @param int $iCurrPage	Номер страницы
	 * @param int $iPerPage		Количество элментов на страницу
	 * @return array
	 */
	public function GetUsersByFilter($aFilter, $sOrder, $iCurrPage, $iPerPage) {
		$sql = "SELECT u.user_id
			FROM
				`" . Config::Get('db.table.user') . "` AS u
			LEFT JOIN
				`" . Config::Get('db.table.session') . "` AS s ON u.user_id = s.user_id
			LEFT JOIN
				`" . Config::Get('db.table.user_administrator') . "` AS ua ON u.user_id = ua.user_id
			WHERE
				1 = 1
				{AND u.user_id = ?d}
				{AND u.user_mail LIKE ?}
				{AND u.user_password = ?}
				{AND u.user_ip_register LIKE ?}
				{AND u.user_activate = ?d}
				{AND u.user_activate_key = ? }
				{AND u.user_profile_sex = ?}
				{AND u.user_login LIKE ?}
				{AND u.user_profile_name LIKE ?}
				{AND s.session_ip_last LIKE ?}
				{AND ua.user_id <> ?d}
			ORDER BY
				{$sOrder}
			LIMIT ?d, ?d
		";
		$iTotalCount = 0;
		$aResult = array();

		if ($aRows = $this->oDb->selectPage($iTotalCount, $sql,
			isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
			isset($aFilter['mail']) ? $aFilter['mail'] : DBSIMPLE_SKIP,
			isset($aFilter['password']) ? $aFilter['password'] : DBSIMPLE_SKIP,
			isset($aFilter['ip_register']) ? $aFilter['ip_register'] : DBSIMPLE_SKIP,
			isset($aFilter['activate']) ? $aFilter['activate'] : DBSIMPLE_SKIP,
			isset($aFilter['activate_key']) ? $aFilter['activate_key'] : DBSIMPLE_SKIP,
			isset($aFilter['profile_sex']) ? $aFilter['profile_sex'] : DBSIMPLE_SKIP,
			isset($aFilter['login']) ? $aFilter['login'] : DBSIMPLE_SKIP,
			isset($aFilter['profile_name']) ? $aFilter['profile_name'] : DBSIMPLE_SKIP,
			isset($aFilter['session_ip_last']) ? $aFilter['session_ip_last'] : DBSIMPLE_SKIP,
			isset($aFilter['admins_only']) ? 0 : DBSIMPLE_SKIP,
			($iCurrPage-1) * $iPerPage,
			$iPerPage
		)) {
			foreach($aRows as $aRow) {
				$aResult[] = $aRow['user_id'];
			}
		}

		return array(
			'collection' => $aResult,
			'count' => $iTotalCount
		);
	}


	/**
	 * Возвращает за что, как и сколько раз голосовал пользователь
	 *
	 * @param $iUserId			ид пользователя
	 * @return array			ассоциативный массив
	 */
	public function GetUserVotingStats($iUserId) {
		$sql = "SELECT
				`target_type`,
				`vote_direction`,
				COUNT(*) as count
			FROM
				`" . Config::Get('db.table.vote') . "`
			WHERE
				`user_voter_id` = ?d
			GROUP BY
				`target_type`, `vote_direction`
		";
		if ($aData = $this->oDb->select($sql,
			$iUserId
		)) {
			return $aData;
		}
		return array();
	}


	/**
	 * Получить списки голосований пользователя по фильтру
	 *
	 * @param     	$iUserId		ид пользователя
	 * @param     	$sWhere			дополнительное условие WHERE запроса (построенное фильтром)
	 * @param		$sOrder			сортировка
	 * @param int 	$iPage			страница
	 * @param int 	$iPerPage		количество результатов
	 * @return array
	 */
	public function GetUserVotingListByFilter($iUserId, $sWhere, $sOrder, $iPage = 1, $iPerPage = PHP_INT_MAX) {
		$sql = "SELECT
				`target_id`,
				`target_type`,
				`vote_direction`,
				`vote_value`,
				`vote_date`,
				`vote_ip`
			FROM
				`" . Config::Get('db.table.vote') . "`
			WHERE
				`user_voter_id` = ?d
				{$sWhere}
			ORDER BY
				{$sOrder}
			LIMIT ?d, ?d
		";
		$aEntities = array();
		$iTotalCount = 0;

		if ($aData = $this->oDb->selectPage($iTotalCount, $sql,
			$iUserId,
			($iPage - 1) * $iPerPage,
			$iPerPage
		)) {
			foreach ($aData as $aRes) {
				$aEntities[] = Engine::GetEntity('Vote', $aRes);
			}
		}
		return array(
			'collection' => $aEntities,
			'count' => $iTotalCount
		);
	}


	/**
	 * Добавить запись о бане пользователя
	 *
	 * @param $oBan				обьект бана
	 * @return array|null
	 */
	public function AddBanRecord($oBan) {
		$sql = 'INSERT INTO
				`' . Config::Get('db.table.users_ban') . '`
			(
				`id`,
				`block_type`,
				`user_id`,
				`ip`,
				`ip_start`,
				`ip_finish`,

				`time_type`,
				`date_start`,
				`date_finish`,

				`add_date`,
				`edit_date`,

				`reason_for_user`,
				`comment`
			)
			VALUES
			(
				?d,
				?d,
				?d,
				?d,
				?d,
				?d,

				?d,
				?,
				?,

				?,
				?,

				?,
				?
			)
			ON DUPLICATE KEY UPDATE
				`block_type` = ?d,
				`user_id` = ?d,
				`ip` = ?d,
				`ip_start` = ?d,
				`ip_finish` = ?d,

				`time_type` = ?d,
				`date_start` = ?,
				`date_finish` = ?,

				`add_date` = ?,
				`edit_date` = ?,

				`reason_for_user` = ?,
				`comment` = ?
		';
		return $this->oDb->query($sql,
			$oBan->getId(),
			$oBan->getBlockType(),
			$oBan->getUserId(),
			$oBan->getIp(),
			$oBan->getIpStart(),
			$oBan->getIpFinish(),

			$oBan->getTimeType(),
			$oBan->getDateStart(),
			$oBan->getDateFinish(),

			$oBan->getAddDate(),
			$oBan->getEditDate(),

			$oBan->getReasonForUser(),
			$oBan->getComment(),

			// duplicate key
			$oBan->getBlockType(),
			$oBan->getUserId(),
			$oBan->getIp(),
			$oBan->getIpStart(),
			$oBan->getIpFinish(),

			$oBan->getTimeType(),
			$oBan->getDateStart(),
			$oBan->getDateFinish(),

			$oBan->getAddDate(),
			$oBan->getEditDate(),

			$oBan->getReasonForUser(),
			$oBan->getComment()
		);
	}


	/**
	 * Получить список банов по фильтру
	 *
	 * @param array $aFilter	Фильтр
	 * @param array $sOrder		Сортировка
	 * @param int $iPage		Номер страницы
	 * @param int $iPerPage		Количество элментов на страницу
	 * @return array
	 */
	public function GetBansByFilter($aFilter, $sOrder, $iPage, $iPerPage) {
		$sql = "SELECT *
			FROM
				`" . Config::Get('db.table.users_ban') . "`
			WHERE
				1 = 1
				{AND `id` = ?d}
			ORDER BY
				{$sOrder}
			LIMIT ?d, ?d
		";
		$aEntities = array();
		$iTotalCount = 0;

		if ($aData = $this->oDb->selectPage($iTotalCount, $sql,
			(isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP),
			($iPage - 1) * $iPerPage,
			$iPerPage
		)) {
			foreach ($aData as $aRes) {
				$aEntities[] = Engine::GetEntity('PluginAdmin_Users_Ban', $aRes);
			}
		}
		return array(
			'collection' => $aEntities,
			'count' => $iTotalCount
		);
	}


	/**
	 * Удалить запись бана по ид
	 *
	 * @param $iId			ид бана
	 * @return array|null
	 */
	public function DeleteBanById($iId) {
		$sql = 'DELETE
			FROM
				`' . Config::Get('db.table.users_ban') . '`
			WHERE
				`id` = ?d
			LIMIT 1;
		';
		return $this->oDb->query($sql,
			$iId
		);
	}


	/**
	 * Проверить попадает ли пользователь под одно из правил для бана
	 *
	 * @param $oUserCurrent				объект пользователя для проверки
	 * @param $mIp						представление ip адреса для сравнения
	 * @param $sCurrentDate				текущая дата в формате DATETIME
	 * @return Entity|null
	 */
	public function IsThisUserBanned($oUserCurrent, $mIp, $sCurrentDate) {
		$sql = "SELECT *
			FROM
				`" . Config::Get('db.table.users_ban') . "`
			WHERE
				(
					(								-- user condition
						`block_type` = ?d
						AND
						`user_id` = ?d
					)
					OR
					(								-- ip
						`block_type` = ?d
						AND
						`ip` = ?d
					)
					OR
					(								-- ip range
						`block_type` = ?d
						AND
						?d BETWEEN `ip_start` AND `ip_finish`
					)
				)
				AND
				(
					`time_type` = ?d
					OR
					(
						`time_type` = ?d
						AND
						? BETWEEN `date_start` AND `date_finish`
					)
				)
			ORDER BY
				`id` DESC
			LIMIT 1
		";
		if ($aResult = $this->oDb->selectRow($sql,
			/*
			 * поиск по ид текущего пользователя
			 */
			PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID,
			($oUserCurrent ? $oUserCurrent->getId() : 0),
			/*
			 * поиск по ip
			 */
			PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP,
			$mIp,
			/*
			 * поиск по диапазону ip адресов
			 */
			PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP_RANGE,
			$mIp,
			/*
			 * временной интервал - постоянный
			 */
			PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT,
			/*
			 * временной интервал - период
			 */
			PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD,
			$sCurrentDate
		)) {
			return Engine::GetEntity('PluginAdmin_Users_Ban', $aResult);
		}
		return null;
	}


}

?>