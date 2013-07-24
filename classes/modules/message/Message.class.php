<?php
/*-------------------------------------------------------
*
*	 LiveStreet Engine Social Networking
*	 Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*	 Official site: www.livestreet.ru
*	 Contact e-mail: rus.engine@gmail.com
*
*	 GNU General Public License, version 2:
*	 http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/*
		by PSNet
		http://psnet.lookformp3.net
*/

class PluginAdmin_ModuleMessage extends PluginAdmin_Inherits_ModuleMessage {
	
	// список ошибок по полям
	private $aParamErrors = array ();
	
	
	private function AddParamError ($sMsg, $sKey) {
		$this -> aParamErrors [] = array (
			'key' => $sKey,
			'msg' => $sMsg
		);
	}
	
	
	public function AddOneParamError ($sMsg, $sKey) {
		if (isAjaxRequest ()) {
			// add errors into special array list
			$this -> AddParamError ($sMsg, $sKey);
		} else {
			$this -> Message_AddError ($sMsg, $this -> Lang_Get ('error'), true);
		}
	}
	
	
	public function GetParamsErrors () {
		return $this -> aParamErrors;
	}

}

?>