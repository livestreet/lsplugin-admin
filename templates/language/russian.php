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

/**
 * Русский языковой файл
 */
 
return array (

	/*
	 *  Ошибки
   */
	'Errors' => array (
		'Plugin_Need_To_Be_Activated' => 'Плагин должен быть активированым для редактирования настроек',
		'Wrong_Description_Key' => 'Ключ <b>%%key%%</b> в описании настроек указывает на не существующий параметр конфига',
		'Wrong_Config_Name' => 'Неверный ключ имени плагина',
		'Wrong_Parameter_Value' => 'Неверное значение для параметра <b>%%key%%</b>. ',
		'Unknown_Parameter' => 'Передан параметр <b>%%key%%</b>, описание которого нет',
	
	),
	
	/*
	 * Общие
	 */
	'true' => 'Включено (true)',
	'false' => 'Выключено (false)',

	/*
	 * Описание каждого параметра конфига для отображения в админке
	 */
	'config_parameters' => array (
		'test' => array(
			'subarr' => array(
				'name' => 'Количество пользователей на страницу',
				'description' => 'Укажите сколько пользователей нужно отображать на одной странице',
			)
		),
		'moredata' => array(
			'name' => 'Ещё один параметр',
			'description' => 'Укажите новую строку',
		),
		'some_param' => array(
			'name' => 'Параметр булевого типа',
			'description' => 'У вас два варианта ответа',
		),
		'users' => array(
			'min_rating' => array(
				'name' => 'Минимальный рейтинг пользователей',
				'description' => 'Укажите минимальный рейтинг пользователей',
			)
		),
		'sitemap' => array(
			'cache_lifetime' => array(
				'name' => 'Время жизни кеша',
				'description' => 'Укажите время жизни кеша',
			),
			'sitemap_priority' => array(
				'name' => 'Приоритет для сайтмапа',
				'description' => 'Укажите приоритет для сайтмапа',
			)
		),
		'setup_rules' => array(
			'one' => array(
				'name' => 'Набор данных для массива',
				'description' => 'Укажите значения',
			),
		),
	
	),	// /config_parameters

);

?>