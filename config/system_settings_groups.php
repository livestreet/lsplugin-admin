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
 * Списки групп настроек главного конфига движка и принадлежащих им параметров
 *
 * Для каждой группы в ключе "allowed_keys" необходимо указать первые символы разрешенных параметров
 * Для ключа "excluded_keys" нужно указать начала параметров, которые необходимо исключить из группы (правило работает после списка разрешенных)
 */

/*
 *
 * ВАЖНО: Имя ключа массива для группы не может быть "plugin" и "save" - эти эвенты зарегистрированы для показа настроек плагинов и сохранения настроек соответственно
 *
 */
$config['settings']['core_config_groups'] = array(

	/*
	 * группа настроек
	 * tip: имя группы идентично её урлу
	 */
	'system' => array(
		/*
		 * раздел на странице настроек
		 */
		'smarty' => array(
			/*
			 * начала параметров, разрешенных для показа в этой группе
			 */
			'allowed_keys' => array(
				'smarty',
			),
			/*
			 * начала параметров, которые необходимо исключить из группы(правило работает после списка разрешенных)
			 */
			'excluded_keys' => array(),
		),
		'memcache' => array(
			'allowed_keys' => array(
				'memcache',
			),
			'excluded_keys' => array(),
		),
	),	// /system


	'view' => array(
		'allowed_keys' => array(
			'view',
		),
		'excluded_keys' => array(
		),
	),


	'interface' => array(
		'allowed_keys' => array(
			'seo',
			'block',
			'pagination',
			'general',
			'lang',
		),
		'excluded_keys' => array(
			'lang.path',
			'block.rule_',

		),
	),


	'sysmail' => array(
		'allowed_keys' => array(
			'sys.mail.',
		),
		'excluded_keys' => array(
		),
	),


	'aclcreate' => array(
		'allowed_keys' => array(
			'acl.create.',
		),
		'excluded_keys' => array(
		),
	),


	'aclvote' => array(
		'allowed_keys' => array(
			'acl.vote.',
		),
		'excluded_keys' => array(
		),
	),


	'moduleblog' => array(
		'allowed_keys' => array(
			'module.blog.',
		),
		'excluded_keys' => array(
		),
	),


	'moduletopic' => array(
		'allowed_keys' => array(
			'module.topic.',
		),
		'excluded_keys' => array(
		),
	),


	'moduleuser' => array(
		'allowed_keys' => array(
			'module.user.',
		),
		'excluded_keys' => array(
		),
	),


	'modulecomment' => array(
		'allowed_keys' => array(
			'module.comment.',
		),
		'excluded_keys' => array(
		),
	),


	'moduletalk' => array(
		'allowed_keys' => array(
			'module.talk.',
		),
		'excluded_keys' => array(
		),
	),


	'modulenotify' => array(
		'allowed_keys' => array(
			'module.notify.',
		),
		'excluded_keys' => array(
		),
	),


	'moduleimage' => array(
		'allowed_keys' => array(
			'module.image.',
		),
		'excluded_keys' => array(
			'module.image.default.path.',
		),
	),


	'modulewall' => array(
		'allowed_keys' => array(
			'module.wall.',
		),
		'excluded_keys' => array(
		),
	),


	'moduleother' => array(
		'allowed_keys' => array(
			'module.security.',
			'module.userfeed.',
			'module.stream.',
			'module.ls.',
		),
		'excluded_keys' => array(
		),
	),


/*	'db' => array(
		'allowed_keys' => array(
			'db',
		),
		'excluded_keys' => array(
		),
	),*/


/*	'blocksrule' => array(
		'allowed_keys' => array(
			'block.rule_',
		),
		'excluded_keys' => array(

		),
	),*/


	'compress' => array(
		'allowed_keys' => array(
			'compress',
		),
		'excluded_keys' => array(
		),
	),


);	// /core_config_groups

return $config;

?>