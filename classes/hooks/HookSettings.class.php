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
 * Работа с настройками плагинов и движка
 *
 */

class PluginAdmin_HookSettings extends Hook {

	public function RegisterHook() {
		$this->AddHook('lang_init_start', 'LangInitStart', __CLASS__, PHP_INT_MAX);			// наивысший приоритет, который можно установить
	}


	public function LangInitStart() {
		/*
		 * выполнить загрузку конфигов системы и плагинов
		 */
		$this->PluginAdmin_Settings_AutoLoadConfigs();
		/*
		 * присоеденить схему главного конфига и текстовки
		 */
		$this->PluginAdmin_Settings_AddSchemeAndLangToRootConfig();
		/*
		 * показать превью шаблона, если он был выбран в админке
		 */
		$this->PluginAdmin_Skin_LoadPreviewTemplate();
		/*
		 * добавить директорию с плагинами для Smarty
		 */
		$this->Viewer_AddSmartyPluginsDir(Plugin::GetPath(__CLASS__) . 'include/smarty/');
	}
	
}

?>