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

abstract class PluginAdmin_ActionPlugin extends ActionPlugin {

	protected function SetTemplateAction($sTemplate) {
		$aDelegates = $this->Plugin_GetDelegationChain('action',$this->GetActionClass());
		$sActionTemplatePath = $sTemplate.'.tpl';
		foreach($aDelegates as $sAction) {
			if(preg_match('/^Plugin([\w]+)_Action([\w]+)$/i',$sAction,$aMatches)) {
				$sTemplatePath = 'actions/Action'.ucfirst($aMatches[2]).'/'.$sTemplate.'.tpl';

				$sPath=Plugin::GetPath($sAction);
				$aSkins=array('admin_default','default',Config::Get('view.skin'));
				foreach($aSkins as $sSkin) {
					$sTpl=$sPath.'templates/skin/'.$sSkin.'/'.$sTemplatePath;
					if (is_file($sTpl)) {
						$sActionTemplatePath = $sTpl;
						break(2);
					}
				}
			}
		}
		$this->Viewer_Assign('sAdminTemplateInclude',$sActionTemplatePath);
		$this->sActionTemplate = Plugin::GetPath('admin').'templates/skin/default/actions/ActionAdmin/plugin.tpl';
	}

}
?>