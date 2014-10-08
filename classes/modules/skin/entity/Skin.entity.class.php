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
 * Сущность для работы с шаблонами
 *
 */

class PluginAdmin_ModuleSkin_EntitySkin extends Entity
{

    /**
     * Включен ли этот шаблон сейчас для предпросмотра
     *
     * @return bool
     */
    public function getInPreview()
    {
        return $this->getName() == $this->PluginAdmin_Skin_GetPreviewSkinName();
    }


    /**
     * Включен ли сейчас этот шаблон (независимо от предпросмотра другого шаблона)
     *
     * @return bool
     */
    public function getIsCurrent()
    {
        return $this->getName() == $this->PluginAdmin_Skin_GetOriginalSkinName();
    }


    /**
     * Получить название шаблона как оно указано в описании, в противном случае - системное имя шаблона (имя директории)
     *
     * @return mixed
     */
    public function getViewName()
    {
        /*
         * если есть имя из xml файла описания для шаблона
         */
        if ($sName = $this->getXmlName()) {
            return $sName;
        }
        /*
         * вернуть системное имя шаблона
         */
        return $this->getName();
    }


    /*
     *
     * --- Данные из xml файла ---
     *
     */

    /**
     * Получить имя шаблона
     *
     * @return mixed
     */
    public function getXmlName()
    {
        if ($oInfo = $this->getXml() and $mValue = $oInfo->name->data and $mValue != '') {
            return (string)$mValue;
        }
        return null;
    }


    /**
     * Получить автора шаблона
     *
     * @return mixed
     */
    public function getAuthor()
    {
        if ($oInfo = $this->getXml() and $mValue = $oInfo->author->data and $mValue != '') {
            return (string)$mValue;
        }
        return null;
    }


    /**
     * Получить страницу шаблона
     *
     * @return mixed
     */
    public function getHomepage()
    {
        if ($oInfo = $this->getXml() and $mValue = $oInfo->homepage and $mValue != '') {
            return (string)$mValue;
        }
        return null;
    }


    /**
     * Получить версию шаблона
     *
     * @return mixed
     */
    public function getVersion()
    {
        if ($oInfo = $this->getXml() and $mValue = $oInfo->version and $mValue != '') {
            return (string)$mValue;
        }
        return null;
    }


    /**
     * Получить описание шаблона
     *
     * @return mixed
     */
    public function getDescription()
    {
        if ($oInfo = $this->getXml() and $mValue = $oInfo->description->data and $mValue != '') {
            return (string)$mValue;
        }
        return null;
    }


    /**
     * Получить массив тем шаблона
     *
     * @return mixed
     */
    public function getThemes()
    {
        if ($oInfo = $this->getXml() and
            $oXmlThemes = $oInfo->themes and
            $aXmlThemes = $oXmlThemes->children()
            and $aXmlThemes != ''
        ) {
            /*
             * получить массив тем, где ключ - системное имя темы, значение - массив с описанием темы
             */
            $aThemes = array();
            foreach ($aXmlThemes as $oTheme) {
                $aThemes[(string)$oTheme->value] = array(
                    /*
                     * системное имя
                     */
                    'value'       => (string)$oTheme->value,
                    /*
                     * описание темы, на основе установленного языка сайта
                     */
                    'description' => (string)$oTheme->description->data,
                );
            }
            return $aThemes;
        }
        return array();
    }


    /**
     * Поддерживается ли указанная тема этим шаблоном (есть ли в списке тем шаблона)
     *
     * @param $sTheme        имя темы для проверки
     * @return bool
     */
    public function getIsThemeSupported($sTheme)
    {
        return in_array($sTheme, array_keys($this->getThemes()));
    }


    /*
     *
     * --- Урлы ---
     *
     */

    /**
     * Получить путь к превью из шаблона или превью по-умолчанию
     *
     * @return string    путь к изображению превью
     */
    public function getPreviewImage()
    {
        if ($sPreview = $this->getPreview()) {
            return $sPreview;
        }
        /*
         * если нет превью - использовать превью по-умолчанию
         */
        return Plugin::GetTemplateWebPath(__CLASS__) . 'assets/images/default_skin_preview.png';
    }


    /**
     * Получить ссылку для смены шаблона
     *
     * @return string
     */
    public function getChangeSkinUrl()
    {
        return Router::GetPath('admin/skins/use') . $this->getName() . '?security_ls_key=' . $this->Security_GetSecurityKey();
    }


    /**
     * Получить ссылку для выключения предпросмотра шаблона
     *
     * @return string
     */
    public function getTurnOffPreviewUrl()
    {
        return Router::GetPath('admin/skins/turnoffpreview') . $this->getName() . '?security_ls_key=' . $this->Security_GetSecurityKey();
    }


    /**
     * Получить ссылку для включения предпросмотра шаблона
     *
     * @return string
     */
    public function getTurnOnPreviewUrl()
    {
        return Router::GetPath('admin/skins/preview') . $this->getName() . '?security_ls_key=' . $this->Security_GetSecurityKey();
    }

}

?>