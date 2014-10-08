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
/*
 *
 * Вывод статистики внизу страницы (бд, общее время и т.п.)
 *
 */

class PluginAdmin_HookStatsPerformance extends Hook
{


    public function RegisterHook()
    {
        $this->AddHook('template_admin_body_end', 'ShowStatistics', __CLASS__, -1000);
    }


    /**
     * Вывод статистики
     *
     * @return mixed
     */
    public function ShowStatistics()
    {
        /*
         * нужно ли выводить статистику
         */
        if (!$this->User_GetIsAdmin() or !Router::GetIsShowStats()) {
            return false;
        }
        $oEngine = Engine::getInstance();
        /*
         * время работы
         */
        $iTimeInit = $oEngine->GetTimeInit();
        $iTimeFull = round(microtime(true) - $iTimeInit, 3);
        $this->Viewer_Assign('iTimeFullPerformance', $iTimeFull);
        /*
         * кеш и бд
         */
        $aStats = $oEngine->getStats();
        $aStats['cache']['time'] = round($aStats['cache']['time'], 5);
        $this->Viewer_Assign('aStatsPerformance', $aStats);

        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'stats_performance.tpl');
    }

}

?>