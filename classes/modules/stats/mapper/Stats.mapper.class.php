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

class PluginAdmin_ModuleStats_MapperStats extends Mapper {


	/**
	 * Получить прирост топиков, комментариев, блогов, пользователей за период
	 *
	 * @param $aFilter		фильтр
	 * @param $aPeriod		периоды
	 * @return int
	 */
	public function GetGrowthByFilterAndPeriod($aFilter, $aPeriod) {
		$sWhere = $this->BuildWhereQuery($aFilter['conditions']);
		$sql = 'SELECT
			(
				SELECT COUNT(*) as now_items
				FROM
					`' . $aFilter['table'] . '`
				WHERE
					' . $sWhere . '
					AND
					`' . $aFilter['period_row_name'] . '` ' . $aPeriod['now_period'] . '
			) - (
				SELECT COUNT(*) as prev_items
				FROM
					`' . $aFilter['table'] . '`
				WHERE
					' . $sWhere . '
					AND
					`' . $aFilter['period_row_name'] . '` ' . $aPeriod['prev_period'] . '
			) as items_growth
		';
		return (int) $this->oDb->selectCell($sql);
	}


	/**
	 * Построить условие WHERE sql-запроса для получения прироста
	 *
	 * @param $aConditions		массив условий
	 * @return string			часть sql-строки
	 */
	protected function BuildWhereQuery($aConditions) {
		$sSql = '1 = 1';
		foreach($aConditions as $sField => $mValue) {
			$sSql .= ' AND `' . $sField . '`' . $this->GetCorrectSyntaxForValue($mValue);
		}
		return $sSql;
	}


	/**
	 * Вернуть корректную запись для запроса в зависимости от типа значения
	 *
	 * @param $mValue		значение
	 * @return string		часть sql-запроса WHERE
	 * @throws Exception	не поддерживаемый тип переменной
	 */
	protected function GetCorrectSyntaxForValue($mValue) {
		switch (gettype($mValue)) {
			case 'float':
			case 'integer':
				return ' = ' . $mValue;
			case 'string':
				return ' = "' . $mValue . '"';
			case 'array':
				return ' IN ("' . implode('", "', $mValue) . '")';
			default:
				throw new Exception('admin: error: unsupported value type in ' . __METHOD__ . ': ' . gettype($mValue));
		}
	}


}

?>