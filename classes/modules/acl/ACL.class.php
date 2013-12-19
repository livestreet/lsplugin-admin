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

class PluginAdmin_ModuleACL extends PluginAdmin_Inherits_ModuleACL {


	/**
	 * Проверить включен ли для текущего пользователя режим "только чтение"
	 *
	 * @return bool
	 */
	private function CheckIfReadOnlyModeForCurrentUserIsSet() {
		/*
		 * если пользователь переведен в режим "только чтение" - запретить ему любое действие
		 */
		if ($oBan = $this->PluginAdmin_Users_IsCurrentUserBannedForReadOnly()) {
			/*
			 * добавить запись о срабатывании бана в статистику
			 */
			$this->PluginAdmin_Users_AddBanTriggering($oBan);
			/*
			 * сообщение пользователю в зависимости от типа бана (временный или постоянный)
			 */
			$this->Message_AddError($oBan->getBanMessageForUser(), '403');
			return true;
		}
		return false;
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
	public function CanCreateBlog(ModuleUser_EntityUser $oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь создавать топики в определенном блоге
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @param ModuleBlog_EntityBlog $oBlog
	 * @return bool
	 */
	public function CanAddTopic(ModuleUser_EntityUser $oUser, ModuleBlog_EntityBlog $oBlog) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь создавать комментарии
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @param null                  $oTopic
	 * @return bool
	 */
	public function CanPostComment(ModuleUser_EntityUser $oUser,$oTopic = null) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь создавать комментарии по времени(например ограничение максимум 1 коммент в 5 минут)
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @return bool
	 */
	public function CanPostCommentTime(ModuleUser_EntityUser $oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь создавать топик по времени
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @return bool
	 */
	public function CanPostTopicTime(ModuleUser_EntityUser $oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь отправить инбокс по времени
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @return bool
	 */
	public function CanSendTalkTime(ModuleUser_EntityUser $oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь создавать комментарии к инбоксу по времени
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @return bool
	 */
	public function CanPostTalkCommentTime(ModuleUser_EntityUser $oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь голосовать за конкретный комментарий
	 *
	 * @param ModuleUser_EntityUser       $oUser
	 * @param ModuleComment_EntityComment $oComment
	 * @return bool
	 */
	public function CanVoteComment(ModuleUser_EntityUser $oUser, ModuleComment_EntityComment $oComment) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь голосовать за конкретный блог
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @param ModuleBlog_EntityBlog $oBlog
	 * @return bool
	 */
	public function CanVoteBlog(ModuleUser_EntityUser $oUser, ModuleBlog_EntityBlog $oBlog) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь голосовать за конкретный топик
	 *
	 * @param ModuleUser_EntityUser   $oUser
	 * @param ModuleTopic_EntityTopic $oTopic
	 * @return bool
	 */
	public function CanVoteTopic(ModuleUser_EntityUser $oUser, ModuleTopic_EntityTopic $oTopic) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь голосовать за конкретного пользователя
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @param ModuleUser_EntityUser $oUserTarget
	 * @return bool
	 */
	public function CanVoteUser(ModuleUser_EntityUser $oUser, ModuleUser_EntityUser $oUserTarget) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет можно ли юзеру слать инвайты
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @return bool
	 */
	public function CanSendInvite(ModuleUser_EntityUser $oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет можно или нет юзеру постить в данный блог
	 *
	 * @param $oBlog
	 * @param $oUser
	 * @return bool
	 */
	public function IsAllowBlog($oBlog,$oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет можно или нет юзеру просматривать блог (fix: просматривать комментарии)
	 *
	 * @param $oBlog
	 * @param $oUser
	 * @return bool
	 */
	public function IsAllowShowBlog($oBlog,$oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет можно или нет пользователю редактировать данный топик
	 *
	 * @param $oTopic
	 * @param $oUser
	 * @return bool
	 */
	public function IsAllowEditTopic($oTopic,$oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет можно или нет пользователю удалять данный топик
	 *
	 * @param $oTopic
	 * @param $oUser
	 * @return bool
	 */
	public function IsAllowDeleteTopic($oTopic,$oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет можно или нет пользователю удалять данный блог
	 *
	 * @param $oBlog
	 * @param $oUser
	 * @return bool
	 */
	public function IsAllowDeleteBlog($oBlog,$oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь удалить комментарий
	 *
	 * @param $oUser
	 * @return bool
	 */
	public function CanDeleteComment($oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет может ли пользователь публиковать на главной
	 *
	 * @param ModuleUser_EntityUser $oUser
	 * @return bool
	 */
	public function IsAllowPublishIndex(ModuleUser_EntityUser $oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет можно или нет пользователю редактировать данный блог
	 *
	 * @param $oBlog
	 * @param $oUser
	 * @return bool
	 */
	public function IsAllowEditBlog($oBlog,$oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверяет можно или нет пользователю управлять пользователями блога
	 *
	 * @param $oBlog
	 * @param $oUser
	 * @return bool
	 */
	public function IsAllowAdminBlog($oBlog,$oUser) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}


	/**
	 * Проверка на ограничение по времени на постинг на стене
	 *
	 * @param $oUser
	 * @param $oWall
	 * @return bool
	 */
	public function CanAddWallTime($oUser,$oWall) {
		return $this->CheckIfReadOnlyModeForCurrentUserIsSet() ? false : call_user_func_array(array('parent', __FUNCTION__), func_get_args());
	}

}

?>