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
 *	Сущность для работы с настройками
 */

class PluginAdmin_ModuleSettings_EntitySettings extends Entity {


	/**
	 * Нужно ли показывать для параметра типа "массив" форму специального отображения (динимическое поле)
	 *
	 * @return bool
	 */
	public function getNeedToShowSpecialArrayForm() {
		$aValidatorData = $this->getValidator();
		
		if ($aValidatorData ['type'] != 'Array') {
			return false;
		}
		
		if (!isset($aValidatorData ['params'])) {
			return false;
		}
		
		if ($this->getShowAsPhpArray()) {
			return false;
		}
		if (!$this->IsArraySimple()) {
			return false;
		}
		/*
		 * разрешить перечисление (если задано) или текстовое поле для добавления значений в противном случае
		 */
		return true;
	}


	/**
	 * Проверяет является ли массив простым (каждое значение которого - скалярное)
	 *
	 * @return bool
	 */
	protected function IsArraySimple() {
		$aData = $this->getValue();
		if (!is_array($aData)) return false;
		foreach($aData as $mVal) {
			if (!is_scalar($mVal)) return false;
		}
		return true;
	}


	/**
	 * Нужно ли показывать селект для выбора значения для типа параметра "целое число" (на основе данных валидатора)
	 *
	 * @return bool
	 */
	public function getNeedToShowSpecialIntegerForm() {
		$aValidatorData = $this->getValidator();
		
		if ($aValidatorData ['type'] != 'Number') {
			return false;
		}
		
		if (!isset($aValidatorData ['params'])) {
			return false;
		}
		
		$aValidatorParams = $aValidatorData ['params'];
		if (!isset($aValidatorParams ['min']) or !isset($aValidatorParams ['max'])) {
			return false;
		}
		/*
		 * чтобы не нагружать браузер слишком большими списками чисел
		 */
		if ($aValidatorParams ['max'] - $aValidatorParams ['min'] > 500) {
			return false;
		}
		return true;
	}

}

?>