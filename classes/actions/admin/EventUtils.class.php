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
 * Разные утилиты
 *
 */

class PluginAdmin_ActionAdmin_EventUtils extends Event
{

    /*
     *
     * --- Проверка и восстановление ---
     *
     */

    /**
     * Показать список действий для утилит раздела оптимизации
     */
    public function EventOptimization()
    {
        $this->SetTemplateAction('utils/optimization');

        /*
         * если нужно выполнить действие
         */
        if ($sActionType = $this->GetParam(1)) {
            $this->Security_ValidateSendForm();
            $this->ProcessOptimization($sActionType);
        }
    }


    /**
     * Выполнить нужное действие для утилит раздела оптимизации
     *
     * @param $sActionType    тип действия
     * @return bool
     */
    protected function ProcessOptimization($sActionType)
    {
        @set_time_limit(0);
        switch ($sActionType) {
            case 'repaircomments':
                /*
                 * Очистить таблицу комментариев и все связанные с ней данные от поврежденных записей комментариев
                 */
                $this->PluginAdmin_Deletecontent_PerformRepairCommentsStructure();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.tables.checking_comments_done'), '',
                    true);
                break;
            case 'cleanstream':
                /*
                 * Очистка активности (стрима) от ссылок на записи, которых больше нет
                 */
                $this->PluginAdmin_Deletecontent_PerformCleanStreamEventsRecords();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.tables.checking_stream_done'), '',
                    true);
                break;
            case 'cleanvotings':
                /*
                 * Удалить все голосования, указывающие на несуществующие объекты
                 */
                $this->PluginAdmin_Deletecontent_CleanVotingsTableTargetingObjectsNotExists();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.tables.checking_votings_done'), '',
                    true);
                break;
            case 'cleanfavourites':
                /*
                 * Очистить записи избранного и тегов для избранного, указывающие на несуществующие объекты
                 */
                $this->PluginAdmin_Deletecontent_CleanFavouritesAndItsTagsTargetingObjectsNotExists();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.tables.checking_favourites_done'),
                    '', true);
                break;
            case 'checkencoding':
                /*
                 * Проверить корректность кодировки файлов
                 */
                if ($this->PluginAdmin_Tools_CheckFilesOfPluginsAndEngineHaveCorrectEncoding()) {
                    $this->Message_AddNotice($this->Lang('notices.utils.optimization.files.checking_encoding_done'),
                        '', true);
                }
                break;
            case 'resetallbansstats':
                /*
                 * Сбросить статистику срабатываний банов
                 */
                $this->PluginAdmin_Users_DeleteAllBansStats();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.datareset.bans_stats_cleared'), '',
                    true);
                break;
            case 'deleteoldbanrecords':
                /*
                 * Удалить старые записи банов, дата окончания которых уже прошла
                 */
                $this->PluginAdmin_Users_DeleteOldBanRecords();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.datareset.old_ban_records_deleted'),
                    '', true);
                break;
            case 'resetalllscache':
                /*
                 * Сбросить весь кеш движка (данные, компилированные шаблоны, сжатые CSS и JS файлы)
                 */
                $this->PluginAdmin_Tools_ResetAllLSCache();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.datareset.reset_all_ls_cache_done'),
                    '', true);
                break;
            case 'resetconfigsheme':
                /*
                 * Удаление лишних настроек конфигов
                 */
                $this->PluginAdmin_Tools_ResetConfigSheme();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.datareset.reset_config_sheme_done'),
                    '', true);
                break;
            case 'restore-comments':
                $this->Comment_RestoreTree();
                $this->Cache_Clean();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.restore.comments'), '', true);
                break;
            case 'restore-counter-favourite':
                $this->Comment_RecalculateFavourite();
                $this->Topic_RecalculateFavourite();
                $this->Cache_Clean();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.restore.counter_favourite'), '', true);
                break;
            case 'restore-counter-vote':
                $this->Topic_RecalculateVote();
                $this->Cache_Clean();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.restore.counter_vote'), '', true);
                break;
            case 'restore-counter-topic':
                $this->Blog_RecalculateCountTopic();
                $this->Cache_Clean();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.restore.counter_topic'), '', true);
                break;
            case 'recreate-previews':
                $this->Media_ReCreateFilePreviewAll();
                $this->Cache_Clean();
                $this->Message_AddNotice($this->Lang('notices.utils.optimization.recreate_previews'), '', true);
                break;
            default:
                $this->Message_AddError($this->Lang('errors.utils.unknown_optimization_action'),
                    $this->Lang_Get('common.error.error'), true);
        }
        $this->RedirectToReferer();
    }

    /*
     *
     * --- Планировщик cron ---
     *
     */

    /**
     * Выводит список задач
     */
    public function EventCron()
    {
        $aResult = $this->Cron_GetTaskItemsByFilter(array('#order' => array('state' => 'desc', 'plugin' => 'asc')));
        $this->Viewer_Assign('aTaskItems', $aResult);
        $this->Viewer_Assign('sPathCron', Config::Get('path.application.server') . '/utilities/cron/main.php');
        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('utils/cron/list');
    }

    public function EventCronCreate()
    {
        if (getRequest('task_submit')) {
            $this->Security_ValidateSendForm();
            $oTask = Engine::GetEntity('ModuleCron_EntityTask');
            $oTask->_setDataSafe(getRequest('task'));
            if ($oTask->_Validate()) {
                if ($oTask->Add()) {
                    $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::Location(Router::LocationAction('admin/utils/cron'));
                } else {
                    $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oTask->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        }
        $this->SetTemplateAction('utils/cron/create');
    }

    public function EventCronUpdate()
    {
        $this->SetTemplateAction('utils/cron/create');

        if (!$oTask = $this->Cron_GetTaskById($this->GetParam(2))) {
            return parent::EventNotFound();
        }
        $this->Viewer_Assign('oTask', $oTask);

        if (getRequest('task_submit')) {
            $this->Security_ValidateSendForm();
            $oTask->_setDataSafe(getRequest('task'), array('state'));
            if ($oTask->_Validate()) {
                if ($oTask->Update()) {
                    $this->Message_AddNotice('Сохранение прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::Location(Router::LocationAction('admin/utils/cron'));
                } else {
                    $this->Message_AddError('Возникла ошибка при сохранении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oTask->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        } else {
            $_REQUEST['task'] = array(
                'title'      => htmlspecialchars_decode($oTask->getTitle()),
                'method'     => htmlspecialchars_decode($oTask->getMethod()),
                'period_run' => $oTask->getPeriodRun(),
                'state'      => $oTask->getState(),
                'time_start' => $oTask->getTimeStart(),
                'time_end'   => $oTask->getTimeEnd(),
            );
        }
    }

    public function EventCronRemove()
    {
        $this->Security_ValidateSendForm();
        if (!$oTask = $this->Cron_GetTaskById($this->GetParam(2))) {
            return parent::EventNotFound();
        }
        $oTask->Delete();
        $this->Message_AddNotice('Удаление прошло успешно', $this->Lang_Get('common.attention'), true);
        Router::Location(Router::LocationAction('admin/utils/cron'));
    }

    public function EventCronAjaxRun()
    {
        $this->Viewer_SetResponseAjax('json');

        if (!$oTask = $this->Cron_GetTaskById(getRequestStr('id'))) {
            return parent::EventNotFound();
        }

        $aResult = $this->Cron_RunTask($oTask);
        if ($aResult['state'] == 'successful') {
            $this->Message_AddNotice('Задача выполнена', $this->Lang_Get('common.attention'));
        } else {
            $this->Message_AddError('Не удалось выполнить задачу, смотрите логи', $this->Lang_Get('common.error.error'));
        }
        $this->Viewer_Assign('item', $oTask, true);
        $this->Viewer_AssignAjax('sHtmlRow', $this->Viewer_Fetch('component@admin:p-cron.item'));
    }
}