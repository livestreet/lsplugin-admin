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
 * Модуль работы с официальным каталогом плагинов для LiveStreet CMS
 *
 */

class PluginAdmin_ModuleCatalog extends Module
{

    /*
     * строка замены на код плагина в урле метода
     */
    const PLUGIN_CODE_PLACEHOLDER = '{plugin_code}';
    /*
     * Префикс методов АПИ каталога
     */
    const CALLING_METHOD_PREFIX = 'RequestUrlFor';

    /*
     * Базовый путь к АПИ каталога
     */
    private $sCatalogBaseApiUrl = null;
    /*
     * Методы для работы с каталогом
     */
    private $aCatalogMethodPath = array();

    /*
     * Время жизни кеша для разных запросов
     */
    protected $aCacheLiveTime = array();

    /*
     * Макс. время подключения к серверу, сек
     */
    protected $iConnectTimeout = 2;
    /*
     * Макс. время получения данных от сервера, сек
     */
    protected $iWorkTimeout = 4;


    final public function Init()
    {
        $this->Setup();
    }


    /**
     * Выполнить основную настройку модуля
     */
    protected function Setup()
    {
        /*
         * настройки АПИ
         */
        $this->sCatalogBaseApiUrl = Config::Get('plugin.admin.catalog.api.base_url');
        $this->aCatalogMethodPath = Config::Get('plugin.admin.catalog.api.methods');
        /*
         * время жизни кеша
         */
        $this->aCacheLiveTime = Config::Get('plugin.admin.catalog.cache.time');
        /*
         * тайминги подключений к серверу
         */
        $this->iConnectTimeout = Config::Get('plugin.admin.catalog.timeouts.max_connect_timeout');
        $this->iWorkTimeout = Config::Get('plugin.admin.catalog.timeouts.max_work_timeout');
    }


    /*
     *
     * --- АПИ ---
     *
     */

	/**
	 * Построить относительный путь к методу по коду плагина, группе методов и методе из указанной группы
	 *
	 * @param string $sPluginCode  код плагина
	 * @param string $sMethodGroup группа методов
	 * @param string $sMethod      метод группы
	 * @return mixed            строка с относительным путем к методу
	 */
    private function BuildMethodPathForPlugin($sPluginCode, $sMethodGroup, $sMethod)
    {
        return str_replace(self::PLUGIN_CODE_PLACEHOLDER, $sPluginCode, $this->aCatalogMethodPath[$sMethodGroup][$sMethod]);
    }


    /**
     * Получить абсолютный путь к АПИ по коду плагина, группе методов и методе из указанной группы
     *
     * @param $sPluginCode        код плагина
     * @param $sMethodGroup        группа методов
     * @param $sMethod            метод группы
     * @return mixed            строка с абсолютным путем к методу
     */
    private function GetApiPath($sPluginCode, $sMethodGroup, $sMethod)
    {
        return $this->sCatalogBaseApiUrl . $this->BuildMethodPathForPlugin($sPluginCode, $sMethodGroup, $sMethod);
    }


    /**
     * Обрабатывает все запросы к АПИ каталога
     *
     * @param string $sName имя не обьявленного метода
     * @param array $aArgs аргументы
     * @return mixed
     */
    public function __call($sName, $aArgs)
    {
        /*
         * если это вызов АПИ
         */
        if (strpos($sName, self::CALLING_METHOD_PREFIX) !== false) {
            /*
             * убрать префикс
             */
            $sName = str_replace(self::CALLING_METHOD_PREFIX, '', $sName);
            /*
             * найти группу методов и сам метод
             */
            list($sMethodGroup, $sMethod) = explode('_', func_underscore($sName), 2);

            /*
             * добавить их в набор параметров
             */
            $aArgsToSend = array_merge($aArgs ? $aArgs : array('no_plugin_code'), array($sMethodGroup, $sMethod));

            /*
             * вернуть путь к методу
             */
            return call_user_func_array(array($this, 'GetApiPath'), $aArgsToSend);
        } else {
            /*
             * обычный вызов ядра
             */
            return parent::__call($sName, $aArgs);
        }
    }


