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
 * Работа с банами пользователей
 *
 */

class PluginAdmin_HookUserban extends Hook
{


    public function RegisterHook()
    {
        /*
         * сообщение текущему пользователю что он под баном
         * tip: наименьший приоритет, который можно установить
         */
        $this->AddHook('engine_init_complete', 'EngineInitComplete', __CLASS__, -PHP_INT_MAX);
        /*
         * чтобы в профиле админки указать забанен пользователь или нет
         */
        $this->AddHook('template_admin_user_profile_center_info', 'AdminUserProfileCenterInfo');
        /*
         * чтобы в профиле пользователя на сайте указать забанен пользователь или нет
         */
        $this->AddHook('template_user_info_begin', 'AdminUserProfileCenterInfo');
    }


    /**
     * Сообщение текущему пользователю что он под баном
     */
    public function EngineInitComplete()
    {
        /*
         * если текущий пользователь попадает под условия бана - показать ему сообщение
         */
        $this->CheckUserBan();
    }


    /**
     * Проверка бана текущего пользователя
     */
    protected function CheckUserBan()
    {
        /*
         * если это полный бан с лишением доступа ко всему сайту
         * tip: использовать этот метод для общей проверки на бан т.к. пользователь может быть не авторизирован
         */
        if ($oBan = $this->PluginAdmin_Users_IsCurrentUserBannedFully()) {
            /*
             * добавить запись о срабатывании бана в статистику
             */
            $this->PluginAdmin_Users_AddBanTriggering($oBan);
            /*
             * блокировать пользователя
             */
            $this->ShowBanMessage($oBan);
        }
    }


    /**
     * Показать сообщение о бане
     *
     * @param $oBan        объект бана
     */
    protected function ShowBanMessage($oBan)
    {
        /*
         * корректный код ответа - 403 (запрещено)
         */
        header('HTTP/1.1 403');
        /*
         * сообщение пользователю в зависимости от типа бана (временный или постоянный)
         */
        $this->Message_AddError($oBan->getBanMessageForUser(), '403');
        /*
         * независимо от типа блокировки (айпи или сущность пользователя) - авторизация запрещена
         */
        $this->User_Logout();
        Router::Action('error');
    }


    /**
     * Сообщение в профиле пользователя что он забанен
     *
     * @param $aVars    передаваемые параметры
     * @return mixed
     */
    public function AdminUserProfileCenterInfo($aVars)
    {
        /*
         * видно либо хозяину профиля либо админам (этот метод добавлен в профиль админки и на сайте)
         */
        $oUserProfile = isset($aVars['user']) ? $aVars['user'] : $aVars['oUserProfile']; // временный хак
        if ($this->User_GetUserCurrent() and $oBan = $oUserProfile->getBanned()) {
            $this->Viewer_Assign('ban', $oBan, true);
            return $this->Viewer_Fetch('component@admin:p-user.banned-alert');
        }
    }

}