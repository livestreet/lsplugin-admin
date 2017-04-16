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
 * Работа с шаблонами
 *
 */

class PluginAdmin_ActionAdmin_EventSkins extends Event
{

    protected $iPage = null;

    /**
     * Показать список шаблонов
     *
     * @return mixed
     */
    public function EventSkinsList()
    {
        $this->SetTemplateAction('skins/list');

        /*
         * получить список шаблонов и отдельно - текущий скин
         */
        $aSkinsData = $this->PluginAdmin_Skin_GetSkinList(array(
            'separate_current_skin'         => true,
            'delete_current_skin_from_list' => true
        ));
        /*
         * список шаблонов, кроме текущего
         */
        $aSkinList = $aSkinsData['skins'];
        /*
         * текущий скин
         */
        $oSkinCurrent = $aSkinsData['current'];

        /*
         * проверка разрешенных действий и корректности имени шаблона
         */
        if ($sAction = $this->getParam(0) and in_array($sAction, array('use', 'preview', 'turnoffpreview'))) {
            /*
             * указан и есть ли такой шаблон
             */
            if ($sSkinName = $this->getParam(1) and isset($aSkinList[$sSkinName])) {
                $this->Security_ValidateSendForm();
                /*
                 * выполнить нужную операцию
                 */
                $sMethodName = ucfirst($sAction) . 'Skin';
                $this->{$sMethodName}($sSkinName);

                return $this->RedirectToReferer();
            } else {
                $this->Message_AddError($this->Lang('errors.skin.unknown_skin'));
            }
        }
        $this->Viewer_Assign('aSkins', $aSkinList);
        $this->Viewer_Assign('oSkinCurrent', $oSkinCurrent);
    }


    /**
     * Изменить тему активного шаблона
     */
    public function EventChangeSkinTheme()
    {
        $this->Security_ValidateSendForm();
        /*
         * получить имя нужной темы
         */
        $sTheme = getRequestStr('theme');
        /*
         * получить текущий шаблон
         */
        $oCurrentSkin = $this->PluginAdmin_Skin_GetSkinCurrent();
        /*
         * проверить есть ли такая тема текущего шаблона
         */
        if ($oCurrentSkin->getIsThemeSupported($sTheme)) {
            /*
             * установить тему
             */
            if ($this->PluginAdmin_Skin_ChangeTheme($sTheme)) {
                $this->Message_AddNotice($this->Lang('notices.theme_changed'), '', true);
            }
        } else {
            $this->Message_AddError($this->Lang('errors.skin.xml_dont_tells_anything_about_this_theme'), '', true);
        }
        return $this->RedirectToReferer();
    }


    /**
     * Включить шаблон
     *
     * @param $sSkinName    имя шаблона
     */
    private function UseSkin($sSkinName)
    {
        if ($this->PluginAdmin_Skin_ChangeSkin($sSkinName)) {
            $this->Message_AddNotice($this->Lang('notices.template_changed'), '', true);
        }
    }


    /**
     * Предпросмотр шаблона
     *
     * @param $sSkinName    имя шаблона
     */
    private function PreviewSkin($sSkinName)
    {
        /*
         * уведомление вместе с ссылкой для выключения будет выводиться при предпросмотре через хуки
         */
        $this->PluginAdmin_Skin_PreviewSkin($sSkinName);
    }


    /**
     * Выключить предпросмотр
     *
     * @param $sSkinName    имя шаблона
     */
    private function TurnoffpreviewSkin($sSkinName)
    {
        $this->PluginAdmin_Skin_TurnOffPreviewSkin();
        $this->Message_AddNotice($this->Lang('notices.template_preview_turned_off'), '', true);
    }


    /**
     * Установка плагинов (каталог)
     *
     * @return mixed
     */
    public function EventSkinsInstall()
    {
        $this->SetTemplateAction('skins/install');
        /*
         * если сортировка не указана - использовать сортировку каталога по-умолчанию
         */
        $sOrder = $this->GetDataFromFilter('order') ? $this->GetDataFromFilter('order') : Config::Get('plugin.admin.catalog.remote.addons.default_sorting');
        /*
         * версия дополнений
         */
        if (!isset($_REQUEST['filter']['version'])) {
            $_REQUEST['filter']['version'] = 4; // 2.0.0
        }
        $sVersion = $this->GetDataFromFilter('version');

        $this->SetPagingForApi();

        $aFilter = (array)$this->GetDataFromFilter();
        /*
         * передать весь фильтр в запрос серверу (считаем что он сам корректно распознает все свои get параметры)
         */
        $mData = $this->PluginAdmin_Catalog_GetAddonsListFromCatalogByFilterCached(array_merge(
            $aFilter,
            array(
                'page'     => $this->iPage,
                /*
                 * показывать только плагины
                 */
                'category' => 2
            )
        ));
        /*
         * есть ли корректный ответ
         */
        if (is_array($mData)) {
            $aPaging = $mData['paging'];
            $aAddons = $mData['addons'];
        } else {
            $aPaging = array();
            $aAddons = array();
            /*
             * показать текст ошибки
             */
            $this->Message_AddError($mData, $this->Lang_Get('common.error.error'));
        }

        /*
         * подставить путь в пагинации на админку
         * tip: пагинация добавляет спереди слеш "/page1/, поэтому выходит "install//page1", пришлось вынести из метода
         */
        $aPaging['sBaseUrl'] = Router::GetPath('admin') . 'skins/install';
        /*
         * подставить сам фильтр в пагинацию, чтобы, например, корректно работала сортировка
         * tip: каталог устанавливает свои параметры типа и сортировки, которые есть в фильтре,
         * 		админке эти параметры не нужны т.к. она их получает из фильтра, поэтому параметры заменяются
         */
        $aPaging['sGetParams'] = $aFilter ? '?' . http_build_query(array('filter' => $aFilter)) : null;

        $this->Viewer_Assign('sSortOrderCurrent', $sOrder);
        $this->Viewer_Assign('sVersionCurrent', $sVersion);

        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aAddons', $aAddons);
    }

    /**
     * Задать страницу в пагинации (к-во на страницу фиксировано каталогом)
     *
     * @param int $iParamNum номер параметра, в котором нужно искать номер страницы
     */
    protected function SetPagingForApi($iParamNum = 1)
    {
        if (!$this->iPage = intval(preg_replace('#^page(\d+)$#iu', '$1', $this->GetParam($iParamNum)))) {
            $this->iPage = 1;
        }
    }
}