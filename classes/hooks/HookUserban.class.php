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

class PluginAdmin_HookUserban extends Hook {

	protected $oUserCurrent = null;


	public function RegisterHook() {
		/*
		 * обработка старых банов, сообщение текущему пользователю что он под баном
		 */
		$this->AddHook('engine_init_complete', 'EngineInitComplete', __CLASS__, -PHP_INT_MAX);	// наименьший приоритет, который можно установить
		/*
		 * чтобы в профиле админки указать забанен пользователь или нет
		 */
		$this->AddHook('template_admin_user_profile_brief_aside', 'AdminUserProfileBriefAside');
		/*
		 * чтобы в профиле пользователя на сайте указать забанен пользователь или нет
		 */
		$this->AddHook('template_user_info_begin', 'AdminUserProfileBriefAside');
	}


	/**
	 * Обработка старых банов, сообщение текущему пользователю что он под баном
	 */
	public function EngineInitComplete() {
		/*
		 * удалить старые записи банов
		 */
		$this->PluginAdmin_Users_DeleteOldBanRecords();
		/*
		 * если текущий пользователь попадает под условия бана - показать ему сообщение
		 */
		$this->CheckUserBan();
	}


	/**
	 * Проверка бана текущего пользователя
	 */
	protected function CheckUserBan() {
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
	 * @param $oBan		объект бана
	 */
	protected function ShowBanMessage($oBan) {
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
	 * @param $aVars	передаваемые параметры
	 * @return mixed
	 */
	public function AdminUserProfileBriefAside($aVars) {
		/*
		 * видно либо хозяину профиля либо админам (этот метод добавлен в профиль админки и на сайте)
		 */
		if ($this->oUserCurrent = $this->User_GetUserCurrent() and $oBan = $aVars['oUserProfile']->getBanned()) {
			$this->Viewer_Assign('oBan', $oBan);
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'actions/ActionAdmin/users/profile_user_banned_msg.tpl');
		}
	}

}

?>