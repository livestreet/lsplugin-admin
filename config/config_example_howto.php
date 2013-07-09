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

//
// --- Пример параметров всех типов для конфига и их описание для управления через админку ---
//

//
// FAQ: Сначала нужно записать параметры как обычно
//

$config['test']['subarr'] = 3;					// integer
$config['moredata'] = 'param2';					// string
$config['some_param'] = true;						// bool
$config['users']['min_rating'] = 0.1;		// float

// Массивы

// Settings for plugin Sitemap
$config['sitemap'] = array(
    'cache_lifetime' => 60 * 60 * 24, // 24 hours
    'sitemap_priority' => '0.8',
);

$config ['setup_rules']['one'] = array(1, 2, 3);

//
// FAQ: Потом нужно указать описание структуры для каждого параметра в специальном массиве, которым управляет админка
//

//
// Описание настроек плагина
//
$config ['$config_schema$'] = array(
  //
  // Пример для параметра целочисленного типа
  //
  'test.subarr' => array(
    'type' => 'integer',																							// integer, string, array, boolean, float
    'name' => 'config_parameters.test.subarr.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.test.subarr.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array(           // валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'Number',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
      'params' => array(            // параметры, которые будут переданы в валидатор
				'min' => 1,
				'max' => 100,
			),
    ),
  ),
	
  //
  // Пример для параметра строкового типа
  //
  'moredata' => array(
    'type' => 'string',																						// integer, string, array, boolean, float
    'name' => 'config_parameters.moredata.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.moredata.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array(           // валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'String',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
      'params' => array(            // параметры, которые будут переданы в валидатор
				'min' => 2,
				'max' => 50,
			),
    ),
  ),
	
  //
  // Пример для параметра булевого типа
  //
  'some_param' => array(
    'type' => 'boolean',																						// integer, string, array, boolean, float
    'name' => 'config_parameters.some_param.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.some_param.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array(						// валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'Boolean',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
			'params' => array(),
    ),
  ),
	
  //
  // Пример для параметра плавающего типа
  //
  'users.min_rating' => array(
    'type' => 'float',																						// integer, string, array, boolean, float
    'name' => 'config_parameters.users.min_rating.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.users.min_rating.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array(						// валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'Number',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
      'params' => array(            // параметры, которые будут переданы в валидатор
				'min' => 0,
				'max' => 100,
				'integerOnly' => false,
				'allowEmpty' => false,
			),
    ),
  ),
	
	// Массивы
	
  //
  // Пример для параметра от массива
  //
  'sitemap.cache_lifetime' => array(
    'type' => 'integer',																						// integer, string, array, boolean, float
    'name' => 'config_parameters.sitemap.cache_lifetime.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.sitemap.cache_lifetime.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array(						// валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'Number',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
      'params' => array(            // параметры, которые будут переданы в валидатор
				'min' => 0,
				'max' => 1000000,
				'integerOnly' => true,
				'allowEmpty' => false,
			),
    ),
  ),
	
  //
  // Пример для параметра от массива
  //
  'sitemap.sitemap_priority' => array(
    'type' => 'string',																						// integer, string, array, boolean, float
    'name' => 'config_parameters.sitemap.sitemap_priority.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.sitemap.sitemap_priority.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array(						// валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'String',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
      'params' => array(            // параметры, которые будут переданы в валидатор
				'min' => 2,
				'max' => 100,
			),
    ),
  ),
	
	
  //
  // Пример для параметра-массива
  //
  'setup_rules.one' => array(
    'type' => 'array',																						// integer, string, array, boolean, float
    'name' => 'config_parameters.setup_rules.one.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.setup_rules.one.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array(						// валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'Array',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
      'params' => array(            // параметры, которые будут переданы в валидатор
				'min_items' => 2,						// мин. количество элементов в массиве
				'max_items' => 10,					// макс. количество элементов в массиве
				'enum' => array(						// перечисление разрешенных элементов массива
					1,2,3,4,5,6,7,8,9,10
				),
				'range' => array(						// диапазон разрешенных чисел массива от и до
					'min' => 0, 'max' => 100
				),
			),
    ),
  ),
	
);



return $config;

?>