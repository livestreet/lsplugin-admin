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

class ModuleStorage_MapperStorage extends Mapper {

	public function GetData ($sFilter = null, $iCurrentPage = 1, $iPerPage = PHP_INT_MAX) {
		$sql = "SELECT *
			FROM
				`" . Config::Get ('db.table.storage') . "`
			" . ($sFilter ? "WHERE 1 = 1 " . $sFilter : "") . "
			ORDER BY
				`id` ASC
			LIMIT ?d, ?d
		";
		$iTotalCount = 0;

		if ($aResult = $this -> oDb -> selectPage (
			$iTotalCount,
			$sql,
			($iCurrentPage - 1) * $iPerPage,
			$iPerPage
		)) {
			// Если нужен только один элемент
			$aResult = $iPerPage == 1 ? array_shift ($aResult) : $aResult;
			return array (
				'collection' => $aResult,
				'count' => $iTotalCount
			);
		}
		return array (
			'collection' => array (),
			'count' => 0
		);
	}
	

	public function SetData ($sKey, $sValue, $sInstance) {
		$sql = "INSERT INTO
			`" . Config::Get ('db.table.storage') . "`
			(
				`key`,
				`value`,
				`instance`
			)
			VALUES
			(
				?,
				?,
				?
			)
			ON DUPLICATE KEY UPDATE
				`value` = ?
		";

		return $this -> oDb -> query ($sql,
			$sKey,
			$sValue,
			$sInstance,
			
			$sValue
		);
	}
	

	public function DeleteData ($sFilter = null, $iLimit = 1) {
		$sql = "DELETE
			FROM
				`" . Config::Get ('db.table.storage') . "`
			" . ($sFilter ? "WHERE 1 = 1 " . $sFilter : "") . "
			LIMIT ?d
		";

		return $this -> oDb -> query ($sql,
			$iLimit
		);
	}
	
	
	public function BuildFilter ($aFilter = array ()) {
		$sFilter = '';
		// Список доступных фильтров
		if (isset ($aFilter ['key'])) {
			$sFilter .= '
				AND
					`key` = "' . $aFilter ['key'] . '"
			';
		}
		if (isset ($aFilter ['instance'])) {
			$sFilter .= '
				AND
					`instance` = "' . $aFilter ['instance'] . '"
			';
		}
		return $sFilter;
	}
	
}

?>