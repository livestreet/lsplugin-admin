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
 *	Модуль подписки на уведомление о изменении параметров конфига
 *
 *	Плагины, которые хотят получить уведомления о смене параметра их конфига, должны унаследовать этот модуль
 *	и добавить в него свой метод "PluginnameOnChange ($sKey, $mNewValue, $mPreviousValue)"
 *	и возвращать true в случае успеха (разрешения на изменение параметра)
 *	или текст ошибки (тип string) в случае запрета для данного значения ключа
 *	
 *	by PSNet
 *	http://psnet.lookformp3.net
 *
*/

class PluginAdmin_ModuleEvents extends Module {
	
	protected $sOnChangeFunctionPostfix = 'OnChange';
	
	
	public function Init() {}
	
	
	final public function ConfigParameterChangeNotification ($sConfigName, $sKey, $mNewValue, $mPreviousValue) {
		$sMethodName = $this -> GetOnChangeHandlerMethodName ($sConfigName);
		if (method_exists ($this, $sMethodName)) {
			return call_user_func (array ($this, $sMethodName), $sKey, $mNewValue, $mPreviousValue);
		}
		return true;
	}
	
	
	final protected function GetOnChangeHandlerMethodName ($sConfigName) {
		if ($sConfigName != ModuleStorage::DEFAULT_KEY_NAME) {
			return ucfirst ($sConfigName) . $this -> sOnChangeFunctionPostfix;
		}
		return $this -> sOnChangeFunctionPostfix;			// for engine this will be just "OnChange"
	}

}

?>