<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/*
		by PSNet
		http://psnet.lookformp3.net
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
  
	// ---

	public function SetData ($sKey, $sValue, $sInstance) {
		$sql = "INSERT INTO
			`" . Config::Get ('db.table.storage') . "`
			(
				`skey`,
				`svalue`,
				`instance`
			)
			VALUES
			(
				?,
				?,
				?
			)
			ON DUPLICATE KEY UPDATE
				`svalue` = ?
		";

		return $this -> oDb -> Query ($sql,
			$sKey,
			$sValue,
			$sInstance,
			
			$sValue,
			$sInstance
		);
	}
  
	// ---

	public function DeleteData ($sFilter = null, $iLimit = 1) {
		$sql = "DELETE
			FROM
				`" . Config::Get ('db.table.storage') . "`
			" . ($sFilter ? "WHERE 1 = 1 " . $sFilter : "") . "
			LIMIT ?d
		";

		return $this -> oDb -> Query ($sql,
			$iLimit
		);
	}
	
	// ---
	
	public function BuildFilter ($aFilter = array ()) {
		$sFilter = '';
		// Список доступных фильтров
		if (isset ($aFilter ['skey'])) {
			$sFilter .= '
				AND
					`skey` = "' . $aFilter ['skey'] . '"
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