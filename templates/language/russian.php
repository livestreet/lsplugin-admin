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

/**
 * Русский языковой файл
 */
 
return array(

	/*
	 * Ошибки
	 */
	'errors' => array(
		'you_are_not_admin' => 'Вы не администратор',
		'plugin_need_to_be_activated' => 'Плагин должен быть активированым для редактирования настроек',
		'wrong_description_key' => 'Ключ <b>%%key%%</b> в описании настроек указывает на не существующий параметр конфига',
		'wrong_config_name' => 'Неверный ключ имени плагина',
		'wrong_parameter_value' => 'Неверное значение для параметра <b>%%key%%</b>. ',
		'unknown_parameter' => 'Передан параметр <b>%%key%%</b>, описание которого нет',
		'unknown_parameter_type' => 'Неизвестный тип параметра',
		'disallowed_parameter_value' => 'Это значение для параметра <b>%%key%%</b> недопустимо. ',
		'some_fields_are_incorrect' => 'В некоторых полях указаны неверные значения',
		
		/*
		 * Ошибки встроенного валидатора массивов
		 */
		'validator' => array(
			'validate_array_must_be_array' => 'Поле %%field%% должно быть массивом',
			'validate_array_too_small' => 'Массив %%field%% слишком маленький (минимально допустимо %%min_items%% элементов)',
			'validate_array_too_big' => 'Массив %%field%% слишком большой (максимально допустимо %%max_items%% элементов)',
			'validate_array_value_is_not_allowed' => 'В массиве %%field%% не должно быть значения %%val%%',
			//'validate_array_value_is_too_small' => 'В массиве %%field%% значения не должны быть меньшими чем %%min%%',  //todo: delete
			//'validate_array_value_is_too_big' => 'В массиве %%field%% значения не должны быть больше чем %%max%%',
			'validate_array_value_is_not_correct' => 'Для массива %%field%% значение %%val%% не является корректным. ',
		
		),

		/*
		 * Ошибки активации шаблона
		 */
		'skin'=>array(
			'activation_version_error' => 'Для работы шаблона необходимо ядро LiveStreet версии не ниже %%version%%',
			'activation_requires_error' => 'Для работы шаблона необходим активированный плагин <b>%%plugin%%</b>',
		),

	),
	
	/*
	 * Общие
	 */
	'title' => 'Админка для LiveStreet CMS',
	'true' => 'Включено(true)',
	'false' => 'Выключено(false)',
	'current' => 'текущее',
	
	/*
	 * Уведомления
	 */
	'notices' => array(
		'template_changed' => 'Шаблон изменён',
		'template_preview_set' => 'Для вас установлен режим предпросмотра шаблона. Откройте главную страницу сайта и рассмотрите шаблон. Когда захотите отключить предпросмотр - нажмите на ссылку в уведомлении',
		'template_preview_turned_off' => 'Предпросмотр шаблона отключен',
		'theme_changed' => 'Тема изменёна',
	),
	
	/*
	 * Шаблоны
	 */
	'skin' => array(
		'use_skin' => 'Включить',
		'preview_skin' => 'Предпросмотр',
		'current_skin' => 'Включен сейчас',
		
		'this_is_preview' => 'Включен предпросмотр выбранного шаблона, который доступен только вам.',
		'turn_off_preview' => 'Выключить предпросмотр шаблона',
		'change_theme' => 'Изменить тему',
	
	),
	
	/*
	 * Список параметров
	 */
	'settings' => array(
		'titles' => array(
			'main_config' => 'Настройки движка LiveStreet',
			'plugin_config' => 'Настройки плагина',
			'skin_config' => 'Другие доступные шаблоны',
			'current_skin' => 'Текущий активный шаблон',
		),

		'no_settings_for_this_plugin' => 'У этого плагина нет настроек или его автор не добавил возможность их редактирования',
	
	),

	/*
	 * Описание каждого параметра конфига для отображения в админке
	 */
	'config_parameters' => array(
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