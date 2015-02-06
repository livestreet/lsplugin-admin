<?php

/**
 * Управление списком подключаемых JS и CSS
 */

/**
 * Основные скрипты движка
 */
$config['assets']['js'] = array(
    /* Vendor libs */
);


/**
 * Основные стили движка
 */
$config['assets']['css'] = array(
    // Framework styles

);


/**
 * Скрипты плагина, подключается админкой автоматически
 */
$config['admin']['assets']['js'] = array(
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
    'assets/js/rbac.js',
    'assets/js/cron.js',
    'assets/js/topic.js',
    // Vendor scripts
    'assets/js/vendor/highcharts/highcharts.src.js',
    'assets/js/vendor/icheck/jquery.icheck.js',
    'assets/js/vendor/jeditable/jquery.jeditable.js',
);


/**
 * Стили плагина, подключается админкой автоматически
 */
$config['admin']['assets']['css'] = array(
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