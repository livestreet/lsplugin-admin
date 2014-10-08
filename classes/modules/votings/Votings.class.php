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
class PluginAdmin_ModuleVotings extends Module
{

    protected $oMapper = null;


    public function Init()
    {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }


    /**
     * Получить статистику по новым голосованиям
     *
     * @param $aPeriod        период
     * @return mixed
     */
    public function GetVotingsStats($aPeriod)
    {
        return $this->oMapper->GetVotingsStats($aPeriod,
            $this->PluginAdmin_Stats_BuildDateFormatFromPHPToMySQL($aPeriod['format']));
    }

}

?>