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
		Для ручного управления конфигами, переопределим методы хранилища

		by PSNet
		http://psnet.lookformp3.net
*/

class PluginAdmin_ModuleStorage extends PluginAdmin_Inherits_ModuleStorage {
	
	//
	// Для того, чтобы админка могла сама установить параметр для нужного ключа вручную
	//
	public function SetOneParam ($sKey, $sParamName, $mValue, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		return parent::SetOneParam ($sKey, $sParamName, $mValue, $sInstance);
	}
	
	//
	// --- Переопределение публичных методов чтобы запретить работу с параметром конфига каждого ключа ---
	//
	
	private function CheckParamName ($sParamName) {
		if ($sParamName == PluginAdmin_ModuleSettings::CONFIG_DATA_PARAM_NAME) {
			throw new Exception ('Admin: You can`t access directly to config`s data in storage.');
		}
	}
	
	// ---
	
	/*
		Установить значение
	*/
	public function Set ($sParamName, $mValue, $oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$this -> CheckParamName ($sParamName);
		return parent::Set ($sParamName, $mValue, $oCaller, $sInstance);
	}
	
	// ---
	
	/*
		Получить значение
	*/
	public function Get ($sParamName, $oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$this -> CheckParamName ($sParamName);
		return parent::Get ($sParamName, $oCaller, $sInstance);
	}
	
	// ---
	
	/*
		Удалить значение
	*/
	public function Remove ($sParamName, $oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$this -> CheckParamName ($sParamName);
		return parent::Remove ($sParamName, $oCaller, $sInstance);
	}
	
	// ---
	
	/*
		Удалить все значения
	*/
	public function RemoveAll ($oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		
		
		// todo: delete all except PluginAdmin_ModuleSettings::CONFIG_DATA_PARAM_NAME
		
		
		throw new Exception ('todo: admin: storage RemoveAll');
	}

}

?>