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

/*
 *	Разрешенные списки имен полей для сортировки, а также поиска по ним
 */


/*
 * Разрешенные имена полей для поиска по пользователям
 *
 * параметр "search_as_part_of_string" разрешает искать по данному полю как по части строки запроса
 * (при изменении необходимы правки в маппере модуля юзеров плагина - изменить присваивание на LIKE)
 */
$config ['user_search_allowed_types'] = array(
	'id' => array('search_as_part_of_string'=>false),
	'mail' => array('search_as_part_of_string'=>true),
	'password' => array('search_as_part_of_string'=>false),
	'ip_register' => array('search_as_part_of_string'=>true),
	'activate' => array('search_as_part_of_string'=>false),
	'activate_key' => array('search_as_part_of_string'=>false),
	'profile_sex' => array('search_as_part_of_string'=>false),
	'login' => array('search_as_part_of_string'=>true),
	'profile_name' => array('search_as_part_of_string'=>true),
	'session_ip_last' => array('search_as_part_of_string'=>true),
	'admins_only' => array('search_as_part_of_string'=>false),
);


/*
 * Корректные значения для сортировок пользователей
 */
$config ['correct_sorting_order_for_users'] = array(
	'u.user_id',
	'u.user_login',
	'u.user_date_register',
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
$config ['default_sorting_order_for_users'] = 'u.user_id DESC';


/*
 * Корректные значения для сортировки голосов пользователя
 */
$config ['correct_sorting_order_for_votes'] = array(
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
$config ['default_sorting_order_for_votes'] = '`vote_date` DESC';


/*
 * Корректные значения для сортировки банов
 */
$config ['correct_sorting_bans'] = array(
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
$config ['default_sorting_bans'] = '`edit_date` DESC';


return $config;

?>