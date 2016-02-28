<?php

/**
 * Управление списком подключаемых JS и CSS
 */

/**
 * Список компонентов для админки
 */
$config['components'] = array(
    // Базовые компоненты
    'admin:css-reset', 'admin:css-helpers', 'admin:typography', 'admin:forms', 'admin:grid', 'admin:ls-vendor', 'admin:ls-core', 'admin:ls-component', 'admin:lightbox',
    'admin:slider', 'admin:details', 'admin:alert', 'admin:dropdown', 'admin:button', 'admin:block', 'admin:confirm',
    'admin:nav', 'admin:tooltip', 'admin:tabs', 'admin:modal', 'admin:table', 'admin:text', 'admin:uploader', 'admin:email', 'admin:field', 'admin:pagination',
    'admin:editor', 'admin:more', 'admin:crop', 'admin:performance', 'admin:toolbar', 'admin:actionbar', 'admin:badge',
    'admin:autocomplete', 'admin:icon', 'admin:item', 'admin:highlighter', 'admin:jumbotron', 'admin:notification', 'admin:blankslate', 'admin:info-list',

    // Компоненты админки
    'admin:plugin', 'admin:skin', 'admin:p-settings', 'admin:p-actionbar', 'admin:p-cron', 'admin:p-property', 'admin:p-topic', 'admin:p-category', 'admin:p-optimization',
    'admin:p-form', 'admin:p-rbac', 'admin:p-user', 'admin:p-menu', 'admin:p-dashboard',

    // Компоненты LS CMS
    'admin:note', 'admin:icons-contact', 'admin:toolbar-scrollup', 'admin:toolbar-scrollnav',
    'admin:media', 'admin:property', 'admin:content', 'admin:activity',
);

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
    'assets/js/admin_misc.js',
    // Vendor scripts
    'assets/js/vendor/highcharts/highcharts.src.js',
    'assets/js/vendor/icheck/jquery.icheck.js'
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
    'assets/css/buttons.css',
    'assets/css/forms.css',
    'assets/css/user.css',
    'assets/css/table.css',
    'assets/css/dropdowns.css',
    'assets/css/helpers.css',
    'assets/css/stats.css',
    'assets/css/flags.css',
    // Vendor style
    'assets/css/vendor/jquery.notifier.css',
    'assets/css/vendor/icheck/skins/livestreet/minimal.css',
);

return $config;