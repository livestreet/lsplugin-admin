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
 * tip: ключ {plugin_code} - код плагина (имя папки плагина)
 */
$config['catalog']['methods_pathes'] = array(
	/*
	 * Группа: работа с одним плагином с указанием его кода
	 */
	'plugin' => array(
		/*
		 * полный урл: получить лого плагина (180х180)
		 */
		'logo' => 'plugin/{plugin_code}/get-logo/',
	),
	/*
	 * Группа: работа со списком плагинов
	 */
	'addons' => array(
		/*
		 * полный урл: получить обновления списка плагинов
		 */
		'check_version' => 'addons/check-version/',
	),
);

/*
 * Время кеширования запросов из каталога
 */
$config['catalog']['cache_live_time'] = array(
	/*
	 * получение обновлений (5 минут)
	 */
	'plugin_updates_check' => 60*5
);

/*
 * Проверять наличие новых версий плагинов в каталоге
 */
$config['catalog']['allow_plugin_updates_checking'] = true;

return $config;

?>