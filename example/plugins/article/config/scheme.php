<?php

/*
 * Описание настроек плагина для интерфейса редактирования
 */
$config['$config_scheme$'] = array(
    'per_page'           => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'integer',
        /*
         * отображаемое имя параметра, ключ языкового файла
         */
        'name'        => 'config.per_page.name',
        /*
         * отображаемое описание параметра, ключ языкового файла
         */
        'description' => 'config.per_page.description',
        /*
         * валидатор (не обязательно)
         */
        'validator'   => array(
            /*
             * тип валидатора, существующие типы валидаторов движка:
             * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (специальный валидатор, см. документацию)
             */
            'type'   => 'Number',
            /*
             * параметры, которые будут переданы в валидатор
             */
            'params' => array(
                'min'         => 1,
                'max'         => 20,
                /*
                 * разрешить только целое число
                 */
                'integerOnly' => true,
                /*
                 * не допускать пустое значение
                 */
                'allowEmpty'  => false,
            ),
        ),
    ),
    'property_tags_code' => array(
        'type'        => 'string',
        'name'        => 'Код поля с тегами',
        'description' => 'Код задается при создании дополнительного поля',
        'validator'   => array(
            'type'   => 'Regexp',
            'params' => array(
                'pattern'    => '#^[a-z0-9\_]+$#i',
                'allowEmpty' => true,
            ),
        ),
    ),
    'param_string_1'     => array(
        'type'        => 'string',
        'name'        => 'config.param_string_1.name',
        'description' => 'config.param_string_1.description',
        'validator'   => array(
            'type'   => 'String',
            'params' => array(
                'min'        => 5,
                'max'        => 50,
                'allowEmpty' => true,
            ),
        ),
    ),
    'param_string_2'     => array(
        'type'      => 'string',
        'name'      => 'config.param_string_2.name',
        'validator' => array(
            'type'   => 'String',
            'params' => array(
                'min'        => 1,
                'max'        => 50,
                'allowEmpty' => false,
            ),
        ),
    ),
);


/**
 * Описание разделов для настроек
 * Каждый раздел группирует определенные параметры конфига
 */
$config['$config_sections$'] = array(
    /**
     * Настройки раздела
     */
    array(
        /**
         * Название раздела
         */
        'name'         => 'config_sections.one',
        /**
         * Список параметров для отображения в разделе
         */
        'allowed_keys' => array(
            'per_page',
            'property_tags_code'
        ),
    ),
    array(
        'name'         => 'config_sections.two',
        'allowed_keys' => array(
            'param_string_*',
        ),
    ),
);

return $config;