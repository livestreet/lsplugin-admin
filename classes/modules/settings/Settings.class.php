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
 * Модуль для работы с настройками
 *
 */

class PluginAdmin_ModuleSettings extends ModuleStorage
{

    /*
     * Ключ конфига, который хранит описатели настроек (схему) каждого конфига
     */
    const CONFIG_SCHEME_KEY = '$config_scheme$';
    /*
     * Ключ конфига движка, который указывает на список групп главного конфига
     */
    const ROOT_CONFIG_GROUPS_KEY = '$config_groups$';
    /*
     * Ключ конфига плагина, который хранит список разделов настроек для плагина
     */
    const PLUGIN_CONFIG_SECTIONS = '$config_sections$';

    /*
     * Имя параметра для плагина или ядра для сохранения конфига в хранилище
     */
    const CONFIG_DATA_PARAM_NAME = '__config__';

    /*
     * Скрытый системный идентификатор данных о настройках из формы (для проверки что данный набор данных - параметр настроек)
     */
    const ADMIN_SETTINGS_FORM_SYSTEM_ID = 'LS-Admin';

    /*
     * До момента сохранения настроек в БД они будут хранится в этой инстанции конфига
     */
    const ADMIN_TEMP_CONFIG_INSTANCE = 'temporary_instance';

    /*
     * Индекс массива с подписью параметра
     */
    const POST_RAW_DATA_ARRAY_SIGNATURE = 0;
    /*
     * Индекс массива с ключем параметра
     */
    const POST_RAW_DATA_ARRAY_KEY = 1;
    /*
     * Индекс массива с данными параметра (от этого номера и до конца массива)
     */
    const POST_RAW_DATA_ARRAY_VALUE_FIRST = 2;

    /*
     * Путь к схеме и языковым файлам главного конфига относительно корня папки плагина
     */
    const PATH_TO_ROOT_CONFIG_SCHEME = 'config/root_config/';


    public function Init()
    {
        parent::Init();
    }


    /**
     * Сохранить конфиг ключа
     *
     * @param $sConfigName        имя конфига
     * @param $mData            данные
     * @param $sInstance        инстанция хранилища
     * @return mixed
     */
    final public function SaveConfigData($sConfigName, $mData, $sInstance = self::DEFAULT_INSTANCE)
    {
        $sKey = $this->GetCorrectStorageKey($sConfigName);
        return $this->SetOneParam($sKey, self::CONFIG_DATA_PARAM_NAME, $mData, $sInstance);
    }


    /**
     * Начать загрузку всех конфигов в системе
     */
    final public function AutoLoadConfigs()
    {
        /*
         * получить данные в сыром виде для всех записей хранилища
         */
        $aData = $this->GetFieldsAll();
        if ($aData['count']) {
            /*
             * для каждой записи хранилища выполнить загрузку данных
             */
            foreach ($aData['collection'] as $aFieldData) {
                /*
                 * tip: фактически, к хранилищу используется всего один запрос для получения данных (см. выше GetFieldsAll),
                 * метод ниже распакует для каждого ключа все его параметры в сессионное хранилище.
                 * это позволит увеличить быстродействие хранилища по максимуму при загрузке конфигов.
                 * tip 2: в некоторых случаях, с админкой сайт будет работать быстрее, если установлено много плагинов, использующих хранилище
                 */
                $this->GetParamsValuesFromRawData($aFieldData['key'], $aFieldData['value']);
                /*
                 * начать загрузку
                 */
                $this->LoadConfig($aFieldData['key']);
            }
        }
    }


