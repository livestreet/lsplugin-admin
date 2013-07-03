<?php

class PluginAdmin_ModuleUser extends Module {

	protected $oMapper=null;

	public function Init() {
		$this->oMapper=Engine::GetMapper(__CLASS__);
	}


	/**
	 * Возвращает список пользователей по фильтру
	 *
	 * @param array $aFilter	Фильтр
	 * @param array $aOrder	Сортировка
	 * @param int $iCurrPage	Номер страницы
	 * @param int $iPerPage	Количество элментов на страницу
	 * @param array $aAllowData	Список типо данных для подгрузки к пользователям
	 * @return array('collection'=>array,'count'=>int)
	 */
	public function GetUsersByFilter($aFilter,$aOrder,$iCurrPage,$iPerPage,$aAllowData=null) {
		if (is_null($aAllowData)) {
			$aAllowData=array('session');
		}
		$data = array('collection'=>$this->oMapper->GetUsersByFilter($aFilter,$aOrder,$iCount,$iCurrPage,$iPerPage),'count'=>$iCount);
		$data['collection']=$this->User_GetUsersAdditionalData($data['collection'],$aAllowData);
		return $data;
	}
	
}

?>