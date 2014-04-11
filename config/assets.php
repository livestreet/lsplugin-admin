<?php

/**
 * Управление списком подключаемых JS и CSS
 */

/**
 * Основные скрипты движка
 */
$config['assets']['js']=array(
	/* Vendor libs */
	"___path.framework.frontend.web___/js/vendor/html5shiv.js" => array('browser'=>'lt IE 9'),
	"___path.framework.frontend.web___/js/vendor/jquery-1.9.1.min.js",
	"___path.framework.frontend.web___/js/vendor/jquery-ui/js/jquery-ui-1.10.2.custom.min.js",
	"___path.framework.frontend.web___/js/vendor/jquery-ui/js/localization/jquery-ui-datepicker-ru.js",
	"___path.framework.frontend.web___/js/vendor/jquery.browser.js",
	"___path.framework.frontend.web___/js/vendor/jquery.scrollto.js",
	"___path.framework.frontend.web___/js/vendor/jquery.rich-array.min.js",
	"___path.framework.frontend.web___/js/vendor/jquery.form.js",
	"___path.framework.frontend.web___/js/vendor/jquery.jqplugin.js",
	"___path.framework.frontend.web___/js/vendor/jquery.cookie.js",
	"___path.framework.frontend.web___/js/vendor/jquery.serializejson.js",
	"___path.framework.frontend.web___/js/vendor/jquery.file.js",
	"___path.framework.frontend.web___/js/vendor/jcrop/jquery.Jcrop.js",
	"___path.framework.frontend.web___/js/vendor/jquery.placeholder.min.js",
	"___path.framework.frontend.web___/js/vendor/jquery.charcount.js",
	"___path.framework.frontend.web___/js/vendor/jquery.imagesloaded.js",
	"___path.framework.frontend.web___/js/vendor/jquery.fileupload.js",
	"___path.framework.frontend.web___/js/vendor/notifier/jquery.notifier.js",
	"___path.framework.frontend.web___/js/vendor/prettify/prettify.js",
	"___path.framework.frontend.web___/js/vendor/parsley/parsley.js",
	"___path.framework.frontend.web___/js/vendor/parsley/i18n/messages.ru.js",
	"___path.framework.frontend.web___/js/vendor/jquery.livequery.js",
	"___path.framework.frontend.web___/js/vendor/fotorama/fotorama.js",
	"___path.framework.frontend.web___/js/vendor/nprogress/nprogress.js",
	"___path.framework.frontend.web___/js/vendor/colorbox/jquery.colorbox.js",

	/* Core */
	"___path.framework.frontend.web___/js/core/polyfills.js",
	"___path.framework.frontend.web___/js/core/main.js",
	"___path.framework.frontend.web___/js/core/dev.js",
	"___path.framework.frontend.web___/js/core/hook.js",
	"___path.framework.frontend.web___/js/core/i18n.js",
	"___path.framework.frontend.web___/js/core/ie.js",
	"___path.framework.frontend.web___/js/core/ajax.js",
	"___path.framework.frontend.web___/js/core/registry.js",
	"___path.framework.frontend.web___/js/core/utils.js",
	"___path.framework.frontend.web___/js/core/timer.js",

	/* User Interface */
	"___path.framework.frontend.web___/js/ui/dropdown.js",
	"___path.framework.frontend.web___/js/ui/tab.js",
	"___path.framework.frontend.web___/js/ui/modal.js",
	"___path.framework.frontend.web___/js/ui/toolbar.js",
	"___path.framework.frontend.web___/js/ui/tooltip.js",
	"___path.framework.frontend.web___/js/ui/autocomplete.js",
	"___path.framework.frontend.web___/js/ui/notification.js",
	"___path.framework.frontend.web___/js/ui/alert.js",
	"___path.framework.frontend.web___/js/ui/captcha.js",

	/* LiveStreet */
	"___path.application.web___/frontend/common/js/favourite.js",
	"___path.application.web___/frontend/common/js/blocks.js",
	"___path.application.web___/frontend/common/js/pagination.js",
	"___path.application.web___/frontend/common/js/editor.js",
	//"___path.application.web___/frontend/common/js/talk.js",
	//"___path.application.web___/frontend/common/js/vote.js",
	//"___path.application.web___/frontend/common/js/poll.js",
	"___path.application.web___/frontend/common/js/subscribe.js",
	"___path.application.web___/frontend/common/js/geo.js",
	//"___path.application.web___/frontend/common/js/wall.js",
	"___path.application.web___/frontend/common/js/usernote.js",
	"___path.application.web___/frontend/common/js/comments.js",
	"___path.application.web___/frontend/common/js/blog.js",
	"___path.application.web___/frontend/common/js/user.js",
	//"___path.application.web___/frontend/common/js/userfeed.js",
	//"___path.application.web___/frontend/common/js/activity.js",
	"___path.application.web___/frontend/common/js/toolbar.js",
	"___path.application.web___/frontend/common/js/settings.js",
	"___path.application.web___/frontend/common/js/topic.js",
	//"___path.application.web___/frontend/common/js/admin.js",
	//"___path.application.web___/frontend/common/js/userfield.js",
	"___path.application.web___/frontend/common/js/captcha.js",
	"___path.application.web___/frontend/common/js/media.js",
	"___path.application.web___/frontend/common/js/tags.js",
	"___path.application.web___/frontend/common/js/content.js",
	"___path.application.web___/frontend/common/js/user_list_add.js",
	"___path.application.web___/frontend/common/js/search.js",
	"___path.application.web___/frontend/common/js/more.js",
	//"___path.application.web___/frontend/common/js/init.js",
);


