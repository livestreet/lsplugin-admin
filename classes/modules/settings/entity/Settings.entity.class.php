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
 * @author Serge Pustovit (PSNet) <light.feel@gmail.com>
 *
 */
/*
 *
 * Сущность для работы с настройками
 *
 */

class PluginAdmin_ModuleSettings_EntitySettings extends Entity
{

    /*
     * максимальное количество элементов для селекта типа "целое число", если диапазон больше - будет показан простой текстовый ввод
     */
    const INTEGER_MAX_SELECT_ELEMENTS = 500;


    /**
     * Нужно ли показывать для параметра типа "массив" форму специального отображения (динимическое поле)
     *
     * @return bool
     */
    public function getNeedToShowSpecialArrayForm()
    {
        $aValidatorData = $this->getValidator();
        /*
         * является ли этот параметр массивом
         */
        if ($aValidatorData['type'] != 'Array') {
            return false;
        }
        /*
         * для специального отображения нужны параметры валидатора
         */
        if (!isset($aValidatorData['params'])) {
            return false;
        }
        /*
         * если указано выводить как обычный массив
         */
        if ($this->getShowAsPhpArray()) {
            return false;
        }
        /*
         * если массив не является простым (имеет вложенные массивы)
         */
        if (!$this->IsArraySimple()) {
            return false;
        }
        /*
         * разрешить перечисление (если задано) или текстовое поле для добавления значений
         */
        return true;
    }


    /**
     * Проверяет является ли массив простым (каждое значение которого - скалярное)
     *
     * @return bool
     */
    protected function IsArraySimple()
    {
        $aData = $this->getValue();
        if (!is_array($aData)) {
            return false;
        }
        foreach ($aData as $mVal) {
            if (!is_scalar($mVal)) {
                return false;
            }
        }
        return true;
    }


    /**
     * Нужно ли показывать селект для выбора значения для типа параметра "целое число" (на основе данных валидатора)
     *
     * @return bool
     */
    public function getNeedToShowSpecialIntegerForm()
    {
        $aValidatorData = $this->getValidator();
        /*
         * является ли этот параметр числом
         */
        if ($aValidatorData['type'] != 'Number') {
            return false;
        }
        /*
         * для специального отображения нужны параметры валидатора
         */
        if (!isset($aValidatorData['params'])) {
            return false;
        }
        /*
         * нужны границы числа
         */
        $aValidatorParams = $aValidatorData['params'];
        if (!isset($aValidatorParams['min']) or !isset($aValidatorParams['max'])) {
            return false;
        }
        /*
         * чтобы не нагружать браузер слишком большими списками чисел
         */
        if ($aValidatorParams['max'] - $aValidatorParams['min'] > self::INTEGER_MAX_SELECT_ELEMENTS) {
            return false;
        }
        /*
         * разрешить использование селекта для чисел
         */
        return true;
    }

}

?>