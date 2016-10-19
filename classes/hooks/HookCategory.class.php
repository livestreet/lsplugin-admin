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
class PluginAdmin_HookCategory extends Hook
{


    public function RegisterHook()
    {
        $this->AddHook('init_action_admin', 'InitActionAdmin');
    }


    public function InitActionAdmin()
    {
        /*
         * Если нет ни одного плагина, который использует универсальные категории - не выводить соотв. пункт меню
         */
        if (!$aTypes = $this->Category_GetTypeItemsByFilter(array(
            'state'  => ModuleCategory::TARGET_STATE_ACTIVE,
            '#order' => array('title' => 'asc')
        ))
        ) {
            return false;
        }

        $oSection = Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Категории')->SetName('categories')->SetUrl('categories')->setIcon('map-signs');
        foreach ($aTypes as $oType) {
            $oSection->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption(htmlspecialchars($oType->getTitle()))->SetUrl($oType->getTargetType()));
        }

        $oMenu = $this->PluginAdmin_Ui_GetMenuMain();
        $oMenu->AddSection($oSection);
    }

}