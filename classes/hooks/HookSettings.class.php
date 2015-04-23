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
 * Работа с настройками плагинов и движка
 *
 */

class PluginAdmin_HookSettings extends Hook
{

    public function RegisterHook()
    {
        /*
         * наивысший приоритет, который можно установить (первая очередь)
         * (другие обработчики этого хука, которые обращаются к классу конфига должны иметь более низкий приоритет)
         */
        $this->AddHook('engine_init_complete', 'EngineInitComplete', __CLASS__, PHP_INT_MAX);
    }


    public function EngineInitComplete()
    {
        /**
         * присоеденить текстовки
         */
        $this->PluginAdmin_Settings_AddConfigLanguageToRootConfig();
    }

}