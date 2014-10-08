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
class PluginArticle_ActionArticle extends ActionPlugin
{

    public function Init()
    {
        /**
         * Получаем текущего пользователя
         */
        $this->oUserCurrent = $this->User_GetUserCurrent();

        $this->Viewer_AppendScript(Plugin::GetWebPath(__CLASS__) . 'js/main.js');
    }

    /**
     * Регистрируем евенты
     *
     */
    protected function RegisterEvent()
    {
        $this->AddEventPreg('/^(page(\d{1,5}))?$/i', '/^$/i', array('EventIndex', 'index'));
        $this->AddEventPreg('/^view$/i', "/^\d{1,6}$/i", 'EventArticleShow');
        $this->AddEventPreg('/^tag$/i', '/^.+$/i', '/^(page([1-9]\d{0,5}))?$/i', "/^$/i", 'EventTag');
        $this->AddEventPreg('/^category$/i', '/^[\w\-\_]+$/i', 'EventCategoryShow');
    }

    /**
     * Отображение списка статей
     */
    protected function EventIndex()
    {
        /**
         * Получаем номер страницы из урла
         */
        $iPage = $this->GetEventMatch(2) ? $this->GetEventMatch(2) : 1;
        /**
         * Формируем фильтр для запроса статей. Используется функционал ORM
         */
        $aFilter = array('#properties' => true, '#order' => array('id' => 'desc'));
        $aFilter['#page'] = array($iPage, Config::Get('plugin.article.per_page'));
        /**
         * Получаем статьи
         */
        $aResult = $this->PluginArticle_Main_GetArticleItemsByFilter($aFilter);
        /**
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging($aResult['count'], $iPage, Config::Get('plugin.article.per_page'),
            Config::Get('pagination.pages.count'), Router::GetPath('article'));
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
     * Выводить статьи по категории
     */
    protected function EventCategoryShow()
    {
        $aParams = $this->GetParams();
        $sLastParam = array_pop($aParams);

        if (preg_match('#^page(\d{1,5})$#i', $sLastParam, $aMatch)) {
            $iPage = $aMatch[1];
        } else {
            $iPage = 1;
            $aParams[] = $sLastParam;
        }
        $sUrlFull = join('/', $aParams);

        /**
         * Получаем категорию
         */
        if (!($oCategory = $this->Category_GetCategoryByUrlFull($sUrlFull))) {
            return $this->EventNotFound();
        }
        /**
         * Список ID всех категорий, включая дочернии
         */
        $aCategoriesId = $this->Category_GetCategoriesIdByCategory($oCategory, true);
        /**
         * Получаем список статей
         */
        $aResult = $this->PluginArticle_Main_GetArticleItemsByFilter(array(
                '#category' => $aCategoriesId,
                '#page'     => array(
                    $iPage,
                    Config::Get('plugin.article.per_page')
                )
            ));
        $aPaging = $this->Viewer_MakePaging($aResult['count'], $iPage, Config::Get('plugin.article.per_page'),
            Config::Get('pagination.pages.count'), $oCategory->getWebUrl());

        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aArticleItems', $aResult['collection']);
        $this->Viewer_Assign('oCategoryCurrent', $oCategory);

        $this->Viewer_AddHtmlTitle($oCategory->getTitle());
        $this->SetTemplateAction('category');
    }

    /**
     * Обработка детального вывода статьи
     */
    protected function EventArticleShow()
    {
        if (!$this->Rbac_IsAllow('view', $this)) {
            return $this->Rbac_ReturnActionError();
        }
        $iId = $this->GetParam(0);
        /**
         * Проверяем статью на существование
         */
        if (!($oArticle = $this->PluginArticle_Main_GetArticleById($iId))) {
            return $this->EventNotFound();
        }
        /**
         * Прогружаем переменные в шаблон, устанавливает title страницы и нужный шаблон вывода
         */
        $this->Viewer_Assign('oArticle', $oArticle);
        $this->Viewer_AddHtmlTitle(htmlspecialchars_decode($oArticle->getTitle()));
        $this->SetTemplateAction('view');
    }

    /**
     * Обработка поиска статей по тегам
     * Теги создаются как отдельное дополнительно поле через модуль Property
     */
    protected function EventTag()
    {
        /**
         * Проверяем есть ли у статей нужное поле с тегами
         */
        if (!($oPropertyTags = $this->Property_GetPropertyByTargetTypeAndCode($this->PluginArticle_Main_GetPropertyTargetType(),
            Config::Get('plugin.article.property_tags_code')))
        ) {
            return $this->EventNotFound();
        }
        /**
         * Получаем тег из УРЛа
         */
        $sTag = $this->GetParam(0);
        /**
         * Передан ли номер страницы
         */
        $iPage = $this->GetParamEventMatch(1, 2) ? $this->GetParamEventMatch(1, 2) : 1;
        /**
         * Получаем список статей
         */
        $aResult = $this->PluginArticle_Main_GetArticleItemsByTag($oPropertyTags, $sTag, $iPage,
            Config::Get('plugin.article.per_page'));
        $aArticles = $aResult['collection'];
        /**
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging($aResult['count'], $iPage, Config::Get('plugin.article.per_page'),
            Config::Get('pagination.pages.count'), Router::GetPath('article/tag') . htmlspecialchars($sTag));
        /**
         * Загружаем переменные в шаблон
         */
        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aArticleItems', $aArticles);
        $this->Viewer_Assign('sTag', $sTag);
        $this->Viewer_Assign('oPropertyTags', $oPropertyTags);
        $this->Viewer_AddHtmlTitle('Поиск по тегу');
        $this->Viewer_AddHtmlTitle($sTag);
        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('tag');
    }
}