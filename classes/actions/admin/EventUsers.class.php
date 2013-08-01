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

class PluginAdmin_ActionAdmin_EventUsers extends Event {

	/*
	 * страница результатов
	 */
	protected $iPage = 1;

	/*
	 * результатов на страницу
	 */
	protected $iPerPage = 20;


	/**
	 * Список пользователей
	 */
	public function EventUsersList() {
		$this -> SetTemplateAction('users/list');
		$this -> SetPaging();

		$sOrder = getRequestStr('order');
		$sWay = getRequestStr('way');

		$aResult = $this -> PluginAdmin_Users_GetUsersByFilter(
			array(),
			array($sOrder => $sWay),
			$this -> iPage,
			$this -> iPerPage
		);
		$aUsers = $aResult['collection'];
		/**
		 * Формируем постраничность
		 */
		$aPaging = $this -> Viewer_MakePaging($aResult['count'],
			$this -> iPage,
			$this -> iPerPage,
			Config::Get('pagination.pages.count'),
			Router::GetPath('people').'index',
			array()
		);

		$this->Viewer_Assign('aPaging', $aPaging);
		$this->Viewer_Assign('aUsers', $aUsers);

		/*
		 * сортировка
		 */
		$this->Viewer_Assign('sReverseOrder', $this -> PluginAdmin_Users_GetReversedOrderDirection ($sWay));
		$this->Viewer_Assign('sOrder', $sOrder);
		$this->Viewer_Assign('sWay', $sWay);
	}


	/**
	 * Задать страницу и к-во элементов пагинации
	 */
	protected function SetPaging () {
		$this -> iPage = preg_replace ('#^page(\d+)#iu', '$1', $this -> GetParam (1));
		if (!$this -> iPage) {
			$this -> iPage = 1;
		}
		$this -> iPerPage = Config::Get('plugin.admin.user.per_page');
	}
	
}

?>