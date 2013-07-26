<?php

class PluginAdmin_ModuleUser_MapperUser extends Mapper {

	/**
	 * Возвращает список пользователей по фильтру
	 *
	 * @param array $aFilter	Фильтр
	 * @param array $aOrder	Сортировка
	 * @param int $iCount	Возвращает общее количество элементов
	 * @param int $iCurrPage	Номер страницы
	 * @param int $iPerPage	Количество элментов на страницу
	 * @return array
	 */
	public function GetUsersByFilter($aFilter,$aOrder,&$iCount,$iCurrPage,$iPerPage) {
		$aOrderAllow=array('u.user_id','u.user_login','u.user_date_register','u.user_rating','u.user_skill','u.user_profile_name','s.session_ip_last');
		$sOrder='';
		foreach($aOrder as $key=>$value) {
			if (!in_array($key,$aOrderAllow)) {
				unset($aOrder[$key]);
			} elseif (in_array($value,array('asc','desc'))) {
				$sOrder.=" {$key} {$value},";
			}
		}
		$sOrder=trim($sOrder,',');
		if ($sOrder=='') {
			$sOrder=' u.user_id desc ';
		}

		$sql = "SELECT
					u.user_id
				FROM
					".Config::Get('db.table.user')." as u
					LEFT JOIN ".Config::Get('db.table.session')." AS s ON u.user_id=s.user_id
				WHERE
					1 = 1
					{ AND u.user_id = ?d }
					{ AND u.user_mail = ? }
					{ AND u.user_password = ? }
					{ AND u.user_ip_register = ? }
					{ AND u.user_activate = ?d }
					{ AND u.user_activate_key = ? }
					{ AND u.user_profile_sex = ? }
					{ AND u.user_login LIKE ? }
					{ AND u.user_profile_name LIKE ? }
				ORDER by {$sOrder}
				LIMIT ?d, ?d ;
					";
		$aResult=array();
		if ($aRows=$this->oDb->selectPage($iCount,$sql,
										  isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
										  isset($aFilter['mail']) ? $aFilter['mail'] : DBSIMPLE_SKIP,
										  isset($aFilter['password']) ? $aFilter['password'] : DBSIMPLE_SKIP,
										  isset($aFilter['ip_register']) ? $aFilter['ip_register'] : DBSIMPLE_SKIP,
										  isset($aFilter['activate']) ? $aFilter['activate'] : DBSIMPLE_SKIP,
										  isset($aFilter['activate_key']) ? $aFilter['activate_key'] : DBSIMPLE_SKIP,
										  isset($aFilter['profile_sex']) ? $aFilter['profile_sex'] : DBSIMPLE_SKIP,
										  isset($aFilter['login']) ? $aFilter['login'] : DBSIMPLE_SKIP,
										  isset($aFilter['profile_name']) ? $aFilter['profile_name'] : DBSIMPLE_SKIP,
										 ($iCurrPage-1)*$iPerPage, $iPerPage
		)) {
			foreach($aRows as $aRow) {
				$aResult[]=$aRow['user_id'];
			}
		}
		return $aResult;
	}

}

?>