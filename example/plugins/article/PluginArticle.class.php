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

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
	die('Hacking attempt!');
}

class PluginArticle extends Plugin {

	public function Init() {

	}

	public function Activate() {
		if (!$this->isTableExists('prefix_article')) {
			/**
			 * При активации выполняем SQL дамп
			 */
			$this->ExportSQL(dirname(__FILE__).'/dump.sql');
		}
		/**
		 * Создаем новый тип для дополнительных полей
		 * Третий параметр true ознает перезапись параметров, если такой тип уже есть в БД
		 */
		if (!$this->Property_CreateTargetType('article',array('entity'=>'PluginArticle_ModuleMain_EntityArticle','name'=>'Статьи'),true)) {
			return false;
		}
		return true;
	}

	public function Deactivate() {

		return true;
	}
}