    /*
     *
     * --- Обработка запросов по АПИ ---
     *
     */

	/**
	 * Послать запрос серверу с нужными таймингами
	 *
	 * @param string $sApiUrl      урл нужного АПИ
	 * @param arrray $aRequestData передаваемые данные
	 * @return array            массив (RESPONSE_SUCCESS, RESPONSE_ERROR_MESSAGE, RESPONSE_DATA) см. модуль Remoteserver
	 */
    protected function SendDataToServer($sApiUrl, $aRequestData)
    {
        return $this->PluginAdmin_Remoteserver_Send(array(
            PluginAdmin_ModuleRemoteserver::REQUEST_URL          => $sApiUrl,
            PluginAdmin_ModuleRemoteserver::REQUEST_DATA         => $aRequestData,
            /*
             * установка кастомных опций для курла (таймингов)
             */
            PluginAdmin_ModuleRemoteserver::REQUEST_CURL_OPTIONS => array(
                CURLOPT_CONNECTTIMEOUT => $this->iConnectTimeout,
                CURLOPT_TIMEOUT        => $this->iWorkTimeout
            )
        ));
    }


    /**
     * Распарсить ответ соединения с сервером
     *
     * @param $aResponseAnswer        массив данных ответа от SendDataToServer
     * @return mixed
     */
    protected function ParseConnectResponse($aResponseAnswer)
    {
        /*
         * если нет ошибок соединения
         */
        if ($aResponseAnswer[PluginAdmin_ModuleRemoteserver::RESPONSE_SUCCESS]) {
            /*
             * вернуть массив данных
             */
            return json_decode($aResponseAnswer[PluginAdmin_ModuleRemoteserver::RESPONSE_DATA], true);
        }
        /*
         * вернуть текст ошибки соединения
         */
        return $aResponseAnswer[PluginAdmin_ModuleRemoteserver::RESPONSE_ERROR_MESSAGE];
    }


    /**
     * Распарсить ответ АПИ от сервера
     *
     * @param $mData                массив данных от сервера, полученный от ParseConnectResponse
     * @return array|bool|string
     */
    protected function ParseServerApiResponse($mData)
    {
        /*
         * если получен ответ от сервера
         */
        if (is_array($mData)) {
            /*
             * если ошибка на стороне сервера
             */
            if (isset($mData['bStateError']) and $mData['bStateError']) {
                /*
                 * вернуть её текст
                 */
                return $mData['sMsgTitle'] . ': ' . $mData['sMsg'];
            }
            /*
             * если переданы данные в ответ на запрос
             */
            if (isset($mData['aData'])) {
                return $mData['aData'];
            }
            /*
             * данных нет
             */
            return false;
        }
        /*
         * текст ошибки соединения с сервером (полученной от ParseConnectResponse)
         */
        return $mData;
    }


    /**
     * Получить ответ АПИ сервера или ошибку соединения или обработки запроса сервером
     *
     * @param $sApiUrl                полный урл к АПИ (получить через методы)
     * @param $aRequestData            массив данных POST запроса
     * @return array|bool|string
     */
    protected function GetParsedAnswerForApiRequest($sApiUrl, $aRequestData)
    {
        /*
         * запросить данные
         */
        $aResponseAnswer = $this->SendDataToServer($sApiUrl, $aRequestData);
        /*
         * получить строку ошибки соединения или асоциативный массив ответа
         */
        $mData = $this->ParseConnectResponse($aResponseAnswer);
        /*
         * получить ответ от АПИ
         */
        return $this->ParseServerApiResponse($mData);
    }


    /*
     *
     * --- Обновление плагинов ---
     *
     */

