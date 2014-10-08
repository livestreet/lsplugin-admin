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
class PluginAdmin_ModuleVotings_MapperVotings extends Mapper
{

    /**
     * Получить статистику по новым голосованиям
     *
     * @param $aPeriods                период от и до
     * @param $sMySQLDateFormat        формат даты для мускула
     * @return array|null
     */
    public function GetVotingsStats($aPeriods, $sMySQLDateFormat)
    {
        $sql = 'SELECT
				DATE_FORMAT(`vote_date`, "' . $sMySQLDateFormat . '") as date,
				COUNT(*) as count
			FROM
				`' . Config::Get('db.table.vote') . '`
			WHERE
				`vote_date` >= ?
				AND
				`vote_date` <= ?
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

}

?>