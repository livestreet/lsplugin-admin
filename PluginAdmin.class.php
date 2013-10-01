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

/**
 * Запрещаем напрямую через браузер обращение к этому файлу
 */
if (!class_exists('Plugin')) {
	die('Hacking attempt!');
}

class PluginAdmin extends Plugin {

	public function Activate() {
		/*
		 * дамп таблицы для банов пользователя
		 */
		if (!$this -> isTableExists ('prefix_admin_users_ban')) {
			$this -> ExportSQL (dirname (__FILE__) . '/sql_dumps/admin_users_ban.sql');
		}
		return true;
	}
	
	
	public function Init() {}
	
	
	protected $aInherits = array(
		'module' => array(
			/*
			 * Расширение возможностей работы со Smarty
			 */
			'ModuleViewer',
			/*
			 * Расширение возможностей работы с хранилищем и сохранением данных конфигов
			 */
			'ModuleStorage',
			/*
			 * Расширение возможностей показа сообщений об ошибках
			 */
			'ModuleMessage'
		),
		'entity' => array(
			/*
			 * Добавляем новый тип валидатора - Array
			 */
			'ModuleValidate_EntityValidatorArray',
		)
	);

}

?>