    /**
     * Сформировать массив со списком кодов плагинов и их версиями
     *
     * @param $aPlugins        массив сущностей плагинов
     * @return array
     */
    protected function BuildPluginsRequestArray($aPlugins)
    {
        $aRequestData = array();
        foreach ($aPlugins as $oPlugin) {
            $aRequestData[] = array('code' => $oPlugin->getCode(), 'version' => $oPlugin->getVersion());
        }
        return $aRequestData;
    }


    /**
     * Получить ответ от сервера по обновлениям для всех или указанных плагинов
     *
     * @param array $aPlugins массив сущностей плагинов для проверки, если не указать - будут проверены все плагины в системе
     * @return mixed            массив ответа от сервера или строка ошибки соединения
     */
    protected function GetServerResponseForPluginsUpdates($aPlugins = array())
    {
        /*
         * если список проверяемых плагинов не указан - получить все плагины
         */
        if (empty($aPlugins)) {
            $aPluginsInfo = $this->PluginAdmin_Plugins_GetPluginsList();
            $aPlugins = $aPluginsInfo['collection'];
        }
        if (!is_array($aPlugins)) {
            $aPlugins = (array)$aPlugins;
        }
        /*
         * сформировать нужный массив для запроса
         */
        $aRequestData = array('data' => $this->BuildPluginsRequestArray($aPlugins), 'ls_version' => LS_VERSION);
        /*
         * получить полный урл для АПИ каталога по запросу последних версий плагинов
         */
        $sApiUrl = $this->RequestUrlForAddonsCheckVersion();
        /*
         * выполнить запрос, распарсить соединение и ответ
         */
        return $this->GetParsedAnswerForApiRequest($sApiUrl, $aRequestData);
    }


    /**
     * Получение массива сущностей обновлений плагинов (код и версия), для которых есть обновления в каталоге
     *
     * @param array $aPlugins массив сущностей плагинов для проверки, если нужно
     * @return string|bool|array    массив сущностей обновлений (код и версии плагинов), false если нет обновлений или строка ошибки соединения или сервера
     */
    public function GetPluginUpdates($aPlugins = array())
    {
        /*
         * нужно ли проверять на наличие обновлений для плагинов
         */
        if (!Config::Get('plugin.admin.catalog.updates.allow_plugin_updates_checking')) {
            return false;
        }
        /*
         * послать запрос на сервер для получения списка обновлений
         */
        $mData = $this->GetServerResponseForPluginsUpdates($aPlugins);
        /*
         * если передан список кодов плагинов, для которых есть обновления и их последние версии
         */
        if (is_array($mData)) {
            if (count($mData) > 0) {
                /*
                 * формирование массива сущностей, где в качестве ключа выступает код плагина
                 */
                return Engine::GetEntityItems('PluginAdmin_Plugins_Update', $mData, 'code');
            }
            /*
             * обновлений нет
             */
            return false;
        }
        /*
         * текст ошибки соединения с сервером или обработки АПИ
         */
        return $mData;
    }


    /**
     * Получение массива кодов плагинов, для которых есть обновления в каталоге из кеша (обновление каждый 1 час)
     *
     * @param array $aPlugins массив сущностей плагинов для проверки, если нужно
     * @return string|bool|array    массив кодов и версий плагинов с обновлениям, false если нет обновлений или строка ошибки
     */
    public function GetPluginUpdatesCached($aPlugins = array())
    {
        $sCacheKey = 'admin_get_plugins_updates_' . serialize($aPlugins);
        /*
         * есть ли в кеше
         * tip: принудительное кеширование + хранение результата в памяти (сессионный кеш)
         */
        if (($mData = $this->Cache_Get($sCacheKey, null, true, true)) === false) {
            $mData = $this->GetPluginUpdates($aPlugins);
            /*
             * кеширование обновлений на час
             * tip: сбрасывать после (де)активации (это выполняется при Plugin_Toggle - сброс всего кеша)
             */

            // todo: сбрасывать при обновлении плагинов

            /*
             * tip: использовать принудительное кеширование
             */
            $this->Cache_Set($mData, $sCacheKey, array('plugin_update', 'plugin_new'),
                $this->aCacheLiveTime['plugin_updates_check'], null, true);
        }
        return $mData;
    }


