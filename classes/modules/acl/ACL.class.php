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
 * ACL (Access Control List)
 * Реализация механизма бана типа "только чтение"
 *
 */

class PluginAdmin_ModuleACL extends PluginAdmin_Inherits_ModuleACL
{


    /**
     * Проверить включен ли для текущего пользователя режим "только чтение"
     *
     * @param $sFuncName        имя метода, который вызывает проверку
     * @return bool
     */
    private function CheckIfReadOnlyModeForCurrentUserIsSet($sFuncName)
    {
        /*
         * если пользователь переведен в режим "только чтение" - запретить ему любое действие
         */
        if ($oBan = $this->PluginAdmin_Users_IsCurrentUserBannedForReadOnly()) {
            /*
             * нужно ли увеличить счетчик срабатываний для этого метода
             */
            if ($this->NeedToGatherStatsForThisMethod($sFuncName)) {
                /*
                 * добавить запись о срабатывании бана в статистику
                 */
                $this->PluginAdmin_Users_AddBanTriggering($oBan);
            }
            /*
             * сообщение пользователю в зависимости от типа бана (временный или постоянный)
             */
            $this->Message_AddError($oBan->getBanMessageForUser(), '403');
            return true;
        }
        return false;
    }


    /**
     * Нужно ли записывать срабатывание бана для указанного метода из ACL (некоторые методы выполняются по несколько раз на странице и подсчет их запуска - слишком ресурсоёмко)
     *
     * @param $sFuncName    имя метода из ACL
     * @return bool
     */
    private function NeedToGatherStatsForThisMethod($sFuncName)
    {
        return !in_array($sFuncName, Config::Get('plugin.admin.bans.acl_exclude_methods_from_gather_stats'));
    }


    /*
     *
     * --- Наследуемые методы, в которые вшита проверка на бан типа "только чтение" для текущего пользователя ---
     *
     */

    /**
     * Проверяет может ли пользователь создавать блоги
     *
     * @param ModuleUser_EntityUser $oUser
     * @return bool
     */
    public function CanCreateBlog($oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет может ли пользователь создавать топики в определенном блоге
     *
     * @param ModuleUser_EntityUser $oUser
     * @param $oTopicType
     * @return bool
     */
    public function CanAddTopic($oUser, $oTopicType)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет может ли пользователь создавать комментарии
     *
     * @param ModuleUser_EntityUser $oUser
     * @param null $oTopic
     * @return bool
     */
    public function CanPostComment($oUser, $oTopic = null)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет может ли пользователь создавать топик по времени
     *
     * @param ModuleUser_EntityUser $oUser
     * @return bool
     */
    public function CanPostTopicTime($oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет может ли пользователь отправить инбокс по времени
     *
     * @param ModuleUser_EntityUser $oUser
     * @return bool
     */
    public function CanSendTalkTime($oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет может ли пользователь голосовать за конкретный комментарий
     *
     * @param ModuleUser_EntityUser $oUser
     * @param ModuleComment_EntityComment $oComment
     * @return bool
     */
    public function CanVoteComment($oUser, $oComment)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет может ли пользователь голосовать за конкретный топик
     *
     * @param ModuleUser_EntityUser $oUser
     * @param ModuleTopic_EntityTopic $oTopic
     * @param int $iValue
     * @return bool
     */
    public function CanVoteTopic($oUser, $oTopic, $iValue)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }



    /**
     * Проверяет можно ли юзеру слать инвайты
     *
     * @param ModuleUser_EntityUser $oUser
     * @return bool
     */
    public function CanSendInvite($oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет можно или нет юзеру постить в данный блог
     *
     * @param $oBlog
     * @param $oUser
     * @return bool
     */
    public function IsAllowBlog($oBlog, $oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет можно или нет юзеру просматривать блог (fix: просматривать комментарии)
     *
     * @param $oBlog
     * @param $oUser
     * @return bool
     */
    public function IsAllowShowBlog($oBlog, $oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет можно или нет пользователю редактировать данный топик
     *
     * @param $oTopic
     * @param $oUser
     * @return bool
     */
    public function IsAllowEditTopic($oTopic, $oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет можно или нет пользователю удалять данный топик
     *
     * @param $oTopic
     * @param $oUser
     * @return bool
     */
    public function IsAllowDeleteTopic($oTopic, $oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет можно или нет пользователю удалять данный блог
     *
     * @param $oBlog
     * @param $oUser
     * @return bool
     */
    public function IsAllowDeleteBlog($oBlog, $oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет может ли пользователь удалить комментарий
     *
     * @param $oUser
     * @return bool
     */
    public function CanDeleteComment($oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет можно или нет пользователю редактировать данный блог
     *
     * @param $oBlog
     * @param $oUser
     * @return bool
     */
    public function IsAllowEditBlog($oBlog, $oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверяет можно или нет пользователю управлять пользователями блога
     *
     * @param $oBlog
     * @param $oUser
     * @return bool
     */
    public function IsAllowAdminBlog($oBlog, $oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Проверка на ограничение по времени на постинг на стене
     *
     * @param $oUser
     * @param $oWall
     * @return bool
     */
    public function CanAddWallTime($oUser, $oWall)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }


    /**
     * Можно ли редактировать этот комментарий
     *
     * @param $oComment
     * @param $oUser
     * @return bool|mixed
     */
    public function IsAllowEditComment($oComment, $oUser)
    {
        return $this->CheckIfReadOnlyModeForCurrentUserIsSet(__FUNCTION__) ? false : call_user_func_array(array(
                'parent',
                __FUNCTION__
            ), func_get_args());
    }

}

?>