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

/**
 * Часть экшена админки по управлению ajax запросами
 */
class PluginArticle_ActionAdmin_EventAjax extends Event
{

    public function Init()
    {
        /**
         * Устанавливаем формат ответа
         */
        $this->Viewer_SetResponseAjax('json');
    }

    /**
     * Обработка добавления статьи
     */
    public function EventArticleCreate()
    {
        if (!$this->Rbac_IsAllow('create', $this)) {
            return $this->Rbac_ReturnActionError(true);
        }
        /**
         * Создаем статью
         */
        $oArticle = Engine::GetEntity('PluginArticle_ModuleMain_EntityArticle');
        /**
         * Загружаем данные из реквеста (массив article) в объект
         * Поля массива должны совпадать с полями в $aValidateRules у объекта
         * Данные дополнительных полей передавать не нужно, они автоматически учитываются при валидации из переменной реквеста property
         */
        $oArticle->_setDataSafe(getRequest('article'));
        $oArticle->setUserId($this->oUserCurrent->getId());
        /**
         * Валидируем
         */
        if ($oArticle->_Validate()) {
            /**
             * Добавляем в БД
             */
            if ($oArticle->Add()) {
                $this->Viewer_AssignAjax('sUrlRedirect', $this->oAdminUrl->get(null, 'article'));
                $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'));
            } else {
                $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
            }
        } else {
            $this->Message_AddError($oArticle->_getValidateError(), $this->Lang_Get('common.error.error'));
        }
    }

    /**
     * Обработка обновления статьи
     */
    public function EventArticleUpdate()
    {
        /**
         * Данные статьи из реквеста
         */
        $aArticleRequest = getRequest('article');
        /**
         * Проверяем статью на существование
         */
        if (!(isset($aArticleRequest['id']) and $oArticle = $this->PluginArticle_Main_GetArticleById($aArticleRequest['id']))) {
            $this->Message_AddErrorSingle('Не удалось найти статью', $this->Lang_Get('common.error.error'));
            return;
        }
        /**
         * Права на редактирование
         */
        if (!$this->Rbac_IsAllow('update', $this, array('article' => $oArticle))) {
            return $this->Rbac_ReturnActionError(true);
        }
        $oArticle->_setDataSafe($aArticleRequest);
        /**
         * Валидируем
         */
        if ($oArticle->_Validate()) {
            /**
             * Обновляем статью
             */
            if ($oArticle->Update()) {
                $this->Message_AddNotice('Обновление прошло успешно', $this->Lang_Get('common.attention'));
                $this->Viewer_AssignAjax('bReloadPage', true);
            } else {
                $this->Message_AddError('Возникла ошибка при обновлении', $this->Lang_Get('common.error.error'));
            }
        } else {
            $this->Message_AddError($oArticle->_getValidateError(), $this->Lang_Get('common.error.error'));
        }
    }

    /**
     * Обработка удаления статьи
     */
    public function EventArticleRemove()
    {
        /**
         * Проверяем статью на существование
         */
        if (!($oArticle = $this->PluginArticle_Main_GetArticleById(getRequestStr('id')))) {
            $this->Message_AddErrorSingle('Не удалось найти статью', $this->Lang_Get('common.error.error'));
            return;
        }
        /**
         * Удаляем статью
         */
        if ($oArticle->Delete()) {
            $this->Message_AddNoticeSingle("Удаление прошло успешно");
        } else {
            $this->Message_AddErrorSingle("Ошибка при удалении");
        }
    }
}
