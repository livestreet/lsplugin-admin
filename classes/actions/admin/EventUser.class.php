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

	}
	
	

	public function EventShowTopic() {

	}

}

?>