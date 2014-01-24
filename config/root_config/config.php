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
 * Дополнительный конфиг движка, содержащий схему и список групп
 *
 */

return array(
	/*
	 * --- Списки групп настроек главного конфига движка и принадлежащих им разделов и их параметров ---
	 *
	 * Для каждой группы указывается как минимум один раздел, в котором указываются
	 * 		в ключе "allowed_keys" - первые символы разрешенных параметров
	 * 		в ключе "excluded_keys" - начала параметров, которые необходимо исключить из группы (правило работает после списка разрешенных, исключаемое подмножество)
	 */
	'$config_groups$' => array(
		/*
		 * группа настроек
		 * tip: имя группы идентично её урлу и не может быть "plugin" и "save" - эти эвенты зарегистрированы для показа настроек плагинов и сохранения настроек соответственно
		 */
		'system' => array(
			/*
			 * раздел "smarty" на странице настроек для группы с кодом "system"
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
			/*
			 * раздел "memcache" на странице настроек для группы с кодом "system"
			 */
			'memcache' => array(
				'allowed_keys' => array(
					'memcache',
				),
				'excluded_keys' => array(),
			),
		),


		'view' => array(
			'view' => array(
				'allowed_keys' => array(
					'view',
				),
			),
		),


		'interface' => array(
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

		),


		'sysmail' => array(
			'mail' => array(
				'allowed_keys' => array(
					'sys.mail.',
				),
			),
		),


		'aclcreate' => array(
			'aclcreate' => array(
				'allowed_keys' => array(
					'acl.create.',
				),
			),
		),


		'aclvote' => array(
			'aclvote' => array(
				'allowed_keys' => array(
					'acl.vote.',
				),
			),
		),


		'moduleblog' => array(
			'moduleblog' => array(
				'allowed_keys' => array(
					'module.blog.',
				),
			),
		),


		'moduletopic' => array(
			'moduletopic' => array(
				'allowed_keys' => array(
					'module.topic.',
				),
			),
		),


		'moduleuser' => array(
			'moduleuser' => array(
				'allowed_keys' => array(
					'module.user.',
				),
			),
		),


		'modulecomment' => array(
			'modulecomment' => array(
				'allowed_keys' => array(
					'module.comment.',
				),
			),
		),


		'moduletalk' => array(
			'moduletalk' => array(
				'allowed_keys' => array(
					'module.talk.',
				),
			),
		),


		'modulenotify' => array(
			'modulenotify' => array(
				'allowed_keys' => array(
					'module.notify.',
				),
			),
		),


		'moduleimage' => array(
			'moduleimage' => array(
				'allowed_keys' => array(
					'module.image.',
				),
				'excluded_keys' => array(
					'module.image.default.path.',
				),
			),
		),


		'modulewall' => array(
			'modulewall' => array(
				'allowed_keys' => array(
					'module.wall.',
				),
			),
		),


		'moduleother' => array(
			'moduleother' => array(
				'allowed_keys' => array(
					'module.security.',
					'module.userfeed.',
					'module.stream.',
					'module.ls.',
				),
			),
		),


		'compress' => array(
			'compress' => array(
				'allowed_keys' => array(
					'compress',
				),
			),
		),
	),

	/*
	 *
	 * --- Описание настроек главного конфига LiveStreet CMS ---
	 *
	 */
	'$config_scheme$' => array(
		'view.name' => array(
			'type' => 'string',
			'name' => 'config_parameters.view.name.name',
			'description' => 'config_parameters.view.name.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
					'min' => 2,
					'max' => 200,
					'allowEmpty' => false,
				),
			),
		),
		'view.description' => array(
			'type' => 'string',
			'name' => 'config_parameters.view.description.name',
			'description' => 'config_parameters.view.description.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'view.keywords' => array(
			'type' => 'string',
			'name' => 'config_parameters.view.keywords.name',
			'description' => 'config_parameters.view.keywords.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'view.wysiwyg' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.view.wysiwyg.name',
			'description' => 'config_parameters.view.wysiwyg.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'view.noindex' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.view.noindex.name',
			'description' => 'config_parameters.view.noindex.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'view.img_resize_width' => array(
			'type' => 'integer',
			'name' => 'config_parameters.view.img_resize_width.name',
			'description' => 'config_parameters.view.img_resize_width.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'view.img_max_width' => array(
			'type' => 'integer',
			'name' => 'config_parameters.view.img_max_width.name',
			'description' => 'config_parameters.view.img_max_width.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'view.img_max_height' => array(
			'type' => 'integer',
			'name' => 'config_parameters.view.img_max_height.name',
			'description' => 'config_parameters.view.img_max_height.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'view.img_max_size_url' => array(
			'type' => 'integer',
			'name' => 'config_parameters.view.img_max_size_url.name',
			'description' => 'config_parameters.view.img_max_size_url.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'seo.description_words_count' => array(
			'type' => 'integer',
			'name' => 'config_parameters.seo.description_words_count.name',
			'description' => 'config_parameters.seo.description_words_count.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'block.stream.row' => array(
			'type' => 'integer',
			'name' => 'config_parameters.block.stream.row.name',
			'description' => 'config_parameters.block.stream.row.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'block.stream.show_tip' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.block.stream.show_tip.name',
			'description' => 'config_parameters.block.stream.show_tip.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'block.blogs.row' => array(
			'type' => 'integer',
			'name' => 'config_parameters.block.blogs.row.name',
			'description' => 'config_parameters.block.blogs.row.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'block.tags.tags_count' => array(
			'type' => 'integer',
			'name' => 'config_parameters.block.tags.tags_count.name',
			'description' => 'config_parameters.block.tags.tags_count.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'block.tags.personal_tags_count' => array(
			'type' => 'integer',
			'name' => 'config_parameters.block.tags.personal_tags_count.name',
			'description' => 'config_parameters.block.tags.personal_tags_count.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'pagination.pages.count' => array(
			'type' => 'integer',
			'name' => 'config_parameters.pagination.pages.count.name',
			'description' => 'config_parameters.pagination.pages.count.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'path.root.server' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.root.server.name',
			'description' => 'config_parameters.path.root.server.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.root.engine' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.root.engine.name',
			'description' => 'config_parameters.path.root.engine.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.root.engine_lib' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.root.engine_lib.name',
			'description' => 'config_parameters.path.root.engine_lib.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.static.root' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.static.root.name',
			'description' => 'config_parameters.path.static.root.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.static.skin' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.static.skin.name',
			'description' => 'config_parameters.path.static.skin.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.uploads.root' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.uploads.root.name',
			'description' => 'config_parameters.path.uploads.root.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.uploads.images' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.uploads.images.name',
			'description' => 'config_parameters.path.uploads.images.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.offset_request_url' => array(
			'type' => 'integer',
			'name' => 'config_parameters.path.offset_request_url.name',
			'description' => 'config_parameters.path.offset_request_url.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'path.smarty.template' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.smarty.template.name',
			'description' => 'config_parameters.path.smarty.template.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.smarty.compiled' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.smarty.compiled.name',
			'description' => 'config_parameters.path.smarty.compiled.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.smarty.cache' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.smarty.cache.name',
			'description' => 'config_parameters.path.smarty.cache.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'path.smarty.plug' => array(
			'type' => 'string',
			'name' => 'config_parameters.path.smarty.plug.name',
			'description' => 'config_parameters.path.smarty.plug.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'smarty.compile_check' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.smarty.compile_check.name',
			'description' => 'config_parameters.smarty.compile_check.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.plugins.activation_file' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.plugins.activation_file.name',
			'description' => 'config_parameters.sys.plugins.activation_file.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.cookie.path' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.cookie.path.name',
			'description' => 'config_parameters.sys.cookie.path.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.cookie.time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.sys.cookie.time.name',
			'description' => 'config_parameters.sys.cookie.time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'sys.session.standart' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.session.standart.name',
			'description' => 'config_parameters.sys.session.standart.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.session.name' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.session.name.name',
			'description' => 'config_parameters.sys.session.name.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.session.host' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.session.host.name',
			'description' => 'config_parameters.sys.session.host.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.session.path' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.session.path.name',
			'description' => 'config_parameters.sys.session.path.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.type' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.mail.type.name',
			'description' => 'config_parameters.sys.mail.type.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.from_email' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.mail.from_email.name',
			'description' => 'config_parameters.sys.mail.from_email.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.from_name' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.mail.from_name.name',
			'description' => 'config_parameters.sys.mail.from_name.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.charset' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.mail.charset.name',
			'description' => 'config_parameters.sys.mail.charset.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.smtp.host' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.mail.smtp.host.name',
			'description' => 'config_parameters.sys.mail.smtp.host.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.smtp.port' => array(
			'type' => 'integer',
			'name' => 'config_parameters.sys.mail.smtp.port.name',
			'description' => 'config_parameters.sys.mail.smtp.port.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'sys.mail.smtp.user' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.mail.smtp.user.name',
			'description' => 'config_parameters.sys.mail.smtp.user.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.smtp.password' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.mail.smtp.password.name',
			'description' => 'config_parameters.sys.mail.smtp.password.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.smtp.secure' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.mail.smtp.secure.name',
			'description' => 'config_parameters.sys.mail.smtp.secure.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.mail.smtp.auth' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.mail.smtp.auth.name',
			'description' => 'config_parameters.sys.mail.smtp.auth.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.mail.include_comment' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.mail.include_comment.name',
			'description' => 'config_parameters.sys.mail.include_comment.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.mail.include_talk' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.mail.include_talk.name',
			'description' => 'config_parameters.sys.mail.include_talk.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.cache.use' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.cache.use.name',
			'description' => 'config_parameters.sys.cache.use.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.cache.type' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.cache.type.name',
			'description' => 'config_parameters.sys.cache.type.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.cache.dir' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.cache.dir.name',
			'description' => 'config_parameters.sys.cache.dir.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.cache.prefix' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.cache.prefix.name',
			'description' => 'config_parameters.sys.cache.prefix.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.cache.directory_level' => array(
			'type' => 'integer',
			'name' => 'config_parameters.sys.cache.directory_level.name',
			'description' => 'config_parameters.sys.cache.directory_level.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'sys.cache.solid' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.cache.solid.name',
			'description' => 'config_parameters.sys.cache.solid.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.logs.file' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.logs.file.name',
			'description' => 'config_parameters.sys.logs.file.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.logs.sql_query' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.logs.sql_query.name',
			'description' => 'config_parameters.sys.logs.sql_query.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.logs.sql_query_file' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.logs.sql_query_file.name',
			'description' => 'config_parameters.sys.logs.sql_query_file.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.logs.sql_error' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.logs.sql_error.name',
			'description' => 'config_parameters.sys.logs.sql_error.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.logs.sql_error_file' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.logs.sql_error_file.name',
			'description' => 'config_parameters.sys.logs.sql_error_file.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.logs.cron' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.logs.cron.name',
			'description' => 'config_parameters.sys.logs.cron.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.logs.cron_file' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.logs.cron_file.name',
			'description' => 'config_parameters.sys.logs.cron_file.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.logs.profiler' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.logs.profiler.name',
			'description' => 'config_parameters.sys.logs.profiler.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'sys.logs.profiler_file' => array(
			'type' => 'string',
			'name' => 'config_parameters.sys.logs.profiler_file.name',
			'description' => 'config_parameters.sys.logs.profiler_file.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'sys.logs.hacker_console' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.sys.logs.hacker_console.name',
			'description' => 'config_parameters.sys.logs.hacker_console.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'general.close' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.general.close.name',
			'description' => 'config_parameters.general.close.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'general.rss_editor_mail' => array(
			'type' => 'string',
			'name' => 'config_parameters.general.rss_editor_mail.name',
			'description' => 'config_parameters.general.rss_editor_mail.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'general.reg.invite' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.general.reg.invite.name',
			'description' => 'config_parameters.general.reg.invite.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'general.reg.activation' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.general.reg.activation.name',
			'description' => 'config_parameters.general.reg.activation.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'lang.current' => array(
			'type' => 'string',
			'name' => 'config_parameters.lang.current.name',
			'description' => 'config_parameters.lang.current.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'lang.default' => array(
			'type' => 'string',
			'name' => 'config_parameters.lang.default.name',
			'description' => 'config_parameters.lang.default.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'lang.path' => array(
			'type' => 'string',
			'name' => 'config_parameters.lang.path.name',
			'description' => 'config_parameters.lang.path.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'lang.load_to_js' => array(
			'type' => 'array',
			'name' => 'config_parameters.lang.load_to_js.name',
			'description' => 'config_parameters.lang.load_to_js.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'acl.create.blog.rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.blog.rating.name',
			'description' => 'config_parameters.acl.create.blog.rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.comment.rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.comment.rating.name',
			'description' => 'config_parameters.acl.create.comment.rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.comment.limit_time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.comment.limit_time.name',
			'description' => 'config_parameters.acl.create.comment.limit_time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.comment.limit_time_rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.comment.limit_time_rating.name',
			'description' => 'config_parameters.acl.create.comment.limit_time_rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.topic.limit_time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.topic.limit_time.name',
			'description' => 'config_parameters.acl.create.topic.limit_time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.topic.limit_time_rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.topic.limit_time_rating.name',
			'description' => 'config_parameters.acl.create.topic.limit_time_rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.topic.limit_rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.topic.limit_rating.name',
			'description' => 'config_parameters.acl.create.topic.limit_rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.talk.limit_time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.talk.limit_time.name',
			'description' => 'config_parameters.acl.create.talk.limit_time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.talk.limit_time_rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.talk.limit_time_rating.name',
			'description' => 'config_parameters.acl.create.talk.limit_time_rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.talk_comment.limit_time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.talk_comment.limit_time.name',
			'description' => 'config_parameters.acl.create.talk_comment.limit_time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.talk_comment.limit_time_rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.talk_comment.limit_time_rating.name',
			'description' => 'config_parameters.acl.create.talk_comment.limit_time_rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.wall.limit_time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.wall.limit_time.name',
			'description' => 'config_parameters.acl.create.wall.limit_time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.create.wall.limit_time_rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.create.wall.limit_time_rating.name',
			'description' => 'config_parameters.acl.create.wall.limit_time_rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.vote.comment.rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.vote.comment.rating.name',
			'description' => 'config_parameters.acl.vote.comment.rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.vote.blog.rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.vote.blog.rating.name',
			'description' => 'config_parameters.acl.vote.blog.rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.vote.topic.rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.vote.topic.rating.name',
			'description' => 'config_parameters.acl.vote.topic.rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.vote.user.rating' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.vote.user.rating.name',
			'description' => 'config_parameters.acl.vote.user.rating.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.vote.topic.limit_time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.vote.topic.limit_time.name',
			'description' => 'config_parameters.acl.vote.topic.limit_time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'acl.vote.comment.limit_time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.acl.vote.comment.limit_time.name',
			'description' => 'config_parameters.acl.vote.comment.limit_time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.blog.per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.blog.per_page.name',
			'description' => 'config_parameters.module.blog.per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.blog.users_per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.blog.users_per_page.name',
			'description' => 'config_parameters.module.blog.users_per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.blog.personal_good' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.blog.personal_good.name',
			'description' => 'config_parameters.module.blog.personal_good.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.blog.collective_good' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.blog.collective_good.name',
			'description' => 'config_parameters.module.blog.collective_good.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.blog.index_good' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.blog.index_good.name',
			'description' => 'config_parameters.module.blog.index_good.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.blog.encrypt' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.blog.encrypt.name',
			'description' => 'config_parameters.module.blog.encrypt.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.blog.avatar_size' => array(
			'type' => 'array',
			'name' => 'config_parameters.module.blog.avatar_size.name',
			'description' => 'config_parameters.module.blog.avatar_size.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'module.blog.category_allow' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.blog.category_allow.name',
			'description' => 'config_parameters.module.blog.category_allow.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.blog.category_only_admin' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.blog.category_only_admin.name',
			'description' => 'config_parameters.module.blog.category_only_admin.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.blog.category_only_children' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.blog.category_only_children.name',
			'description' => 'config_parameters.module.blog.category_only_children.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.blog.category_allow_empty' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.blog.category_allow_empty.name',
			'description' => 'config_parameters.module.blog.category_allow_empty.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.topic.new_time' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.topic.new_time.name',
			'description' => 'config_parameters.module.topic.new_time.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.topic.per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.topic.per_page.name',
			'description' => 'config_parameters.module.topic.per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.topic.max_length' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.topic.max_length.name',
			'description' => 'config_parameters.module.topic.max_length.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.topic.link_max_length' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.topic.link_max_length.name',
			'description' => 'config_parameters.module.topic.link_max_length.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.topic.question_max_length' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.topic.question_max_length.name',
			'description' => 'config_parameters.module.topic.question_max_length.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.topic.allow_empty_tags' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.topic.allow_empty_tags.name',
			'description' => 'config_parameters.module.topic.allow_empty_tags.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.user.per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.per_page.name',
			'description' => 'config_parameters.module.user.per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.friend_on_profile' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.friend_on_profile.name',
			'description' => 'config_parameters.module.user.friend_on_profile.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.friend_notice.delete' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.user.friend_notice.delete.name',
			'description' => 'config_parameters.module.user.friend_notice.delete.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.user.friend_notice.accept' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.user.friend_notice.accept.name',
			'description' => 'config_parameters.module.user.friend_notice.accept.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.user.friend_notice.reject' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.user.friend_notice.reject.name',
			'description' => 'config_parameters.module.user.friend_notice.reject.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.user.avatar_size' => array(
			'type' => 'array',
			'name' => 'config_parameters.module.user.avatar_size.name',
			'description' => 'config_parameters.module.user.avatar_size.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'module.user.login.min_size' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.login.min_size.name',
			'description' => 'config_parameters.module.user.login.min_size.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.login.max_size' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.login.max_size.name',
			'description' => 'config_parameters.module.user.login.max_size.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.login.charset' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.user.login.charset.name',
			'description' => 'config_parameters.module.user.login.charset.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.user.time_active' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.time_active.name',
			'description' => 'config_parameters.module.user.time_active.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.usernote_text_max' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.usernote_text_max.name',
			'description' => 'config_parameters.module.user.usernote_text_max.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.usernote_per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.usernote_per_page.name',
			'description' => 'config_parameters.module.user.usernote_per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.userfield_max_identical' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.userfield_max_identical.name',
			'description' => 'config_parameters.module.user.userfield_max_identical.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.profile_photo_width' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.profile_photo_width.name',
			'description' => 'config_parameters.module.user.profile_photo_width.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.name_max' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.user.name_max.name',
			'description' => 'config_parameters.module.user.name_max.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.user.captcha_use_registration' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.user.captcha_use_registration.name',
			'description' => 'config_parameters.module.user.captcha_use_registration.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.comment.per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.comment.per_page.name',
			'description' => 'config_parameters.module.comment.per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.comment.bad' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.comment.bad.name',
			'description' => 'config_parameters.module.comment.bad.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.comment.max_tree' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.comment.max_tree.name',
			'description' => 'config_parameters.module.comment.max_tree.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.comment.use_nested' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.comment.use_nested.name',
			'description' => 'config_parameters.module.comment.use_nested.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.comment.nested_per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.comment.nested_per_page.name',
			'description' => 'config_parameters.module.comment.nested_per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.comment.nested_page_reverse' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.comment.nested_page_reverse.name',
			'description' => 'config_parameters.module.comment.nested_page_reverse.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.comment.favourite_target_allow' => array(
			'type' => 'array',
			'name' => 'config_parameters.module.comment.favourite_target_allow.name',
			'description' => 'config_parameters.module.comment.favourite_target_allow.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'module.talk.per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.talk.per_page.name',
			'description' => 'config_parameters.module.talk.per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.talk.encrypt' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.talk.encrypt.name',
			'description' => 'config_parameters.module.talk.encrypt.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.talk.max_users' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.talk.max_users.name',
			'description' => 'config_parameters.module.talk.max_users.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.lang.delete_undefined' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.lang.delete_undefined.name',
			'description' => 'config_parameters.module.lang.delete_undefined.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.notify.delayed' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.notify.delayed.name',
			'description' => 'config_parameters.module.notify.delayed.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.notify.insert_single' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.notify.insert_single.name',
			'description' => 'config_parameters.module.notify.insert_single.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.notify.per_process' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.notify.per_process.name',
			'description' => 'config_parameters.module.notify.per_process.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.notify.dir' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.notify.dir.name',
			'description' => 'config_parameters.module.notify.dir.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.notify.prefix' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.notify.prefix.name',
			'description' => 'config_parameters.module.notify.prefix.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_use' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.image.default.watermark_use.name',
			'description' => 'config_parameters.module.image.default.watermark_use.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_type' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_type.name',
			'description' => 'config_parameters.module.image.default.watermark_type.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_position' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_position.name',
			'description' => 'config_parameters.module.image.default.watermark_position.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_text' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_text.name',
			'description' => 'config_parameters.module.image.default.watermark_text.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_font' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_font.name',
			'description' => 'config_parameters.module.image.default.watermark_font.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_font_color' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_font_color.name',
			'description' => 'config_parameters.module.image.default.watermark_font_color.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_font_size' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_font_size.name',
			'description' => 'config_parameters.module.image.default.watermark_font_size.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_font_alfa' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_font_alfa.name',
			'description' => 'config_parameters.module.image.default.watermark_font_alfa.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_back_color' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_back_color.name',
			'description' => 'config_parameters.module.image.default.watermark_back_color.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_back_alfa' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.watermark_back_alfa.name',
			'description' => 'config_parameters.module.image.default.watermark_back_alfa.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_image' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.image.default.watermark_image.name',
			'description' => 'config_parameters.module.image.default.watermark_image.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_min_width' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.image.default.watermark_min_width.name',
			'description' => 'config_parameters.module.image.default.watermark_min_width.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.image.default.watermark_min_height' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.image.default.watermark_min_height.name',
			'description' => 'config_parameters.module.image.default.watermark_min_height.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.image.default.round_corner' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.image.default.round_corner.name',
			'description' => 'config_parameters.module.image.default.round_corner.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.image.default.round_corner_radius' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.round_corner_radius.name',
			'description' => 'config_parameters.module.image.default.round_corner_radius.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.round_corner_rate' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.round_corner_rate.name',
			'description' => 'config_parameters.module.image.default.round_corner_rate.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.path.watermarks' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.path.watermarks.name',
			'description' => 'config_parameters.module.image.default.path.watermarks.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.path.fonts' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.image.default.path.fonts.name',
			'description' => 'config_parameters.module.image.default.path.fonts.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.image.default.jpg_quality' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.image.default.jpg_quality.name',
			'description' => 'config_parameters.module.image.default.jpg_quality.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.image.foto.watermark_use' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.image.foto.watermark_use.name',
			'description' => 'config_parameters.module.image.foto.watermark_use.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.image.foto.round_corner' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.image.foto.round_corner.name',
			'description' => 'config_parameters.module.image.foto.round_corner.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.image.topic.watermark_use' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.image.topic.watermark_use.name',
			'description' => 'config_parameters.module.image.topic.watermark_use.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.image.topic.round_corner' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.image.topic.round_corner.name',
			'description' => 'config_parameters.module.image.topic.round_corner.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.security.hash' => array(
			'type' => 'string',
			'name' => 'config_parameters.module.security.hash.name',
			'description' => 'config_parameters.module.security.hash.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'module.userfeed.count_default' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.userfeed.count_default.name',
			'description' => 'config_parameters.module.userfeed.count_default.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.stream.count_default' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.stream.count_default.name',
			'description' => 'config_parameters.module.stream.count_default.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.stream.disable_vote_events' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.stream.disable_vote_events.name',
			'description' => 'config_parameters.module.stream.disable_vote_events.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.ls.send_general' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.ls.send_general.name',
			'description' => 'config_parameters.module.ls.send_general.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.ls.use_counter' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.module.ls.use_counter.name',
			'description' => 'config_parameters.module.ls.use_counter.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'module.wall.count_last_reply' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.wall.count_last_reply.name',
			'description' => 'config_parameters.module.wall.count_last_reply.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.wall.per_page' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.wall.per_page.name',
			'description' => 'config_parameters.module.wall.per_page.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.wall.text_max' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.wall.text_max.name',
			'description' => 'config_parameters.module.wall.text_max.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.wall.text_min' => array(
			'type' => 'integer',
			'name' => 'config_parameters.module.wall.text_min.name',
			'description' => 'config_parameters.module.wall.text_min.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'module.autoLoad' => array(
			'type' => 'array',
			'name' => 'config_parameters.module.autoLoad.name',
			'description' => 'config_parameters.module.autoLoad.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
/*		'db.params.host' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.params.host.name',
			'description' => 'config_parameters.db.params.host.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.params.port' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.params.port.name',
			'description' => 'config_parameters.db.params.port.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.params.user' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.params.user.name',
			'description' => 'config_parameters.db.params.user.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.params.pass' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.params.pass.name',
			'description' => 'config_parameters.db.params.pass.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.params.type' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.params.type.name',
			'description' => 'config_parameters.db.params.type.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.params.dbname' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.params.dbname.name',
			'description' => 'config_parameters.db.params.dbname.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.prefix' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.prefix.name',
			'description' => 'config_parameters.db.table.prefix.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.user' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.user.name',
			'description' => 'config_parameters.db.table.user.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.blog' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.blog.name',
			'description' => 'config_parameters.db.table.blog.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.blog_category' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.blog_category.name',
			'description' => 'config_parameters.db.table.blog_category.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.topic' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.topic.name',
			'description' => 'config_parameters.db.table.topic.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.topic_tag' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.topic_tag.name',
			'description' => 'config_parameters.db.table.topic_tag.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.comment' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.comment.name',
			'description' => 'config_parameters.db.table.comment.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.vote' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.vote.name',
			'description' => 'config_parameters.db.table.vote.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.topic_read' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.topic_read.name',
			'description' => 'config_parameters.db.table.topic_read.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.blog_user' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.blog_user.name',
			'description' => 'config_parameters.db.table.blog_user.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.favourite' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.favourite.name',
			'description' => 'config_parameters.db.table.favourite.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.favourite_tag' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.favourite_tag.name',
			'description' => 'config_parameters.db.table.favourite_tag.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.talk' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.talk.name',
			'description' => 'config_parameters.db.table.talk.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.talk_user' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.talk_user.name',
			'description' => 'config_parameters.db.table.talk_user.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.talk_blacklist' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.talk_blacklist.name',
			'description' => 'config_parameters.db.table.talk_blacklist.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.friend' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.friend.name',
			'description' => 'config_parameters.db.table.friend.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.topic_content' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.topic_content.name',
			'description' => 'config_parameters.db.table.topic_content.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.topic_question_vote' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.topic_question_vote.name',
			'description' => 'config_parameters.db.table.topic_question_vote.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.user_administrator' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.user_administrator.name',
			'description' => 'config_parameters.db.table.user_administrator.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.comment_online' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.comment_online.name',
			'description' => 'config_parameters.db.table.comment_online.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.invite' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.invite.name',
			'description' => 'config_parameters.db.table.invite.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.page' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.page.name',
			'description' => 'config_parameters.db.table.page.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.reminder' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.reminder.name',
			'description' => 'config_parameters.db.table.reminder.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.session' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.session.name',
			'description' => 'config_parameters.db.table.session.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.notify_task' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.notify_task.name',
			'description' => 'config_parameters.db.table.notify_task.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.userfeed_subscribe' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.userfeed_subscribe.name',
			'description' => 'config_parameters.db.table.userfeed_subscribe.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.stream_subscribe' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.stream_subscribe.name',
			'description' => 'config_parameters.db.table.stream_subscribe.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.stream_event' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.stream_event.name',
			'description' => 'config_parameters.db.table.stream_event.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.stream_user_type' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.stream_user_type.name',
			'description' => 'config_parameters.db.table.stream_user_type.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.user_field' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.user_field.name',
			'description' => 'config_parameters.db.table.user_field.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.user_field_value' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.user_field_value.name',
			'description' => 'config_parameters.db.table.user_field_value.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.topic_photo' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.topic_photo.name',
			'description' => 'config_parameters.db.table.topic_photo.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.subscribe' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.subscribe.name',
			'description' => 'config_parameters.db.table.subscribe.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.wall' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.wall.name',
			'description' => 'config_parameters.db.table.wall.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.user_note' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.user_note.name',
			'description' => 'config_parameters.db.table.user_note.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.geo_country' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.geo_country.name',
			'description' => 'config_parameters.db.table.geo_country.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.geo_region' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.geo_region.name',
			'description' => 'config_parameters.db.table.geo_region.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.geo_city' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.geo_city.name',
			'description' => 'config_parameters.db.table.geo_city.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.geo_target' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.geo_target.name',
			'description' => 'config_parameters.db.table.geo_target.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.user_changemail' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.user_changemail.name',
			'description' => 'config_parameters.db.table.user_changemail.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.table.storage' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.table.storage.name',
			'description' => 'config_parameters.db.table.storage.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'db.tables.engine' => array(
			'type' => 'string',
			'name' => 'config_parameters.db.tables.engine.name',
			'description' => 'config_parameters.db.tables.engine.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),*/
		/*	'memcache.servers.0.host' => array(
				'type' => 'string',
				'name' => 'config_parameters.memcache.servers.0.host.name',
				'description' => 'config_parameters.memcache.servers.0.host.description',
				'validator' => array(
					'type' => 'String',
					'params' => array(
					),
				),
			),
			'memcache.servers.0.port' => array(
				'type' => 'string',
				'name' => 'config_parameters.memcache.servers.0.port.name',
				'description' => 'config_parameters.memcache.servers.0.port.description',
				'validator' => array(
					'type' => 'String',
					'params' => array(
					),
				),
			),
			'memcache.servers.0.persistent' => array(
				'type' => 'boolean',
				'name' => 'config_parameters.memcache.servers.0.persistent.name',
				'description' => 'config_parameters.memcache.servers.0.persistent.description',
				'validator' => array(
					'type' => 'Boolean',
					'params' => array(
					),
				),
			),*/
		'memcache.compression' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.memcache.compression.name',
			'description' => 'config_parameters.memcache.compression.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
/*		'router.rewrite' => array(
			'type' => 'array',
			'name' => 'config_parameters.router.rewrite.name',
			'description' => 'config_parameters.router.rewrite.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'router.uri' => array(
			'type' => 'array',
			'name' => 'config_parameters.router.uri.name',
			'description' => 'config_parameters.router.uri.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'router.page.error' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.error.name',
			'description' => 'config_parameters.router.page.error.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.registration' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.registration.name',
			'description' => 'config_parameters.router.page.registration.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.profile' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.profile.name',
			'description' => 'config_parameters.router.page.profile.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.my' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.my.name',
			'description' => 'config_parameters.router.page.my.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.blog' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.blog.name',
			'description' => 'config_parameters.router.page.blog.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.personal_blog' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.personal_blog.name',
			'description' => 'config_parameters.router.page.personal_blog.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.index' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.index.name',
			'description' => 'config_parameters.router.page.index.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.topic' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.topic.name',
			'description' => 'config_parameters.router.page.topic.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.login' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.login.name',
			'description' => 'config_parameters.router.page.login.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.people' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.people.name',
			'description' => 'config_parameters.router.page.people.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.settings' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.settings.name',
			'description' => 'config_parameters.router.page.settings.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.tag' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.tag.name',
			'description' => 'config_parameters.router.page.tag.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.talk' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.talk.name',
			'description' => 'config_parameters.router.page.talk.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.comments' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.comments.name',
			'description' => 'config_parameters.router.page.comments.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.rss' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.rss.name',
			'description' => 'config_parameters.router.page.rss.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.link' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.link.name',
			'description' => 'config_parameters.router.page.link.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.question' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.question.name',
			'description' => 'config_parameters.router.page.question.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.blogs' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.blogs.name',
			'description' => 'config_parameters.router.page.blogs.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.search' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.search.name',
			'description' => 'config_parameters.router.page.search.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.admin' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.admin.name',
			'description' => 'config_parameters.router.page.admin.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.ajax' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.ajax.name',
			'description' => 'config_parameters.router.page.ajax.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.feed' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.feed.name',
			'description' => 'config_parameters.router.page.feed.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.stream' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.stream.name',
			'description' => 'config_parameters.router.page.stream.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.photoset' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.photoset.name',
			'description' => 'config_parameters.router.page.photoset.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.page.subscribe' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.page.subscribe.name',
			'description' => 'config_parameters.router.page.subscribe.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),*/
/*		'router.config.action_default' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.config.action_default.name',
			'description' => 'config_parameters.router.config.action_default.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'router.config.action_not_found' => array(
			'type' => 'string',
			'name' => 'config_parameters.router.config.action_not_found.name',
			'description' => 'config_parameters.router.config.action_not_found.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),*/
		'block.rule_index_blog' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_index_blog.name',
			'description' => 'config_parameters.block.rule_index_blog.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.rule_index' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_index.name',
			'description' => 'config_parameters.block.rule_index.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.rule_topic_type' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_topic_type.name',
			'description' => 'config_parameters.block.rule_topic_type.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.rule_personal_blog' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_personal_blog.name',
			'description' => 'config_parameters.block.rule_personal_blog.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.rule_tag' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_tag.name',
			'description' => 'config_parameters.block.rule_tag.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.rule_blogs' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_blogs.name',
			'description' => 'config_parameters.block.rule_blogs.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.userfeedBlogs' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.userfeedBlogs.name',
			'description' => 'config_parameters.block.userfeedBlogs.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.userfeedUsers' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.userfeedUsers.name',
			'description' => 'config_parameters.block.userfeedUsers.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.rule_blog_info' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_blog_info.name',
			'description' => 'config_parameters.block.rule_blog_info.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.rule_users' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_users.name',
			'description' => 'config_parameters.block.rule_users.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'block.rule_profile' => array(
			'type' => 'array',
			'name' => 'config_parameters.block.rule_profile.name',
			'description' => 'config_parameters.block.rule_profile.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'head.default.js' => array(
			'type' => 'array',
			'name' => 'config_parameters.head.default.js.name',
			'description' => 'config_parameters.head.default.js.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'head.default.css' => array(
			'type' => 'array',
			'name' => 'config_parameters.head.default.css.name',
			'description' => 'config_parameters.head.default.css.description',
			'validator' => array(
				'type' => 'Array',
				'params' => array(
				),
			),
		),
		'compress.css.merge' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.compress.css.merge.name',
			'description' => 'config_parameters.compress.css.merge.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'compress.css.use' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.compress.css.use.name',
			'description' => 'config_parameters.compress.css.use.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'compress.css.case_properties' => array(
			'type' => 'integer',
			'name' => 'config_parameters.compress.css.case_properties.name',
			'description' => 'config_parameters.compress.css.case_properties.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'compress.css.merge_selectors' => array(
			'type' => 'integer',
			'name' => 'config_parameters.compress.css.merge_selectors.name',
			'description' => 'config_parameters.compress.css.merge_selectors.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'compress.css.optimise_shorthands' => array(
			'type' => 'integer',
			'name' => 'config_parameters.compress.css.optimise_shorthands.name',
			'description' => 'config_parameters.compress.css.optimise_shorthands.description',
			'validator' => array(
				'type' => 'Number',
				'params' => array(
				),
			),
		),
		'compress.css.remove_last_;' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.compress.css.remove_last_;.name',
			'description' => 'config_parameters.compress.css.remove_last_;.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'compress.css.css_level' => array(
			'type' => 'string',
			'name' => 'config_parameters.compress.css.css_level.name',
			'description' => 'config_parameters.compress.css.css_level.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'compress.css.template' => array(
			'type' => 'string',
			'name' => 'config_parameters.compress.css.template.name',
			'description' => 'config_parameters.compress.css.template.description',
			'validator' => array(
				'type' => 'String',
				'params' => array(
				),
			),
		),
		'compress.js.merge' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.compress.js.merge.name',
			'description' => 'config_parameters.compress.js.merge.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
		'compress.js.use' => array(
			'type' => 'boolean',
			'name' => 'config_parameters.compress.js.use.name',
			'description' => 'config_parameters.compress.js.use.description',
			'validator' => array(
				'type' => 'Boolean',
				'params' => array(
				),
			),
		),
	),
);

?>