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
 * Сущность для работы с установленными плагинами
 *
 */

class PluginAdmin_ModulePlugins_EntityPlugins extends Entity
{

    /*
     *
     * --- Урлы ---
     *
     */

    /**
     * Получить урл редактирования настроек конфига плагина
     *
     * @return string
     */
    public function getConfigSettingsPageUrl()
    {
        return Router::GetPath('admin/settings/plugin/' . $this->getCode());
    }


    /**
     * Получить урл для активации плагина
     *
     * @param bool $bGoToInstructionsFirst нужно ли делать ссылку на страницу инструкций (если они есть) вместо прямой ссылки на активацию плагина
     * @return string
     */
    public function getActivateUrl($bGoToInstructionsFirst = true)
    {
        /*
         * проверить нужно ли сначала направить на страницу инструкций по установке плагина
         */
        if ($bGoToInstructionsFirst and $this->getInstallInstructionsPath()) {
            return $this->getInstallInstructionsUrl();
        }
        return Router::GetPath('admin/plugins/toggle') . '?plugin=' . $this->getCode() . '&action=activate&security_ls_key=' . $this->Security_GetSecurityKey();
    }


    /**
     * Получить урл для деактивации плагина
     *
     * @return string
     */
    public function getDeactivateUrl()
    {
        return Router::GetPath('admin/plugins/toggle') . '?plugin=' . $this->getCode() . '&action=deactivate&security_ls_key=' . $this->Security_GetSecurityKey();
    }


    /**
     * Получить урл для применения обновления плагина
     *
     * @return string
     */
    public function getApplyUpdateUrl()
    {
        return Router::GetPath('admin/plugins/toggle') . '?plugin=' . $this->getCode() . '&action=apply_update&security_ls_key=' . $this->Security_GetSecurityKey();
    }


    /**
     * Получить урл для удаления плагина
     *
     * @return string
     */
    public function getRemoveUrl()
    {
        return Router::GetPath('admin/plugins/toggle') . '?plugin=' . $this->getCode() . '&action=remove&security_ls_key=' . $this->Security_GetSecurityKey();
    }


    /**
     * Получить урл для инструкций плагина (просмотр файла install.txt)
     *
     * @return string
     */
    public function getInstallInstructionsUrl()
    {
        return Router::GetPath('admin/plugins/instructions') . '?plugin=' . $this->getCode();
    }


    /**
     * Получить текст инструкций плагина (содержимое файла install.txt)
     *
     * @return string
     */
    public function getInstallInstructionsText()
    {
        return $this->PluginAdmin_Plugins_GetInstallFileText($this->getCode());
    }


    /*
     *
     * --- Данные из xml файла ---
     * tip: xml файл у плагина должен быть всегда, поэтому нет проверки на существование $this->getXml(),
     * пример с проверкой есть в сущности шаблона где xml файл может отсутствовать
     *
     */

    /**
     * Получить имя плагина
     *
     * @return mixed
     */
    public function getName()
    {
        $sData = $this->getXml()->name->data;
        return $sData != '' ? (string)$sData : null;
    }


    /**
     * Получить автора плагина
     *
     * @return mixed
     */
    public function getAuthor()
    {
        $sData = $this->getXml()->author->data;
        return $sData != '' ? (string)$sData : null;
    }


    /**
     * Получить веб-страницу плагина
     *
     * @return mixed
     */
    public function getHomepage()
    {
        $sData = $this->getXml()->homepage;
        return $sData != '' ? (string)$sData : null;
    }


    /**
     * Получить описание плагина
     *
     * @return mixed
     */
    public function getDescription()
    {
        $sData = $this->getXml()->description->data;
        return $sData != '' ? (string)$sData : null;
    }


    /**
     * Получить версию плагина
     *
     * @return mixed
     */
    public function getVersion()
    {
        $sData = $this->getXml()->version;
        return $sData != '' ? (string)$sData : null;
    }


    /**
     * Получить урл страницы собственных настроек плагина
     *
     * @return mixed
     */
    public function getOwnSettingsPageUrl()
    {
        $sData = $this->getXml()->settings;
        return $sData != '' ? (string)$sData : null;
    }


    /*
     *
     * --- Хелперы ---
     *
     */

    /**
     * Есть ли у плагина обновление (используется кеширование) - вернуть объект обновления или нулл
     * todo: работа не проверена, если не будет нужно - удалить
     *
     * @return object|null
     */
    /*	public function getUpdate() {
            $mUpdatesList = $this->PluginAdmin_Catalog_GetPluginUpdatesCached();
            if (is_array($mUpdatesList) and isset($mUpdatesList[$this->getCode()]) and is_object($mUpdatesList[$this->getCode()])) {
                return $mUpdatesList[$this->getCode()];
            }
            return null;
        }*/

}

?>