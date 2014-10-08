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
class PluginAdmin_ModuleStats_MapperStats extends Mapper
{


    /**
     * Получить прирост топиков, комментариев, блогов, пользователей за период
     *
     * @param $aFilter        фильтр
     * @param $aPeriod        периоды
     * @return int
     */
    public function GetGrowthByFilterAndPeriod($aFilter, $aPeriod)
    {
        $sWhere = $this->BuildWhereQuery($aFilter['conditions']);
        $sql = 'SELECT
			(
				SELECT COUNT(*)
				FROM
					`' . $aFilter['table'] . '` as o
				WHERE
					' . $sWhere . '
					AND
					`' . $aFilter['period_row_name'] . '` ' . $aPeriod['now_period'] . '
			) as now_items,
			(
				SELECT COUNT(*)
				FROM
					`' . $aFilter['table'] . '` as o
				WHERE
					' . $sWhere . '
					AND
					`' . $aFilter['period_row_name'] . '` ' . $aPeriod['prev_period'] . '
			) as prev_items
		';
        return (array)$this->oDb->selectRow($sql);
    }


    /**
     * Построить условие WHERE sql-запроса для получения прироста
     *
     * @param $aConditions        массив условий
     * @return string            часть sql-строки
     */
    protected function BuildWhereQuery($aConditions)
    {
        $sSql = '1 = 1';
        foreach ($aConditions as $sFieldRaw => $mValue) {
            /*
             * если поле указано с алиасом таблицы (o.`field_id`), то не экранировать его
             */
            $sField = strpos($sFieldRaw, '.') === false ? $this->oDb->escape($sFieldRaw, true) : $sFieldRaw;
            $sSql .= ' AND ' . $sField . $this->GetCorrectSyntaxForValue($mValue);
        }
        return $sSql;
    }


    /**
     * Вернуть корректную запись для запроса в зависимости от типа значения
     *
     * @param $mValue        значение
     * @return string        часть sql-запроса WHERE
     * @throws Exception    не поддерживаемый тип переменной
     */
    protected function GetCorrectSyntaxForValue($mValue)
    {
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


    /**
     * Получить статистику голосов за обьекты указаного типа в периоде
     *
     * @param $aFilter        фильтр
     * @param $aPeriod        период
     * @return array
     */
    public function GetVotingsForTypeAndPeriod($aFilter, $aPeriod)
    {
        $sWhere = $this->BuildWhereQuery($aFilter['conditions']);
        $sql = 'SELECT
				`vote_direction`,
				COUNT(*) as count
			FROM
				`' . Config::Get('db.table.vote') . '` as v,
				`' . $aFilter['table'] . '` as o
			WHERE
				' . $sWhere . '
				AND
				v.`target_type` = "' . $aFilter['target_type'] . '"
				AND
				v.`target_id` = o.`' . $aFilter['join_table_primary_key'] . '`
				AND
				`' . $aFilter['period_row_name'] . '` ' . $aPeriod['now_period'] . '
			GROUP BY
				v.`target_type`, v.`vote_direction`
		';
        if ($aResult = $this->oDb->select($sql)) {
            return $aResult;
        }
        return array();
    }


    /**
     * Получить статистику рейтинга обьектов указаного типа в периоде
     *
     * @param $aFilter        фильтр
     * @param $aPeriod        период
     * @return array
     */
    public function GetRatingsForTypeAndPeriod($aFilter, $aPeriod)
    {
        $sWhere = $this->BuildWhereQuery($aFilter['conditions']);
        $sql = 'SELECT
			(
				SELECT COUNT(*)
				FROM
					`' . $aFilter['table'] . '` as o
				WHERE
					' . $sWhere . '
					AND
					`' . $aFilter['target_type'] . '_rating` > 0
					AND
					`' . $aFilter['period_row_name'] . '` ' . $aPeriod['now_period'] . '
			) as positive,
			(
				SELECT COUNT(*)
				FROM
					`' . $aFilter['table'] . '` as o
				WHERE
					' . $sWhere . '
					AND
					`' . $aFilter['target_type'] . '_rating` < 0
					AND
					`' . $aFilter['period_row_name'] . '` ' . $aPeriod['now_period'] . '
			) as negative,
			(
				SELECT COUNT(*)
				FROM
					`' . $aFilter['table'] . '` as o
				WHERE
					' . $sWhere . '
					AND
					`' . $aFilter['target_type'] . '_rating` = 0
					AND
					`' . $aFilter['period_row_name'] . '` ' . $aPeriod['now_period'] . '
			) as neutral
		';
        return (array)$this->oDb->selectRow($sql);
    }


}

?>