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
 * --- Описание АПИ официального каталога плагинов для LiveStreet CMS ---
 *
 */

/*
 * Базовый путь к АПИ каталога
 */
$config['catalog']['base_api_url'] = 'https://catalog.livestreetcms.com/api/';

/*
 * Методы для работы с каталогом
 * tip:
 * 		1. строка "{plugin_code}" - код плагина (имя папки плагина)
 * 		2. ключи в массивах нужны для формирования метода для доступа к АПИ каталога, в значениях указывается относительный урл
 */
$config['catalog']['methods_pathes'] = array(
	/*
	 * Группа: работа с одним плагином с указанием его кода
	 */
	'plugin' => array(
		/*
		 * относительный урл: получить лого плагина (180х180)
		 */
		'logo' => 'plugin/{plugin_code}/get-logo/',
	),
	/*
	 * Группа: работа со списком плагинов
	 */
	'addons' => array(
		/*
		 * относительный урл: получить обновления списка плагинов
		 */
		'check_version' => 'addons/check-version/',
		/*
		 * относительный урл: получить список плагинов из каталога по фильтру
		 */
		'filter' => 'addons/filter/',			// todo:
	),
);

/*
 * Время кеширования запросов из каталога
 */
$config['catalog']['cache_live_time'] = array(
	/*
	 * получение обновлений (1 час)
	 */
	'plugin_updates_check' => 60*60*1
);

/*
 * Проверять наличие новых версий плагинов в каталоге
 */
$config['catalog']['allow_plugin_updates_checking'] = true;

/*
 * Добавить кнопку в тулбар с количеством обновлений плагинов
 */
$config['catalog']['show_updates_count_in_toolbar'] = true;

/*
 * макс. время подключения к серверу, сек
 */
$config['catalog']['max_connect_timeout'] = 2;

/*
 * макс. время получения данных от сервера, сек
 */
$config['catalog']['max_work_timeout'] = 4;

return $config;

?>