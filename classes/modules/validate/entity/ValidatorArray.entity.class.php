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
 * Валидатор массивов
 *
 */

class PluginAdmin_ModuleValidate_EntityValidatorArray extends ModuleValidate_EntityValidator
{

    /**
     * Допускать или нет пустое значение
     *
     * @var bool
     */
    public $allowEmpty = true;

    /**
     * Максимально допустимый размер массива(элементов)
     *
     * @var null|integer|float
     */
    public $max_items;

    /**
     * Минимально допустимый размер массива(элементов)
     *
     * @var null|integer|float
     */
    public $min_items;

    /**
     * Список разрешенных элементов массива
     *
     * @var null|array
     */
    public $enum;

    /**
     * Валидатор для каждого значения массива, полный аналог обычного валидатора
     *
     * @var null|array
     */
    public $item_validator;

    /**
     * Кастомное сообщение об ошибке при слишком большом массиве
     *
     * @var string
     */
    public $msgTooBig;

    /**
     * Кастомное сообщение об ошибке при слишком маленьком массиве
     *
     * @var string
     */
    public $msgTooSmall;

    /**
     * Кастомное сообщение об ошибке при значении, не входящим в список разрешенных
     *
     * @var string
     */
    public $msgValueNotAllowed;

    /**
     * Кастомное сообщение об ошибке при значении элемента которое не проходит валидацию элемента
     *
     * @var string
     */
    public $msgIncorrectValue;


    /**
     * Запуск валидации
     *
     * @param mixed $sValue Данные для валидации
     *
     * @return bool|string
     */
    public function validate($sValue)
    {
        /*
         * проверка типа
         */
        if (!is_array($sValue)) {
            return $this->getMessage($this->Lang_Get('plugin.admin.errors.validator.validate_array_must_be_array', null,
                    false));
        }
        /*
         * разрешено ли пустое значение
         */
        if ($this->allowEmpty and $this->isEmpty($sValue)) {
            return true;
        }
        /*
         * минимальное количество элементов
         */
        if ($this->min_items !== null and count($sValue) < $this->min_items) {
            return $this->getMessage($this->Lang_Get('plugin.admin.errors.validator.validate_array_too_small', null,
                    false), 'msgTooSmall', array('min_items' => $this->min_items));
        }
        /*
         * максимальное количество элементов
         */
        if ($this->max_items !== null and count($sValue) > $this->max_items) {
            return $this->getMessage($this->Lang_Get('plugin.admin.errors.validator.validate_array_too_big', null,
                    false), 'msgTooBig', array('max_items' => $this->max_items));
        }
        /*
         * если задано перечисление разрешенных элементов массива
         */
        if ($this->enum !== null and count($this->enum) > 0) {
            foreach ($sValue as $sVal) {
                if (!in_array($sVal, $this->enum)) {
                    return $this->getMessage($this->Lang_Get('plugin.admin.errors.validator.validate_array_value_is_not_allowed',
                            null, false), 'msgValueNotAllowed', array('val' => $sVal));
                }
            }
        }
        /*
         * если для элементов массива задан свой валидатор
         */
        if ($this->item_validator !== null and count($this->item_validator) > 0) {
            foreach ($sValue as $sVal) {
                if (!$this->Validate_Validate($this->item_validator['type'], $sVal,
                    isset($this->item_validator['params']) ? $this->item_validator['params'] : array())
                ) {
                    return $this->getMessage(
                        $this->Lang_Get('plugin.admin.errors.validator.validate_array_value_is_not_correct', null,
                            false) . '. ' . $this->Validate_GetErrorLast(true),
                        'msgIncorrectValue',
                        array('val' => $sVal)
                    );
                }
            }
        }
        /*
         * валидация пройдена
         */
        return true;
    }

}

?>