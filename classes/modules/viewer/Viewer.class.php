<?php 

class PluginAdmin_ModuleViewer extends PluginAdmin_Inherit_ModuleViewer {
	
	public function GetSmartyTemplateVar($sName){
		return $this->oSmarty->get_template_vars($sName);
	}
	
	// ---
	
	public function AddSmartyPluginsDir($sDir){
		if(!is_dir($sDir)){
			return false;
		}
		if(!in_array($sDir, $this->oSmarty->getPluginsDir())){
			$this->oSmarty->setPluginsDir(array_merge($this->oSmarty->getPluginsDir(),array($sDir)));
		}
		return true;
	}
	
	// ---

	public function ClearStyle($bClearConfig=false) {
		$this->aCssInclude = array(
			'append'  => array(),
			'prepend' => array()
		);
		$this->aFilesParams=array(
			'js'  => array(),
			'css' => array()
		);

		if ($bClearConfig) {
			$this->aFilesDefault=array(
				'js'  => array(),
				'css' => array()
			);
			Config::Set('head.rules',array());
		}
	}
	
}

?>