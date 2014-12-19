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
 * Для ручного управления конфигами, переопределим методы хранилища
 *
 */

class PluginAdmin_ModuleStorage extends PluginAdmin_Inherits_ModuleStorage
{

    /*
     *
     * --- Переопределение публичных методов чтобы запретить работу с параметром конфига каждого ключа ---
     *
     */

    /**
     * Проверка имени параметра чтобы оно не совпало с именем параметра в котором хранится конфиг
     *
     * @param $sParamName        имя параметра
     * @throws Exception
     */
    private function CheckParamName($sParamName)
    {
        if ($sParamName == PluginAdmin_ModuleSettings::CONFIG_DATA_PARAM_NAME) {
            throw new Exception('Admin: error: You can`t access directly to config`s data in storage.');
        }
    }


    /**
     * Установить значение
     *
     * @param $sParamName    имя параметра
     * @param $mValue        значение
     * @param $oCaller        контекст, вызывающий метод
     * @param $sInstance    инстанция хранилища
     * @return mixed
     */
    public function Set($sParamName, $mValue, $oCaller = null, $sInstance = self::DEFAULT_INSTANCE)
    {
        $this->CheckParamName($sParamName);
        return parent::Set($sParamName, $mValue, $oCaller, $sInstance);
    }

    /**
     * Удалить все значения
     *
     * @param $oCaller        контекст, вызывающий метод
     * @param $sInstance    инстанция хранилища
     */
    public function RemoveAll($oCaller = null, $sInstance = self::DEFAULT_INSTANCE)
    {
        $sCallerName = $this->GetKeyForCaller($oCaller);

        /*
         * Удалить все ключи, за исключением конфига (PluginAdmin_ModuleSettings::CONFIG_DATA_PARAM_NAME)
         */
        $aParamsList = $this->GetParamsAll($sCallerName, $sInstance);
        foreach (array_keys($aParamsList) as $sParamKeyName) {
            if ($sParamKeyName != PluginAdmin_ModuleSettings::CONFIG_DATA_PARAM_NAME) {
                $this->RemoveOneParam($sCallerName, $sParamKeyName, $sInstance);
            }
        }
    }


    /*
     *
     * --- Работа с параметрами только на момент сессии ---
     *
     */

    /**
     * Сохранить значение параметра на время сессии (без записи в хранилище)
     *
     * @param $sParamName    имя параметра
     * @param $mValue        значение
     * @param $oCaller        контекст, вызывающий метод
     * @param $sInstance    инстанция хранилища
     * @return mixed
     */
    public function SetSmart($sParamName, $mValue, $oCaller = null, $sInstance = self::DEFAULT_INSTANCE)
    {
        $this->CheckParamName($sParamName);
        return parent::SetSmart($sParamName, $mValue, $oCaller, $sInstance);
    }


    /**
     * Удалить параметр кеша сессии (без записи в хранилище)
     *
     * @param $sParamName    имя параметра
     * @param $oCaller        контекст, вызывающий метод
     * @param $sInstance    инстанция хранилища
     * @return mixed
     */
    public function RemoveSmart($sParamName, $oCaller = null, $sInstance = self::DEFAULT_INSTANCE)
    {
        $this->CheckParamName($sParamName);
        return parent::RemoveSmart($sParamName, $oCaller, $sInstance);
    }


    /**
     * Сбросить кеш сессии (без записи в хранилище)
     *
     * @param $oCaller        контекст, вызывающий метод
     * @param $sInstance    инстанция хранилища
     */
    public function Reset($oCaller = null, $sInstance = self::DEFAULT_INSTANCE)
    {
        $sCallerName = $this->GetKeyForCaller($oCaller);

        /*
         * Удалить все параметры, за исключением конфига (PluginAdmin_ModuleSettings::CONFIG_DATA_PARAM_NAME)
         */
        foreach ($this->aSessionCache[$sInstance][$sCallerName] as $sParamKeyName) {
            if ($sParamKeyName != PluginAdmin_ModuleSettings::CONFIG_DATA_PARAM_NAME) {
                $this->RemoveSmartParam($sCallerName, $sParamKeyName, $sInstance);
            }
        }
    }


    /**
     * Может быть вызвано плагином для сохранения ключей его конфига и последующей их автозагрузки как части конфига
     * (после программного их редактирования)
     *
     * Например, добавление данных:
     *
     *        Config::Set('plugin.test.mykey', 'testing');
     *        Config::Set('plugin.test.mydata', array(1, 2, 3));
     *        $this->Storage_SaveMyConfig(array('mykey', 'mydata'), $this);
     *
     * Удаление ранее сохраненного ключа (значение должно быть установлено в null):
     *
     *        Config::Set('plugin.test.mykey', null);
     *        $this->Storage_SaveMyConfig(array('mykey'), $this);
     *
     *
     * @param array $aKeysToSave ключи из конфига плагина, данные которых нужно сохранить
     * @param            $oCaller        контекст, вызывающий метод
     * @param            $sInstance        инстанция хранилища
     * @return bool
     */
    public function SaveMyConfig($aKeysToSave = array(), $oCaller, $sInstance = self::DEFAULT_INSTANCE)
    {
        if (empty($aKeysToSave)) {
            return false;
        }
        $sCallerName = $this->GetKeyForCaller($oCaller);
        return $this->PluginAdmin_Settings_SavePluginConfig($aKeysToSave, $sCallerName, $sInstance);
    }

}

?>