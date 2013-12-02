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
 * Список директорий (масок файлов), которые следует проверить на некорректную кодировку (при вызове соответсвующего метода из утилит)
 */

/*
 * Список масок поиска файлов для проверки
 */
$config['encoding_checking_dirs'] = array(
	/*
	 *
	 * --- Проверка файлов фреймворка ---
	 *
	 */
	/*
	 * все конфиги: конфиг, жевикс, загрузчик
	 */
	array('path' => Config::Get('path.framework.server') . '/config/', 'file_masks' => 'php'),
	/*
	 * все css файлы
	 */
	array('path' => Config::Get('path.framework.server') . '/frontend/framework/css/', 'file_masks' => 'css'),
	/*
	 * все js файлы (кроме папки vendor, которую никто не редактирует)
	 */
	array('path' => Config::Get('path.framework.server') . '/frontend/framework/js/core/', 'file_masks' => 'js'),
	array('path' => Config::Get('path.framework.server') . '/frontend/framework/js/ui/', 'file_masks' => 'js'),
	/*
	 * языковые файлы
	 */
	array('path' => Config::Get('path.framework.server') . '/frontend/i18n/', 'file_masks' => 'php'),
	/*
	 * файлы шаблонов
	 */
	array('path' => Config::Get('path.framework.server') . '/frontend/templates/', 'file_masks' => array('tpl', 'js', 'css')),
	/*
	 * файлы инклуда
	 */
	array('path' => Config::Get('path.framework.server') . '/include/', 'file_masks' => 'php'),


	/*
	 *
	 * --- Проверка файлов приложения ---
	 *
	 */
	/*
	 * все конфиги: конфиг, жевикс
	 */
	array('path' => Config::Get('path.application.server') . '/config/', 'file_masks' => 'php'),
	/*
	 * все js файлы
	 */
	array('path' => Config::Get('path.application.server') . '/frontend/common/js/', 'file_masks' => 'js'),
	/*
	 * языковые файлы
	 */
	array('path' => Config::Get('path.application.server') . '/frontend/i18n/', 'file_masks' => 'php'),
	/*
	 * файлы шаблонов
	 */
	array('path' => Config::Get('path.application.server') . '/frontend/skin/', 'file_masks' => array('tpl', 'js', 'css')),
	/*
	 * файлы инклуда
	 */
	array('path' => Config::Get('path.application.server') . '/include/', 'file_masks' => 'php'),
	/*
	 * проверить файлы крона
	 */
	array('path' => Config::Get('path.application.server') . '/utilities/cron/', 'file_masks' => 'php'),


	/*
	 *
	 * --- Проверка файлов плагинов ---
	 *
	 */
	/*
	 * конфиги плагинов
	 */
	array('path' => Config::Get('path.application.server') . '/plugins/*/config/', 'file_masks' => 'php'),
	/*
	 * инклуды плагинов
	 */
	array('path' => Config::Get('path.application.server') . '/plugins/*/include/', 'file_masks' => 'php'),
	/*
	 * языковые файлы плагинов
	 */
	array('path' => Config::Get('path.application.server') . '/plugins/*/templates/i18n/', 'file_masks' => 'php'),
	/*
	 * файлы шаблонов плагинов
	 */
	array('path' => Config::Get('path.application.server') . '/plugins/*/templates/skin/', 'file_masks' => array('tpl', 'js', 'css')),
);

return $config;

?>