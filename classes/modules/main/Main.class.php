<?php

class PluginAdmin_ModuleMain extends Module {

	public function Init() {

	}
	
	// ---

	public function GetPluginTemplatePath($sName) {
		$sNamePlugin=Engine::GetPluginName($sName);
		$sNamePlugin=$sNamePlugin ? $sNamePlugin : $sName;
		$sNamePlugin=func_underscore($sNamePlugin);

		$sPath=Plugin::GetPath($sNamePlugin);
		$aSkins=array('admin_default','default',Config::Get('view.skin'));
		foreach($aSkins as $sSkin) {
			$sTpl=$sPath.'templates/skin/'.$sSkin.'/';
			if (is_dir($sTpl)) {
				return $sTpl;
			}
		}

		return false;
	}
	
	// ---

	public function GetPluginTemplateWebPath($sName) {
		if ($sPath=$this->GetPluginTemplatePath($sName)) {
			return str_replace(Config::Get('path.root.server'),Config::Get('path.root.web'),$sPath);
		}
		return false;
	}

}

?>