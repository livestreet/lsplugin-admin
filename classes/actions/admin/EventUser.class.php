<?php

class PluginAdmin_ActionAdmin_EventUser extends Event {

	/**
	 * Список пользователей
	 */
	public function EventUserList() {

		/**
		 * Строим фильтр
		 */

		/**
		 * Определяем сортировку
		 */

		/**
		 * Определяем постраничность
		 */
		$iPage=1;

		$aResult=$this->PluginAdmin_User_GetUsersByFilter(array(),array(),$iPage,Config::Get('plugin.admin.user.per_page'));
		$aUsers=$aResult['collection'];
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('plugin.admin.user.per_page'),Config::Get('pagination.pages.count'),Router::GetPath('people').'index',array());
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aUsers',$aUsers);

		$this->SetTemplateAction('user/list');
	}

	public function EventUser() {


		if (getRequestStr('ok')) {
			return $this->EventNotFound();
		}

		$aArr=$this->aItem;
		$aArr[]=3;
		$this->aItem=$aArr;

		//$this->aItem=9;
		//array_push($this->aItem,5);
		if (in_array(4,$this->aItem)) {
			//var_dump('OK');
		}
		//var_dump($this->aItem);
		$this->test('est!!!');

		//$this->SetTemplateaction('index');
		$this->SetTemplate(false);
	}



	public function EventShowTopic() {
		if ($this->oUserCurrent) {
			var_dump('User id: '.$this->oUserCurrent->getId());
		}

		var_dump('Topic id: '.$this->GetParamEventMatch(0,1));

		$this->SetTemplate(false);
	}

}