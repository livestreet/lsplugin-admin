<?php

class PluginAdmin_ActionAdmin_EventSettings extends Event {
	
	const ADMIN_INTERFACE_DESCRIPTION_KEY = '__Admin_Interface__';
	const ADMIN_SETTINGS_FORM_ID = 'ls-admin';
	
	// ---
	
	public function EventGet () {
    // if plugin was selected
    if ($sPlugin = $this -> getParam (0) and is_string ($sPlugin)) {
      $this -> Security_ValidateSendForm ();
      $this -> GetPluginSettings ($sPlugin);
    }
		$this -> Viewer_Assign ('sPlugin', $sPlugin);

	}
	
	// ---
	
	protected function GetPluginSettings ($sPlugin) {
		if (!$this -> CheckIfThisPluginIsActive ($sPlugin)) {
			// todo: error msg
			die('err: plugin not active');
			return false;
		}
		
		$aSettingsInfo = $this -> GetPluginSettingsInfo ($sPlugin);
		//print_r($aSettingsInfo);die();
		$aSettingsAll = array ();
		foreach ($aSettingsInfo as $sConfigKey => $aOneParamInfo) {
			if (!$mRealValue = $this -> GetRealValue ($sPlugin, $sConfigKey)) {
				// todo: err msg
				die ('wrong descr. key - ' . $sConfigKey);
			}
			$this -> ExpandLangs ($sPlugin, $aOneParamInfo);
			$aParam = array_merge ($aOneParamInfo, array (
				'key' => $sConfigKey,
				'value' => $mRealValue
			));
			$aSettingsAll [] = Engine::GetEntity ('PluginAdmin_ModuleSettings_EntitySettings', $aParam);
		}
		
		//print_r($aSettingsAll);die();
		$this -> Viewer_Assign ('aSettingsAll', $aSettingsAll);
		$this -> Viewer_Assign ('sFormSettingsId', self::ADMIN_SETTINGS_FORM_ID);
	}
	
	// ---
	
	private function ExpandLangs ($sPlugin, &$aParam, $aKeys = array ('name', 'description')) {
		foreach ($aKeys as $sNamesToExtend) {
			$aParam [$sNamesToExtend] = $this -> Lang_Get ('plugin.' . $sPlugin . '.' . $aParam [$sNamesToExtend]);
		}
		return true;
	}
	
	// ---
	
	private function GetPluginSettingsInfo ($sPlugin) {
    $aData = Config::Get ('plugin.' . $sPlugin . '.' . self::ADMIN_INTERFACE_DESCRIPTION_KEY);
		return $aData ? $aData : array ();
	}
	
	// ---
	
	private function GetRealValue ($sPlugin, $sConfigKey) {
		return Config::Get ('plugin.' . $sPlugin . '.' . $sConfigKey);
	}
	
  // ---
  
  private function CheckIfThisPluginIsActive ($sPlugin) {
    return in_array ($sPlugin, array_keys (Engine::getInstance () -> GetPlugins ()));
  }

}

?>