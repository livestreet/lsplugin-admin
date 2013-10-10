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

/**
 * Регистрация хука для вывода меню страниц
 *
 */

class PluginAdmin_HookMain extends Hook {

	public function RegisterHook() {
		$this->AddHook('engine_init_complete', 'AddAdminPath');
	}
	
	
	public function AddAdminPath() {
		$aPlugins = Engine::getInstance()->GetPlugins();

		$aTemplateWebPathPlugin=array();
		$aTemplatePathPlugin=array();
		foreach($aPlugins as $k => $oPlugin) {
			$aTemplateWebPathPlugin[$k] = $this->PluginAdmin_Main_GetPluginTemplateWebPath($oPlugin);
			$aTemplatePathPlugin[$k] = $this->PluginAdmin_Main_GetPluginTemplatePath($oPlugin);
		}
		$this->Viewer_Assign('aAdminTemplateWebPathPlugin', $aTemplateWebPathPlugin);
		$this->Viewer_Assign('aAdminTemplatePathPlugin', $aTemplatePathPlugin);
	}
	
}

?>