    /**
     * Загрузить конфиг ключа
     *
     * @param $sKey        ключ
     */
    private function LoadConfig($sKey)
    {
        /*
         * Получить конфиг текущего ключа (если существует)
         * tip: данный метод вернет данные из сессионного хранилища без запроса к БД т.к. они были туда помещены в AutoLoadConfigs
         */
        if ($aConfigData = $this->GetOneParam($sKey, self::CONFIG_DATA_PARAM_NAME)) {
            if ($sKey == ModuleStorage::DEFAULT_KEY_NAME) {
                /*
                 * ядро
                 */

                /**
                 * Получаем схему для фильтрации
                 */
                $aKeys = array();
                $aShemeGroups = (array)Config::Get('$config_groups$');
                foreach ($aShemeGroups as $aGroups) {
                    foreach ((array)$aGroups as $aGroup) {
                        if (isset($aGroup['allowed_keys'])) {
                            $aKeys = array_merge($aKeys, $aGroup['allowed_keys']);
                        }
                    }
                }
                $aKeys = array_merge($aKeys, (array)Config::Get('$config_allowed_keys$'));
                $aConfigData = $this->FilterConfigByKeys($aConfigData, $aKeys,
                    array_keys((array)Config::Get('$config_scheme$')));
                $this->LoadRootConfig($aConfigData);
                /**
                 * Удаляем временные конфиги
                 */
            } else {
                /*
                 * плагин
                 */
                $sPlugin = $this->StripPluginPrefix($sKey);
                /**
                 * Получаем схему для фильтрации
                 */
                $aKeys = array();
                $aShemeSections = (array)Config::Get('plugin.' . $sPlugin . '.$config_sections$');
                if ($aShemeSections) {
                    foreach ($aShemeSections as $aSections) {
                        if (isset($aSections['allowed_keys'])) {
                            $aKeys = array_merge($aKeys, $aSections['allowed_keys']);
                        }
                    }
                    $aKeysAvailable = array_keys((array)Config::Get('plugin.' . $sPlugin . '.$config_scheme$'));
                } else {
                    /**
                     * Используем все доступные ключи
                     */
                    $aKeys = array_keys((array)Config::Get('plugin.' . $sPlugin . '.$config_scheme$'));
                    $aKeysAvailable = array();
                }

                $aConfigData = $this->FilterConfigByKeys($aConfigData, $aKeys, $aKeysAvailable);
                $this->LoadPluginConfig($sPlugin, $aConfigData);
            }
        }
    }

    /**
     * Фильтрует массив конфига по ключам
     *
     * @param $aData
     * @param $aKeys
     * @return array
     */
    protected function FilterConfigByKeys($aData, $aKeys, $aKeysAvailable = array())
    {
        /**
         * Создаем временный конфиг для удобного доступа к значениям
         */
        Config::getInstance($sInstanceTmp = '__for_filter__' . func_generator(8))->SetConfig($aData);
        Config::getInstance($sInstanceResult = '__for_filter_result__' . func_generator(8))->SetConfig(array());

        foreach ($aKeys as $sKey) {
            if (strpos($sKey, '*') === false) {
                if (Config::isExist($sKey, $sInstanceTmp)) {
                    Config::Set($sKey, Config::Get($sKey, $sInstanceTmp), $sInstanceResult);
                }
            } else {
                /**
                 * Получаем набор ключей по маске из списка доступных
                 */
                $sKey = rtrim($sKey, '*');
                foreach ($aKeysAvailable as $sKeyAvailable) {
                    if (strpos($sKeyAvailable, $sKey) !== false) {
                        if (Config::isExist($sKeyAvailable, $sInstanceTmp)) {
                            Config::Set($sKeyAvailable, Config::Get($sKeyAvailable, $sInstanceTmp), $sInstanceResult);
                        }
                    }
                }
            }
        }
        $aData = Config::getInstance($sInstanceResult)->GetConfig();
        /**
         * Удаляем данные временных конфигов
         */
        Config::getInstance($sInstanceTmp)->SetConfig(array());
        Config::getInstance($sInstanceResult)->SetConfig(array());
        return $aData;
    }

    /**
     * Удалить префикс перед именем плагина
     *
     * @param $sKey        ключ
     * @return mixed    ключ без префикса
     */
    private function StripPluginPrefix($sKey)
    {
        return str_replace(ModuleStorage::PLUGIN_PREFIX, '', $sKey);
    }


    /**
     * Загрузить конфиг ядра
     *
     * @param $mValue    данные (конфиг)
     */
    private function LoadRootConfig($mValue)
    {
        /*
         * Загрузить настройки обьеденив их с существующими (из конфига)
         */
        Config::getInstance()->SetConfig($mValue, false);
    }


    /**
     * Загрузить конфиг плагина
     *
     * @param $sPluginName                имя плагина
     * @param $aSavedSettingsFromDB        данные (конфиг)
     * @return bool
     */
    private function LoadPluginConfig($sPluginName, $aSavedSettingsFromDB)
    {
        $aOriginalSettingsFromConfig = Config::Get('plugin.' . $sPluginName);

        /*
         * Проверка активирован ли плагин
         * Если плагин активирован и есть его данные из хранилища, то его текущий конфиг из файла php не будет пустым
         * Данное решение намного быстрее чем получать список плагинов
         */
        if (is_null($aOriginalSettingsFromConfig)) {
            return false;
        }

        /*
         * Применить настройки, специальным методом рекурсивно обьеденив их с существующими
         * tip: не использовать "array_merge_recursive"
         */
        $aMixedSettings = array_replace_recursive_distinct($aOriginalSettingsFromConfig, $aSavedSettingsFromDB);
        Config::Set('plugin.' . $sPluginName, $aMixedSettings);

        /*
         * вариант № 2 (не используется глубокая проверка ключей)
         * tip: не использовать т.к. нет уверенности в полной проверке ключей
         */
        //Config::getInstance()->SetConfig(array('plugin' => array($sPluginName => $aSavedSettingsFromDB)), false);
    }


