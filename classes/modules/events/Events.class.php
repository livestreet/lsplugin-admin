<?php
/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 * 
 * ------------------------------------------------------
 * 
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 * 
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * 
 * ------------------------------------------------------
 * 
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author PSNet <light.feel@gmail.com>
 * 
 */

/*
 *	Модуль подписки на уведомление о изменении параметров конфига
 *
 *	Плагины, которые хотят получить уведомления о смене параметра их конфига, должны унаследовать этот модуль
 *	и добавить в него свой метод "PluginnameOnChange($sKey, $mNewValue, $mPreviousValue)"
 *	и возвращать true в случае успеха(разрешения на изменение параметра)
 *	или текст ошибки(тип string) в случае запрета для данного значения ключа
 *
 *	Подписка может быть нужна, например, когда в админке изменили список размеров изображений и их нужно автоматически пересоздать.
 *	В таком случае плагин может подписаться на событие и его метод в наследуемом модуле будет вызван если один из его ключей изменился.
 *	Метод получит имя ключа в виде "ключ1.ключ2.ключ3"(как и в вызовах класса Config), новое и старое значение параметра.
 *	Метод обязательно должен вернуть true в случае успеха или текст ошибки.
 *	
 *
*/

class PluginAdmin_ModuleEvents extends Module {
	
	protected $sOnChangeFunctionPostfix = 'OnChange';
	
	
	public function Init() {}
	
	
	final public function ConfigParameterChangeNotification($sConfigName, $sKey, $mNewValue, $mPreviousValue) {
		$sMethodName = $this->GetOnChangeHandlerMethodName($sConfigName);
		if (method_exists($this, $sMethodName)) {
			return call_user_func(array($this, $sMethodName), $sKey, $mNewValue, $mPreviousValue);
		}
		return true;
	}
	
	
	final protected function GetOnChangeHandlerMethodName($sConfigName) {
		if ($sConfigName != ModuleStorage::DEFAULT_KEY_NAME) {
			return ucfirst($sConfigName) . $this->sOnChangeFunctionPostfix;
		}
		return $this->sOnChangeFunctionPostfix;			// for engine this will be just "OnChange"
	}

}

?>