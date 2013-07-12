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

/*
		Сущность для работы с настройками

		by PSNet
		http://psnet.lookformp3.net
*/

class PluginAdmin_ModuleSettings_EntitySettings extends Entity {
	
	public function getNeedToShowSpecialArrayForm () {
		$aValidatorData = $this -> getValidator ();
		
		if ($aValidatorData ['type'] != 'Array') {
			return false;
		}
		
		$aValidatorParams = $aValidatorData ['params'];
		if ($this -> getShowAsPhpArray () or (!isset ($aValidatorParams ['enum']) and !isset ($aValidatorParams ['range']))) {
			return false;
		}
		return true;
	}

}

?>