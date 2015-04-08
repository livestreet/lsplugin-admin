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
 * Модуль работы с установленными плагинами
 *
 */

class PluginAdmin_ModulePlugins extends Module
{

    /*
     * файлы xml-описания, лого и файла описания установки плагина, которые должны быть в корне папки плагина
     */
    const LOGO_FILE = 'logo.png';
    const XML_FILE = 'plugin.xml';
    const INSTALL_TXT_FILE = 'install.txt';

    /*
     * путь к плагинам
     */
    protected $sPluginPath = null;

    /*
     * текущий язык сайта (для получения данных с xml файлов)
     */
    protected $sLang = null;

    /*
     * закешированные на время сессии плагины для каждого фильтра
     */
    private $aPluginsData = array();


    public function Init()
    {
        $this->sPluginPath = Config::Get('path.application.plugins.server') . '/';
        $this->sLang = $this->Lang_GetLang();
    }


    /**
     * Получить полный путь к каталогу плагина
     *
     * @param $sPluginCode    код плагина
     * @return string
     */
    protected function GetPluginFolderFullPath($sPluginCode)
    {
        return $this->sPluginPath . $sPluginCode . '/';
    }


    /**
     * Получить полный путь к файлу из корневой папки плагина по его имени
     *
     * @param $sPluginCode    код плагина
     * @param $sFilename    имя файла
     * @return string        полный путь с именем файла
     */
    protected function GetPluginRootFolderFileFullPath($sPluginCode, $sFilename)
    {
        return $this->GetPluginFolderFullPath($sPluginCode) . $sFilename;
    }


    /**
     * Полный путь к xml файлу плагина
     *
     * @param $sPluginCode    код плагина
     * @return string        полный путь к файлу и его имя
     */
    protected function GetXmlFileFullPath($sPluginCode)
    {
        return $this->GetPluginRootFolderFileFullPath($sPluginCode, self::XML_FILE);
    }


    /**
     * Полный путь к файлу лого плагина (изображение)
     *
     * @param $sPluginCode    код плагина
     * @return string        полный путь к файлу и его имя
     */
    protected function GetLogoFileFullPath($sPluginCode)
    {
        return $this->GetPluginRootFolderFileFullPath($sPluginCode, self::LOGO_FILE);
    }


    /**
     * Полный путь к файлу описания установки плагина (текстовый файл)
     *
     * @param $sPluginCode    код плагина
     * @return string        полный путь к файлу и его имя
     */
    protected function GetInstallTxtFileFullPath($sPluginCode)
    {
        return $this->GetPluginRootFolderFileFullPath($sPluginCode, self::INSTALL_TXT_FILE);
    }


    /**
     * Список кодов всех плагинов в каталоге плагинов
     *
     * @return array
     */
    public function GetAllPluginsCodes()
    {
        return array_map('basename', glob($this->sPluginPath . '*', GLOB_ONLYDIR));
    }


    /**
     * Задать новые свойства "data" со значениями из атрибутов согласно настроек языка сайта
     *
     * @param $oXml            объект xml
     * @return mixed        объект xml с новыми свойствами
     */
    protected function SetXmlPropertiesForLang($oXml)
    {
        $this->PluginAdmin_Tools_AddXmlDataValueCorrespondingOnLang($oXml, 'name', $this->sLang);
        $this->PluginAdmin_Tools_AddXmlDataValueCorrespondingOnLang($oXml, 'author', $this->sLang);
        $this->PluginAdmin_Tools_AddXmlDataValueCorrespondingOnLang($oXml, 'description', $this->sLang);

        /*
         * пропустить только через парсер текста т.к. другие методы парсинга (флеш, видео, тег кода и наследование через плагины, которые обычно наследуют метод Parse) не нужны
         */
        $oXml->homepage = $this->Text_JevixParser((string)$oXml->homepage);
        $oXml->settings = preg_replace('#{([^}]+)}#', Router::GetPath('$1'), $oXml->settings);
        return $oXml;
    }


    /**
     * Получает информацию из xml файла плагина на основе основного языка сайта
     *
     * @param $sXmlFile                Путь к xml файлу
     * @return null|SimpleXMLElement
     */
    protected function GetPluginXmlData($sXmlFile)
    {
        if ($oXml = @simplexml_load_file($sXmlFile)) {
            return $this->SetXmlPropertiesForLang($oXml);
        }
        return null;
    }


