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
$config['catalog_base_api_url'] = 'https://catalog.livestreetcms.com/api/';

/*
 * Методы для работы с каталогом
 * tip: ключ {plugin_code} - код плагина (имя папки плагина)
 */
$config['catalog_methods_pathes'] = array(
	/*
	 * Группа: работа с одним плагином с указанием его кода
	 */
	'plugin' => array(
		/*
		 * получить лого плагина
		 */
		'logo' => 'plugin/{plugin_code}/get-logo/',
	),
);

return $config;

?>