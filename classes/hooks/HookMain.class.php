<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Регистрация хука для вывода меню страниц
 *
 */
class PluginAdmin_HookMain extends Hook {

	public function RegisterHook() {
		$this->AddHook('init_action','InitAction');
	}
	
	

	public function InitAction() {
		$aPlugins=Engine::getInstance()->GetPlugins();

		$aTemplateWebPathPlugin=array();
		$aTemplatePathPlugin=array();
		foreach ($aPlugins as $k=>$oPlugin) {
			$aTemplateWebPathPlugin[$k]=$this->PluginAdmin_Main_GetPluginTemplateWebPath($oPlugin);
			$aTemplatePathPlugin[$k]=$this->PluginAdmin_Main_GetPluginTemplatePath($oPlugin);
		}
		$this->Viewer_Assign("aAdminTemplateWebPathPlugin",$aTemplateWebPathPlugin);
		$this->Viewer_Assign("aAdminTemplatePathPlugin",$aTemplatePathPlugin);
	}
	
}

?>