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
		/*
		 * наивысший приоритет, который можно установить
		 */
		$this->AddHook('lang_init_start', 'LangInitStart', __CLASS__, PHP_INT_MAX);
	}


	public function LangInitStart() {
		/*
		 *
		 * --- Важно ---
		 *
		 * Никогда не менять порядок этих вызовов и не выносить их отсюда в другие хуки. Например, предпросмотр шаблона отсюда НЕ выносить в хук для шаблонов.
		 * Это связано с порядком обращения к конфигам и хотя можно использовать приоритеты хуков, но тогда отладка такого кода была бы весьма неудобна,
		 * т.к. методы разных модулей должны запускаться в определенном порядке, поэтому именно здесь должны остаться эти методы и только в этом порядке!
		 *
		 * ВАЖНО: первый вызов к вьюеру должен быть ПОСЛЕ загрузки данных конфигов и обработки шаблонов
		 * т.к. вьюер при ините получает часть данных конфига (в противном случае может не работать, например, предпросмотр шаблона)
		 *
		 */

		/*
		 * выполнить загрузку конфигов системы и плагинов
		 */
		$this->PluginAdmin_Settings_AutoLoadConfigs();
		/*
		 * присоеденить схему главного конфига и текстовки
		 */
		$this->PluginAdmin_Settings_AddSchemeAndLangToRootConfig();

		/*
		 * показать предпросмотр шаблона, если он был выбран в админке
		 */
		$this->PluginAdmin_Skin_LoadPreviewTemplate();

		/*
		 * добавить директорию с плагинами для Smarty
		 */
		$this->Viewer_AddSmartyPluginsDir(Plugin::GetPath(__CLASS__) . 'include/smarty/');
	}
	
}

?>