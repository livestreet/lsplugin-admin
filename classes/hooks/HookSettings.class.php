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
		Работа с настройками плагинов
		
		by PSNet
		http://psnet.lookformp3.net
*/

class PluginAdmin_HookSettings extends Hook {

	public function RegisterHook () {
		$this -> AddHook ('lang_init_start', 'LangInitStart', __CLASS__, PHP_INT_MAX);              // наивысший приоритет, который можно установить
	}
	
	// ---

	public function LangInitStart () {
		// выполнить загрузку конфигов системы и плагинов
		$this -> PluginAdmin_Settings_AutoLoadConfigs ();
	}
	
}

?>