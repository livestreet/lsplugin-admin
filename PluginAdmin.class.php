<?php
/*-------------------------------------------------------
*
*	 LiveStreet Engine Social Networking
*	 Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*	 Official site: www.livestreet.ru
*	 Contact e-mail: rus.engine@gmail.com
*
*	 GNU General Public License, version 2:
*	 http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
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
			 * расширение возможностей работы со Smarty
			 */
			'ModuleViewer',
			/*
			 * расширение возможностей работы с хранилищем и сохранением данных конфигов
			 */
			'ModuleStorage',
			/*
			 * расширение возможностей показа сообщений об ошибках
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