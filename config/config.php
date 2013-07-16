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

/*
 *  Базовые настройки, которые не меняются через интерфейс
 */

$config['user']['per_page'] = 3;

/*
 *	Списки групп настроек главного конфига движка и принадлежащих им параметров
 *
 *	Для каждой группы в ключе "allowed" необходимо указать первые символы разрешенных параметров
 *	Для ключа "exclude" нужно указать начала параметров, которые необходимо исключить из группы (правило работает после списка разрешенных)
 */
$config ['core_config_groups'] = array(
	'system' => array(
		// начала параметров, разрешенных для показа в этой группе
		'allowed' => array(
			//'view',
			//'seo',
			//'block',
			'pagination',
			'path',
			'smarty',
			'sys',
			//'general',
			//'lang',
			//'acl',
			//'module',
			'db',
			'memcache',
			'router',
			//'head',
			'compress',
		),
		// начала параметров, которые необходимо исключить из группы (правило работает после списка разрешенных)
		'exclude' => array(
			'path.',
			'sys.plugins.activation_file',
			'sys.logs.',
			'router',
			'sys.cache',
			'sys.session',
			'sys.cookie',
		
		),
	),	// /system
	'topics' => array(
		'allowed' => array(
			'view',
			'seo',
			'block',
			//'pagination',
			//'path',
			//'smarty',
			//'sys',
			'general',
			'lang',
			//'acl',
			//'module',
			//'db',
			//'memcache',
			//'router',
			//'head',
			'compress',
		),
		'exclude' => array(
			'lang.path',

		),
	),	// /topics
	'user' => array(
		'allowed' => array(
			//'view',
			//'seo',
			//'block',
			//'pagination',
			//'path',
			//'smarty',
			//'sys',
			//'general',
			//'lang',
			'acl',
			'module',
			//'db',
			//'memcache',
			//'router',
			//'head',
			//'compress',
		),
		'exclude' => array(
			'module.image.default.path.',
			'module.autoLoad',
		
		),
	),	// /user

);	// /core_config_groups

/*
 *  роутер
*/
$config['$root$']['router']['page']['admin'] = 'PluginAdmin_ActionAdmin';

return $config;

?>