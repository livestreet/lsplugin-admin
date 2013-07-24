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
 *	или текст ошибки в случае запрета для данного значения ключа (тип string)
 *	
 *	by PSNet
 *	http://psnet.lookformp3.net
 *
*/

class PluginAdmin_ModuleEvents extends Module {
	
	protected $sOnChangeFunctionPostfix = 'OnChange';
	
	
	public function Init() {}
	
	
	final public function ConfigParameterChangeNotification ($sConfigName, $sKey, $mNewValue, $mPreviousValue) {
		$sPluginName = ucfirst ($sConfigName) . $this -> sOnChangeFunctionPostfix;	// todo: engine function name?
		if (method_exists ($this, $sPluginName)) {
			return call_user_func (array ($this, $sPluginName), $sKey, $mNewValue, $mPreviousValue);
		}
		return true;
	}

}

?>