/**
 * Основные стили движка
 */
$config['assets']['css']=array(
	// Framework styles
	"___path.framework.frontend.web___/css/reset.css",
	"___path.framework.frontend.web___/css/helpers.css",
	"___path.framework.frontend.web___/css/text.css",
	"___path.framework.frontend.web___/css/icons.css",
	"___path.framework.frontend.web___/css/dropdowns.css",
	"___path.framework.frontend.web___/css/buttons.css",
	"___path.framework.frontend.web___/css/forms.css",
	"___path.framework.frontend.web___/css/navs.css",
	"___path.framework.frontend.web___/css/modals.css",
	"___path.framework.frontend.web___/css/tooltip.css",
	"___path.framework.frontend.web___/css/alerts.css",
	"___path.framework.frontend.web___/css/toolbar.css",
	"___path.framework.frontend.web___/css/typography.css",
	"___path.framework.frontend.web___/css/grid.css",
	// Vendor Style
	"___path.framework.frontend.web___/js/vendor/jquery-ui/css/smoothness/jquery-ui-1.10.2.custom.css",
	"___path.framework.frontend.web___/js/vendor/markitup/skins/synio/style.css",
	"___path.framework.frontend.web___/js/vendor/markitup/sets/synio/style.css",
	"___path.framework.frontend.web___/js/vendor/jcrop/jquery.Jcrop.css",
	"___path.framework.frontend.web___/js/vendor/prettify/prettify.css",
	"___path.framework.frontend.web___/js/vendor/notifier/jquery.notifier.css",
	"___path.framework.frontend.web___/js/vendor/fotorama/fotorama.css",
	"___path.framework.frontend.web___/js/vendor/nprogress/nprogress.css",
	"___path.framework.frontend.web___/js/vendor/colorbox/colorbox.css",
);


/**
 * Скрипты плагина, подключается админкой автоматически
 */
$config['admin']['assets']['js']=array(
	// Plugin scripts
	'assets/js/init.js',
	'assets/js/admin_settings_save.js',
	'assets/js/admin_settings_array.js',
	'assets/js/admin_misc.js',
	'assets/js/admin_stream.js',
	'assets/js/admin_users_stats_living.js',
	'assets/js/admin_profile_edit.js',
	'assets/js/admin_catalog.js',
	'assets/js/admin_users_search.js',
	'assets/js/admin_users_complaints.js',
	'assets/js/nav.main.js',
	'assets/js/property.js',
	'assets/js/topic.js',
	// Vendor scripts
	'assets/js/vendor/highcharts/highcharts.src.js',
	'assets/js/vendor/icheck/jquery.icheck.js',
	'assets/js/vendor/jeditable/jquery.jeditable.js',
);


/**
 * Стили плагина, подключается админкой автоматически
 */
$config['admin']['assets']['css']=array(
	// Plugin style
	'assets/css/base.css',
	'assets/css/grid.css',
	'assets/css/common.css',
	'assets/css/blocks.css',
	'assets/css/pagination.css',
	'assets/css/icons.css',
	'assets/css/navs.css',
	'assets/css/buttons.css',
	'assets/css/forms.css',
	'assets/css/skins.css',
	'assets/css/user.css',
	'assets/css/table.css',
	'assets/css/dropdowns.css',
	'assets/css/helpers.css',
	'assets/css/stats.css',
	'assets/css/plugins.css',
	'assets/css/addon.css',
	'assets/css/rating.stars.css',
	'assets/css/flags.css',
	// Vendor style
	'assets/css/vendor/jquery.notifier.css',
	'assets/css/vendor/icheck/skins/livestreet/minimal.css',
);

return $config;