    /*
     *
     *	--- Хелперы ---
     *
     */

    /**
     * Проверка активирован ли плагин
     *
     * @param $sConfigName        имя плагина
     * @return bool
     */
    public function CheckPluginCodeIsActive($sConfigName)
    {
        return array_key_exists($sConfigName, Engine::getInstance()->GetPlugins());
    }


    /**
     * Получить полное имя префикса ключа по имени конфига (имя плагина или ядра),
     * вернет для плагинов префикс "plugin.имяплагина." или пустое значение для ядра (без префикса)
     *
     * @param            $sConfigName        имя конфига
     * @param bool $bAddDot добавлять ли точку в конце (удобно для получения всего конфига)
     * @return string                        полное представление ключа
     */
    private function GetFullConfigKeyPrefix($sConfigName, $bAddDot = true)
    {
        return $sConfigName == ModuleStorage::DEFAULT_KEY_NAME ? '' : 'plugin.' . $sConfigName . ($bAddDot ? '.' : '');
    }


    /**
     * Получить полное имя ключа по имени конфига и нужному его ключу
     *
     * @param $sConfigName                    имя конфига
     * @param $sConfigKey                    ключ конфига
     * @return string
     */
    private function GetFullConfigKey($sConfigName, $sConfigKey)
    {
        return $this->GetFullConfigKeyPrefix($sConfigName) . $sConfigKey;
    }


    /**
     * Получить текущее значение из конфига, учитывая имя конфига
     *
     * @param        $sConfigName            имя конфига (имя плагина или ядра)
     * @param        $sConfigKey             ключ конфига
     * @param string $sInstance инстанция
     * @return mixed                значение
     */
    private function GetConfigKeyValue($sConfigName, $sConfigKey, $sInstance = Config::DEFAULT_CONFIG_INSTANCE)
    {
        return Config::Get($this->GetFullConfigKey($sConfigName, $sConfigKey), $sInstance);
    }


    /**
     * Задать новое значение в конфиге, учитывая имя конфига
     *
     * @param        $sConfigName            имя конфига (имя плагина или ядра)
     * @param        $sConfigKey             ключ конфига
     * @param        $mValue                 значение
     * @param string $sInstance инстанция
     */
    private function SetConfigKeyValue($sConfigName, $sConfigKey, $mValue, $sInstance = Config::DEFAULT_CONFIG_INSTANCE)
    {
        Config::Set($this->GetFullConfigKey($sConfigName, $sConfigKey), $mValue, $sInstance);
    }


    /**
     * Превратить ключи языковых констант в текст из языкового файла, на который они указывают
     * На основе имени конфига
     *
     * @param            $sConfigName    имя конфига
     * @param            $aParam            параметр в котором указаны ключи текстовок для данного имени конфига
     * @param array $aKeys ключи, которые нужно заполнить текстовками
     * @return mixed                    параметр с текстовками вместо ключей, указывающих на них
     */
    private function ConvertLangKeysToTexts($sConfigName, $aParam, $aKeys = array('name', 'description'))
    {
        foreach ($aKeys as $sKey) {
            /*
             * если такой ключ не был задан - пропустить
             */
            if (!isset($aParam[$sKey]) or empty($aParam[$sKey])) {
                continue;
            }
            /*
             * получить текстовку по её ключу
             */
            $sLangKey = $this->GetFullConfigKeyPrefix($sConfigName) . $aParam[$sKey];
            $sText = $this->Lang_Get($sLangKey);
            /*
             * если текстовка существует (проверка позволяет не использовать языковый файл и прописывать текстовки прямо в ключах)
             * tip: в новом лс возвращается ключ текстовки, если она не существует по этому ключу
             */
            if ($sText !== $sLangKey) {
                /*
                 * установить вместо ключа, указывающего на текстовку, её отображаемое значение
                 */
                $aParam[$sKey] = $sText;
            }
        }
        return $aParam;
    }


    /**
     * Получить описание схемы конфига для имени конфига
     *
     * @param $sConfigName            имя конфига
     * @return array|mixed            массив с описанием структуры
     */
    private function GetConfigSettingsSchemeInfo($sConfigName)
    {
        $aData = $this->GetConfigKeyValue($sConfigName, self::CONFIG_SCHEME_KEY);
        return $aData ? $aData : array();
    }


