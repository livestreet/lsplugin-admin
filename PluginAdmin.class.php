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

	/**
	 * Активация плагина
	 *
	 * @return bool
	 */
	public function Activate() {
		/*
		 * проверить необходимый минимум для запуска плагина
		 */
		if (!$this->CheckDependencies()) return false;
		/*
		 * дамп таблицы для банов пользователя
		 */
		if (!$this -> isTableExists ('prefix_admin_users_ban')) {
			$this -> ExportSQL (dirname (__FILE__) . '/sql_dumps/admin_users_ban.sql');
		}
		return true;
	}


	/**
	 * Инициализация плагина
	 */
	public function Init() {}


	/**
	 * Массив в записями о наследовании плагином части функционала
	 *
	 * @var array
	 */
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
			/*
			 * Для добавления информации о бане пользователя
			 */
			'ModuleUser_EntityUser'
		)
	);


	/**
	 * Проверка зависимостей плагина
	 *
	 * @return bool
	 */
	protected function CheckDependencies() {
		/*
		 * плагин ни под чем другим не запустится
		 */
		if (!defined('LS_VERSION_FRAMEWORK')) {
			Engine::getInstance()->Message_AddError('This plugin needs to be run in original LiveStreet CMS Framework', 'Error', true);
			return false;
		}
		/*
		 * блокировка от использования одновременно другой админки т.к. возможны конфликты/коллизии
		 * tip: не включать одновременно несколько админок т.к. могут быть самые непредсказуемые последствия
		 */
		if (defined('ACEADMINPANEL_VERSION')) {
			Engine::getInstance()->Message_AddError('You should fully remove old AceAdminPanel plugin and its tables before enabling this admin panel', 'Error', true);
			return false;
		}
		return true;
	}

}

?>