    /**
     * Получить описание плагина из xml файла (если возможно)
     *
     * @param $sPluginCode                код плагина
     * @return null|SimpleXMLElement    обьект данных
     */
    protected function GetXmlObject($sPluginCode)
    {
        $sXmlFile = $this->GetXmlFileFullPath($sPluginCode);
        if (file_exists($sXmlFile)) {
            return $this->GetPluginXmlData($sXmlFile);
        }
        return null;
    }


    /**
     * Получить полный путь к лого плагина
     *
     * @param $sPluginCode                код плагина
     * @return string|null                путь к лого
     */
    protected function GetLogoImage($sPluginCode)
    {
        $sLogoFile = $this->GetLogoFileFullPath($sPluginCode);
        if (file_exists($sLogoFile)) {
            return $this->Fs_GetPathWebFromServer($sLogoFile);
        }
        /*
         * получить лого из каталога
         */
        return $this->PluginAdmin_Catalog_RequestUrlForPluginLogo($sPluginCode);
    }


    /**
     * Получает список плагинов по фильтру из сессионного кеша
     * tip: на время сессии списки плагинов не меняются, поэтому можно закешировать и обращатся к списку сколько угодно раз
     * Ключи $aFilter:
     *        active                        bool - включен или нет
     *        plugins_codes                array - коды нужных плагинов
     *
     * @param array $aFilter фильтр
     * @return array
     */
    public function GetPluginsList($aFilter = array())
    {
        $sCacheKey = serialize($aFilter);
        /*
         * есть ли в сессионном кеше данные
         */
        if (!isset($this->aPluginsData[$sCacheKey])) {
            $this->aPluginsData[$sCacheKey] = $this->GetPluginsListCurrent($aFilter);
        }
        return $this->aPluginsData[$sCacheKey];
    }


    /**
     * Получает список плагинов по фильтру
     * Ключи $aFilter:
     *        active                        bool - включен или нет
     *        plugins_codes                array - коды нужных плагинов
     *
     * @param array $aFilter фильтр
     * @return array
     */
    public function GetPluginsListCurrent($aFilter = array())
    {
        $aPlugins = array();
        /*
         * коды активных плагинов (так быстрее)
         */
        $aActivePluginsCodes = $this->GetActivePluginsCodes();
        /*
         * коды всех плагинов
         */
        $aAllPluginsCodes = $this->GetAllPluginsCodes();
        /*
         * количество активных плагинов
         */
        $iActivePlugins = 0;
        /*
         * текущие версии плагинов из бд
         */
        $aCurrentVersionsFromPluginManager = $this->PluginManager_GetVersionItemsByCodeIn($aAllPluginsCodes,
            array('#index-from' => 'code'));
        /*
         * количество плагинов, которые исключены из списка из-за ошибок
         */
        $iExcludedPlugins = 0;
        foreach ($aAllPluginsCodes as $sPluginCode) {
            /*
             * получить сущность плагина
             */
            if (($oPlugin = $this->GetPluginByCode(
                    $sPluginCode,
                    array(
                        'active_plugins_codes'            => $aActivePluginsCodes,
                        'check_plugin_folder'             => false,
                        'current_versions_plugin_manager' => $aCurrentVersionsFromPluginManager,
                    )
                )) === false
            ) {
                /*
                 * ошибка распознавания xml-файла плагина или некорректный код плагина
                 */
                $iExcludedPlugins++;
                continue;
            }
            if ($oPlugin->getActive()) {
                $iActivePlugins++;
            }
            /*
             * tip: фильтры использовать только после этого комментария т.к. нужно общее количество
             */
            /*
             * проверка отбора только активных или неактивных плагинов
             */
            if (isset($aFilter['active']) and $oPlugin->getActive() !== $aFilter['active']) {
                /*
                 * по фильтру нужны только активные или неактивные плагины
                 */
                continue;
            }
            /*
             * проверка отбора массива нужных кодов плагинов
             */
            if (isset($aFilter['plugins_codes']) and !in_array($oPlugin->getCode(), $aFilter['plugins_codes'])) {
                continue;
            }
            /*
             * ключ массива - имя папки (код) плагина
             */
            $aPlugins[$sPluginCode] = $oPlugin;
        }
        /*
         * общее число плагинов
         */
        $iTotalCount = count($aAllPluginsCodes) - $iExcludedPlugins;
        return array(
            'collection'     => $aPlugins,
            'count_active'   => $iActivePlugins,
            'count_inactive' => $iTotalCount - $iActivePlugins,
            'count_all'      => $iTotalCount
        );
    }


