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
 * Обрабокта жалоб на пользователей
 *
 */

class PluginAdmin_ActionTickets_EventClaims extends Event {


	/**
	 * Страница добавления жалобы
	 */
	public function EventAddClaim() {
		$this->SetTemplateAction('claims/add');
		/*
		 * есть ли такой пользователь
		 */
		if (!$oUser = $this->User_GetUserById((int) $this->getParam(1))) {
			$this->Message_AddError('', $this->Lang('errors.tickets.claims.wrong_user_id'));
			return Router::Action('error');
		}
		/*
		 * если была отправка данных
		 */
		if (isPost('submit_claim')) {
			$this->PerformAddClaim();
		}

		$this->Viewer_Assign('oUser', $oUser);
	}


	/**
	 * Выполнить процесс добавления жалобы
	 */
	protected function PerformAddClaim() {
		$this->Security_ValidateSendForm();

		/*
		 * получить тип жалобы
		 */
		if (!$sType = strip_tags(getRequestStr('type')) or !in_array($sType, Config::Get('plugin.admin.tickets.claims.types'))) {
			return Router::Action('error');
		}
		/*
		 * текст
		 */
		$sText = $this->Text_JevixParser(getRequestStr('text'));
		/*
		 * нужна ли проверка каптчи
		 */
		if (Config::Get('plugin.admin.tickets.claims.use_captcha')) {
			if ($this->Validate_Validate('captcha', getRequestStr('captcha')) !== true) {
				$this->Message_AddError($this->Validate_GetErrorLast(), $this->Lang_Get('error'));
				return false;
			}
		}



	}


}

?>