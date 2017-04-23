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
 * Модуль работы с шаблонами движка
 *
 */

class PluginAdmin_ModuleSkin extends Module
{

    /*
     * файлы описания и превью шаблона, которые должны быть в корне папки шаблона
     */
    const PREVIEW_IMAGE_FILE = 'template_preview.png';
    const XML_FILE = 'template.xml';

    /*
     * ключ сессии, в котором хранится имя шаблона для предпросмотра
     */
    const PREVIEW_SKIN_SESSION_PARAM_NAME = 'admin_preview_skin';

    /*
     * путь к шаблонам в системе
     */
    protected $sSkinPath = null;

    /*
     * текущий язык сайта (для получения данных с описаний шаблонов)
     */
    protected $sLang = null;

    /*
     * сущность текущего шаблона (используется для кеширования на момент сессии)
     */
    private $oSkinCurrent = null;


    public function Init()
    {
        $this->sSkinPath = Config::Get('path.application.server') . '/frontend/skin/';
        $this->sLang = $this->Lang_GetLang();
    }


    /**
     * Получить полный путь к файлу корневой директории шаблона по имени шаблона и файла
     *
     * @param $sSkinName    имя шаблона
     * @param $sFileName    имя файла
     * @return string        полный путь файла
     */
    protected function GetSkinRootFolderFile($sSkinName, $sFileName)
    {
        return $this->sSkinPath . $sSkinName . '/' . $sFileName;
    }


    /**
     * Полный путь к xml файлу для скина
     *
     * @param $sSkinName    Имя шаблона
     * @return string        Полный путь к файлу и его имя
     */
    protected function GetSkinXmlFile($sSkinName)
    {
        return $this->GetSkinRootFolderFile($sSkinName, self::XML_FILE);
    }


    /**
     * Полный путь к файлу превью шаблона (изображение)
     *
     * @param $sSkinName    Имя шаблона
     * @return string        Полный путь к файлу и его имя
     */
    protected function GetSkinPreviewFile($sSkinName)
    {
        return $this->GetSkinRootFolderFile($sSkinName, self::PREVIEW_IMAGE_FILE);
    }


    /**
     * Список имен всех шаблонов
     *
     * @return array
     */
    protected function GetSkinNames()
    {
        return array_map('basename', glob($this->sSkinPath . '*', GLOB_ONLYDIR));
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
        if ($oXml->themes) {
            foreach ($oXml->themes->children() as $oTheme) {
                $this->PluginAdmin_Tools_AddXmlDataValueCorrespondingOnLang($oTheme, 'description', $this->sLang);
            }
        }
        return $oXml;
    }


    /**
     * Получает информацию из файла шаблона на основе основного языка сайта
     *
     * @param $sSkinXmlFile            Имя шаблона
     * @return null|SimpleXMLElement
     */
    protected function GetSkinXmlData($sSkinXmlFile)
    {
        if ($oXml = @simplexml_load_file($sSkinXmlFile)) {
            return $this->SetXmlPropertiesForLang($oXml);
        }
        return null;
    }


    /**
     * Получить описание шаблона из xml файла (если возможно)
     *
     * @param $sSkinName                имя шаблона
     * @return null|SimpleXMLElement    обьект данных
     */
    protected function GetSkinXmlObject($sSkinName)
    {
        $sSkinXmlFile = $this->GetSkinXmlFile($sSkinName);
        if (file_exists($sSkinXmlFile)) {
            return $this->GetSkinXmlData($sSkinXmlFile);
        }
        return null;
    }


    /**
     * Получить полный путь к изображению превью шаблона
     *
     * @param $sSkinName                имя шаблона
     * @return string|null                путь к изображению
     */
    protected function GetSkinPreviewImage($sSkinName)
    {
        $sSkinPreviewFile = $this->GetSkinPreviewFile($sSkinName);
        if (file_exists($sSkinPreviewFile)) {
            return $this->Fs_GetPathWebFromServer($sSkinPreviewFile);
        }
        return null;
    }


