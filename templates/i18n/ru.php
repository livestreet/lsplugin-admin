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
	 * Общие
	 */
	'title' => 'Админка для LiveStreet CMS',
	'true' => 'Включено (true)',
	'false' => 'Выключено (false)',
	'current' => 'текущее',
	'on_page' => 'На странице',
	'delete' => 'Удалить',
	'from' => 'с',
	'to' => 'по',
	'show' => 'Показать',
	'reset_zoom' => 'Сбросить зум',
	'reset_zoom_tip' => 'Показать 1 к 1',
	'save' => 'Сохранить',
	'add' => 'Добавить',

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
			'unknown_rule_sign' => 'Неверное правило поиска пользователя',
			'unknown_ban_timing_rule' => 'Неверный интервал времени бана %%type%%. Должен быть "unlimited", "period" или "days"',
			'incorrect_period_from' => 'Неверная дата старта (должна быть в формате YYYY-mm-dd)',
			'incorrect_period_to' => 'Неверная дата финиша (должна быть в формате YYYY-mm-dd)',
			'period_to_must_be_greater_than_from' => 'Дата финиша должна быть больше даты начала',
			'incorrect_days_count' => 'Неверно указано количество дней для бана',
			'incorrect_user_id' => 'Неверный id пользователя',
			'incorrect_admins_action_type' => 'Некорректная операция с админами',
			'delete_admin_rights_first' => 'Этот пользователь - администратор. Удалите права админа у пользователя сначала',
		),
		/*
		 * Ошибки статистики пользователей
		 */
		'stats' => array(
			'wrong_date_range' => 'Неверный диапазон дат: дата финиша должна быть больше даты начала',
			'wrong_dates' => 'Неверный формат дат: даты должны быть в формате ГГГГ-ММ-ДД или ГГГГ-ММ-ДД ЧЧ:ММ:СС',
		),

	),
	
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
				'user' => 'других пользователей',
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
			'top_bar' => array(
				'msg' => 'Сообщение',
				'admin_delete' => 'Удалить из админов',
				'admin_add' => 'В администраторы',
				'content_delete' => 'Удалить контент',
				'user_delete' => 'Удалить пользователя',
				'ban' => 'Блокировать',
			),
			'middle_bar' => array(
				'profile' => 'Профиль',
				'publications' => 'Публикации',
				'activity' => 'Активность',
				'friends' => 'Друзья',
				'wall' => 'Стена',
				'fav' => 'Избранное',
			),
			'edit_user_rating' => 'Редактировать',
			'skill' => 'Сила',
			'rating' => 'Рейтинг',
			'user_no' => 'Пользователь №',
			'info' => array(
				'resume' => 'Досье',
				'mail' => 'Почта',
				'sex' => 'Пол',
				'birthday' => 'Родился',
				'living' => 'Откуда',
				'reg_date' => 'Зарегистрирован',
				'ip' => 'IP',
				'last_visit' => 'Последний визит',
				'search_this_ip' => 'Искать с этим IP',
				'stats_title' => 'Статистика',
				'created' => 'Создал',
				'topics' => 'топиков',
				'comments' => 'комментариев',
				'blogs' => 'блогов',
				'fav' => 'В избранном',
				'reads' => 'Читает',
				'has' => 'Имеет',
				'friends' => 'друзей',
				'votings_title' => 'Как голосовал',
				'for_topics' => 'За топики',
				'for_comments' => 'За комментарии',
				'for_blogs' => 'За блоги',
				'for_users' => 'За юзеров',
			),

		),


	),

	/*
	 * Список банов
	 */
	'bans' => array(
		'title' => 'Список банов',
		/*
		 * добавление бана
		 */
		'add' => array(
			'title' => 'Запретить вход на сайт для пользователя',
			'user_sign' => 'Идентификация пользователя',
			'user_sign_info' => 'Введите id (1091), логин (userlogin) или почту (user@mail.com) зарегистрированного пользователя или
			ip-адрес (192.168.0.10) или диапазон ip-адресов (192.168.0.10 - 192.168.0.100) для блокировки',
			'ban_time_title' => 'Срок действия бана',
			/*
			 * описания и имена временных периодов блокировки
			 */
			'ban_timing' => array(
				'unlimited' => 'Пожизненно',
				'unlimited_info' => 'Пользователь с указанными данными не сможет войти на сайт никогда.
				Следует применять данный метод в случае если указанный пользователь - бот и рассылает спам.
				Примечание: у некоторых пользователей айпи адрес не статичен.',
				'period' => 'На период времени',
				'period_info' => 'Пользователь не сможет получить доступ к сайту на период времени',
				'period_info2' => 'По проишествии указанного времени пользователь автоматически сможет получить доступ к сайту.',
				'days' => 'На количество дней',
				'days_left' => 'дней',
				'days_info' => 'Пользователь не сможет получить доступ к сайту на указанное количество дней начиная с текущего',
			),
			'comments' => 'Комментарии',
			'reason' => 'Укажите причину блокировки, которая будет видна пользователю (если нужно)',
			'comment_for_yourself' => 'Укажите заметку для себя (видна только администраторам на странице списка банов)',

		),
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
		 * фильтр по банам
		 */
		'filter' => array(
			'all' => 'Все',
			'permanent' => 'Постоянные',
			'period' => 'На период',
		),
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
	 * статистика пользователей
	 */
	'users_stats' => array(
		'period_bar' => array(
			'yesterday' => 'Вчера',
			'today' => 'Сегодня',
			'week' => 'Неделя',
			'default' => 'Месяц',
		),
		'users' => 'пользователей',
		'title' => 'Статистика',
		'registrations' => 'Регистрации',
		'values_in_table' => 'значения таблицей',
		'date' => 'Дата',
		'count' => 'Количество',
		'gender_stats' => 'Гендерное распределение',
		'percent_from_all' => '% от всех',
		'sex_other' => 'Пол не указан',
		'sex_man' => 'Мужчины',
		'sex_woman' => 'Женщины',
		'total' => 'Всего',
		'activity' => 'Активность',
		'activity_active' => 'Активные',
		'activity_passive' => 'Заблудившиеся',
		'good_users' => 'Позитивные',
		'bad_users' => 'Негативные',

		'age_stats' => 'Возрастное распределение',
		'need_more_data' => 'У вас очень мало пользователей либо сайт ещё слишком молод чтобы показать красивый график.',
		'countries' => 'Страны',
		'and_text' => 'и',
		'cities' => 'города',
		/*
		 * заголовок графика в зависимости от типа
		 */
		'graph_labels' => array(
			'registrations' => 'регистрации',
			'topics' => 'топики',
			'comments' => 'комментарии',
			'votings' => 'голосования',
		),
		/*
		 * суффикс для подписей значений графика
		 */
		'graph_suffix' => array(
			'registrations' => 'пользователей',
			'topics' => 'топиков',
			'comments' => 'комментариев',
			'votings' => 'голосований',
		),
	),

	/*
	 * главная страница
	 */
	'index' => array(
		'title' => 'Статистика',

		'users' => 'пользователей',
		'registrations' => 'регистраций',
		'topics' => 'топиков',
		'blogs' => 'блогов',
		'comments' => 'комментариев',

		'new_users_for_week' => 'больше новых пользователей по сравнению с прошлой неделей на',
		'less_users_for_week' => 'меньше новых пользователей по сравнению с прошлой неделей на',

		'show_type' => 'Отображать',
		'show_users' => 'Регистрации',
		'show_topics' => 'Новые топики',
		'show_comments' => 'Комментарии',
		'show_votings' => 'Голосования',

		'show_period' => 'Период',
		'period_bar' => array(
			'today' => 'Сегодня',
			'yesterday' => 'Вчера',
			'week' => 'Неделя',
			'month' => 'Месяц',
		),

		'activity' => 'Активность',
		'activity_type' => array(
			'add_wall' => 'Записи на стене',
			'add_topic' => 'Новые топики',
			'add_comment' => 'Новые комментарии',
			'add_blog' => 'Новые блоги',
			'vote_topic' => 'Голосование за топик',
			'vote_comment' => 'Голосование за комментарий',
			'vote_blog' => 'Голосование за блог',
			'vote_user' => 'Голосование за пользователя',
			'add_friend' => 'Добавление в друзья',
			'join_blog' => 'Вход в блог',
		),

		'new_items' => 'Добавилось',
		'new_topics' => 'Топиков',
		'new_comments' => 'Комментариев',
		'new_blogs' => 'Блогов',
		'new_users' => 'Регистраций',
		'new_items_for_period' => 'новых по сравнению с прошлым аналогичным периодом стало больше на',
		'less_items_for_period' => 'новых по сравнению с прошлым аналогичным периодом стало меньше на',

		'new_topics_info' => 'новых топиков в выбранном периоде',
		'new_comments_info' => 'новых комментариев в выбранном периоде',
		'new_blogs_info' => 'новых блогов в выбранном периоде',
		'new_users_info' => 'новых пользователей в выбранном периоде',

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

	/**
	 * Пагинация
	 */
	'pagination' => array(
		'prev' => 'Предыдущая',
		'next' => 'Следующая',
	),	
);

?>