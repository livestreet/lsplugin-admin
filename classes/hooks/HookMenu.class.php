<?php

/*
 * LiveStreet CMS
 * Copyright © 2018 OOO "ЛС-СОФТ"
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
 * @author Oleg Demodov <boxmilo@gmail.com>
 *
 */

/**
 * Description of HookMenu
 *
 * @author oleg
 */
class PluginAdmin_HookMenu extends Hook {

    public function RegisterHook() {
        $this->AddHook('init_admin_menu', 'InitActionAdmin');
    }
    
    public function InitActionAdmin() {
        
        $aMenus = $this->Menu_GetMenuItemsAll();
        $oSection = Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Меню')->SetName('menu')->SetUrl('menu')->setIcon('bars');
        foreach ($aMenus as $oMenu) {
            $oSection->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption(htmlspecialchars($oMenu->getTitle()))->SetUrl($oMenu->getName()));
        }

        $oMenu = $this->PluginAdmin_Ui_GetMenuMain();
        $oMenu->AddSection($oSection);
    }
}
