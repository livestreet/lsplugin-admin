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
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */
class PluginArticle_ActionAdmin extends PluginAdmin_ActionPlugin
{

    /**
     * Объект УРЛа админки, позволяет удобно получать УРЛы на страницы управления плагином
     */
    public $oAdminUrl;
    public $oUserCurrent;

    public function Init()
    {
        $this->oAdminUrl = Engine::GetEntity('PluginAdmin_ModuleUi_EntityAdminUrl');
        $this->oUserCurrent = $this->User_GetUserCurrent();
        $this->Viewer_AppendScript(Plugin::GetWebPath(__CLASS__) . 'js/admin.js');
    }

    /**
     * Регистрируем евенты
     *
     */
    protected function RegisterEvent()
    {
        /**
         * Для ajax регистрируем внешний обработчик
         */
        $this->RegisterEventExternal('Ajax', 'PluginArticle_ActionAdmin_EventAjax');
        /**
         * Список статей, создание и обновление
         */
        $this->AddEventPreg('/^(page(\d{1,5}))?$/i', '/^$/i', 'EventIndex');
        $this->AddEvent('create', 'EventCreate');
        $this->AddEventPreg('/^update$/i', '/^\d{1,6}$/i', '/^$/i', 'EventUpdate');
        /**
         * Ajax обработка
         */
        $this->AddEventPreg('/^ajax$/i', '/^article-create$/i', '/^$/i', 'Ajax::EventArticleCreate');
        $this->AddEventPreg('/^ajax$/i', '/^article-update$/i', '/^$/i', 'Ajax::EventArticleUpdate');
        $this->AddEventPreg('/^ajax$/i', '/^article-remove$/i', '/^$/i', 'Ajax::EventArticleRemove');
    }

    /**
     *    Вывод списка статей
     */
    protected function EventIndex()
    {
        /**
         * Получаем номер страницы из урла
         */
        $iPage = $this->GetEventMatch(2) ? $this->GetEventMatch(2) : 1;
        /**
         * Получаем статьи
         */
        $aResult = $this->PluginArticle_Main_GetArticleItemsByFilter(array(
                '#order' => array('id' => 'desc'),
                '#page'  => array($iPage, 20)
            ));
        /**
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging($aResult['count'], $iPage, 20, Config::Get('pagination.pages.count'),
            $this->oAdminUrl->get(null, 'article'));
        /**
         * Прогружаем переменные в шаблон
         */
        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aArticleItems', $aResult['collection']);
        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('index');
    }

    /**
     * Создание статьи. По факту только отображение шаблона, т.к. обработка идет на ajax
     */
    protected function EventCreate()
    {
        if (!$this->Rbac_IsAllow('create', $this)) {
            return $this->Rbac_ReturnActionError(true);
        }
        $this->SetTemplateAction('create');
    }

    /**
     * Редактирование статьи
     */
    protected function EventUpdate()
    {
        /**
         * Проверяем статью на существование
         */
        if (!($oArticle = $this->PluginArticle_Main_GetArticleById($this->GetParam(0)))) {
            $this->Message_AddErrorSingle('Не удалось найти статью', $this->Lang_Get('common.error.error'));
            return $this->EventError();
        }
        /**
         * Права на редактирование
         */
        if (!$this->Rbac_IsAllow('update', $this, array('article' => $oArticle))) {
            return $this->Rbac_ReturnActionError(true);
        }

        $this->Viewer_Assign("oArticle", $oArticle);
        $this->SetTemplateAction('create');
    }
}