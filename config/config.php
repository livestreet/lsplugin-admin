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
 *	Базовые настройки, которые не меняются через интерфейс
 */

/*
 * пользователей на страницу
 */
$config['user']['per_page'] = 10;

/*
 * голосов на страницу
 */
$config['votes']['per_page'] = 10;

/*
 *	Списки групп настроек главного конфига движка и принадлежащих им параметров
 *
 *	Для каждой группы в ключе "allowed" необходимо указать первые символы разрешенных параметров
 *	Для ключа "exclude" нужно указать начала параметров, которые необходимо исключить из группы(правило работает после списка разрешенных)
 */
$config ['core_config_groups'] = array(

	'system' => array(
		/*
		 * начала параметров, разрешенных для показа в этой группе
		 */
		'allowed' => array(
			//'view',
			//'seo',
			//'block',
			//'pagination',
			//'path',
			'smarty',
			//'sys',
			//'general',
			//'lang',
			//'acl',
			//'module',
			//'db',
			'memcache',
			//'router',
			//'head',
			//'compress',
		),
		/*
		 * начала параметров, которые необходимо исключить из группы(правило работает после списка разрешенных)
		 */
		'exclude' => array(
			//'path.',
			//'sys.plugins.activation_file',
			//'sys.logs.',
			//'router',
			//'sys.cache',
			//'sys.session',
			//'sys.cookie',
		
		),
	),	// /system
	
	
	'view' => array(
		'allowed' => array(
			'view',
		),
		'exclude' => array(
		),
	),
	
	
	'interface' => array(
		'allowed' => array(
			'seo',
			'block',
			'pagination',
			'general',
			'lang',
		),
		'exclude' => array(
			'lang.path',
			'block.rule_',

		),
	),
	
	
	'sysmail' => array(
		'allowed' => array(
			'sys.mail.',
		),
		'exclude' => array(
		),
	),
	
	
	'aclcreate' => array(
		'allowed' => array(
			'acl.create.',
		),
		'exclude' => array(
		),
	),
	
	
	'aclvote' => array(
		'allowed' => array(
			'acl.vote.',
		),
		'exclude' => array(
		),
	),
	
	
	'moduleblog' => array(
		'allowed' => array(
			'module.blog.',
		),
		'exclude' => array(
		),
	),
	
	
	'moduletopic' => array(
		'allowed' => array(
			'module.topic.',
		),
		'exclude' => array(
		),
	),
	
	
	'moduleuser' => array(
		'allowed' => array(
			'module.user.',
		),
		'exclude' => array(
		),
	),
	
	
	'modulecomment' => array(
		'allowed' => array(
			'module.comment.',
		),
		'exclude' => array(
		),
	),
	
	
	'moduletalk' => array(
		'allowed' => array(
			'module.talk.',
		),
		'exclude' => array(
		),
	),
	
	
	'modulenotify' => array(
		'allowed' => array(
			'module.notify.',
		),
		'exclude' => array(
		),
	),
	
	
	'moduleimage' => array(
		'allowed' => array(
			'module.image.',
		),
		'exclude' => array(
			'module.image.default.path.',
		),
	),
	
	
	'modulewall' => array(
		'allowed' => array(
			'module.wall.',
		),
		'exclude' => array(
		),
	),
	
	
	'moduleother' => array(
		'allowed' => array(
			'module.security.',
			'module.userfeed.',
			'module.stream.',
			'module.ls.',
		),
		'exclude' => array(
		),
	),
	
	
	'db' => array(
		'allowed' => array(
			'db',
		),
		'exclude' => array(
		),
	),
	
	
	'blocksrule' => array(
		'allowed' => array(
			'block.rule_',
		),
		'exclude' => array(

		),
	),
	
	
	'compress' => array(
		'allowed' => array(
			'compress',
		),
		'exclude' => array(
		),
	),

	
);	// /core_config_groups

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
 *	Использовать ли аякс при отправке формы с настройками
 */
$config ['admin_save_form_ajax_use'] = true;

/*
 * роутер
 */
$config['$root$']['router']['page']['admin'] = 'PluginAdmin_ActionAdmin';

return $config;

?>