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
 * --- Схема настроек для раздела "Песочница" ---
 *
 * tip: Пример параметров всех типов для конфига и их полное описание для управления ими через админку.
 * 		Данный файл является примером и создан в обучающих целях и не нужен для работы админки.
 *
 */

$config = array();

/*
 *
 * Этап 1: записать параметры в конфиге как обычно
 *
 */

/*
 * Параметр целого типа (integer)
 */
$config['sandbox']['items_count'] = 3;
/*
 * Параметр строкового типа (string), ввод через текстовое поле
 */
$config['sandbox']['title'] = 'Text string';
/*
 * Параметр ещё одного строкового типа (string), ввод через селект
 */
$config['sandbox']['title2'] = 'Developer';
/*
 * Параметр булевого типа (bool)
 */
$config['sandbox']['enabled'] = true;
/*
 * Параметр вещественного типа (float)
 */
$config['sandbox']['min_rating'] = 0.1;
/*
 * Параметр, описывающий массив (array), ввод через селект
 */
$config['sandbox']['list'] = array(1, 2, 3);
/*
 * Параметр, описывающий ещё один массив (array), ввод через текстовое поле
 */
$config['sandbox']['list2'] = array(48, 64, 128);


/*
 *
 * Этап 2: указать описание структуры для каждого параметра в специальном массиве (схеме), которым управляет админка
 *
 */

/*
 * Описание настроек плагина
 * tip: специальный системный ключ
 */
