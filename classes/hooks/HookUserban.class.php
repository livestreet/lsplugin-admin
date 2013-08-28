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
 * @author PSNet <light.feel@gmail.com>
 * 
 */

/*
 *
 * Работа с банами пользователей
 *
 */

class PluginAdmin_HookUserban extends Hook {

	public function RegisterHook() {
		$this->AddHook('engine_init_complete', 'EngineInitComplete', __CLASS__, -PHP_INT_MAX);	// наименьший приоритет, который можно установить
	}


	public function EngineInitComplete() {
		/*
		 * если текущий пользователь попадает под условия бана - показать ему сообщение
		 */
		$this->CheckUserBan();
	}


	/**
	 * Проверка бана
	 */
	protected function CheckUserBan() {
		if ($oBan = $this->PluginAdmin_Users_IsThisUserBanned()) {
			header('HTTP/1.1 403');
			$this->Message_AddError($this->Lang_Get('plugin.admin.bans.you_are_banned', array(
				'date_start' => $oBan->getDateStart(),
				'date_finish' => $oBan->getDateFinish(),
				'reason' => $oBan->getReasonForUser(),
			)), '403');
			$this->User_Logout();
			Router::Action('error');
		}
	}

}

?>