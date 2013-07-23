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
		
		if (!isset ($aValidatorData ['params'])) {
			return false;
		}
		
		$aValidatorParams = $aValidatorData ['params'];
		if ($this -> getShowAsPhpArray ()) {
			return false;
		}
		return true;							// allow enum (if set) or text field for adding values
	}
	
	// ---
	
	public function getNeedToShowSpecialIntegerForm () {
		$aValidatorData = $this -> getValidator ();
		
		if ($aValidatorData ['type'] != 'Number') {
			return false;
		}
		
		if (!isset ($aValidatorData ['params'])) {
			return false;
		}
		
		$aValidatorParams = $aValidatorData ['params'];
		if (!isset ($aValidatorParams ['min']) or !isset ($aValidatorParams ['max'])) {
			return false;
		}
		// чтобы не нагружать браузер слишком большими списками чисел
		if ($aValidatorParams ['max'] - $aValidatorParams ['min'] > 500) {
			return false;
		}
		return true;
	}

}

?>