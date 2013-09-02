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
		'wrong_description_key' => 'Ключ <b>%%key%%</b> в описании настроек указывает на несуществующий параметр конфига. Этот параметр пропущен',
		'wrong_config_name' => 'Неверный ключ имени плагина',
		'wrong_parameter_value' => 'Неверное значение для параметра <b>%%key%%</b>. ',
		'unknown_parameter' => 'Передан параметр <b>%%key%%</b>, описание которого нет',
		'unknown_parameter_type' => 'Неизвестный тип параметра',
		'disallowed_parameter_value' => 'Это значение для параметра <b>%%key%%</b> недопустимо. ',
		'disallowed_settings_by_inheriting_plugin' => 'Набор данных значений для параметров запрещен для сохранения: ',
		'some_fields_are_incorrect' => 'В некоторых полях указаны неверные значения',
		
		/*
		 * Ошибки встроенного валидатора массивов
		 */
		'validator' => array(
			'validate_array_must_be_array' => 'Поле %%field%% должно быть массивом',
			'validate_array_too_small' => 'Массив %%field%% слишком маленький (минимально допустимо %%min_items%% элементов)',
			'validate_array_too_big' => 'Массив %%field%% слишком большой (максимально допустимо %%max_items%% элементов)',
			'validate_array_value_is_not_allowed' => 'В массиве %%field%% не должно быть значения %%val%%',
			'validate_array_value_is_not_correct' => 'Для массива %%field%% значение %%val%% не является корректным. ',
		
		),

		/*
		 * Ошибки активации шаблона
		 */
		'skin'=>array(
			'activation_version_error' => 'Для работы шаблона необходимо ядро LiveStreet версии не ниже %%version%%',
			'activation_requires_error' => 'Для работы шаблона необходим активированный плагин <b>%%plugin%%</b>',
		),
		/*
		 * Ошибки банов
		 */
		'bans' => array(
			'wrong_ban_id' => 'Неверный id бана',
		),

	),
	
	/*
	 * Общие
	 */
	'title' => 'Админка для LiveStreet CMS',
	'true' => 'Включено (true)',
	'false' => 'Выключено (false)',
	'current' => 'текущее',
	'on_page' => 'На странице',
	'delete' => 'Удалить',
	
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

		'author' => 'Автор',
		'homepage' => 'Сайт',
		'version' => 'Версия',
		'description' => 'Описание',
		'themes' => 'Темы',

	),

	/*
	 * Пользователи
	 */
	'users' => array(
		'title' => 'Пользователи',
		/*
		 * поиск по
		 */
		'search_allowed_in' => array(
			'id' => 'id',
			'mail' => 'почте',
			'password' => 'хеше пароля',
			'ip_register' => 'ip регистрации',
			'activate' => 'активирован ли',
			'activate_key' => 'ключе активации',
			'profile_sex' => 'стать',
			'login' => 'логин',
			'profile_name' => 'имени профиля',
			'session_ip_last' => 'ip последнего входа',
			'admins_only' => 'только админы',
		),
		'search' => 'Поиск',
		/*
		 * заголовок таблицы списка пользователей
		 */
		'table_header' => array(
			'name' => 'Имя',
			'birth' => 'Родился',
			'reg_and_last_visit' => 'Регистрация и визит',
			'ip' => 'IP-адрес',
			'rating_and_skill' => 'Рейтинг и сила',

		),
		/*
		 * списки голосов
		 */
		'votes' => array(
			'title' => 'Списки голосов пользователя',
			'no_votes' => 'Пользователь не голосовал в выбранном направлении',
			'votes_for' => 'Список голосов за',
			'votes_type' => array(
				'topic' => 'топики',
				'blog' => 'блоги',
				'user' => 'пользователей',
				'comment' => 'комментарии',
			),
			/*
			 * заголовок таблицы списка голосов
			 */
			'table_header' => array(
				'target_id' => 'id объекта',
				'vote_direction' => 'направление',
				'vote_value' => 'прирост',
				'vote_date' => 'дата голосования',
				'vote_ip' => 'ip-адрес',
				'target_object' => 'объект',
			),
			'back_to_user_profile_page' => '&larr; Назад на страницу данных пользователя',
		),
		/*
		 * страница данных о пользователе (профиль админки)
		 */
		'profile' => array(
			'edit_user_rating' => 'Редактировать',
			'user_no' => 'Пользователь №',

		),


	),

	/*
	 * Список банов
	 */
	'bans' => array(
		'title' => 'Список банов',
		'add' => 'Запретить вход на сайт для пользователя',
		'back_to_list' => '&larr; Назад к списку банов',
		/*
		 * заголовок таблицы списка банов
		 */
		'table_header' => array(
			'block_type' => 'Тип блокировки',
			'user_id' => 'id юзера',
			'ip' => 'ip',
			'ip_start' => 'с ip',
			'ip_finish' => 'по ip',

			'time_type' => 'Тип времени блокировки',
			'date_start' => 'Дата начала',
			'date_finish' => 'Дата окончания',

			'add_date' => 'Добавлен',
			'edit_date' => 'Отредактирован',

			'reason_for_user' => 'Причина',
			'comment' => 'Комментарий для себя',
		),
		'you_are_banned' => 'Вам запрещен доступ к сайту с <b>%%date_start%%</b> по <b>%%date_finish%%</b>. Причина: <i>%%reason%%</i>.',
		'permanently_banned' => 'Вам запрещен доступ к сайту навсегда. Причина: <i>%%reason%%</i>.',
		/*
		 * аякс проверка правила для бана на корректность
		 */
		'user_sign_check' => array(
			'wrong_rule' => 'Правило не распознано',
			'user' => 'Пользователь <b>%%login%%</b> (id = <b>%%id%%</b>, e-mail = <b>%%mail%%</b>)',
			'ip' => 'IP-адрес',
			'ip_range' => 'Диапазон IP-адресов',
		),
		'add_ban' => 'Добавить бан',
		/*
		 * список
		 */
		'list' => array(
			'block_type' => array(
				'user' => 'пользователь',
				'ip' => 'ip',
				'ip_range' => 'диапазон ip',
			),
			'time_type' => array(
				'permanent' => 'постоянный',
				'period' => 'период',
			),
			'no_bans' => 'Забаненых пользователей пока нет',
			'current_date_on_server' => 'Текущая дата и время на сервере',
			'this_ban_triggered' => 'Данный бан сработал (заблокировал пользователя) %%count%% раз',
		),

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
	 * Описание каждого параметра конфига для отображения в админке (temp)
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