    /**
     * Получает список шаблонов
     *
     * @param array $aFilter Фильтр
     * @return array
     */
    public function GetSkinList($aFilter = array())
    {
        $aSkins = array();
        foreach ($this->GetSkinNames() as $sSkinName) {
            /*
             * получить сущность шаблона, ключ массива - имя папки шаблона
             */
            $aSkins[$sSkinName] = $this->GetSkinByName($sSkinName);
        }

        /*
         * сортировка списка шаблонов
         */
        if (isset($aFilter['order']) and $aFilter['order'] == 'name') {
            ksort($aSkins, SORT_STRING);
        }

        /*
         * фильтр: отдельно вернуть данные текущего скина
         * tip: фильтр меняет формат возвращаемых данных
         */
        if (isset($aFilter['separate_current_skin'])) {
            $aCurrentSkinData = null;
            if (isset($aSkins[$this->GetOriginalSkinName()])) {
                $aCurrentSkinData = $aSkins[$this->GetOriginalSkinName()];
                if (isset($aFilter['delete_current_skin_from_list'])) {
                    unset($aSkins[$this->GetOriginalSkinName()]);
                }
            } else {
                $this->Message_AddError(
                    $this->Lang_Get('plugin.admin.errors.skin.current_error',
                        array('skin' => $this->GetOriginalSkinName())),
                    $this->Lang_Get('common.error.error')
                );
            }
            return array(
                'skins'   => $aSkins,
                'current' => $aCurrentSkinData
            );
        }
        return $aSkins;
    }


    /**
     * Получить шаблон по имени (директории шаблона)
     *
     * @param $sSkinName    имя шаблона (директория)
     * @return object        сущность шаблона
     */
    public function GetSkinByName($sSkinName)
    {
        $aSkinInfo = array();
        /*
         * имя шаблона
         */
        $aSkinInfo['name'] = $sSkinName;
        /*
         * информация о шаблоне
         */
        $aSkinInfo['xml'] = $this->GetSkinXmlObject($sSkinName);
        /*
         * превью шаблона
         */
        $aSkinInfo['preview'] = $this->GetSkinPreviewImage($sSkinName);

        return Engine::GetEntity('PluginAdmin_Skin', $aSkinInfo);
    }


    /*
     *
     * --- Управление шаблонами ---
     *
     */

    /**
     * Проверяет зависимости шаблонов (версия движка и необходимые активированные плагины)
     *
     * @param $sSkinName    имя шаблона
     * @return bool
     */
    protected function CheckSkinDependencies($sSkinName)
    {
        /*
         * если нет файла описания шаблона - просто нечего сверять
         */
        if (!$oXml = $this->GetSkinXmlObject($sSkinName)) {
            return true;
        }
        /*
         * проверить совместимость с версией LS
         */
        if (defined('LS_VERSION') and version_compare(LS_VERSION, (string)$oXml->requires->livestreet, '<')) {
            $this->Message_AddError(
                $this->Lang_Get('plugin.admin.errors.skin.activation_version_error',
                    array('version' => $oXml->requires->livestreet)),
                $this->Lang_Get('common.error.error'),
                true
            );
            return false;
        }
        /*
         * проверить наличие активированных необходимых плагинов
         */
        if ($oXml->requires->plugins) {
            $aActivePluginsCodes = $this->PluginAdmin_Plugins_GetActivePluginsCodes();
            $iConflict = 0;
            foreach ($oXml->requires->plugins->children() as $sReqPlugin) {
                if (!in_array($sReqPlugin, $aActivePluginsCodes)) {
                    $iConflict++;
                    $this->Message_AddError(
                        $this->Lang_Get('plugin.admin.errors.skin.activation_requires_error',
                            array('plugin' => func_camelize($sReqPlugin))),
                        $this->Lang_Get('common.error.error'),
                        true
                    );
                }
            }
            if ($iConflict) {
                return false;
            }
        }
        return true;
    }


