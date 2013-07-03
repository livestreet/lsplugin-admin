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

	protected $oUser=12345;
	protected $aItem=array(1,2);

	public function Init() {
		$this->SetDefaultEvent('index');

		/**
		 * Styles
		 */
		$this->Viewer_ClearStyle(true);
		
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


		//var_dump($this->aItem);

		$this->Viewer_Assign('oCursor', $this->PluginAdmin_Ui_GetCursor());
		$this->Viewer_Assign('oMenuMain', $this->PluginAdmin_Ui_GetMenuMain());
		$this->Viewer_Assign('oMenuAddition', $this->PluginAdmin_Ui_GetMenuAddition());

		$this->InitMenu();
		$this->Viewer_AddBlock('right','blocks/block.nav.tpl',array('plugin'=>'admin'));

		$this->Hook_Run('init_action_admin');
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

		$this->AddEvent('index','EventIndex');

		//$this->AddEvent('user', 'User::');
		$this->AddEventPreg('/^user$/i','/^list$/i','/^$/i','User::EventUserList');
		$this->AddEventPreg('/^user$/i','/^(\d+)\.html$/i','/^$/i','User::EventShowTopic');
		$this->AddEvent('user', 'User::EventUser');
		$this->AddEventPreg('/^plugin$/i','/^[\w_\-]+$/i','Plugin::EventPlugin');
	}


	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */

	protected function test($s) {
		var_dump('test!');
		return 'bla: '.$s;
	}

	protected function EventIndex() {

		/**
		 * Устанавливаем шаблон для вывода
		 */
		$this->SetTemplateAction('index');
	}

	protected function EventUser() {

		/**
		 * Устанавливаем шаблон для вывода
		 */
		$this->SetTemplateAction('index');
	}


	private function InitMenu()
	{
		$this->PluginAdmin_Ui_GetMenuMain()
			->AddSection(
			Engine::GetEntity('PluginAdmin_Ui_MenuSection')
				->SetCaption('Главная') // $this->Lang_Get('admin_menu_main_section_main_caption')
				->SetCssClass('sb-item-1')
				->SetUrl('')
		)
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
		)
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
		)
		;
	}

	public function EventShutdown() {
		$this->PluginAdmin_Ui_HighlightMenus();
		//$this->PluginAdmin_Ui_ArraysToViewer();
		//var_dump($this->aItem);
	}
}
?>