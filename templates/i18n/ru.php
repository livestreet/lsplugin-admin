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
	'controls' => 'Управление',
	'search' => 'Поиск',

	/*
	 * Ошибки
	 */
	'errors' => array(
		/*
		 * Общие
		 */
		'you_are_not_admin' => 'Вы не администратор',
		'plugin_need_to_be_activated' => 'Плагин должен быть активированым для редактирования настроек',
		'wrong_description_key' => 'Ключ <b>%%key%%</b> в описании настроек указывает на несуществующий параметр конфига. Этот параметр пропущен',
		'wrong_config_name' => 'Неверный ключ имени плагина',
		'request_was_not_sent' => 'Запрос на сохранение не получен (не нажата кнопка)',
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
			'activation_version_error' => 'Для работы шаблона необходимо ядро LiveStreet версии не ниже <b>%%version%%</b>',
			'activation_requires_error' => 'Для работы шаблона необходим активированный плагин <b>%%plugin%%</b>',
			'unknown_skin' => 'Неизвестный шаблон',
			'xml_dont_tells_anything_about_this_theme' => 'В xml файле текущего шаблона нет никаких сведений об этой теме',
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
			'incorrect_user_id' => 'Неверный id пользователя или пользователя с таким id  не существует',
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
		/*
		 * Ошибки главной страницы
		 */
		'index' => array(
			'empty_activity_filter' => 'Не выбраны типы объектов для показа последней активности',
		),
		/*
		 * Ошибки утилит
		 */
		'utils' => array(
			'unknown_tables_clean_action' => 'Неизвестная команда очистки таблиц',
			'unknown_files_action' => 'Неизвестная команда проверки файлов',
		),
		/*
		 * Ошибки списка плагинов
		 */
		'plugins' => array(
			'unknown_action' => 'Неизвестное действие над плагином',
			'unknown_filter_type' => 'Неизвестный фильтр для списка плагинов',
			'plugin_not_found' => 'Плагин не найден',
		),
		/*
		 * Ошибки редактирования пользователя
		 */
		'profile_edit' => array(
			'wrong_user_id' => 'Пользователь с таким id не найден',
			'disallowed_value' => 'Не разрешенное значение',
			'unknown_action_type' => 'Неизвестное действие над пользователем',
			'login_has_unsupported_symbols' => 'В новом логине есть недопустимые символы',
			'login_already_exists' => 'Этот логин уже занят',
			'mail_is_incorrect' => 'Почта введена неверно',
			'mail_already_exists' => 'Эта почта уже занята',
			'password_is_too_weak' => 'Этот пароль слишком простой',
		),
		/*
		 * Ошибки проверки файлов на некорректную кодировку
		 */
		'encoding_check' => array(
			'unreadable_file' => 'Нет возможности прочесть файл <b>%%file%%</b>',
			'file_cant_be_read' => 'Файл <b>%%file%%</b> не удалось открыть для чтения',
			'utf8_bom_encoding_detected' => 'В файлах, указанных ниже (<b>%%count%%</b> шт.), найдена некорректная кодировка UTF-8 BOM,
			которая может вызывать разные проблемы при работе с движком, нужно открыть указанные файлы и изменить их кодировку на "UTF-8 <i>БЕЗ</i> BOM" т.е. просто "UTF-8":
			<br /><br />
			',
			'utf8_bom_file' => 'Файл',
		),
		/*
		 * ошибки соединения с каталогом
		 */
		'catalog' => array(
			'connect_error' => 'Ошибка соединения с каталогом',
		),

	),
	
	/*
	 * Уведомления
	 */
	'notices' => array(
		'template_changed' => 'Шаблон изменён',
		'template_preview_turned_off' => 'Предпросмотр шаблона отключен',
		'theme_changed' => 'Тема изменёна',

		/*
		 * главная страница админки
		 */
		'index' => array(
			'no_results' => 'По данному фильтру нет событий',
		),
	),
	
	/*
	 * Шаблоны
	 */
	'skin' => array(
		'title' => 'Шаблоны',
		'use_skin' => 'Включить',
		'preview_skin' => 'Предпросмотр',
		'current_skin' => 'Включен сейчас',
		
		'this_is_preview' => 'Для вас включен предпросмотр шаблона "<b>%%name%%</b>". Откройте главную страницу сайта и рассмотрите шаблон.',
		'turn_off_preview' => 'Выключить',
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
			/*
			 * выпадающий список
			 */
			'name' => 'Имя',
			'id' => 'id',
			'login' => 'Логин',
			'profile_name' => 'ФИО',
			'mail' => 'Почта',

			'birth' => 'Родился',
			/*
			 * выпадающий список
			 */
			'reg_and_last_visit' => 'Регистрация и визит',
			'reg' => 'Дата регистрации',
			'last_visit' => 'Дата последнего визита',
			/*
			 * выпадающий список
			 */
			'ip' => 'IP-адрес',
			'user_ip_register' => 'IP регистрации',
			'session_ip_last' => 'Последний IP сессии',
			/*
			 * выпадающий список
			 */
			'rating_and_skill' => 'Рейтинг и сила',
			'user_rating' => 'Рейтинг',
			'user_skill' => 'Сила',

		),
		'admin' => 'Администратор',
		'banned' => 'Забаненный',
		/*
		 * списки голосов
		 */
		'votes' => array(
			'title' => 'Списки голосов пользователя за',
			'no_votes' => 'Пользователь не голосовал в выбранном направлении',
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
			/*
			 * кнопки на странице списка голосов
			 */
			'voting_list' => array(
				'all' => 'Все',
				'plus' => 'Положительные',
				'minus' => 'Отрицательные',
				'abstain' => 'Нейтральные',
			),
		),
		/*
		 * страница данных о пользователе (профиль пользователя в админке)
		 */
		'profile' => array(
			'top_bar' => array(
				'msg' => 'Сообщение',
				'admin_delete' => 'Удалить из админов',
				'admin_add' => 'В администраторы',
				'user_delete' => 'Удалить контент пользователя',
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
				/*
				 * голоса пользователя
				 */
				'votings_title' => 'Как голосовал',
				'votings' => array(
					'topic' => 'За топики',
					'comment' => 'За комментарии',
					'blog' => 'За блоги',
					'user' => 'За юзеров',
				),
				'votings_direction' => array(
					'plus' => '+',
					'minus' => '-',
					'abstain' => '0',
				),
			),

		),
		/*
		 * удаление пользователя и его данных
		 */
		'deleteuser' => array(
			'title' => 'Удаление пользователя',
			'back_to_profile' => '&larr; Вернуться в профиль пользователя',
			'delete_user_itself' => 'Удалить самого пользователя?',

			'delete_user_info' => 'В зависимости от размера БД данный процесс может занять продолжительное время.
			При удалении будут последовательно чиститься все таблицы.
			<br /><br />
			Если установить флажок, расположенный ниже, то также будет удален из БД и сам пользователь вместе с его личным блогом
			(в противном случае у пользователя останется пустой личный блог).',
		),
		/*
		 * стать пользователя
		 */
		'sex' => array(
			'man' => 'мужской',
			'woman' => 'женский',
			'other' => 'не скажу'
		),
		/*
		 * инлайн редактирование данных профиля
		 */
		'profile_edit' => array(
			'rating' => 'Рейтинг',
			'skill' => 'Сила',
			'password' => 'Пароль',
			'about_user' => 'О себе',
			'no_profile_name' => 'имя не указано',
			/*
			 * др
			 */
			'no_bidthday_set' => 'не указано',
			'bidthday_parts' => array(
				'day' => 'день',
				'month' => 'месяц',
				'year' => 'год',
			),
			/*
			 * проживание
			 */
			'no_living_set' => 'не указано польностью или частично',
			'living_parts' => array(
				'country' => 'страна',
				'region' => 'регион',
				'city' => 'город',
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

			'restriction_title' => 'Тип ограничения пользования сайтом',
			'restriction_types' => array(
				'1' => 'Полный бан (без доступа к контенту сайта)',
				'2' => 'Read only бан (есть возможность читать сайт, без возможности что либо публиковать, комментировать и т.п.)',
			),

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
			'reason' => 'Причина',
			'reason_tip' => 'Укажите причину блокировки, которая будет видна пользователю (если нужно)',
			'comment' => 'Заметка',
			'comment_for_yourself_tip' => 'Укажите заметку для себя (видна только администраторам на странице списка банов)',

		),
		'back_to_list' => '&larr; Назад к списку банов',
		/*
		 * заголовок таблицы списка банов
		 */
		'table_header' => array(
			'block_rule' => 'Пользователь / IP',
			'block_type' => 'Тип блокировки',
			'user_id' => 'id юзера',
			'ip' => 'ip',
			'ip_start' => 'с ip',
			'ip_finish' => 'по ip',

			'restriction_type' => 'Тип ограничения пользования сайтом',

			'time_type' => 'Тип времени блокировки',
			'date_start' => 'Дата начала',
			'date_finish' => 'Дата окончания',

			'add_date' => 'Добавлен',
			'edit_date' => 'Отредактирован',

			'reason_for_user' => 'Причина',
			'comment' => 'Комментарий для себя',
		),
		/*
		 * сообщения пользователю при бане
		 */
		'messages' => array(
			'full_ban' => array(
				'permanently_banned' => 'Вам запрещен доступ к сайту навсегда. Причина: <i>%%reason%%</i>.',
				'banned_for_period' => 'Вам запрещен доступ к сайту с <b>%%date_start%%</b> по <b>%%date_finish%%</b>. Причина: <i>%%reason%%</i>.',
			),
			'readonly_ban' => array(
				'permanently_banned' => 'Вы переведены в режим "только чтение" навсегда. Причина: <i>%%reason%%</i>.',
				'banned_for_period' => 'Вы переведены в режим "только чтение" с <b>%%date_start%%</b> по <b>%%date_finish%%</b>. Причина: <i>%%reason%%</i>.',
			),
		),
		/*
		 * аякс проверка правила для бана на корректность
		 */
		'user_sign_check' => array(
			'wrong_rule' => 'Правило не распознано',
			'user' => 'Пользователь <b>%%login%%</b> (id = <b>%%id%%</b>, почта = <b>%%mail%%</b>, ip регистрации = <b>%%reg_ip%%</b>, ip последнего входа = <b>%%session_ip%%</b>)',
			'ip' => 'IP-адрес',
			'ip_range' => 'Диапазон IP-адресов',
		),
		'add_ban' => 'Добавить бан',
		/*
		 * фильтр по банам
		 */
		'filter' => array(
			/*
			 * фильтр по типу ограничений банов
			 */
			'restriction' => array(
				'all' => 'Все',
				'full' => 'Полный бан',
				'readonly' => 'Read only бан',
			),
			/*
			 * фильтр по типу временного интервала банов
			 */
			'time' => array(
				'all' => 'Все',
				'permanent' => 'Постоянные',
				'period' => 'На период',
			),
		),
		/*
		 * список
		 */
		'list' => array(
			'restriction_types' => array(
				'1' => 'Полный бан (без доступа к контенту сайта)',
				'2' => 'Read only бан (есть возможность читать сайт, без возможности что либо публиковать)',
			),
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
		'user_is_banned' => 'Этот пользователь в данный момент забанен. Причина:',
		/*
		 * страница информации бана
		 */
		'view' => array(
			'title' => 'Информация про бан',

		),

	),

	/*
	 * Статистика пользователей
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
		'registrations' => 'регистрации',
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
	 * Главная страница
	 */
	'index' => array(
		'title' => 'Статистика',
		/*
		 * верхняя планка основной информации
		 */
		'users' => 'пользователей',
		'registrations' => 'регистраций',
		'topics' => 'топиков',
		'blogs' => 'блогов',
		'comments' => 'комментариев',
		/*
		 * для пункта "регистрации" верхней планки
		 */
		'new_users_for_week' => 'больше новых пользователей по сравнению с прошлой неделей на',
		'less_users_for_week' => 'меньше новых пользователей по сравнению с прошлой неделей на',
		/*
		 * блок активности
		 */
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
		'with_all_checkboxes' => 'Со всеми',
		/*
		 * блок информации о новом контенте
		 */
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

		/*
		 * обновления
		 */
		'updates' => array(
			/*
			 * плагинов
			 */
			'plugins' => array(
				'title' => 'Плагины',
				'no_updates' => 'Обновлений нет',
				'there_are_n_updates' => 'Есть %%count%% обновления',

			),
		),

	),

	/*
	 * графики
	 */
	'graph' => array(
		/*
		 * тип данных для графика
		 */
		'show_type' => 'Отображать',
		'graph_type' => array(
			'registrations' => 'Регистрации',
			'topics' => 'Новые топики',
			'comments' => 'Комментарии',
			'votings' => 'Голосования',
		),

		/*
		 * предустановленные интервалы для графика
		 */
		'show_period' => 'Период',
		'period_bar' => array(
			'today' => 'Сегодня',
			'yesterday' => 'Вчера',
			'week' => 'Неделя',
			'month' => 'Месяц',
		),
		/*
		 * таблица с данными графика
		 */
		'values_in_table' => 'значения таблицей',
		'date' => 'Дата',
		'count' => 'Количество',
	),

	/*
	 * работа с комментариями
	 */
	'comments' => array(
		'full_deleting' => 'Полное удаление',
		/*
		 * страница удаления комментария
		 */
		'delete' => array(
			'title' => 'Удалить коментарий',

			'delete_info' => 'Данный комментарий будет полностью удален из БД без возможности восстановления,
			также будут удалены все дочерние ответы на него от других пользователей т.е. вся ветка комментариев.
			<br /><br />
			Также будут удалены все связанные данные (голоса за комментарии, избранное пользователей и т.п.)',
		),

	),

	/*
	 * Утилиты
	 */
	'utils' => array(
		/*
		 * чистка таблиц
		 */
		'tables' => array(
			'title' => 'Утилиты: проверка таблиц',

			'info' => 'Данный раздел позволяет проверить таблицы БД и очистить их от поврежденных связей и несуществующих значений,
			которые могли появиться при разных ситуациях. Этот процесс может занять некоторое время, рекомендуется его проводить в момент,
			когда нагрузка на сайт минимальна, также необходимо сделать бэкап перед проведением этой операции.',
			'repair_comments' => 'Проверить и очистить таблицы комментариев от поврежденных связей',
			'clean_stream' => 'Очистить активность (стрим) от записей, указывающих на несуществующие данные',
		),
		/*
		 * проверка кодировки файлов
		 */
		'files' => array(
			'title' => 'Утилиты: проверка файлов',

			'info' => 'Данный раздел позволяет проверить наиболее часто редактируемые файлы сайта в поисках кодировки,
			которая крайне не рекомендована для использования - UTF-8 BOM. Все такие файлы будут показаны списком.
			Сам список файлов (маски путей и расширения файлов) задаются в конфиге админки в config/encoding_checking_dirs.php',
			'check_encoding' => 'Проверить кодировку наиболее часто редактируемых файлов',
		),

	),

	/*
	 * список плагинов
	 */
	'plugins' => array(
		'list' => array(
			'title' => 'Список плагинов',
			'settings' => 'Настройки',
			'new_version_avaible' => 'У этого плагина есть обновление - версия',
		),
		'no_plugins' => 'Установленных плагинов нет',
		/*
		 * фильтр
		 */
		'menu' => array(
			'filter' => array(
				'activated' => 'Активные',
				'deactivated' => 'Не активные',
				'all' => 'Все',
				'updates' => 'Обновления',
			),
			'install_plugin' => 'Установить плагин',
		),
		/*
		 * инструкции по установке
		 */
		'instructions' => array(
			'title' => 'Инструкции по установке плагина',
			'description' => 'Автор этого плагина добавил к плагину инструкцию по установке. Внимательно прочитайте её ниже.',
			'controls' => array(
				'activate' => 'Инструкции прочитаны, активировать плагин',
				'dont_activate' => 'Нет, не активировать сейчас',
			),
		),
		'back_to_list' => 'Назад к списку плагинов',

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
	 * Описание каждого параметра конфига для отображения в админке (todo: ВРЕМЕННОЕ, ДЛЯ ТЕСТОВ)
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

	/*
	 * Пагинация
	 */
	'pagination' => array(
		'prev' => 'Предыдущая',
		'next' => 'Следующая',
	),

	/*
	 * Приветствия
	 */
	'hello' => array(
		'first_run' => 'Это ваше первое знакомство с админкой для LiveStreet CMS. Будем надеятся, что она вам понравится и работа с ней будет удобной.',
		'last_visit' => 'Последний раз заходили в админку',
		'last_visit_ip_not_match_current' => 'Предыдущий вход в админку был выполнен из другого ip - <b>%%last_ip%%</b>, текущий ip - <b>%%current_ip%%</b>.'

	),

);

?>