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
 * Работа с вьюером
 *
 */

class PluginAdmin_HookViewer extends Hook
{

    public function RegisterHook()
    {
        /*
         * должен быть запущен после загрузки настроек и предпросмотра шаблона (третья очередь)
         */
        $this->AddHook('engine_init_complete', 'EngineInitComplete');
    }


    public function EngineInitComplete()
    {
        /*
         * добавить директорию с плагинами для Smarty
         */
        $this->Viewer_AddSmartyPluginsDir($this->PluginAdmin_Tools_GetSmartyPluginsPath());
    }

}

?>