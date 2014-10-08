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
 * Добавление переменных с помошью которых можно достучаться к кастомным шаблонам для админки плагинов
 */

class PluginAdmin_HookAdminPath extends Hook
{

    public function RegisterHook()
    {
        $this->AddHook('engine_init_complete', 'AddAdminPath');
    }


    /**
     * Добавить массивы путей к шаблонам админки для всех плагинов
     */
    public function AddAdminPath()
    {
        $aPlugins = Engine::getInstance()->GetPlugins();

        $aTemplateWebPathPlugin = array();
        $aTemplatePathPlugin = array();
        foreach ($aPlugins as $k => $sPlugin) {
            $aTemplateWebPathPlugin[$k] = $this->PluginAdmin_Tools_GetPluginTemplateWebPath($sPlugin);
            $aTemplatePathPlugin[$k] = $this->PluginAdmin_Tools_GetPluginTemplatePath($sPlugin);
        }
        $this->Viewer_Assign('aAdminTemplateWebPathPlugin', $aTemplateWebPathPlugin);
        $this->Viewer_Assign('aAdminTemplatePathPlugin', $aTemplatePathPlugin);
    }

}

?>