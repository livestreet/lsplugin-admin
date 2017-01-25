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
 * --- Настройки конфига админки ---
 *
 * tip: за полным описанием и примерами следует смотреть конфиг "config_scheme_sandbox.php"
 *
 */

$config = array();

/*
 * Описание всех параметров админки
 */
$config['$config_scheme$'] = array(

    /*
     * Баны
     */

    'bans.gather_bans_running_stats'                        => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'boolean',
        'name'        => 'config_parameters.bans.gather_bans_running_stats.name',
        'description' => 'config_parameters.bans.gather_bans_running_stats.description',
        'validator'   => array(
            /*
             * тип валидатора: Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Boolean',
            'params' => array(),
        ),
    ),
    'bans.per_page' => array(
        'type'        => 'integer',
        'name'        => 'config_parameters.bans.per_page.name',
        'description' => '',
        'validator'   => array(
            'type'   => 'Number',
            'params' => array(
                'min'         => 1,
                'max'         => 500,
                'integerOnly' => true,
                'allowEmpty'  => true,
            ),
        ),
    ),
    /*
     * Каталог
     */

    'catalog.updates.allow_plugin_updates_checking'         => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'boolean',
        'name'        => 'config_parameters.catalog.updates.allow_plugin_updates_checking.name',
        'description' => 'config_parameters.catalog.updates.allow_plugin_updates_checking.description',
        'validator'   => array(
            /*
             * тип валидатора: Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Boolean',
            'params' => array(),
        ),
    ),
    'catalog.updates.show_updates_count_in_toolbar'         => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'boolean',
        'name'        => 'config_parameters.catalog.updates.show_updates_count_in_toolbar.name',
        'description' => 'config_parameters.catalog.updates.show_updates_count_in_toolbar.description',
        'validator'   => array(
            /*
             * тип валидатора: Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Boolean',
            'params' => array(),
        ),
    ),
    /*
     * Настройки настроек
     */

    'settings.admin_save_form_ajax_use'                     => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'boolean',
        'name'        => 'config_parameters.settings.admin_save_form_ajax_use.name',
        'description' => 'config_parameters.settings.admin_save_form_ajax_use.description',
        'validator'   => array(
            /*
             * тип валидатора: Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Boolean',
            'params' => array(),
        ),
    ),
    'settings.show_section_keys'                            => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'boolean',
        'name'        => 'config_parameters.settings.show_section_keys.name',
        'description' => 'config_parameters.settings.show_section_keys.description',
        'validator'   => array(
            /*
             * тип валидатора: Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Boolean',
            'params' => array(),
        ),
    ),
    /*
     * Пользователи
     */

    'users.min_user_age_difference_to_show_users_age_stats' => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'integer',
        'name'        => 'config_parameters.users.min_user_age_difference_to_show_users_age_stats.name',
        'description' => 'config_parameters.users.min_user_age_difference_to_show_users_age_stats.description',
        'validator'   => array(
            /*
             * тип валидатора: Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Number',
            'params' => array(
                'min'         => 5,
                'max'         => 18,
                'integerOnly' => true,
                'allowEmpty'  => false,
            ),
        ),
    ),
    'users.per_page' => array(
        'type'        => 'integer',
        'name'        => 'config_parameters.users.per_page.name',
        'description' => '',
        'validator'   => array(
            'type'   => 'Number',
            'params' => array(
                'min'         => 1,
                'max'         => 500,
                'integerOnly' => true,
                'allowEmpty'  => true,
            ),
        ),
    ),
    'users.complaints.per_page' => array(
        'type'        => 'integer',
        'name'        => 'config_parameters.users.complaints.per_page.name',
        'description' => '',
        'validator'   => array(
            'type'   => 'Number',
            'params' => array(
                'min'         => 1,
                'max'         => 500,
                'integerOnly' => true,
                'allowEmpty'  => true,
            ),
        ),
    ),

    'votes.per_page' => array(
        'type'        => 'integer',
        'name'        => 'config_parameters.votes.per_page.name',
        'description' => '',
        'validator'   => array(
            'type'   => 'Number',
            'params' => array(
                'min'         => 1,
                'max'         => 500,
                'integerOnly' => true,
                'allowEmpty'  => true,
            ),
        ),
    ),
);

/*
 * Разделы настроек
 */
$config['$config_sections$'] = array(
    /*
     * раздел "Баны"
     *
     * tip: ключ "bans" указывать не обязательно, здесь он нужен чтобы лоадер движка корректно загрузил два конфига (песочницы и реальных настроек),
     * 		т.к. ассоциативные массивы обьеденяются при загрузке.
     * 		В плагинах нужно указывать ключ для группы настроек только если группы настроек разделены на несколько файлов
     */
    'bans'     => array(
        'name'         => 'config_sections.bans.title',
        'allowed_keys' => array(
            'bans*',
        ),
    ),
    /*
     * раздел "каталог"
     */
    'catalog'  => array(
        'name'         => 'config_sections.catalog.title',
        'allowed_keys' => array(
            'catalog*',
        ),
    ),
    /*
     * раздел "настройки"
     */
    'settings' => array(
        'name'         => 'config_sections.settings.title',
        'allowed_keys' => array(
            'settings*',
        ),
    ),
    /*
     * раздел "пользователи"
     */
    'users'    => array(
        'name'         => 'config_sections.users.title',
        'allowed_keys' => array(
            'users*',
            'votes*',
        ),
    ),
);

return $config;

?>