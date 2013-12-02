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
	Config::Get('path.framework.server') . '/config/*.php',
	/*
	 * все css файлы
	 */
	Config::Get('path.framework.server') . '/frontend/framework/css/*.css',
	/*
	 * все js файлы (кроме папки vendor, которую никто не редактирует)
	 */
	Config::Get('path.framework.server') . '/frontend/framework/js/core/*.js',
	Config::Get('path.framework.server') . '/frontend/framework/js/ui/*.js',
	/*
	 * языковые файлы
	 */
	Config::Get('path.framework.server') . '/frontend/i18n/*.php',
	/*
	 * файлы шаблонов
	 */
	Config::Get('path.framework.server') . '/frontend/templates/*.tpl',
	Config::Get('path.framework.server') . '/frontend/templates/*.js',
	Config::Get('path.framework.server') . '/frontend/templates/*.css',

	/*
	 *
	 * --- Проверка файлов приложения ---
	 *
	 */
	/*
	 * все конфиги: конфиг, жевикс
	 */
	Config::Get('path.application.server') . '/config/*.php',
	/*
	 * все js файлы
	 */
	Config::Get('path.application.server') . '/frontend/common/js/*.js',
	/*
	 * языковые файлы
	 */
	Config::Get('path.application.server') . '/frontend/i18n/*.php',
	/*
	 * файлы шаблонов
	 */
	Config::Get('path.application.server') . '/frontend/skin/*.tpl',//todo
	Config::Get('path.application.server') . '/frontend/skin/*.js',
	Config::Get('path.application.server') . '/frontend/skin/*.css',
	/*
	 * проверить файлы крона
	 */
	Config::Get('path.application.server') . '/utilities/cron/*.php',

	/*
	 *
	 * --- Плагины ---
	 *
	 */
	/*
	 * конфиги плагинов
	 */
	Config::Get('path.application.server') . '/plugins/*/config/*.php',
	/*
	 * инклуды плагинов
	 */
	Config::Get('path.application.server') . '/plugins/*/include/*.php',
	/*
	 * языковые файлы плагинов
	 */
	Config::Get('path.application.server') . '/plugins/*/templates/i18n/*.php',
	/*
	 * файлы шаблонов плагинов
	 */
	Config::Get('path.application.server') . '/plugins/*/templates/skin/*.tpl',// todo:
	Config::Get('path.application.server') . '/plugins/*/templates/skin/*.js',
	Config::Get('path.application.server') . '/plugins/*/templates/skin/*.css',
);

return $config;

?>