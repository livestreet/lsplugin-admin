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

$config['user']['per_page'] = 3;

$config['moredata'] = 'param2';

//
// Описание настроек плагина
//

$config ['__Admin_Interface__'] = array (
  //
  // Пример для параметра целочисленного типа
  //
  'user.per_page' => array (
    'type' => 'integer',
    'name' => 'config_parameters.user.per_page.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.user.per_page.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array (           // валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'Number',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url
      'params' => array (            // параметры, которые будут переданы в валидатор
				'min' => 1,
				'max' => 100,
			),
    ),
  ),
	
  //
  // Пример для параметра строкового типа
  //
  'moredata' => array (
    'type' => 'string',
    'name' => 'config_parameters.moredata.name',                  // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.moredata.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array (           // валидация (если нужна), существующие типы валидаторов ядра
      'type' => 'String',            // Boolean, Compare, Date, Email, Number, Regexp, Required, String, Tags, Type, Url
      'params' => array (            // параметры, которые будут переданы в валидатор
				'min' => 2,
				'max' => 50,
			),
    ),
  ),
	
);


/*
	роутер
*/
$config['$root$']['router']['page']['admin'] = 'PluginAdmin_ActionAdmin';

return $config;

?>