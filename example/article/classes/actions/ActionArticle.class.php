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

class PluginArticle_ActionArticle extends ActionPlugin {

	public function Init() {
		/**
		 * Получаем текущего пользователя
		 */
		$this->oUserCurrent=$this->User_GetUserCurrent();
	}

	/**
	 * Регистрируем евенты
	 *
	 */
	protected function RegisterEvent() {
		$this->AddEventPreg('/^(page(\d{1,5}))?$/i','/^$/i',array('EventIndex','index'));
		$this->AddEventPreg('/^view$/i',"/^\d{1,6}$/i",'EventArticleShow');
		$this->AddEventPreg('/^tag$/i','/^.+$/i','/^(page([1-9]\d{0,5}))?$/i',"/^$/i",'EventTag');
	}


	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */


	protected function EventIndex() {
		$iPage=$this->GetEventMatch(2) ? $this->GetEventMatch(2) : 1;

		$aFilter=array('#properties'=>true,'#order'=>array('id'=>'desc'));
		$aFilter['#page']=array($iPage,Config::Get('plugin.article.per_page'));

		$aResult=$this->PluginArticle_Main_GetArticleItemsByFilter($aFilter);
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('plugin.article.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('article'));

		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aArticleItems',$aResult['collection']);
		$this->SetTemplateAction('index');
	}

	protected function EventArticleShow() {
		$iId=$this->GetParam(0);
		if (!($oArticle=$this->PluginArticle_Main_GetArticleById($iId))) {
			return $this->EventNotFound();
		}

		$this->Viewer_Assign('oArticle',$oArticle);
		$this->Viewer_AddHtmlTitle(htmlspecialchars_decode($oArticle->getTitle()));
		$this->SetTemplateAction('view');
	}

	protected function EventTag() {
		/**
		 * Получаем тег из УРЛа
		 */
		$sTag=$this->GetParam(0);
		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(1,2) ? $this->GetParamEventMatch(1,2) : 1;
		/**
		 * Получаем список статей
		 */
		$aResult=$this->PluginArticle_Main_GetArticleItemsByTag($sTag,$iPage,Config::Get('plugin.article.per_page'));
		$aArticles=$aResult['collection'];
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('plugin.article.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('article/tag').htmlspecialchars($sTag));
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aArticleItems',$aArticles);
		$this->Viewer_Assign('sTag',$sTag);
		$this->Viewer_AddHtmlTitle('Поиск по тегу');
		$this->Viewer_AddHtmlTitle($sTag);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('tag');
	}

}