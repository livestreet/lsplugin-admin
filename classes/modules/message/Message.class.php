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
 *	Модуль сообщений, в зависимости от типа запроса(аякс или нет) добавляет сообщения об ошибках
 *	Используется при получении данных формы настроек
 */

class PluginAdmin_ModuleMessage extends PluginAdmin_Inherits_ModuleMessage {
	
	/*
	 * список ошибок по полям
	 */
	private $aParamErrors = array();


	/**
	 * Добавляет запись ошибки в массив
	 *
	 * @param $sMsg		текст ошибки
	 * @param $sKey		ключ, у которого эта ошибка возникла
	 */
	private function AddParamError($sMsg, $sKey) {
		$this->aParamErrors [] = array(
			'key' => $sKey,
			'msg' => $sMsg
		);
	}


	/**
	 * Добавить показ ошибки
	 * В зависимости от запроса (обычный или через аякс) будет использован стандартный метод для вывода ошибок или специальный
	 *
	 * @param $sMsg		текст ошибки
	 * @param $sKey		ключ, у которого эта ошибка возникла
	 */
	public function AddOneParamError($sMsg, $sKey) {
		if (isAjaxRequest()) {
			// add errors into special array list
			$this->AddParamError($sMsg, $sKey);
		} else {
			$this->Message_AddError($sMsg, $this->Lang_Get('error'), true);
		}
	}


	/**
	 * Получить список всех ошибок для вывода их через аякс
	 *
	 * @return array
	 */
	public function GetParamsErrors() {
		return $this->aParamErrors;
	}

}

?>