	/**
	 * Получить сущность плагина по коду (папке плагина)
	 *
	 * @param string $sPluginCode код плагина
	 * @param array  $aOptions    дополнительные опции (не обязательны)
	 * @return bool|Entity                      сущность плагина или false в случае ошибки
	 */
    public function GetPluginByCode($sPluginCode, $aOptions = array())
    {
        /*
         * массив кодов активированных плагинов (для метода "active")
         */
        $aActivePluginsCodes = isset($aOptions['active_plugins_codes']) ? $aOptions['active_plugins_codes'] : array();
        /*
         * нужно ли проверять есть ли такой плагин в системе
         */
        $bCheckPluginFolder = isset($aOptions['check_plugin_folder']) ? $aOptions['check_plugin_folder'] : true;
        /*
         * выводить сообщения об ошибках (некорректный код плагина или поврежденный xml файл)
         */
        $bShowErrorMessages = isset($aOptions['show_error_messages']) ? $aOptions['show_error_messages'] : true;
        /*
         * текущая версия плагина в бд
         */
        $oVersion = isset($aOptions['current_versions_plugin_manager'][$sPluginCode]) ?
            $aOptions['current_versions_plugin_manager'][$sPluginCode] :
            $this->PluginManager_GetVersionByCode($sPluginCode);


        /*
         * нужно ли проверять есть ли такой плагин в системе
         */
        if ($bCheckPluginFolder and !in_array($sPluginCode, $this->GetAllPluginsCodes())) {
            return false;
        }
        /*
         * проверить корректность кода плагина (и директории, соответственно)
         */
        if (!$this->CheckPluginCodeToBeCorrect($sPluginCode)) {
            /*
             * если нужно вывести сообщение об ошибке
             */
            if ($bShowErrorMessages) {
                /*
                 * если найден корректный код плагина
                 */
                if ($sFoundCorrectCode = $this->GetCorrectPluginCodeFromMainPluginClass($sPluginCode)) {
                    $sMsg = $this->Lang_Get('plugin.admin.errors.plugins.plugin_code_is_wrong_but_found_correct',
                        array('code' => $sPluginCode, 'new_dir' => $sFoundCorrectCode));
                } else {
                    $sMsg = $this->Lang_Get('plugin.admin.errors.plugins.plugin_code_is_wrong',
                        array('code' => $sPluginCode));
                }
                $this->Message_AddErrorUnique($sMsg, $this->Lang_Get('common.error.error'));
            }
            return false;
        }
        /*
         * если список активных плагинов не был передан - получить коды активных плагинов
         */
        $aActivePluginsCodes = empty($aActivePluginsCodes) ? $this->GetActivePluginsCodes() : $aActivePluginsCodes;
        /*
         * собрать данные по плагину
         */
        $aPluginInfo = array();
        /*
         * код плагина
         */
        $aPluginInfo['code'] = $sPluginCode;
        /*
         * включен ли
         */
        $aPluginInfo['active'] = in_array($sPluginCode, $aActivePluginsCodes);
        /*
         * информация о плагине из xml данных
         */
        if (!$aPluginInfo['xml'] = $this->GetXmlObject($sPluginCode)) {
            /*
             * если xml файл плагина некорректен или поврежден - исключить из списка
             */
            if ($bShowErrorMessages) {
                $this->Message_AddErrorUnique($this->Lang_Get('plugin.admin.errors.plugins.wrong_xml_file',
                        array('code' => $sPluginCode)), $this->Lang_Get('common.error.error'));
            }
            return false;
        }
        /*
         * необходимость применить обновление
         */
        $sVersionDb = $oVersion ? $oVersion->getVersion() : null;
        /*
         * todo: вынести в метод, который будет проверять версию из бд ($sVersionDb, которую в свойство) и версию через существующий метод (getVersion) т.к. текущий вариант не очень
         */
        $aPluginInfo['apply_update'] = (is_null($sVersionDb) or version_compare($sVersionDb,
                (string)$aPluginInfo['xml']->version, '<')) ? true : false;
        /*
         * лого плагина
         */
        $aPluginInfo['logo'] = $this->GetLogoImage($sPluginCode);
        /*
         * получить серверный путь к файлу install.txt
         */
        $aPluginInfo['install_instructions_path'] = $this->CheckInstallTxtFile($sPluginCode);
        /*
         * получить сущность плагина
         */
        return Engine::GetEntity('PluginAdmin_Plugins', $aPluginInfo);
    }