    /**
     * Проводит валидацию значения параметра (используется валидатор движка)
     *
     * @param $aValidatorInfo        данные для валидатора
     * @param $mValue                значение, которое нужно проверит
     * @return bool                    результат проверки
     */
    private function ValidateParameter($aValidatorInfo, $mValue)
    {
        if (!isset($aValidatorInfo['type'])) {
            return true;
        }
        return $this->Validate_Validate(
            $aValidatorInfo['type'],
            $mValue,
            isset($aValidatorInfo['params']) ? $aValidatorInfo['params'] : array()
        );
    }


    /**
     * Получить последнюю ошибку валидатора
     *
     * @return mixed                текст ошибки
     */
    private function ValidatorGetLastError()
    {
        return $this->Validate_GetErrorLast(true);
    }


    /**
     * Получение обьектов информации о настройках конфига
     *
     * @param            $sConfigName                имя конфига
     * @param array $aAllowedKeys список разрешенных ключей для показа из схемы конфига
     * @param array $aExcludedKeys список запрещенных ключей для показа из схемы конфига
     * @return array                                настройки конфига
     */
    private function GetConfigSettings($sConfigName, $aAllowedKeys = array(), $aExcludedKeys = array())
    {
        /*
         * Получить описание настроек из конфига
         */
        $aSettingsInfo = $this->GetConfigSettingsSchemeInfo($sConfigName);
        /*
         * Все настройки
         */
        $aSettingsAll = array();
        /*
         * По всем записям описаний каждого параметра получить дополнительные данные
         */
        foreach ($aSettingsInfo as $sConfigKey => $aOneParamInfo) {
            /*
             * Получить только нужные ключи
             */
            if (!empty($aAllowedKeys) and !$this->CheckIfPartOfKeyExistsInArray($sConfigKey, $aAllowedKeys)) {
                continue;
            }
            /*
             * Исключить не нужные ключи
             */
            if (!empty($aExcludedKeys) and $this->CheckIfPartOfKeyExistsInArray($sConfigKey, $aExcludedKeys)) {
                continue;
            }

            /*
             * Получить текущее значение параметра
             */
            if (($mValue = $this->GetConfigKeyValue($sConfigName, $sConfigKey)) === null) {
                $this->Message_AddError($this->Lang_Get('plugin.admin.errors.wrong_description_key',
                    array('key' => $sConfigKey)), $this->Lang_Get('common.error.error'));
                continue;
            }

            /*
             * Получить текстовки имени и описания параметра из ключей, указывающих на языковый файл
             */
            $aOneParamInfo = $this->ConvertLangKeysToTexts($sConfigName, $aOneParamInfo);

            /*
             * Собрать данные параметра и получить сущность
             */
            $aParamData = array_merge($aOneParamInfo, array('key' => $sConfigKey, 'value' => $mValue));
            $aSettingsAll[$sConfigKey] = Engine::GetEntity('PluginAdmin_Settings', $aParamData);
        }
        /*
         * отсортировать настройки согласно списку разрешенных ключей
         */
        $aSettingsAll = $this->SortSettingsByAllowedKeysList($aSettingsAll, $aAllowedKeys);
        return $aSettingsAll;
    }


