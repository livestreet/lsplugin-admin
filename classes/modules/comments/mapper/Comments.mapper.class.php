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
class PluginAdmin_ModuleComments_MapperComments extends Mapper
{


    /**
     * Получить статистику по новым комментариям
     *
     * @param $aPeriods                период от и до
     * @param $sMySQLDateFormat        формат даты для мускула
     * @return array|null
     */
    public function GetCommentsStats($aPeriods, $sMySQLDateFormat)
    {
        $sql = 'SELECT
				DATE_FORMAT(`comment_date`, "' . $sMySQLDateFormat . '") as date,
				COUNT(*) as count
			FROM
				`' . Config::Get('db.table.comment') . '`
			WHERE
				`comment_publish` = 1
				AND
				`comment_date` >= ?
				AND
				`comment_date` <= ?
				AND
				`target_type` IN (?a)
			GROUP BY
				`date`
			ORDER BY
				`date` ASC
		';
        if ($aResult = $this->oDb->query($sql,
            $aPeriods['from'],
            $aPeriods['to'],
            array('topic')
        )
        ) {
            return $aResult;
        }
        return array();
    }


    /**
     * Получить количество всех опубликованных комментариев
     *
     * @return int
     */
    public function GetCountCommentsTotal($sType = null)
    {
        $sql = 'SELECT COUNT(*) as count
			FROM
				`' . Config::Get('db.table.comment') . '`
			WHERE
				`comment_publish` = 1 { and target_type = ? }
		';
        return (int)$this->oDb->selectCell($sql, $sType ? $sType : DBSIMPLE_SKIP);
    }

}

?>