    /*
     *
     * --- Получение списков дополнений из каталога ---
     *
     */

    /**
     * Получить список дополнений из каталога по фильтру
     *
     * @param $aRequestData            передаваемые данные
     * @return array|bool|string    ответ АПИ сервера, ошибка соединения или обработки запроса сервером
     */
    public function GetAddonsListFromCatalogByFilter($aRequestData)
    {
        /*
         * получить полный урл для АПИ каталога по запросу списка плагинов по фильтру
         */
        $sApiUrl = $this->RequestUrlForAddonsFilter();
        /*
         * выполнить запрос, распарсить соединение и ответ
         */
        $mData = $this->GetParsedAnswerForApiRequest($sApiUrl, $aRequestData);
        /*
         * есть ли корректный ответ
         */
        if (is_array($mData)) {
            /*
             * переделаем массив данных каждого плагина в сущность
             */
            $mData['addons'] = Engine::GetEntityItems('PluginAdmin_Catalog_Addon', $mData['addons'], 'code');
            /*
             * установить свойство "установлен ли уже этот плагин"
             */
            $aAllPluginsCodes = $this->PluginAdmin_Plugins_GetAllPluginsCodes();
            foreach ($mData['addons'] as $oAddon) {
                if (in_array($oAddon->getCode(), $aAllPluginsCodes)) {
                    $oAddon->setAlreadyInstalled(true);
                }
            }
        }
        return $mData;
    }


    /**
     * Получить список дополнений из каталога по фильтру из кеша (обновление каждый 1 час)
     *
     * @param $aRequestData            передаваемые данные
     * @return array|bool|string    ответ АПИ сервера, ошибка соединения или обработки запроса сервером
     */
    public function GetAddonsListFromCatalogByFilterCached($aRequestData)
    {
        $sCacheKey = 'admin_get_addons_by_filter_' . serialize($aRequestData);
        /*
         * есть ли в кеше
         */
        if (($mData = $this->Cache_Get($sCacheKey)) === false) {
            $mData = $this->GetAddonsListFromCatalogByFilter($aRequestData);
            /*
             * кеширование полученных дополнений на час
             */
            $this->Cache_Set($mData, $sCacheKey, array('catalog_addons_update', 'catalog_addons_new'),
                $this->aCacheLiveTime['catalog_addons_list']);
        }
        return $mData;
    }


    /*
     *
     * --- Удобные методы для вызова прямо из экшенов ---
     *
     */

    /**
     * Получить список плагинов у которых есть более новые версии в каталоге чем текущая установленная
     */
    public function GetUpdatesInfo()
    {
        $mUpdatesList = $this->GetPluginUpdatesCached();
        switch (gettype($mUpdatesList)) {
            /*
             * ошибка соединения или сервера
             */
            case 'string':
                $this->Message_AddError($mUpdatesList, $this->Lang_Get('plugin.admin.errors.catalog.connect_error'));
                $this->Viewer_Assign('iPluginUpdates', 0);
                break;
            /*
             * есть обновления
             */
            case 'array':
                $this->Viewer_Assign('aPluginUpdates', $mUpdatesList);
                $this->Viewer_Assign('iPluginUpdates', count($mUpdatesList));
                break;
            /*
             * обновлений нет
             */
            default:
                $this->Viewer_Assign('iPluginUpdates', 0);
        }
        return $mUpdatesList;
    }


    /**
     * Сброс кеша списка дополнений из каталога
     */
    public function ResetCatalogCache()
    {
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('catalog_addons_update'));
    }

}

?>