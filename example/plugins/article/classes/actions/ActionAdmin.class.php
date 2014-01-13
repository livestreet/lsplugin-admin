<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

class PluginArticle_ActionAdmin extends PluginAdmin_ActionPlugin {

	protected $oUserCurrent=null;
	public $oAdminUrl;

	public function Init() {
		/**
		 * Получаем текущего пользователя
		 */
		$this->oUserCurrent=$this->User_GetUserCurrent();
		if (!$this->oUserCurrent) {
			$this->Message_AddErrorSingle('Нет доступа');
			return $this->EventError();
		}

		$this->oAdminUrl=Engine::GetEntity('PluginAdmin_ModuleUi_EntityAdminUrl');
		$this->Viewer_AppendScript(Plugin::GetWebPath(__CLASS__) . 'js/admin.js');
	}



	/**
	 * Регистрируем евенты
	 *
	 */
	protected function RegisterEvent() {
		$this->RegisterEventExternal('Ajax','PluginArticle_ActionAdmin_EventAjax');

		$this->AddEventPreg('/^(page(\d{1,5}))?$/i','/^$/i','EventIndex');
		$this->AddEvent('create','EventCreate');
		$this->AddEventPreg('/^update$/i','/^\d{1,6}$/i','/^$/i','EventUpdate');

		/**
		 * Ajax обработка
		 */
		$this->AddEventPreg('/^ajax$/i', '/^article-create$/i','/^$/i', 'Ajax::EventArticleCreate');
		$this->AddEventPreg('/^ajax$/i', '/^article-update$/i','/^$/i', 'Ajax::EventArticleUpdate');
		$this->AddEventPreg('/^ajax$/i', '/^article-remove$/i','/^$/i', 'Ajax::EventArticleRemove');
	}


	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */


	protected function EventIndex() {
		$iPage=$this->GetEventMatch(2) ? $this->GetEventMatch(2) : 1;

		$aResult=$this->PluginArticle_Main_GetArticleItemsByFilter(array('#order'=>array('id'=>'desc'),'#page'=>array($iPage,20)));
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,20,Config::Get('pagination.pages.count'),$this->oAdminUrl->get(null,'article'));

		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aArticleItems',$aResult['collection']);

		$this->SetTemplateAction('index');
	}

	protected function EventCreate() {
		$this->SetTemplateAction('create');
	}

	protected function EventUpdate() {
		if (!($oArticle=$this->PluginArticle_Main_GetArticleById($this->GetParam(0)))) {
			$this->Message_AddErrorSingle('Не удалось найти статью',$this->Lang_Get('error'));
			return $this->EventError();
		}

		$this->Viewer_Assign("oArticle",$oArticle);
		$this->SetTemplateAction('create');
	}
}