    /**
     * Включить новый шаблон
     *
     * @param $sSkinName    шаблон
     * @return bool
     */
    public function ChangeSkin($sSkinName)
    {
        /*
         * проверить зависимости
         */
        if (!$this->CheckSkinDependencies($sSkinName)) {
            return false;
        }
        /*
         * установить шаблон и тему по-умолчанию
         */
        $aData = array(
            'view' => array(
                'skin'  => $sSkinName,
                'theme' => ''
            )
        );
        $this->PluginAdmin_Settings_SaveConfigByKey(ModuleStorage::DEFAULT_KEY_NAME, $aData);
        /*
         * выключить превью
         */
        $this->TurnOffPreviewSkin();
        return true;
    }


    /**
     * Получить текущий установленный шаблон (не зависимо от предпросмотра другого шаблона)
     * tip: используется кеширование на момент сессии
     *
     * @return object        сущность шаблона
     */
    public function GetSkinCurrent()
    {
        /*
         * если шаблон не установлен или имя закешированного шаблона не совпадает с текущим установленным шаблоном
         */
        if (!$this->oSkinCurrent or $this->oSkinCurrent->getName() != $this->GetOriginalSkinName()) {
            $this->oSkinCurrent = $this->GetSkinByName($this->GetOriginalSkinName());
        }
        return $this->oSkinCurrent;
    }


    /*
     *
     * --- Предпросмотр шаблона ---
     *
     */

    /**
     * Задать значение шаблона для предпросмотра для текущего пользователя
     *
     * @param $sSkinName    шаблон
     * @return bool
     */
    public function PreviewSkin($sSkinName)
    {
        /*
         * проверить зависимости
         */
        if (!$this->CheckSkinDependencies($sSkinName)) {
            return false;
        }
        $this->Session_Set(self::PREVIEW_SKIN_SESSION_PARAM_NAME, $sSkinName);
        return true;
    }


    /**
     * Получить имя шаблона для предпросмотра (если есть) для текущего пользователя
     *
     * @return string
     */
    public function GetPreviewSkinName()
    {
        return $this->Session_Get(self::PREVIEW_SKIN_SESSION_PARAM_NAME);
    }


    /**
     * Включить шаблон для предпросмотра (если есть) текущему пользователю
     */
    public function SetPreviewTemplate()
    {
        if ($sPreviewSkin = $this->GetPreviewSkinName()) {
            /*
             * сохранить оригинальное значение шаблона чтобы получить его при предпросмотре другого шаблона
             */
            Config::Set('view.skin_original', Config::Get('view.skin'));
            Config::Set('view.skin', $sPreviewSkin);
        }
    }


    /**
     * Получить оригинальное имя шаблона (даже если включен режим предпросмотра другого шаблона)
     *
     * @return string
     */
    public function GetOriginalSkinName()
    {
        /*
         * если был включен режим предпросмотра и оригинальный шаблон был сохранен (т.к. если не вызвали смену шаблона через SetPreviewTemplate, то он не был изменен т.е. показан)
         */
        if ($this->GetPreviewSkinName() and $sSkinOriginal = Config::Get('view.skin_original')) {
            return $sSkinOriginal;
        }
        return Config::Get('view.skin');
    }


    /**
     * Выключить предпросмотр шаблона
     */
    public function TurnOffPreviewSkin()
    {
        $this->Session_Drop(self::PREVIEW_SKIN_SESSION_PARAM_NAME);
        Config::Set('view.skin_original', null);
    }


    /*
     *
     * --- Темы шаблона ---
     *
     */

    /**
     * Установить тему шаблона
     *
     * @param $sTheme    имя темы шаблона
     * @return bool
     */
    public function ChangeTheme($sTheme)
    {
        /*
         * установить тему
         */
        $aData = array(
            'view' => array(
                'theme' => $sTheme
            )
        );
        $this->PluginAdmin_Settings_SaveConfigByKey(ModuleStorage::DEFAULT_KEY_NAME, $aData);
        /*
         * выключить превью
         */
        $this->TurnOffPreviewSkin();
        return true;
    }


}

?>