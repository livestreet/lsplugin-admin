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
 * Разрешенные списки имен полей для сортировки, поиска по ним и сортировок по-умолчанию
 *
 */

/*
 *
 * --- Пользователи ---
 *
 */

/*
 * Разрешенные имена полей для поиска по пользователям
 *
 * Параметры:
 *
 * "search_as_part_of_string"	разрешает искать по данному полю как по части строки запроса
 * 								(при изменении необходимы правки в маппере модуля юзеров плагина - изменить присваивание на LIKE)
 * "restricted_values"			список всех возможных значений для этого поля (текстовки задаются в языковом файле в массиве plugin.admin.users.restricted_values),
 * 								которые будут показаны в селекте, если не указано - будет простой инпут
 * "allow_empty_search"			разрешить ли поиск с пустым значением для этого поля (по-умолчанию запрещено)
 */
$config['users']['search_allowed_types'] = array(
	'id' => array('search_as_part_of_string' => false),
	'mail' => array('search_as_part_of_string' => true),
	'password' => array('search_as_part_of_string' => false),
	'ip_register' => array('search_as_part_of_string' => true),
	'activate' => array('search_as_part_of_string' => false, 'restricted_values' => array('1', '0')),
	'activate_key' => array('search_as_part_of_string' => false),
	'profile_sex' => array('search_as_part_of_string' => false, 'restricted_values' => array('man', 'woman', 'other')),
	'login' => array('search_as_part_of_string' => true),
	'profile_name' => array('search_as_part_of_string' => true, 'allow_empty_search' => true),
	'session_ip_last' => array('search_as_part_of_string' => true),
);


/*
 * Корректные значения (поля) для сортировок пользователей
 */
$config['users']['correct_sorting_order'] = array(
	'u.user_id',
	'u.user_login',
	'u.user_mail',
	'u.user_date_register',
	'u.user_ip_register',
	'u.user_rating',
	'u.user_skill',
	'u.user_profile_name',
	'u.user_profile_birthday',
	's.session_ip_create',
	's.session_ip_last',
	's.session_date_create',
	's.session_date_last',
);

/*
 * Сортировка пользователей по-умолчанию (если указанная сортировка некорректна или не разрешена)
 */
$config['users']['default_sorting_order'] = 'u.user_id';


/*
 *
 * --- Голоса ---
 *
 */

/*
 * Корректные значения (поля) для сортировки голосов пользователя
 */
$config['votes']['correct_sorting_order'] = array(
	'target_id',
	'target_type',
	'vote_direction',
	'vote_value',
	'vote_date',
	'vote_ip'
);

/*
 * Сортировка для вывода голосов по-умолчанию
 */
$config['votes']['default_sorting_order'] = 'vote_date';


/*
 *
 * --- Баны ---
 *
 */

/*
 * Корректные значения (поля) для сортировки банов
 */
$config['bans']['correct_sorting_order'] = array(
	'restriction_type',

	'block_type',
	'user_id',
	'ip',
	'ip_start',
	'ip_finish',

	'time_type',
	'date_start',
	'date_finish',

	'add_date',
	'edit_date',

	'reason_for_user',
	'comment'
);

/*
 * Сортировка для вывода банов по-умолчанию
 */
$config['bans']['default_sorting_order'] = 'edit_date';

return $config;

?>