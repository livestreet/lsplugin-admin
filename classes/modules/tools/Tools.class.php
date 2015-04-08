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
 * Разные методы
 *
 */

class PluginAdmin_ModuleTools extends Module
{

    /*
     * имя параметра хранилища со счетчиком последнего сброса кеша
     */
    const CACHE_LAST_RESET_COUNTER = 'sLastCounterOfCacheReset';


    public function Init()
    {
    }


    /**
     * Возвращает путь к плагинам админки для смарти
     *
     * @return string
     */
    public function GetSmartyPluginsPath()
    {
        return Plugin::GetPath(__CLASS__) . 'include/smarty/';
    }


    /**
     * Вернуть путь к шаблону админки для плагина
     *
     * @param $sName            имя плагина
     * @return bool|string
     */
    public function GetPluginTemplatePath($sName)
    {
        $sNamePlugin = Engine::GetPluginName($sName);
        $sNamePlugin = $sNamePlugin ? $sNamePlugin : $sName;
        $sNamePlugin = func_underscore($sNamePlugin);

        $sPath = Plugin::GetPath($sNamePlugin);
        $aSkins = array('admin_default', 'default', Config::Get('view.skin'));
        foreach ($aSkins as $sSkin) {
            $sTpl = $sPath . 'frontend/skin/' . $sSkin . '/';
            if (is_dir($sTpl)) {
                return $sTpl;
            }
        }
        return false;
    }


    /**
     * Вернуть веб-путь к шаблону админки для плагина
     *
     * @param $sName            имя плагина
     * @return bool|string
     */
    public function GetPluginTemplateWebPath($sName)
    {
        if ($sPath = $this->GetPluginTemplatePath($sName)) {
            return str_replace(Config::Get('path.root.server'), Router::GetPathRootWeb(), $sPath);
        }
        return false;
    }


    /*
     *
     * --- Проверка кодировки файлов ---
     *
     */

    /**
     * Выполнить проверку файлов плагинов и системы на UTF-8 BOM
     *
     * @param bool $bSessionMessages выводить сообщения об ошибках в отложенный вывод (для следующей загрузки ядра)
     * @return bool
     */
    public function CheckFilesOfPluginsAndEngineHaveCorrectEncoding($bSessionMessages = true)
    {
        /*
         * убрать лимит времени
         */
        @set_time_limit(0);
        /*
         * получить массив масок для проверки
         */
        $aFilesMasksToCheck = Config::Get('plugin.admin.utils.encoding_checking_dirs');
        /*
         * проверить файлы
         */
        if ($aWrongEncodingFiles = $this->CheckFilesEncodingByArray($aFilesMasksToCheck, $bSessionMessages)) {
            $this->Message_AddError(
                $this->Lang_Get('plugin.admin.errors.encoding_check.utf8_bom_encoding_detected',
                    array('count' => count($aWrongEncodingFiles))),
                $this->Lang_Get('common.error.error'),
                $bSessionMessages
            );
            /*
             * показать список файлов с неверной кодировкой
             */
            foreach ($aWrongEncodingFiles as $sFile) {
                $this->Message_AddError($sFile, $this->Lang_Get('plugin.admin.errors.encoding_check.utf8_bom_file'),
                    $bSessionMessages);
            }
            return false;
        }
        return true;
    }


    /**
     * Проверить файлы из переданного массива на корректность кодировки
     *
     * @param        $aFilesMasks                    массив файлов для проверки
     * @param bool $bSessionMessages выводить сообщения об ошибках в отложенный вывод (для следующей загрузки ядра)
     * @return array
     */
    protected function CheckFilesEncodingByArray($aFilesMasks, $bSessionMessages = true)
    {
        /*
         * список файлов с некорректной кодировкой
         */
        $aIncorrectEncodingFiles = array();
        /*
         * пройтись по всем заданным путям для поиска файлов
         */
        foreach ($aFilesMasks as $aPathAndMask) {
            /*
             * найти по указанному пути файлы с нужными расширениями
             */
            $aFiles = $this->GetDirsRecursiveListing($aPathAndMask['path'], (array)$aPathAndMask['file_extensions']);
            /*
             * проверить каждый найденный файл
             */
            foreach ($aFiles as $sFile) {
                /*
                 * можно ли прочитать этот файл
                 */
                if (!is_readable($sFile)) {
                    $this->Message_AddError($this->Lang_Get('plugin.admin.errors.encoding_check.unreadable_file',
                            array('file' => $sFile)), $this->Lang_Get('common.error.error'), $bSessionMessages);
                    continue;
                }
                /*
                 * получить первые 50 байт, этого достаточно для проверки
                 */
                if (($sText = @file_get_contents($sFile, false, null, 0, 50)) === false) {
                    $this->Message_AddError($this->Lang_Get('plugin.admin.errors.encoding_check.file_cant_be_read',
                            array('file' => $sFile)), $this->Lang_Get('common.error.error'), $bSessionMessages);
                    continue;
                }
                /*
                 * проверить на некорректную кодировку файлов (utf-8 BOM)
                 */
                if ($this->IsTextEncodedByUTF8BOM($sText)) {
                    $aIncorrectEncodingFiles[] = $sFile;
                }
            }
        }
        return $aIncorrectEncodingFiles;
    }


