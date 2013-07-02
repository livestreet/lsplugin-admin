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


$config ['elements_per_page'] = 15;                 // базовое значение по-умолчанию
$config ['hello_message'] = 'hello, livestreet';    // базовое значение по-умолчанию
$config ['for_admins'] = true;                      // базовое значение по-умолчанию

//
// --- Массивы ---
//

$config ['setup_rules'] = array (                   // базовое значение по-умолчанию
  'one' => array (1,2,3),
  'two' => true,
  'three' => false
);

// ИЛИ Массив ведь можно записать и так:

$config ['setup_rules']['one'] = array (1,2,3);
$config ['setup_rules']['two'] = true;
$config ['setup_rules']['three'] = false;


// Описание для параметров, добавлять в конец каждого конфига
$config ['__Admin_Interface__'] = array (
  //
  // Пример для параметра целочисленного типа
  //
  'elements_per_page' => array (
    'type' => 'integer',
    'name' => 'config_parameters.elements_per_page.name'                   // отображаемое имя параметра, ключ языкового файла
    'range' => array (0, 100),
    'description' => 'config_parameters.elements_per_page.description',    // отображаемое описание параметра, ключ языкового файла
  ),
  
  //
  // Пример для параметра строкового типа
  //
  'hello_message' => array (
    'type' => 'string',
    'name' => 'config_parameters.hello_message.name'                   // отображаемое имя параметра, ключ языкового файла
    'range' => array (0, 100),                                          // только для строковых типов, длина от и до
    'description' => 'config_parameters.hello_message.description',    // отображаемое описание параметра, ключ языкового файла
    'validator' => array (    // валидация (если нужна)
      'string'                // тип готовой ИЛИ
      'regexp' => '#\w+#iUu'  // указание регулярки
    ),
  ),
  
  //
  // Пример для параметра булевого типа
  //
  'for_admins' => array (
    'type' => 'bool',
    'name' => 'config_parameters.for_admins.name'                   // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.for_admins.description',    // отображаемое описание параметра, ключ языкового файла
  ),
  
  //
  // --- Массивы ---
  //
  
  // Пример для параметра массива
  // Возможные (разрешенные) варианты не указаны - можно писать что угодно
  'setup_rules' => array (
    'type' => 'array',
    'name' => 'config_parameters.setup_rules.name'                   // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.setup_rules.description',    // отображаемое описание параметра, ключ языкового файла
  ),
  
  // ИЛИ
  
  // Пример расширенного варианта для массива
  'setup_rules.one' => array (                                           // запись ключей через точку
    'type' => 'array',
    
    'enum' => array (1, 2, 5, 10),                                       // разрешенные значения массива
    // ИЛИ
    'range' => array (0, 10),                                            // диапазон чисел (для числовых значений массива)
    
    'name' => 'config_parameters.setup_rules.one.name'                   // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.setup_rules.one.description',    // отображаемое описание параметра, ключ языкового файла
  ),
  
  // Пример для параметра массива
  'setup_rules.two' => array (
    'type' => 'bool',
    'name' => 'config_parameters.setup_rules.two.name'                   // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.setup_rules.two.description',    // отображаемое описание параметра, ключ языкового файла
  ),
  
  // Пример для параметра массива
  'setup_rules.three' => array (
    'type' => 'bool',
    'name' => 'config_parameters.setup_rules.three.name'                   // отображаемое имя параметра, ключ языкового файла
    'description' => 'config_parameters.setup_rules.three.description',    // отображаемое описание параметра, ключ языкового файла
  ),
  

);


return $config;
?>