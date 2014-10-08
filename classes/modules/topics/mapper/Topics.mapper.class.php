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
class PluginAdmin_ModuleTopics_MapperTopics extends Mapper
{


    /**
     * Получить статистику по новым топикам
     *
     * @param $aPeriods                период от и до
     * @param $sMySQLDateFormat        формат даты для мускула
     * @return array|null
     */
    public function GetTopicsStats($aPeriods, $sMySQLDateFormat)
    {
        $sql = 'SELECT
				DATE_FORMAT(`topic_date_add`, "' . $sMySQLDateFormat . '") as date,
				COUNT(*) as count
			FROM
				`' . Config::Get('db.table.topic') . '`
			WHERE
				`topic_publish` = 1
				AND
				`topic_date_add` >= ?
				AND
				`topic_date_add` <= ?
			GROUP BY
				`date`
			ORDER BY
				`date` ASC
		';
        if ($aResult = $this->oDb->query($sql,
            $aPeriods['from'],
            $aPeriods['to']
        )
        ) {
            return $aResult;
        }
        return array();
    }


    /**
     * Меняет у топиков тип на новый
     *
     * @param $sTypeNew
     * @param $sTypeOld
     * @return bool
     */
    public function ReplaceTopicsType($sTypeNew, $sTypeOld)
    {
        $sql = "UPDATE
				`" . Config::Get('db.table.topic') . "`
			SET
				topic_type = ?
			WHERE
				topic_type = ?
		";
        $mResult = $this->oDb->query($sql, $sTypeNew, $sTypeOld);
        if ($mResult !== false and !is_null($mResult)) {
            return true;
        }
        return false;
    }

}
