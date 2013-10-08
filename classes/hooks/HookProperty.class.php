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


class PluginAdmin_HookProperty extends Hook {

	public function RegisterHook() {
		$this->AddHook('init_action_admin', 'InitActionAdmin');
	}
	
	
	public function InitActionAdmin() {
		$aTypes = $this->Property_GetTargetTypes();
		$oMenu = $this->PluginAdmin_Ui_GetMenuMain();

		$oSection = Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Дополнительные поля')->SetName('properties')->SetUrl('properties');
		foreach($aTypes as $sKey => $aParams) {
			$oSection->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption(isset($aParams['name']) ? $aParams['name'] : $sKey)->SetUrl($sKey));
		}
		$oMenu->AddSection($oSection);
	}
}

?>