    /**
     * Сравнение начала ключей из массива с указанным ключем (в списке ключей массива можно использовать первые символы ключей)
     *
     * @param $sCurrentKey                текущий ключ (в виде ключ1.ключ2.ключ3...)
     * @param $aKeys                    массив ключей
     * @return bool                        результат проверки
     */
    private function CheckIfPartOfKeyExistsInArray($sCurrentKey, $aKeys)
    {
        foreach ($aKeys as $sKey) {
            /*
             * если используется маска (может быть только в конце ключа!)
             */
            if (strpos($sKey, '*') !== false) {
                /*
                 * сравнивать по длине ключа (минус символ маски) из массива разрешенных ключей с текущим
                 */
                if (substr_compare($sKey, $sCurrentKey, 0, strlen($sKey) - 1, true) === 0) {
                    return true;
                }
            } else {
                /*
                 * сравнивать ключи как есть
                 */
                if ($sKey == $sCurrentKey) {
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * Сортировать массив настроек согласно массиву ключей настроек
     *
     * @param $aSettings        массив сущностей настроек
     * @param $aAllowedKeys        массив ключей
     * @return array            новый отсортированный массив сущностей настроек
     */
    private function SortSettingsByAllowedKeysList($aSettings, $aAllowedKeys)
    {
        /*
         * если разрешенные ключи не заданы - вернуть все настройки как есть
         */
        if (empty($aAllowedKeys)) {
            return $aSettings;
        }
        /*
         * новый набор отсортированных настроек
         */
        $aSettingsSorted = array();
        /*
         * по всему списку ключей
         */
        foreach ($aAllowedKeys as $sKey) {
            foreach ($aSettings as $sParamKey => $oParameter) {
                /*
                 * совпадают ли ключи по правилам записи
                 */
                if ($this->CheckIfPartOfKeyExistsInArray($oParameter->getKey(), (array)$sKey)) {
                    $aSettingsSorted[$sParamKey] = $oParameter;
                }
            }
        }
        return $aSettingsSorted;
    }


    /*
     *
     * --- Обработка разделов настроек ---
     *
     */

    /**
     * Получить разделы с их настройками по данным массива разделов и имени конфига
     *
     * @param $aSectionsInfo    массив разделов
     * @param $sConfigName        имя конфига
     * @return array
     */
    public function GetSectionsAndItsSettings($aSectionsInfo, $sConfigName)
    {
        /*
         * разделы и их настройки
         */
        $aSections = array();
        /*
         * по всем разделам группы
         */
        foreach ($aSectionsInfo as $aSectionOptions) {
            /*
             * получить текстовки имени раздела настроек и его описания
             */
            $aData = $this->ConvertLangKeysToTexts($sConfigName, $aSectionOptions);
            /*
             * получить настройки этого раздела
             */
            $aData['settings'] = $this->GetConfigSettings(
                $sConfigName,
                $this->GetAllowedKeysForGroupSection($aSectionOptions),
                $this->GetExcludedKeysForGroupSection($aSectionOptions)
            );
            $aSections[] = Engine::GetEntity('PluginAdmin_Settings_Section', $aData);
        }
        return $aSections;
    }


    /**
     * Получить список разрешенных ключей для раздела
     *
     * @param $aSectionData        данные раздела
     * @return array
     */
    private function GetAllowedKeysForGroupSection($aSectionData)
    {
        return isset($aSectionData['allowed_keys']) ? $aSectionData['allowed_keys'] : array();
    }


    /**
     * Получить список исключенных ключей для раздела
     *
     * @param $aSectionData        данные раздела
     * @return array
     */
    private function GetExcludedKeysForGroupSection($aSectionData)
    {
        return isset($aSectionData['excluded_keys']) ? $aSectionData['excluded_keys'] : array();
    }


    /**
     * Получить разделы с их настройками для ключа плагина
     *
     * @param $sConfigName        имя конфига (плагина)
     * @return array
     */
    public function GetPluginSectionsAndItsSettings($sConfigName)
    {
        /*
         * получить список разделов настроек плагина
         */
        $aSectionsInfo = $this->GetConfigKeyValue($sConfigName, self::PLUGIN_CONFIG_SECTIONS);
        /*
         * разрешить плагинам не заполнять разделы
         */
        if (is_null($aSectionsInfo)) {
            $aSectionsInfo = array(array());
        }
        return $this->GetSectionsAndItsSettings($aSectionsInfo, $sConfigName);
    }


    /*
     *
     * --- Получение настроек ---
     *
     */

    /**
     * Весь процесс получения настроек из формы
     *
     * @param $sConfigName                имя конфига
     * @return bool
     */
    final public function ParsePOSTDataIntoSeparateConfigInstance($sConfigName)
    {
        $bResult = true;
        /*
         * Получить описание настроек из конфига
         */
        $aSettingsInfo = $this->GetConfigSettings($sConfigName);
        foreach ($_POST as $aPostRawData) {
            /*
             * Проверка это ли параметр настроек формы
             */
            if (is_array($aPostRawData) and $aPostRawData[self::POST_RAW_DATA_ARRAY_SIGNATURE] == self::ADMIN_SETTINGS_FORM_SYSTEM_ID) {
                /*
                 * Структура принимаемых данных - массив с значениями по ключам:
                 *
                 *
                 * [self::POST_RAW_DATA_ARRAY_SIGNATURE] - идентификатор приналежности значения к параметрам (всегда должен быть self::ADMIN_SETTINGS_FORM_SYSTEM_ID)
                 * [self::POST_RAW_DATA_ARRAY_KEY] - ключ параметра (как прописан в конфиге)
                 * [self::POST_RAW_DATA_ARRAY_VALUE_FIRST] - значение параметра из формы
                 * [n] - n-е значение из формы (для типа "массив" улучшеного отображения)
                 */
                $sKey = $aPostRawData[self::POST_RAW_DATA_ARRAY_KEY];
                /*
                 * Если существует запись в конфиге о таком параметре, который был передан
                 */
                if ($sKey and array_key_exists($sKey, $aSettingsInfo)) {
                    $oParamInfo = $aSettingsInfo [$sKey];

                    /*
                     * получить значение данного параметра на основе данных о нем
                     */
                    $mValue = $this->GetFormParameterValue($aPostRawData, $oParamInfo);

                    /*
                     * Валидация параметра
                     */
                    if ($oParamInfo->getValidator() and !$this->ValidateParameter($oParamInfo->getValidator(), $mValue)
                    ) {
                        $this->Message_AddOneParamError(
                            $this->Lang_Get('plugin.admin.errors.wrong_parameter_value',
                                array('key' => $sKey)) . $this->ValidatorGetLastError(),
                            $sKey
                        );
                        $bResult = false;
                        /*
                         * продолжить если неверное значение указано для одного параметра
                         * чтобы получить список всех ошибок
                         */
                        continue;
                    }
                    /*
                     * Проверить текущее значение и предыдущее, вызов событий
                     */
                    if (($mResult = $this->FireEvents($sConfigName, $sKey, $mValue, $oParamInfo)) !== true) {
                        $this->Message_AddOneParamError(
                            $this->Lang_Get('plugin.admin.errors.disallowed_parameter_value',
                                array('key' => $sKey)) . $mResult,
                            $sKey
                        );
                        $bResult = false;
                        /*
                         * продолжить, если вызванное событие подписчика на изменение запретило (забраковало) данное значение
                         * чтобы собрать все ошибки
                         */
                        continue;
                    }
                    /*
                     * Сохранить значение ключа во временной инстанции конфига
                     */
                    $this->SaveKeyValue($sConfigName, $sKey, $mValue);
                } else {
                    $this->Message_AddOneParamError(
                        $this->Lang_Get('plugin.admin.errors.unknown_parameter', array('key' => $sKey)),
                        $sKey
                    );
                    $bResult = false;
                }
            }
        }
        /*
         * Проверить изменен ли хоть один параметр и вызвать событие
         */
        if (($mResult = $this->FireChangedAtLeastOneParamEvent($sConfigName, $aSettingsInfo)) !== true) {
            $this->Message_AddError($this->Lang_Get('plugin.admin.errors.disallowed_settings_by_inheriting_plugin') . $mResult);
            $bResult = false;
        }
        return $bResult;
    }


    /**
     * Получить данные параметра из формы
     *
     * @param $aPostRawData        значение одного параметра из post данных
     * @param $oParamInfo        описание структуры парамера из конфига
     * @return mixed            значение параметра
     * @throws Exception        если данные для параметра не были отправлены формой
     */
    private function GetFormParameterValue($aPostRawData, $oParamInfo)
    {
        /*
         * не установленное значение
         */
        $mValue = null;
        switch ($oParamInfo->getType()) {
            /*
             * массив
             */
            case 'array':
                /*
                 * для массива у которого особый вид отображения, нужно собрать значения
                 */
                if ($oParamInfo->getNeedToShowSpecialArrayForm()) {
                    $mValue = array();
                    /*
                     * собрать значения
                     */
                    for ($i = self::POST_RAW_DATA_ARRAY_VALUE_FIRST; $i < count($aPostRawData); $i++) {
                        $mValue[] = $aPostRawData[$i];
                    }
                    break;
                }
                /*
                 * для стандартного отображения массива в виде php array логика не меняется - получение идентично как и для других типов данных
                 * (прислано его строковое представление)
                 */

                /*
                 * tip: на данный момент такой тип данных запрещен в целях безопасности, т.к. требуется eval для этого
                 * поэтому проверка ниже бросит исключение
                 */
                break;
            /*
             * флажок
             */
            case 'boolean':
                /*
                 * tip: если данных для флажка нет - значит он просто выключен
                 */
                $mValue = isset($aPostRawData[self::POST_RAW_DATA_ARRAY_VALUE_FIRST]) ? 1 : 0;
                break;
            /*
             * остальные типы данных
             */
            default:
                if (isset($aPostRawData[self::POST_RAW_DATA_ARRAY_VALUE_FIRST])) {
                    $mValue = $aPostRawData[self::POST_RAW_DATA_ARRAY_VALUE_FIRST];
                }
        }
        /*
         * проверить результат
         */
        if (is_null($mValue)) {
            throw new Exception('Admin: error: value was not sent by request or null, raw post data: ' . print_r($aPostRawData,
                    true));
        }
        return $mValue;
    }


    /**
     * Сохранение данных одного ключа в временной инстанции конфига
     *
     * @param $sConfigName        имя конфига
     * @param $sKey                ключ
     * @param $mValue            значение
     */
    private function SaveKeyValue($sConfigName, $sKey, $mValue)
    {
        /*
         * Сохранить значение ключа в отдельной области видимости для дальнейшего получения списка настроек
         * Это очень удобно делать через отдельную инстанцию конфига - не нужно разбирать вручную ключи
         */
        $this->SetConfigKeyValue($sConfigName, $sKey, $mValue, self::ADMIN_TEMP_CONFIG_INSTANCE);
    }


    /**
     * Получение всех данных ранее сохраненных ключей из временной инстанции
     *
     * @param $sConfigName        имя конфига
     * @return array            массив данных
     */
    private function GetKeysData($sConfigName)
    {
        /*
         * Все параметры из формы сохранены в отдельной инстанции конфига
         */
        return Config::Get($this->GetFullConfigKeyPrefix($sConfigName, false), self::ADMIN_TEMP_CONFIG_INSTANCE);
    }


    /**
     * Сохранить полученные настройки из кастомной инстанции конфига в хранилище
     *
     * @param            $sConfigName            имя конфига
     * @param null $aData ручное указание данных, вместо получения их временной инстанции конфига
     * @return mixed
     */
    final public function SaveConfigByKey($sConfigName, $aData = null)
    {
        if (is_null($aData)) {
            /*
             * получить данные, которые были сохранены во временной инстанции конфига после их парсинга и анализа
             */
            $aData = $this->GetKeysData($sConfigName);
        }
        /*
         * получить ранее сохраненные данные, если есть
         */
        if ($aConfigOldData = $this->GetOneParam($this->GetCorrectStorageKey($sConfigName),
            self::CONFIG_DATA_PARAM_NAME)
        ) {
            /*
             * обьеденить сохраненные ранее настройки с новыми
             * это необходимо если настройки разбиты на группы и показываются в разных разделах частями (например, настройки ядра)
             * tip: не использовать "array_merge_recursive"
             */
            $aData = array_replace_recursive_distinct($aConfigOldData, $aData);
        }
        return $this->SaveConfigData($sConfigName, $aData);
    }


    /**
     * Получить корректное имя ключа для сохранения в хранилище.
     * Для системного конфига имя - ModuleStorage::DEFAULT_KEY_NAME.
     * Если же это плагин, то к его имени должен быть добавлен префикс ModuleStorage::PLUGIN_PREFIX
     *
     * @param $sConfigName        имя конфига
     * @return string            ключ
     */
    private function GetCorrectStorageKey($sConfigName)
    {
        if ($sConfigName == ModuleStorage::DEFAULT_KEY_NAME) {
            return ModuleStorage::DEFAULT_KEY_NAME;
        }
        return ModuleStorage::PLUGIN_PREFIX . $sConfigName;
    }


    /**
     * Cохранения ключей конфига плагина и последующей их автозагрузки как части конфига
     *
     * @param array $aKeysToSave ключи из конфига плагина, данные которых нужно сохранить
     * @param            $sCallerName        имя плагина
     * @param string $sInstance инстанция хранилища
     * @return mixed
     */
    final public function SavePluginConfig($aKeysToSave = array(), $sCallerName, $sInstance = self::DEFAULT_INSTANCE)
    {
        /*
         * Получить сохраненный конфиг из хранилища
         */
        $aConfigData = array();
        if ($aConfigDataOld = $this->GetOneParam($sCallerName, self::CONFIG_DATA_PARAM_NAME, $sInstance)) {
            $aConfigData = $aConfigDataOld;
        }
        $sConfigName = $this->StripPluginPrefix($sCallerName);

        /*
         * Получить текущие данные конфига по ключам
         */
        $aDataToSave = array();
        foreach ($aKeysToSave as $sConfigKey) {
            if (($mValue = $this->GetConfigKeyValue($sConfigName, $sConfigKey)) === null) {
                /*
                 * Значение удалили, значит нужно удалить и из хранилища вместо добавления
                 */
                unset($aConfigData[$sConfigKey]);
                continue;
            }
            $aDataToSave[$sConfigKey] = $mValue;
        }
        /*
         * Обьеденить и записать данные
         */
        return $this->SaveConfigData($sConfigName, array_replace_recursive_distinct($aConfigData, $aDataToSave),
            $sInstance);
    }


    /*
     *
     *	--- Функции работы с описанием главного конфига ---
     *
     */

    /**
     * Получить путь к схеме главного конфига движка
     *
     * @return string
     */
    private function GetRootConfigSchemePath()
    {
        return Plugin::GetPath(__CLASS__) . self::PATH_TO_ROOT_CONFIG_SCHEME;
    }


    /**
     * Путь к языковым файлам, в которых храняться текстовки описания настроек главного конфига движка
     *
     * @param $sFileName        имя языкового файла (совпадает с языком движка)
     * @return string
     */
    private function GetRootConfigLanguge($sFileName)
    {
        return $this->GetRootConfigSchemePath() . Config::Get('lang.dir') . '/' . $sFileName . '.php';
    }


    /**
     * Добавить к главному конфигу движка схему его настроек, которая находится внутри плагина админки
     *
     * @throws Exception
     */
    public function AddConfigSchemeToRootConfig()
    {
        $sPathRootConfigScheme = $this->GetRootConfigSchemePath() . 'config.php';
        if (!is_readable($sPathRootConfigScheme)) {
            throw new Exception('Admin: error: can`t read root config scheme "' . $sPathRootConfigScheme . '". Check rights for this file.');
        }

        $aRootConfigScheme = require_once($sPathRootConfigScheme);
        if (!is_array($aRootConfigScheme)) {
            throw new Exception('Admin: error: scheme of root config is not an array. Last error: ' . print_r(error_get_last(),
                    true));
        }
        /*
         * объеденить с главным конфигом движка
         */
        $this->LoadRootConfig($aRootConfigScheme);
    }


    /**
     * Добавить к главному конфигу движка описание его настроек, которое находится внутри плагина админки
     *
     * @throws Exception
     */
    public function AddConfigLanguageToRootConfig()
    {
        $sPathRootConfigLang = $this->GetRootConfigLanguge(Config::Get('lang.current'));
        if (!is_readable($sPathRootConfigLang)) {
            $sPathRootConfigLang = $this->GetRootConfigLanguge(Config::Get('lang.default'));
            if (!is_readable($sPathRootConfigLang)) {
                return false;
            }
        }

        $aRootConfigLang = require_once($sPathRootConfigLang);
        if (!is_array($aRootConfigLang)) {
            return false;
        }
        /*
         * объеденить с текстовками движка
         */
        $this->Lang_AddMessages($aRootConfigLang);
        return true;
    }


    /**
     * Добавить к главному конфигу движка схему его конфига и описание в языковый файл
     */
    final public function AddSchemeAndLangToRootConfig()
    {
        $this->AddConfigSchemeToRootConfig();
        $this->AddConfigLanguageToRootConfig();
    }


    /*
     *
     * --- События ---
     *
     */

    /**
     * Сверка нового значения параметра и предыдущего, оповещение подписчикам о смене
     *
     * @param $sConfigName        имя конфига
     * @param $sKey                ключ
     * @param $mNewValue        новое значение
     * @param $oParamInfo        описание параметра из схемы конфига
     * @return bool                разрешение на установку данного значения для этого ключа
     */
    private function FireEvents($sConfigName, $sKey, $mNewValue, $oParamInfo)
    {
        $mPreviousValue = $oParamInfo->getValue();
        if ($mNewValue != $mPreviousValue) {
            return $this->PluginAdmin_Events_ConfigParameterChangeNotification($sConfigName, $sKey, $mNewValue,
                $mPreviousValue);
        }
        return true;
    }


    /**
     * Проверка если хоть одно значение было изменено в конфиге, вызов подписчиков (перед записью данных)
     *
     * @param $sConfigName        имя конфига
     * @param $aSettingsInfo    набор настроек
     * @return bool                разрешение на запись настроек
     */
    private function FireChangedAtLeastOneParamEvent($sConfigName, $aSettingsInfo)
    {
        /*
         * проверить каждый параметр - было изменено хотя бы одно значение
         */
        foreach ($aSettingsInfo as $sKey => $oParamInfo) {
            /*
             * получить старое значение
             */
            $mPreviousValue = $oParamInfo->getValue();
            /*
             * получить новое значение из временной инстанции конфига (куда оно было помещено для последущего сохранения)
             */
            $mNewValue = $this->GetConfigKeyValue($sConfigName, $sKey, self::ADMIN_TEMP_CONFIG_INSTANCE);
            /*
             * сравнить значения
             */
            if ($mNewValue != $mPreviousValue) {
                /*
                 * вызвать событие у подписчика (если таковые есть)
                 */
                return $this->PluginAdmin_Events_ConfigParametersAreChangedNotification($sConfigName);
            }
        }
        return true;
    }
}