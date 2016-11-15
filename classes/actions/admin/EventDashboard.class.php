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
 * Главная страница админки
 *
 */

class PluginAdmin_ActionAdmin_EventDashboard extends Event
{


    /**
     * Дашборд (главная страница админки)
     */
    public function EventIndex()
    {
        $this->SetTemplateAction('index/index');
        /*
         * данные для графика
         */
        $this->PluginAdmin_Stats_GatherAndBuildDataForGraph(
            $this->GetDataFromFilter('graph_type'),
            $this->GetDataFromFilter('graph_period'),
            $this->GetDataFromFilter('date_start'),
            $this->GetDataFromFilter('date_finish')
        );

        /*
         * период для показа прироста новых топиков, комментариев и т.п.
         */
        $sItemsAddedPeriod = $this->GetDataFromFilter('newly_added_items_period');

        /*
         * получить прирост, линейку голосов и рейтингов топиков, комментариев, блогов и пользователей за указанный период (период по-умолчанию)
         */
        $this->Viewer_Assign('aDataGrowth', array(
            PluginAdmin_ModuleStats::DATA_TYPE_TOPICS        => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_TOPICS,
                $sItemsAddedPeriod),
            PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS      => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS,
                $sItemsAddedPeriod),
            PluginAdmin_ModuleStats::DATA_TYPE_BLOGS         => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_BLOGS,
                $sItemsAddedPeriod),
            PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS,
                $sItemsAddedPeriod),
        ));

        /*
         * получить прирост пользователей за месяц (для отображения в шапке шаблона, без линейки голосов и рейтингов)
         */
        $this->Viewer_Assign('aUserGrowth', $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(
            PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS,
            PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK,
            false,
            false
        ));

        /*
         * получить все события
         */
        $this->GetStreamAll();
        /*
         * получить список всех событий для отображения фильтра
         */
        $this->Viewer_Assign('aEventTypes', array_keys($this->Stream_getEventTypes()));

        /*
         * получить базовую статистику
         */
        $this->Viewer_Assign('aStats', $this->User_GetStatUsers());
        /*
         * количество топиков всего
         */
        $this->Viewer_Assign('iTotalTopicsCount', $this->Topic_GetCountTopicsByFilter(array('published' => 1)));
        /*
         * количество блогов всего
         */
        $this->Viewer_Assign('iTotalBlogsCount', $this->PluginAdmin_Blogs_GetCountBlogs());
        /*
         * количество комментариев всего
         */
        $this->Viewer_Assign('iTotalCommentsCount', $this->PluginAdmin_Comments_GetCountCommentsTotal('topic'));
        /*
         * получить информацию по обновлениям плагинов
         */
        $this->PluginAdmin_Catalog_GetUpdatesInfo();
        /*
         * получить информацию о новых жалобах на пользователей
         */
        $this->Viewer_Assign('iUsersComplaintsCountNew', $this->PluginAdmin_Users_GetUsersComplaintsCountNew());
    }


    /**
     * Получить обработанный блок для показа при смене периода через аякс для новых объектов
     */
    public function EventAjaxGetNewItemsBlock()
    {
        $this->Viewer_SetResponseAjax('json');
        /*
         * период для показа прироста новых топиков, комментариев и т.п.
         */
        $sItemsAddedPeriod = $this->GetDataFromFilter('newly_added_items_period');

        $oViewer = $this->Viewer_GetLocalViewer();
        /*
         * получить прирост, линейку голосов и рейтингов топиков, комментариев, блогов и пользователей за указанный период
         */
        $oViewer->Assign('aDataGrowth', array(
            PluginAdmin_ModuleStats::DATA_TYPE_TOPICS        => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_TOPICS,
                $sItemsAddedPeriod),
            PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS      => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_COMMENTS,
                $sItemsAddedPeriod),
            PluginAdmin_ModuleStats::DATA_TYPE_BLOGS         => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_BLOGS,
                $sItemsAddedPeriod),
            PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS => $this->PluginAdmin_Stats_GetGrowthAndVotingsByTypeAndPeriod(PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS,
                $sItemsAddedPeriod),
        ));
        $this->Viewer_AssignAjax('sText', $oViewer->Fetch('component@admin:p-dashboard.block-stats-content'));
    }


    /**
     * Получить всю последнюю активность
     */
    protected function GetStreamAll()
    {
        $aEvents = $this->Stream_ReadAll(Config::Get('plugin.admin.dashboard.stream.count_default'));
        $this->Viewer_Assign('iStreamCount', $this->Stream_GetCountAll());
        $this->Viewer_Assign('aStreamEvents', $aEvents);
        if (count($aEvents)) {
            $oEvenLast = end($aEvents);
            $this->Viewer_Assign('iStreamLastId', $oEvenLast->getId());
        }
    }


    /**
     * Аякс получение последней активности по фильтру (первая порция после смены фильтра)
     */
    public function EventAjaxGetIndexActivity()
    {
        $this->ProcessAjaxStreamContentLoading();
    }


    /**
     * Аякс загрузка следующей порции активности на основе фильтра
     */
    public function EventAjaxGetIndexActivityMore()
    {
        $this->ProcessAjaxStreamContentLoading(true);
    }


    /**
     * Выполнить загрузку данных для ленты активности
     *
     * @param bool $bUseFromIdValue использовать ли смещение
     * @return bool
     */
    protected function ProcessAjaxStreamContentLoading($bUseFromIdValue = false)
    {
        $this->Viewer_SetResponseAjax('json');
        /*
         * получить фильтр со списком событий, которые нужно показать
         */
        if (!$aFilterData = $this->GetDataFromFilter()) {
            $this->Message_AddError($this->Lang('errors.index.empty_activity_filter'), $this->Lang_Get('common.error.error'));
            return false;
        }
        /*
         * нужно ли использовать ид последнего, ранее показанного события
         */
        $iFromId = null;
        if ($bUseFromIdValue and !$iFromId = getRequestStr('iLastId')) {
            $this->Message_AddError($this->Lang_Get('common.error.system.base'), $this->Lang_Get('common.error.error'));
            return false;
        }
        /*
         * прочитать нужные события
         */
        $aEvents = $this->Stream_ReadEvents(array_keys($aFilterData), null,
            Config::Get('plugin.admin.dashboard.stream.count_default'), $iFromId);
        /*
         * получить ленту с событиями в виде хтмл-кода
         */
        $oViewer = $this->Viewer_GetLocalViewer();
        $oViewer->Assign('aStreamEvents', $aEvents);
        $this->Viewer_AssignAjax('result',
            $oViewer->Fetch(Plugin::GetTemplatePath(__CLASS__) . 'actions/ActionAdmin/index/activity/events.tpl'));
        /*
         * установить ид последнего события
         */
        if (count($aEvents)) {
            $oEvenLast = end($aEvents);
            $this->Viewer_AssignAjax('iStreamLastId', $oEvenLast->getId());
        } else {
            /*
             * сообщить что по выбранному фильтру нет данных
             */
            $this->Message_AddError($this->Lang('notices.index.no_results'));
        }
        $this->Viewer_AssignAjax('events_count', count($aEvents));
        /*
         * отключить ли кнопку "показать ещё события"
         */
        /*
         * --- хак "бага-особенности" обработки активности движком ---
         *
         * модуль стрима получает обьекты по записям из таблицы, пропуская все битые данные (без сообщений об ошибке), которые он не может получить (но запись в таблице существует),
         * поэтому может быть ситуация когда количество возвращаемых в ответ данных меньше чем запрошенное количество для показа, т.е. указано количество на страницу 5, а получено 4.
         *
         * при включении первого варианта возможна "пропажа" кнопки "показать ещё", даже если данные активности ещё есть. это означает что есть "битые" данные в таблице активности.
         * а если нельзя получить обьект по записи из бд, то он просто пропускается (метод Stream_ReadEvents), в результате сравнивается количество полученных обьектов
         * и если оно меньше чем нужно показать за одно нажатие "показать ещё" - значит обьекты кончились (и нужно спрятать кнопку).
         *
         * а в случае поврежденной таблицы активности (остались данные обьектов, которые удалены) их будет меньше т.к. данные будут просто пропущены.
         * это баг в самом движке - нужно искать место, где не чистится стрим после удаления какого-то обьекта
         *
         * В стандартной активности на сайте нет такой проверки и даже если данные последние - кнопка появится
         * и только если нажать на неё ещё раз и данных не будет вообще - только тогда она прячется.
         *
         * p.s. в таком случае нужно вообще периодически производить очистку активности (через утилиты) т.к. там может собираться мусор
         *
         */
        /*
         * вариант #1 (по-хорошему следует использовать этот вариант)
         */
        //$this->Viewer_AssignAjax('bDisableGetMoreButton', count($aEvents) < Config::Get('plugin.admin.dashboard.stream.count_default'));
        /*
         * вариант #2 (как в движке, требует ещё одного нажатия на кнопку "показать ещё" чтобы она спряталась)
         */
        $this->Viewer_AssignAjax('bDisableGetMoreButton', count($aEvents) == 0);
    }


}

?>