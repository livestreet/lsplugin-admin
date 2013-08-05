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
		$this->SetTemplateAction('users/list');
		$this->SetPaging();

		/*
		 * сортировка
		 */
		$sOrder = getRequestStr('order');
		$sWay = getRequestStr('way');

		/*
		 * поиск по полям
		 */
		$sSearchQuery = getRequestStr('q');
		$aSearchFields = getRequest('field');
		if (!is_array($aSearchFields)) {
			$aSearchFields = (array) $aSearchFields;
		}

		/*
		 * получить правила (фильтр для поиска)
		 */
		$aSearchRules = $this->GetSearchRule($sSearchQuery, $aSearchFields);

		/*
		 * получение пользователей
		 */
		$aResult = $this->PluginAdmin_Users_GetUsersByFilter(
			$aSearchRules,
			array($sOrder => $sWay),
			$this->iPage,
			$this->iPerPage
		);
		$aUsers = $aResult['collection'];

		/*
		 * Формируем постраничность
		 */
		$aPaging = $this->Viewer_MakePaging(
			$aResult['count'],
			$this->iPage,
			$this->iPerPage,
			Config::Get('pagination.pages.count'),
			Router::GetPath('admin') . Router::GetActionEvent() . '/list',
			array()
		);

		$this->Viewer_Assign('aPaging', $aPaging);
		$this->Viewer_Assign('aUsers', $aUsers);

		/*
		 * сортировка
		 */
		$this->Viewer_Assign('sReverseOrder', $this->PluginAdmin_Users_GetReversedOrderDirection ($sWay));
		$this->Viewer_Assign('sOrder', $sOrder);
		$this->Viewer_Assign('sWay', $this->PluginAdmin_Users_GetDefaultOrderDirectionIfIncorrect ($sWay));

		/*
		 * поиск
		 */
		$this->Viewer_Assign('sSearchQuery', $sSearchQuery);
		$this->Viewer_Assign('aSearchFields', $aSearchFields);
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
		if (!$this->iPage = intval(preg_replace('#^page(\d+)$#iu', '$1', $this->GetParam (1)))) {
			$this->iPage = 1;
		}
		$this->iPerPage = Config::Get('plugin.admin.user.per_page');
	}


	/**
	 * Получить правила для поиска по полям
	 *
	 * @param string|array	$aSearchQueries		запросы
	 * @param array 		$aSearchFields		имена полей, по которым будет происходить поиск
	 * @return array							правило для фильтра
	 */
	protected function GetSearchRule ($aSearchQueries, $aSearchFields) {
		$aUserSearchFieldsRules = Config::Get('plugin.admin.user_search_allowed_types');
		$aQueries = array();
		foreach ($aSearchFields as $sField) {
			/*
			 * если имя поля для поиска разрешено
			 */
			if (in_array($sField, array_keys($aUserSearchFieldsRules))) {
				// todo: review: the same query for all fields if not array
				if (is_array($aSearchQueries)) {
					$sQuery = $aSearchQueries [$sField];
				} else {
					$sQuery = $aSearchQueries;
				}
				/*
				 * экранировать спецсимволы
				 */
				$sQuery = str_replace(array('_', '%'), array('\_', '\%'), $sQuery);
				/*
				 * если разрешено искать по данному параметру как по части строки
				 */
				if ($aUserSearchFieldsRules[$sField]['search_as_part_of_string']) {
					/*
					 * искать в любой части строки
					 */
					$sQuery = '%' . $sQuery . '%';
				}
				$aQueries [$sField] = $sQuery;
			}
		}
		return $aQueries;
	}

}

?>