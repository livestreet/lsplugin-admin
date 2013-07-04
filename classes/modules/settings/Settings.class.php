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
		Модуль для работы с настройками

		by PSNet
		http://psnet.lookformp3.net
*/

class PluginAdmin_ModuleSettings extends Module {
	
	const CONFIG_DATA_PARAM_NAME = '__config__';					// имя параметра для плагина или ядра для сохранения конфига в хранилище
	
	// ---

	public function Init() {}
	
	// ---
	
	public function SaveConfig ($sConfigName, $aData) {
		if ($sConfigName == PluginAdmin_ActionAdmin_EventSettings::SYSTEM_CONFIG_ID) {
			$sKey = PluginAdmin_ModuleStorage::ENGINE_KEY_NAME;
		} else {
			$sKey = $sConfigName;
		}
		return $this -> PluginAdmin_Storage_SetOneParam ($sKey, self::CONFIG_DATA_PARAM_NAME, $aData);
	}

}

?>