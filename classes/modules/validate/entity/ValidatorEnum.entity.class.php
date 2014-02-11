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
 * @link      http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author    Serge Pustovit (PSNet) <light.feel@gmail.com>
 *
 */

/*
 *
 * Валидатор перечислений
 *
 */

class PluginAdmin_ModuleValidate_EntityValidatorEnum extends ModuleValidate_EntityValidator {

	/**
	 * Допускать или нет пустое значение
	 *
	 * @var bool
	 */
	public $allowEmpty = true;

	/**
	 * Массив разрешенных элементов
	 *
	 * @var array
	 */
	public $enum = array();

	/*
	 * Ключ языкового файла сообщения о неверном типе значения
	 */
	public $sMsgValueNotCorrectId = 'plugin.admin.errors.validator.validate_enum_value_type_is_not_correct';

	/*
	 * Ключ языкового файла сообщения о не разрешенном значении
	 */
	public $sMsgValueNotAllowedId = 'plugin.admin.errors.validator.validate_enum_value_is_not_allowed';

	/*
	 * todo: удалить две переменные ниже, когда будет закрыт тикет в фреймворке: https://github.com/livestreet/livestreet-framework/issues/13
	 * 		 проверить на ошибку, подставляя некорректные данные
	 */
	public $sMsgValueNotAllowed = null;
	public $sMsgValueNotCorrect = null;


	/**
	 * Запуск валидации
	 *
	 * @param mixed $sValue    			Данные для валидации
	 * @return bool|string
	 */
	public function validate($sValue) {
		/*
		 * проверка типа значения
		 */
		if (!is_scalar($sValue)) {
			return $this->getMessage(null, 'sMsgValueNotCorrect', array('val' => $sValue));
		}
		/*
		 * разрешение на пустое значение
		 */
		if ($this->allowEmpty and $this->isEmpty($sValue)) {
			return true;
		}
		/*
		 * проверка на вхождение в перечисление
		 */
		if (!in_array($sValue, $this->enum)) {
			return $this->getMessage(null, 'sMsgValueNotAllowed', array('val' => $sValue));
		}
		/*
		 * значение корректно
		 */
		return true;
	}

}

?>