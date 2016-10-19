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
 *
 */
class PluginAdmin_HookProperty extends Hook
{


    public function RegisterHook()
    {
        $this->AddHook('init_action_admin', 'InitActionAdmin');
    }


    public function InitActionAdmin()
    {
        /*
         * если нет ни одного плагина, который использует дополнительные поля - не выводить соотв. пункт меню
         */
        if (!$aTypes = $this->Property_GetTargetTypes()) {
            return false;
        }

        $oSection = Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Пользовательские поля')->SetName('properties')->SetUrl('properties')->setIcon('th-list');
        foreach ($aTypes as $sKey => $aParams) {
            $oSection->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption(isset($aParams['name']) ? htmlspecialchars_decode($aParams['name']) : $sKey)->SetUrl($sKey));
        }

        $oMenu = $this->PluginAdmin_Ui_GetMenuMain();
        $oMenu->AddSection($oSection);
    }

}