    /**
     * Возвращает список кодов активированных плагинов в системе
     *
     * @return array
     */
    public function GetActivePluginsCodes()
    {
        /*
         * данные из файла PLUGINS.DAT
         */
        $aPlugins = @file($this->sPluginPath . Config::Get('sys.plugins.activation_file'));
        $aPlugins = (is_array($aPlugins)) ? array_unique(array_map('trim', $aPlugins)) : array();
        return $aPlugins;
    }


    /**
     * Проверить корректность кода плагина (соответственно и его директории)
     *
     * @param $sPluginCode        код плагина
     * @return bool
     */
    protected function CheckPluginCodeToBeCorrect($sPluginCode)
    {
        /*
         * проверить разрешенные символы кода плагина
         * например, если код (директория) плагина содержит дефис - скорее всего плагин скачали из Git-репозитория, а тот дает свои имена директориям, которые нужно переименовывать
         * @todo: вроде как был коммит, который разрешал дефис в именах плагинов, если это так - добавить дефис в регулярку
         */
        if (!preg_match('#^[\w\d]+$#iu', $sPluginCode)) {
            return false;
        }
        /*
         * есть ли главный класс плагина с таким кодом (не была ли ошибочно названа директория с плагином)
         */
        if (!file_exists($this->GetPluginRootFolderFileFullPath($sPluginCode, $this->GetFullFileNameForMainPluginClass($sPluginCode)))) {
            return false;
        }
        return true;
    }


    /**
     * Получить полное имя главного класса плагина по коду
     *
     * @param $sPluginCode        код плагина
     * @return string
     */
    protected function GetFullFileNameForMainPluginClass($sPluginCode)
    {
        return 'Plugin' . func_camelize($sPluginCode) . '.class.php';
    }


    /**
     * Получить корректное имя плагина на основе имени главного класса плагина в указанной директории
     *
     * @param $sPluginCode        код плагина (в данном случае - директория)
     * @return null|string        найденное имя плагина или нулл
     */
    protected function GetCorrectPluginCodeFromMainPluginClass($sPluginCode)
    {
        /*
         * начало и конец имени искомого файла
         */
        $sPrefix = 'Plugin';
        $sPostfix = '.class.php';
        /*
         * получить список всех главных классов в корне папки
         */
        if ($aPluginMainClassFiles = @glob($this->GetPluginFolderFullPath($sPluginCode) . $sPrefix . '*' . $sPostfix)) {
            $sFirstClassFile = basename(array_shift($aPluginMainClassFiles));
            return func_underscore(str_replace(array($sPrefix, $sPostfix), '', $sFirstClassFile));
        }
        return null;
    }


    /**
     * Проверить урл файла описания установки плагина
     *
     * @param $sPluginCode                код плагина
     * @return null|SimpleXMLElement    обьект данных
     */
    protected function CheckInstallTxtFile($sPluginCode)
    {
        $sInstallTxtFile = $this->GetInstallTxtFileFullPath($sPluginCode);
        if (file_exists($sInstallTxtFile)) {
            return $sInstallTxtFile;
        }
        return null;
    }


    /**
     * Получить текст файла описания установки
     *
     * @param $sPluginCode                код плагина
     * @return null|string
     */
    public function GetInstallFileText($sPluginCode)
    {
        if ($sInstallTxtFilePath = $this->CheckInstallTxtFile($sPluginCode) and ($sText = @file_get_contents($sInstallTxtFilePath)) !== false) {
            return $sText;
        }
        return null;
    }


}

?>