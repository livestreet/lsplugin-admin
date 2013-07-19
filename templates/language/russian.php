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
		'Unknown_Parameter_Type' => 'Неизвестный тип параметра',
		
		/*
		 * Ошибки встроенного валидатора массивов
		 */
		'validator' => array(
			'validate_array_must_be_array' => 'Поле %%field%% должно быть массивом',
			'validate_array_too_small' => 'Массив %%field%% слишком маленький (минимально допустимо %%min_items%% элементов)',
			'validate_array_too_big' => 'Массив %%field%% слишком большой (максимально допустимо %%max_items%% элементов)',
			'validate_array_value_is_not_allowed' => 'В массиве %%field%% не должно быть значения %%val%%',
			'validate_array_value_is_too_small' => 'В массиве %%field%% значения не должны быть меньшими чем %%min%%',
			'validate_array_value_is_too_big' => 'В массиве %%field%% значения не должны быть больше чем %%max%%',
		
		),
	
	),
	
	/*
	 * Общие
	 */
	'title' => 'Админка для LiveStreet CMS',
	'true' => 'Включено (true)',
	'false' => 'Выключено (false)',
	'current' => 'текущее',
	
	/*
	 * Список параметров
	 */
	'settings' => array(
		'titles' => array(
			'main_config' => 'Настройки движка LiveStreet',
			'plugin_config' => 'Настройки плагина',
		),
		// для типов параметров (форм)
		'param_type' => array(
			'array' => array(
				'multiple_select_tip' => 'Можно выбирать несколько значений (для этого нажмите ctrl и выбирайте значения)',
			
			),
		
		),

		'no_settings_for_this_plugin' => 'У этого плагина нет настроек или его автор не добавил возможность их редактирования',
	
	),

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