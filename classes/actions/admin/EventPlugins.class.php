<?php

class PluginAdmin_ActionAdmin_EventPlugins extends Event {
	
	public function EventPluginsList () {
    $aPluginList = $this -> GetAllPluginLists ();
    
    $this -> Viewer_Assign ('aPluginsInfo', $aPluginList);
	}
	
  // ---
  
  private function GetAllPluginLists () {
    return $this -> Plugin_GetList (array ('order' => 'name'));
  }

}

?>