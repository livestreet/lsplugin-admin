<?php

// Для тестов

// Добавить в конец главного конфига

/*
 * Описание настроек плагина
 */
$config ['$config_schema$'] = array (
  'view.skin' => array (
    'type' => 'string',																						// integer, string, array, boolean, float
    'name' => 'config_parameters.viewskin.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.viewskin.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array (           // валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'String',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
      'params' => array (            // параметры, которые будут переданы в валидатор
				'min' => 1,
				'max' => 100,
			),
    ),
  ),
  
  'view.name' => array (
    'type' => 'string',																						// integer, string, array, boolean, float
    'name' => 'config_parameters.viewname.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.viewname.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array (           // валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'String',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url, Array (special validator)
      'params' => array (            // параметры, которые будут переданы в валидатор
				'min' => 1,
				'max' => 100,
			),
    ),
  ),
  
);

?>