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
	 * @param array $sOrder	Сортировка
	 * @param int $iCount	Возвращает общее количество элементов
	 * @param int $iCurrPage	Номер страницы
	 * @param int $iPerPage	Количество элментов на страницу
	 * @return array
	 */
	public function GetUsersByFilter($aFilter, $sOrder, &$iCount, $iCurrPage, $iPerPage) {
		$sql = "SELECT u.user_id
			FROM
				" . Config::Get('db.table.user') . " AS u
			LEFT JOIN
				" . Config::Get('db.table.session') . " AS s ON u.user_id = s.user_id
			LEFT JOIN
				" . Config::Get('db.table.user_administrator') . " AS ua ON u.user_id = ua.user_id
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
			ORDER BY
				{$sOrder}
			LIMIT ?d, ?d
		";
		$aResult = array();
		if ($aRows = $this->oDb->selectPage($iCount, $sql,
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
			($iCurrPage-1) * $iPerPage,
			$iPerPage
		)) {
			foreach($aRows as $aRow) {
				$aResult[] = $aRow['user_id'];
			}
		}
		return $aResult;
	}

}

?>