    /**
     * Получить рекурсивно список файлов (и директорий) по указанному пути с указанными расширениями (или все файлы)
     *
     * @param      $sDir            корневая директория для поиска (далее в ней будет рекурсивный поиск)
     * @param null $aFileTypes массив расширений файлов для поиска (или null если нужны все файлы)
     * @param bool $bOnlyFiles флаг возвращения в списке только файлов, иначе будут возвращены и директории тоже
     * @return array                массив файлов (и директорий, если нужно)
     */
    public function GetDirsRecursiveListing($sDir, $aFileTypes = null, $bOnlyFiles = true)
    {
        /*
         * список файлов по указанному пути
         */
        $aFiles = array();
        /*
         * выбрать все директории и файлы, добавляя к директориям слеш в конце
         * (будут выбраны все файлы, кроме тех, которые начинаются на точку (.htaccess))
         */
        if (!$aFilesAndDirs = glob($sDir . '*', GLOB_MARK)) {
            return array();
        }
        foreach ($aFilesAndDirs as $sFileOrDir) {
            /*
             * если это директория
             */
            if (is_dir($sFileOrDir)) {
                /*
                 * искать в ней файлы рекурсивно с возвращением их списка
                 */
                $aFiles = array_merge($aFiles, $this->GetDirsRecursiveListing($sFileOrDir, $aFileTypes, $bOnlyFiles));
                /*
                 * если нужно получить только список файлов
                 */
                if ($bOnlyFiles) {
                    continue;
                }
            }
            /*
             * это файл
             */
            /*
             * если указан массив нужных расширений для отбора файлов и это не директория (может быть если флаг $bOnlyFiles установлен в false)
             */
            if (is_array($aFileTypes) and !is_dir($sFileOrDir)) {
                $sFileExtension = pathinfo($sFileOrDir, PATHINFO_EXTENSION);
                /*
                 * проверить на расширение
                 */
                if (!in_array($sFileExtension, $aFileTypes)) {
                    continue;
                }
            }
            /*
             * добавить файл (или директорию) в список
             */
            $aFiles[] = $sFileOrDir;
        }
        return $aFiles;
    }


    /**
     * Проверить является ли кодировкой текста utf-8 BOM (которую нельзя использовать в файлах движка)
     *
     * @param $sText    текст для проверки
     * @return bool
     */
    protected function IsTextEncodedByUTF8BOM($sText)
    {
        /*
         * "utf-8 BOM" отличается от простой "utf-8 без сигнатуры" первыми тремя символами
         */
        return substr($sText, 0, 3) === pack('CCC', 0xEF, 0xBB, 0xBF);
    }


    /*
     *
     * --- Хелперы ---
     *
     */

    /**
     * Получает значение свойства из объекта XML на основе указанного языка на сайте
     * tip: имеет обратную совместимость со старыми форматами xml файлов (когда язык указан полностью, т.е. russian, ukrainian)
     *
     * @param $oXml            узел
     * @param $sProperty    свойство, которое дополнится значением data указанного языка
     * @param $sLang        название языка
     */
    public function AddXmlDataValueCorrespondingOnLang($oXml, $sProperty, $sLang)
    {
        /*
         * есть ли текущий язык в формате i18n
         */
        if (!count($mData = $oXml->xpath($sProperty . '/lang[@name="' . $sLang . '"]'))) {
            /*
             * получить язык в старом формате (полностью)
             */
            $sLangFull = Config::Get('plugin.admin.lang.i18n_mapping.' . $sLang);
            /*
             * есть ли язык в старом формате
             */
            if (!$sLangFull or !count($mData = $oXml->xpath($sProperty . '/lang[@name="' . $sLangFull . '"]'))) {
                /*
                 * использовать язык по-умолчанию
                 */
                $mData = $oXml->xpath($sProperty . '/lang[@name="default"]');
            }
        }
        /*
         * обработать как текст без других парсеров
         */
        $oXml->$sProperty->data = $this->Text_JevixParser(trim((string)array_shift($mData)));
    }


    /**
     * Сбросить весь кеш движка (данные, компилированные шаблоны, сжатые CSS и JS файлы)
     */
    public function ResetAllLSCache()
    {
        /*
         * Сбрасываем кеш данных
         */
        $this->Cache_Clean();
        /*
         * выбрать все файлы и директории во временной директории движка, без учета самой директории
         * tip: файлы, начинающихся на точку (.htaccess) будут пропущены
         */
        if ($aDirsAndFiles = $this->GetDirsRecursiveListing(Config::Get('path.tmp.server') . '/', null, false)) {
            foreach ($aDirsAndFiles as $sDirItem) {
                if (is_dir($sDirItem)) {
                    @rmdir($sDirItem);
                } else {
                    @unlink($sDirItem);
                }
            }
        }
        /*
         * увеличить счетчик для сброса кеша браузера на стороне пользователя
         */
        $this->Storage_Set(self::CACHE_LAST_RESET_COUNTER,
            $this->Storage_Get(self::CACHE_LAST_RESET_COUNTER, $this) + 1, $this);
    }

    /**
     * Удаляет лишние настройки конфигов из хранилища админки
     */
    public function ResetConfigSheme() {

    }

}