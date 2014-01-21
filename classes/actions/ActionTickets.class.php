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
 * Обработка жалоб на пользователя и функции обратной связи
 *
 */

class PluginAdmin_ActionTickets extends ActionPlugin {

	/*
	 * текущий пользователь (если авторизирован)
	 */
	protected $oUserCurrent = null;


	public function Init() {
		/*
		 * могут пользоватся даже не авторизированные пользователи
		 */
		$this->oUserCurrent = $this->User_GetUserCurrent();
		/*
		 * по-умолчанию показывать главную страницу
		 */
		$this->SetDefaultEvent('index');
		$this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.admin.title'));
		$this->Hook_Run('init_action_admin_tickets');
	}


	/**
	 * Регистрация эвентов
	 */
	protected function RegisterEvent() {
		/*
		 *
		 * --- Регистрируем внешние обработчики евентов ---
		 *
		 */

		/*
		 * Жалобы на пользователей
		 */
		$this->RegisterEventExternal('Claims', 'PluginAdmin_ActionTickets_EventClaims');


		/*
		 *
		 * --- Эвенты ---
		 *
		 */

		/*
		 *
		 * --- Жалобы на пользователей ---
		 *
		 */

		/*
		 * Страница добавления жалобы
		 */
		$this->AddEventPreg('#^claim$#iu', '#^add$#iu', '#^\d{1,5}$#iu', 'Claims::EventAddClaim');
	}


	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */


	/*
	 *
	 * --- Хелперы ---
	 *
	 */

	/**
	 * Делает редирект на страницу, с которой пришел запрос
	 */
	public function RedirectToReferer() {
		Router::Location(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : Router::GetPath('admin'));
		return false;
	}


	/**
	 * Быстрое получение текстовки плагина без указания префикса
	 *
	 * @param $sKey		ключ языкового файла (без префикса plugin.имяплагина.)
	 * @param $aParams	параметры подстановки значений для передачи в текстовку
	 * @return mixed	значение
	 */
	public function Lang($sKey, $aParams = array()) {
		return $this->Lang_Get('plugin.admin.' . $sKey, $aParams);
	}


	/**
	 * Получить значение из фильтра (массива-переменной "filter" из реквеста) или весь фильтр
	 *
	 * @param $sName				имя ключа из массива фильтра или null для получения всего фильтра
	 * @return mixed|array|null		значение
	 */
	protected function GetDataFromFilter($sName = null) {
		/*
		 * получить фильтр, хранящий в себе все параметры (разрезы показа, сортировку, поиск и др.)
		 */
		if ($aFilter = getRequest('filter') and is_array($aFilter)) {
			/*
			 * если нужны все значения фильтра
			 */
			if (!$sName) {
				return $aFilter;
			}
			/*
			 * если нужно выбрать одно значение из фильтра
			 */
			if ($sName and isset($aFilter[$sName]) and $aFilter[$sName]) {
				return $aFilter[$sName];
			}
		}
		return null;
	}
	
	
	public function EventShutdown() {

	}


}

?>