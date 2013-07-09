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

class PluginAdmin_ActionAdmin extends ActionPlugin {

	public function Init() {
		// Reset added styles and scripts
		$this->Viewer_ClearStyle(true);
		
		/**
		 * Styles
		 */
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/reset.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/helpers.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/text.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/dropdowns.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/buttons.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/forms.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/navs.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/modals.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/tooltip.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/popover.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/alerts.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/toolbar.css");
		$this->Viewer_AppendStyle(Config::Get('path.static.framework')."/css/toolbar.css");

		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."css/base.css");
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."css/grid.css");
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."css/blocks.css");
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."css/pagination.css");
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."css/icons.css");
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."css/navs.css");
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__)."css/__temp__.css");								// todo: temporary, delete on production

		/**
		 * Scripts
		 */
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery-1.9.1.min.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery-ui/js/jquery-ui-1.10.2.custom.min.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery-ui/js/localization/jquery-ui-datepicker-ru.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.browser.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.scrollto.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.rich-array.min.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.form.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.jqplugin.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.cookie.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.serializejson.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.file.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jcrop/jquery.Jcrop.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.placeholder.min.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.charcount.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/jquery.imagesloaded.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/notifier/jquery.notifier.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/markitup/jquery.markitup.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/prettify/prettify.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/vendor/prettyphoto/js/jquery.prettyphoto.js");

		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/core/hook.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/core/main.js");

		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/ui/popup.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/ui/dropdown.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/ui/tooltip.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/ui/popover.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/ui/tab.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/ui/modal.js");
		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/ui/toolbar.js");

		$this->Viewer_AppendScript(Config::Get('path.static.framework')."/js/livestreet/init.js");
		$this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__)."/js/init.js");

		$this->Hook_Run('init_action_admin');
		$this->SetDefaultEvent('index');
	}



	/**
	 * Регистрируем евенты
	 *
	 */
	protected function RegisterEvent() {
		/**
		 * Регистрируем внешние обработчики евентов
		 */
		$this->RegisterEventExternal('User','PluginAdmin_ActionAdmin_EventUser');
		$this->RegisterEventExternal('Plugin','PluginAdmin_ActionAdmin_EventPlugin');
		$this->RegisterEventExternal('Plugins', 'PluginAdmin_ActionAdmin_EventPlugins');					// Список плагинов
		$this->RegisterEventExternal('Settings', 'PluginAdmin_ActionAdmin_EventSettings');				// Работа с настройками плагинов
		
		//
		// дашборд и статистика
		//
		$this->AddEvent('index', 'EventIndex');
		
		//
		// Пользователи
		//
		$this->AddEventPreg('/^user$/i', '/^list$/i','/^$/i', 'User::EventUserList');
		//$this->AddEventPreg('/^user$/i','/^(\d+)\.html$/i','/^$/i','User::EventShowTopic');
		//$this->AddEvent('user', 'User::EventUser');
		
		//
		// Плагины
		//
		//$this->AddEventPreg('#^plugin$#iu', '#^toggle$#iu', 'Plugins::EventPluginsToggle');//todo:
		$this->AddEventPreg('#^plugins$#iu', '#^list$#iu', 'Plugins::EventPluginsList');
		$this->AddEventPreg('/^plugin$/i', '/^[\w_\-]+$/i', 'Plugin::EventPlugin');			// показать страницу собственных настроек плагина
		
		//
		// Настройки
		//
		$this->AddEventPreg('#^settings$#iu', '#^plugin$#iu', 'Settings::EventShow');
		$this->AddEventPreg('#^settings$#iu', '#^save$#iu', 'Settings::EventSaveConfig');
	}


	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */

	protected function EventIndex() {
		// дашборд
		$this->SetTemplateAction('index');
	}
	
	
	
	
	// Построение меню
	private function InitMenu() {
		$this->PluginAdmin_Ui_GetMenuMain()
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')
				->SetCaption('Главная') // $this->Lang_Get('admin_menu_main_section_main_caption')
				->SetCssClass('sb-item-1')
				->SetUrl('')
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')
				->SetCaption('Пользователи')
				->SetName('users')
				->SetCssClass('sb-item-8')
				->SetUrl('user')
				->AddItem(
					Engine::GetEntity('PluginAdmin_Ui_MenuItem')
					->SetCaption('Статистика')
					->SetUrl('stats')
				)
				->AddItem(
					Engine::GetEntity('PluginAdmin_Ui_MenuItem')
					->SetCaption('Весь список')
					->SetUrl('list')
				)
				->AddItem(
					Engine::GetEntity('PluginAdmin_Ui_MenuItem')
					->SetCaption('Бан-листы')
					->SetUrl('ban')
				)
				->AddItem(
					Engine::GetEntity('PluginAdmin_Ui_MenuItem')
					->SetCaption('Администраторы')
					->SetUrl('admins')
				)
				->AddItem(
					Engine::GetEntity('PluginAdmin_Ui_MenuItem')
					->SetCaption('Инвайты')
					->SetUrl('invite')
				)
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')
				->SetCaption('Плагины')
				->SetName('plugins')
				->SetCssClass('sb-item-3')
				->SetUrl('plugins')
				->AddItem(
					Engine::GetEntity('PluginAdmin_Ui_MenuItem')
					->SetCaption('Список плагинов')
					->SetUrl('list')
				)
				->AddItem(
					Engine::GetEntity('PluginAdmin_Ui_MenuItem')
					->SetCaption('Установить плагин')
					->SetUrl('install')
				)
			)	// /AddSection
		;
	}
	
	

	public function EventShutdown() {
		//$this->Viewer_Assign('oCursor', $this->PluginAdmin_Ui_GetCursor());		// todo: delete, unneeded
		$this->Viewer_Assign('oMenuMain', $this->PluginAdmin_Ui_GetMenuMain());
		$this->Viewer_Assign('oMenuAddition', $this->PluginAdmin_Ui_GetMenuAddition());

		$this->InitMenu();	// todo: review: dublicates menu when redirecting using router
		$this->Viewer_AddBlock('right','blocks/block.nav.tpl',array('plugin'=>'admin'));

		$this->PluginAdmin_Ui_HighlightMenus();
		//$this->PluginAdmin_Ui_ArraysToViewer();
		
		$this -> Viewer_Assign ('sAdminSystemConfigId', PluginAdmin_ModuleSettings::SYSTEM_CONFIG_ID);	// todo: review
	}
	
}

?>