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

		/*
		 * сортировка
		 */
		$sOrder = getRequestStr('order');
		$sWay = getRequestStr('way');

		/*
		 * поиск по полям
		 */
		$sSearchQuery = getRequestStr('q');
		$sSearchField = getRequestStr('field');
		$sSearchType = getRequestStr('type');

		/*
		 * получение пользователей
		 */
		$aResult = $this -> PluginAdmin_Users_GetUsersByFilter(
			$this -> GetSearchRule($sSearchQuery, $sSearchField, $sSearchType),
			array($sOrder => $sWay),
			$this -> iPage,
			$this -> iPerPage
		);
		$aUsers = $aResult['collection'];

		/*
		 * Формируем постраничность
		 */
		$aPaging = $this -> Viewer_MakePaging(
			$aResult['count'],
			$this -> iPage,
			$this -> iPerPage,
			Config::Get('pagination.pages.count'),
			Router::GetPath('admin') . Router::GetActionEvent() . '/list',
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

		/*
		 * поиск
		 */
		$this->Viewer_Assign('sSearchQuery', $sSearchQuery);
		$this->Viewer_Assign('sSearchField', $sSearchField);
		$this->Viewer_Assign('sSearchType', $sSearchType);
	}


	/**
	 * Изменить количество пользователей на странице
	 */
	public  function EventAjaxUsersOnPage () {
		$this->Viewer_SetResponseAjax('json');
		$this->PluginAdmin_Users_ChangeUsersPerPage(getRequestStr('onpage'));
	}


	/**
	 * Задать страницу и количество элементов в пагинации
	 */
	protected function SetPaging () {
		if (!$this -> iPage = intval(preg_replace ('#^page(\d+)$#iu', '$1', $this -> GetParam (1)))) {
			$this -> iPage = 1;
		}
		$this -> iPerPage = Config::Get('plugin.admin.user.per_page');
	}


	/**
	 * Получить правило для поиска
	 *
	 * @param $sQuery		запрос
	 * @param $sField		имя поля, по которому будет поиск
	 * @param $sType		тип поиска (точный, префикс и т.п.)
	 * @return array		правило для фильтра
	 */
	protected function GetSearchRule ($sQuery, $sField, $sType) {
		/*
		 * если был поиск
		 */
		if (isPost('submit_search')) {
			/*
			 * имя поля для поиска разрешено
			 */
			if (in_array($sField, Config::Get('plugin.admin.user_search_allowed_types'))) {
				/*
				 * экранировать спецсимволы
				 */
				$sQuery = str_replace(array('_', '%'), array('\_', '\%'), $sQuery);

				/*
				 * тип поиска
				 */
				switch ($sType) {
					case 'exact':
						break;
					case 'prefix':
						$sQuery .= '%';
						break;
					case 'postfix':
						$sQuery = '%' . $sQuery;
						break;
					case 'any':
						$sQuery = '%' . $sQuery . '%';
						break;
					default:
						break;
				}
				return array($sField => $sQuery);
			}
		}
		return array();
	}
	
}

?>