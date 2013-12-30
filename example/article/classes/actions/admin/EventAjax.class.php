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
 */

class PluginArticle_ActionAdmin_EventAjax extends Event {

	public function Init() {
		/**
		 * Устанавливаем формат ответа
		 */
		$this->Viewer_SetResponseAjax('json');
	}

	public function EventArticleCreate() {
		/**
		 * Создаем статью
		 */
		$oArticle=Engine::GetEntity('PluginArticle_ModuleMain_EntityArticle');
		$oArticle->_setDataSafe(getRequest('article'));
		$oArticle->setUserId($this->oUserCurrent->getId());
		if ($oArticle->_Validate()) {
			if ($oArticle->Add()) {
				$this->Viewer_AssignAjax('sUrlRedirect',$this->oAdminUrl->get(null,'article'));
				$this->Message_AddNotice('Добавление прошло успешно',$this->Lang_Get('attention'));
			} else {
				$this->Message_AddError('Возникла ошибка при добавлении',$this->Lang_Get('error'));
			}
		} else {
			$this->Message_AddError($oArticle->_getValidateError(),$this->Lang_Get('error'));
		}
	}

	public function EventArticleUpdate() {
		$aArticleRequest=getRequest('article');
		if (!(isset($aArticleRequest['id']) and $oArticle=$this->PluginArticle_Main_GetArticleById($aArticleRequest['id']))) {
			$this->Message_AddErrorSingle('Не удалось найти статью',$this->Lang_Get('error'));
			return;
		}
		/**
		 * Обновляем статью
		 */
		$oArticle->_setDataSafe($aArticleRequest);
		if ($oArticle->_Validate()) {
			if ($oArticle->Update()) {
				$this->Message_AddNotice('Обновление прошло успешно',$this->Lang_Get('attention'));
			} else {
				$this->Message_AddError('Возникла ошибка при обновлении',$this->Lang_Get('error'));
			}
		} else {
			$this->Message_AddError($oArticle->_getValidateError(),$this->Lang_Get('error'));
		}
	}

	public function EventArticleRemove() {
		if (!($oArticle=$this->PluginArticle_Main_GetArticleById(getRequestStr('id')))) {
			$this->Message_AddErrorSingle('Не удалось найти статью',$this->Lang_Get('error'));
			return;
		}

		if ($oArticle->Delete()) {
			$this->Message_AddNoticeSingle("Удаление прошло успешно");
		} else {
			$this->Message_AddErrorSingle("Ошибка при удалении");
		}
	}
}