$config['$config_scheme$'] = array(

    /*
     * Пример для параметра целочисленного типа
     */
    'sandbox.items_count' => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'integer',
        /*
         * отображаемое имя параметра, относительный ключ языкового файла
         */
        'name'        => 'config_parameters.sandbox.items_count.name',
        /*
         * отображаемое описание параметра, относительный ключ языкового файла
         */
        'description' => 'config_parameters.sandbox.items_count.description',
        /*
         * валидатор (не обязательно)
         */
        'validator'   => array(
            /*
             * тип валидатора, существующие типы валидаторов движка:
             * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Number',
            /*
             * параметры, которые будут переданы в валидатор
             */
            'params' => array(
                'min'         => 1,
                'max'         => 100,
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
    /*
     * Пример для параметра строкового типа
     */
    'sandbox.title'       => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'string',
        /*
         * отображаемое имя параметра, ключ языкового файла
         */
        'name'        => 'config_parameters.sandbox.title.name',
        /*
         * отображаемое описание параметра, ключ языкового файла
         */
        'description' => 'config_parameters.sandbox.title.description',
        /*
         * валидатор (не обязательно)
         */
        'validator'   => array(
            /*
             * тип валидатора, существующие типы валидаторов движка:
             * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'String',
            /*
             * параметры, которые будут переданы в валидатор
             */
            'params' => array(
                'min'        => 2,
                'max'        => 50,
                /*
                 * Конкретное значение длины строки
                 */
                //'is' => 30,
                'allowEmpty' => false,
            ),
        ),
    ),
    /*
     * Пример для ещё одного параметра строкового типа с вводом через селект
     */
    'sandbox.title2'      => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'string',
        /*
         * отображаемое имя параметра, ключ языкового файла
         */
        'name'        => 'config_parameters.sandbox.title2.name',
        /*
         * отображаемое описание параметра, ключ языкового файла
         */
        'description' => 'config_parameters.sandbox.title2.description',
        /*
         * валидатор (не обязательно)
         */
        'validator'   => array(
            /*
             * тип валидатора, существующие типы валидаторов движка:
             * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Enum',
            /*
             * параметры, которые будут переданы в валидатор
             */
            'params' => array(
                /*
                 * массив перечислений, которые будут доступны через селект
                 */
                'enum'       => array(
                    'User',
                    'Developer',
                    'Manager',
                    'Director',
                    'Designer',
                    'Sysadmin',
                ),
                /*
                 * разрешить ли в селекте использовать не установленное значение (пустое), добавляет вначало массива пустое разрешенное значение
                 */
                'allowEmpty' => true,
            ),
        ),
    ),
    /*
     * Пример для параметра булевого типа
     */
    'sandbox.enabled'     => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'boolean',
        /*
         * отображаемое имя параметра, ключ языкового файла
         */
        'name'        => 'config_parameters.sandbox.enabled.name',
        /*
         * отображаемое описание параметра, ключ языкового файла
         */
        'description' => 'config_parameters.sandbox.enabled.description',
        /*
         * валидатор (не обязательно)
         */
        'validator'   => array(
            /*
             * тип валидатора, существующие типы валидаторов движка:
             * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Boolean',
            /*
             * параметры, которые будут переданы в валидатор
             */
            'params' => array(),
        ),
    ),
    /*
     * Пример для параметра плавающего типа
     */
    'sandbox.min_rating'  => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'        => 'float',
        /*
         * отображаемое имя параметра, ключ языкового файла
         */
        'name'        => 'config_parameters.sandbox.min_rating.name',
        /*
         * отображаемое описание параметра, ключ языкового файла
         */
        'description' => 'config_parameters.sandbox.min_rating.description',
        /*
         * валидатор (не обязательно)
         */
        'validator'   => array(
            /*
             * тип валидатора, существующие типы валидаторов движка:
             * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Number',
            /*
             * параметры, которые будут переданы в валидатор
             */
            'params' => array(
                'min'         => 0,
                'max'         => 100,
                'integerOnly' => false,
                'allowEmpty'  => false,
            ),
        ),
    ),
    /*
     * Пример для параметра-массива
     * tip: для ввода используется селект с разрешенными значениями для массива
     */
    'sandbox.list'        => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'              => 'array',
        /*
         * отображаемое имя параметра, ключ языкового файла
         */
        'name'              => 'config_parameters.sandbox.list.name',
        /*
         * отображаемое описание параметра, ключ языкового файла
         */
        'description'       => 'config_parameters.sandbox.list.description',
        /*
         * выводить как обычный массив, иначе будет показан селект на основе данных валидатора (перечисление разрешенных вариантов или поле ввода)
         * ВНИМАНИЕ: на данный момент этот параметр должен быть false или не использоваться вообще
         */
        'show_as_php_array' => false,
        /*
         * валидатор (не обязательно)
         */
        'validator'         => array(
            /*
             * тип валидатора, существующие типы валидаторов движка:
             * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Array',
            /*
             * параметры, которые будут переданы в валидатор
             */
            'params' => array(
                /*
                 * минимальное количество элементов в массиве
                 */
                'min_items'      => 2,
                /*
                 * максимальное количество элементов в массиве
                 */
                'max_items'      => 10,
                /*
                 * перечисление разрешенных элементов массива
                 */
                'enum'           => array(
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                    8,
                    9,
                    10
                ),
                /*
                 * И/ИЛИ
                 */
                /*
                 * валидатор каждого элемента массива как отдельного элемента
                 */
                'item_validator' => array(
                    /*
                     * тип валидатора, существующие типы валидаторов движка:
                     * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
                     */
                    'type'   => 'Number',
                    /*
                     * параметры, которые будут переданы в валидатор
                     */
                    'params' => array(
                        'min'         => 0,
                        'max'         => 100,
                        'integerOnly' => true,
                        /*
                         * может ли быть пустым элемент массива
                         */
                        'allowEmpty'  => false,
                    ),
                ),
                /*
                 * может ли быть пустым весь массив
                 */
                'allowEmpty'     => false,
            ),
        ),
    ),
    /*
     * Пример для ещё одного параметра-массива
     * tip: для этого массива используется для ввода данных текстовое поле
     */
    'sandbox.list2'       => array(
        /*
         * тип: integer, string, array, boolean, float
         */
        'type'              => 'array',
        /*
         * отображаемое имя параметра, ключ языкового файла
         */
        'name'              => 'config_parameters.sandbox.list2.name',
        /*
         * отображаемое описание параметра, ключ языкового файла
         */
        'description'       => 'config_parameters.sandbox.list2.description',
        /*
         * выводить как обычный массив, иначе будет показан селект на основе данных валидатора (перечисление разрешенных вариантов или поле ввода)
         * ВНИМАНИЕ: на данный момент этот параметр должен быть false или не использоваться вообще
         */
        'show_as_php_array' => false,
        /*
         * валидатор (не обязательно)
         */
        'validator'         => array(
            /*
             * тип валидатора, существующие типы валидаторов движка:
             * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
             */
            'type'   => 'Array',
            /*
             * параметры, которые будут переданы в валидатор
             */
            'params' => array(
                /*
                 * минимальное количество элементов в массиве
                 */
                'min_items'      => 2,
                /*
                 * максимальное количество элементов в массиве
                 */
                'max_items'      => 5,
                /*
                 * валидатор каждого элемента массива как отдельного элемента
                 */
                'item_validator' => array(
                    /*
                     * тип валидатора, существующие типы валидаторов движка:
                     * Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, дополнительные: Array и Enum (специальные валидаторы, см. документацию)
                     */
                    'type'   => 'String',
                    /*
                     * параметры, которые будут переданы в валидатор
                     */
                    'params' => array(
                        'min'        => 2,
                        'max'        => 50,
                        'allowEmpty' => false,
                    ),
                ),
                'allowEmpty'     => true,
            ),
        ),
    ),

);    // /$config_scheme$


/*
 *
 * Этап 3: заголовки разделов настроек (не обязательно)
 *
 */

/*
 * Заголовки разделов
 * tip: специальный системный ключ
 */
$config['$config_sections$'] = array(
    /*
     * один раздел
     *
     * tip: ключ "sandbox" указывать не обязательно, здесь он нужен чтобы лоадер движка корректно загрузил два конфига (песочницы и реальных настроек),
     * 		т.к. ассоциативные массивы обьеденяются при загрузке.
     * 		В плагинах нужно указывать ключ для группы настроек только если группы настроек разделены на несколько файлов
     */
    'sandbox' => array(
        /*
         * раздел "Песочница" на странице настроек
         * tip: относительные ключи, указывающий на текстовку
         */
        'name'          => 'config_sections.sandbox.title',
        'description'   => 'config_sections.sandbox.description',
        /*
         * начала параметров, разрешенных для показа в этом разделе
         */
        'allowed_keys'  => array(
            'sandbox*',
        ),
        /*
         * начала параметров, которые необходимо исключить из раздела (правило работает после списка разрешенных)
         */
        'excluded_keys' => array(),
    ),
);

return $config;

?>