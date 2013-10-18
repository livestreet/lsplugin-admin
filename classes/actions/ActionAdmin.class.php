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

class PluginAdmin_ActionAdmin extends ActionPlugin {
	protected $oUserCurrent = null;
	
	/*
	 * Списки групп настроек системного конфига
	 */
	protected $aCoreSettingsGroups = array();
	
	/*
	 * Имя виртуального метода, который будет пойман в __call для групп системных настроек
	 */
	protected $sCallbackMethodToShowSystemSettings = 'EventShowSystemSettings';


	public function Init() {
		if (!$this->oUserCurrent = $this->User_GetIsAdmin(true)) {
			$this->Message_AddError($this->Lang('errors.you_are_not_admin'), $this->Lang_Get('error'));
			return Router::Action('error');
		}

		/*
		 * задать таблицы стилей и жс файлов для админки
		 */
		$this->AddJSAndCSSFiles();

		/*
		 * получить группы настроек системного конфига
		 */
		$this->aCoreSettingsGroups = Config::Get('plugin.admin.core_config_groups');
		
		$this->SetDefaultEvent('index');

		$this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.admin.title'));
		$this->InitMenu();
		$this->Hook_Run('init_action_admin');
	}


	/**
	 * Регистрируем евенты
	 */
	protected function RegisterEvent() {
		/*
		 *
		 * --- Регистрируем внешние обработчики евентов ---
		 *
		 */

		/*
		 * Модуль "Property"
		 */
		$this->RegisterEventExternal('Property', 'PluginAdmin_ActionAdmin_EventProperty');
		/*
		 * Работа с пользователями
		 */
		$this->RegisterEventExternal('Users', 'PluginAdmin_ActionAdmin_EventUsers');
		/*
		 * Встраивание интерфейса плагина в админку
		 */
		$this->RegisterEventExternal('Plugin', 'PluginAdmin_ActionAdmin_EventPlugin');
		/*
		 * Список плагинов
		 */
		$this->RegisterEventExternal('Plugins', 'PluginAdmin_ActionAdmin_EventPlugins');
		/*
		 * Работа с настройками плагинов и движка
		 */
		$this->RegisterEventExternal('Settings', 'PluginAdmin_ActionAdmin_EventSettings');
		/*
		 * Дашбоард
		 */
		$this->RegisterEventExternal('Dashboard', 'PluginAdmin_ActionAdmin_EventDashboard');

		/*
		 *
		 * --- Модуль свойств ----
		 *
		 */
		$this->AddEventPreg('#^properties$#i', '#^\w+$#i', '#^$#i', 'Property::EventPropertiesTarget');
		$this->AddEventPreg('#^properties$#i', '#^\w+$#i', '#^update$#i', '#^\d{1,5}$#i', 'Property::EventPropertyUpdate');
		$this->AddEventPreg('#^properties$#i', '#^\w+$#i', '#^create$#i', '#^$#i', 'Property::EventPropertyCreate');

		/*
		 *
		 * --- дашборд ---
		 *
		 */
		$this->AddEvent('index', 'Dashboard::EventIndex');
		/*
		 * аякс смена периода в блоке новых объектов
		 */
		$this->AddEvent('ajax-get-new-items-block', 'Dashboard::EventAjaxGetNewItemsBlock');
		/*
		 * аякс смена отображения активности (настройка событий)
		 */
		$this->AddEvent('ajax-get-index-activity', 'Dashboard::EventAjaxGetIndexActivity');
		/*
		 * аякс отображения активности ленты дальше
		 */
		$this->AddEvent('ajax-get-index-activity-more', 'Dashboard::EventAjaxGetIndexActivityMore');
		/**
		 * Обработка ошибок, аналог ActionError
		 */
		$this->AddEvent('error', 'EventError');

		/*
		 *
		 * --- Пользователи ---
		 *
		 */

		/*
		 * список пользователей
		 */
		$this->AddEventPreg('#^users$#iu', '#^list$#iu', '#^(page(\d{1,5}))?$#iu', 'Users::EventUsersList');
		/*
		 * страница информации о пользователе
		 */
		$this->AddEventPreg('#^users$#iu', '#^profile$#iu', '#^\d{1,5}$#iu', 'Users::EventUserProfile');
		/*
		 * просмотр в постраничном режиме за что именно голосовал пользователь
		 */
		$this->AddEventPreg('#^users$#iu', '#^votes$#iu', '#^\d{1,5}$#iu', 'Users::EventUserVotesList');
		/*
		 * список админов
		 */
		$this->AddEventPreg('#^users$#iu', '#^admins$#iu', '#^(page(\d{1,5}))?$#iu', 'Users::EventAdminsList');
		/*
		 * добавить бан
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^add$#iu', 'Users::EventAddBan');
		/*
		 * список банов
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^(?:all)?|permanent|period$#iu', '#^(page(\d{1,5}))?$#iu', 'Users::EventBansList');
		/*
		 * редактировать бан
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^edit$#iu', '#^\d++$#iu', 'Users::EventEditBan');
		/*
		 * удалить бан
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^delete$#iu', '#^\d++$#iu', 'Users::EventDeleteBan');
		/*
		 * добавить или удалить админа
		 */
		$this->AddEventPreg('#^users$#iu', '#^site_admins$#iu', '#^(add|delete$)$#iu', '#^\d++$#iu', 'Users::EventManageAdmins');
		/*
		 * удалить контент пользователя и самого пользователя
		 */
		$this->AddEventPreg('#^users$#iu', '#^(deletecontent|deleteuser)$#iu', '#^\d++$#iu', 'Users::EventDeleteUserContent');
		/*
		 * статистика пользователей
		 */
		$this->AddEventPreg('#^users$#iu', '#^stats$#iu', 'Users::EventShowUserStats');

		/*
		 * аякс обработчики
		 */
		/*
		 * изменение количества пользователей на страницу
		 */
		$this->AddEventPreg('#^users$#iu', '#^ajax-on-page$#iu', 'Users::EventAjaxUsersOnPage');
		/*
		 * изменение рейтинга и силы пользователя
		 */
		$this->AddEventPreg('#^users$#iu', '#^ajax-edit-rating$#iu', 'Users::EventAjaxEditUserRatingAndSkill');
		/*
		 * изменение количества банов на страницу
		 */
		$this->AddEventPreg('#^bans$#iu', '#^ajax-on-page$#iu', 'Users::EventAjaxBansOnPage');
		/*
		 * изменение количества голосов на страницу
		 */
		$this->AddEventPreg('#^votes$#iu', '#^ajax-on-page$#iu', 'Users::EventAjaxVotesOnPage');
		/*
		 * проверить правило бана на корректность
		 */
		$this->AddEventPreg('#^bans$#iu', '#^ajax-check-user-sign$#iu', 'Users::EventAjaxBansCheckUserSign');

		/*
		 *
		 * --- Плагины ---
		 *
		 */

		/*
		 * показать страницу собственных настроек плагина
		 */
		$this->AddEventPreg('#^plugin$#i', '#^[\w-]+$#i', 'Plugin::EventPlugin');
		/*
		 * список плагинов
		 */
		$this->AddEventPreg('#^plugins$#iu', '#^(?:list)?$#iu', 'Plugins::EventPluginsList');

		/*
		 *
		 * --- Настройки ---
		 *
		 */

		/*
		 * Настройки плагина
		 */
		$this->AddEventPreg('#^settings$#iu', '#^plugin$#iu', 'Settings::EventShow');
		/*
		 * Сохранить настройки
		 */
		$this->AddEventPreg('#^settings$#iu', '#^save$#iu', 'Settings::EventSaveConfig');
		/*
		 * Управление темами шаблонов
		 */
		$this->AddEventPreg('#^settings$#iu', '#^skin$#iu', '#^theme$#iu', 'Settings::EventProcessSkinTheme');
		/*
		 * Управление шаблонами
		 */
		$this->AddEventPreg('#^settings$#iu', '#^skin$#iu', 'Settings::EventProcessSkin');

		/*
		 *
		 * --- Системные настройки ---
		 *
		 */

		/*
		 * для каждой группы настроек добавим виртуальный эвент и будем ловить их через __call()
		 * чтобы не плодить полупустых методов, так компактнее и удобнее
		 * todo: нужно что-то ещё с меню придумать чтобы полностью автоматизировать процесс создания групп
		 * пока в меню нужно прописывать вручную пункты групп
		 */
		foreach(array_keys(Config::Get('plugin.admin.core_config_groups')) as $sKey) {
			$this->AddEventPreg('#^settings$#iu', '#^' . $sKey . '$#iu', 'Settings::' . $this->sCallbackMethodToShowSystemSettings . $sKey);
		}
	}


	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */


	/**
	 * Построение меню
	 */
	private function InitMenu() {
		$oMenu = $this->PluginAdmin_Ui_GetMenuMain();
		if ($oMenu->GetSections()) {
			return;
		}
		$oMenu->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Главная')->SetUrl('')
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Пользователи')->SetName('users')->SetUrl('users')
				
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Статистика')->SetUrl('stats'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Весь список')->SetUrl('list'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Бан-листы')->SetUrl('bans'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Администраторы')->SetUrl('admins'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Инвайты')->SetUrl('invite'))
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Плагины')->SetName('plugins')->SetUrl('plugins')
				
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Список плагинов')->SetUrl('list'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Установить плагин')->SetUrl('install'))
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Настройки')->SetName('settings')->SetUrl('settings')
				
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Шаблоны')->SetUrl('skin'))
				
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Внешний вид сайта')->SetUrl('view'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Интерфейс')->SetUrl('interface'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Системные')->SetUrl('system'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Почта')->SetUrl('sysmail'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('ACL создания')->SetUrl('aclcreate'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('ACL голосования')->SetUrl('aclvote'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль блогов')->SetUrl('moduleblog'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль топиков')->SetUrl('moduletopic'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль пользователей')->SetUrl('moduleuser'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль комментариев')->SetUrl('modulecomment'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль писем')->SetUrl('moduletalk'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль уведомлений')->SetUrl('modulenotify'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль изображений')->SetUrl('moduleimage'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль стены')->SetUrl('modulewall'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модули разные')->SetUrl('moduleother'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Таблицы БД')->SetUrl('db'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Правила блоков')->SetUrl('blocksrule'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Обработка JS и CSS')->SetUrl('compress'))
			)	// /AddSection
		;
	}
	
	
	/*
	 * Хелперы
	 */


	/**
	 * Делает редирект на страницу, с которой пришел запрос
	 */
	public function RedirectToReferer() {
		return Router::Location(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : Router::GetPath('admin'));
	}


	/**
	 * Быстрое получение текстовки плагина без указания префикса
	 *
	 * @param $sKey		ключ языкового файла (без префикса plugin.имяплагина.)
	 * @param $aParams	параметры подстановки значений для передачи в текстовку
	 * @return mixed	значение
	 */
	public function Lang($sKey, $aParams = array()) {
		return $this->Lang_Get('plugin.admin.' . $sKey, $aParams);
	}


	/**
	 * Получить значение из фильтра (массива-переменной "filter" из реквеста) или весь фильтр
	 *
	 * @param $sName				имя ключа из массива фильтра или null для получения всего фильтра
	 * @return mixed|array|null		значение
	 */
	protected function GetDataFromFilter($sName = null) {
		/*
		 * получить фильтр, хранящий в себе все параметры (разрезы показа, сортировку, поиск и др.)
		 */
		if ($aFilter = getRequest('filter') and is_array($aFilter)) {
			/*
			 * если нужны все значения фильтра
			 */
			if (!$sName) {
				return $aFilter;
			}
			/*
			 * если нужно выбрать одно значение из фильтра
			 */
			if ($sName and isset($aFilter[$sName]) and $aFilter[$sName]) {
				return $aFilter[$sName];
			}
		}
		return null;
	}
	
	
	public function EventShutdown() {
		$this->Viewer_Assign('oMenuMain', $this->PluginAdmin_Ui_GetMenuMain());
		$this->Viewer_Assign('oMenuAddition', $this->PluginAdmin_Ui_GetMenuAddition());

		$this->Viewer_AddBlock('right','blocks/block.nav.tpl', array('plugin'=>'admin'));

		if (Router::GetActionEvent()!='error') {
			$this->PluginAdmin_Ui_HighlightMenus();
		}


		/*
		 * записать данные последнего входа пользователя в админку
		 */
		$this->PluginAdmin_Users_SetLastVisitData();

		/*
		 * для редактирования настроек плагинов и системы
		 */
		$this->Viewer_Assign('sAdminSettingsFormSystemId', PluginAdmin_ModuleSettings::ADMIN_SETTINGS_FORM_SYSTEM_ID);
		$this->Viewer_Assign('sAdminSystemConfigId', ModuleStorage::DEFAULT_KEY_NAME);
	}


	public function EventError() {
		$aHttpErrors=array(
			'404' => array(
				'header' => '404 Not Found',
			),
		);
		$iNumber=$this->GetParam(0);
		if (array_key_exists($iNumber,$aHttpErrors)) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error_'.$iNumber),$iNumber);
			$aHttpError=$aHttpErrors[$iNumber];
			if (isset($aHttpError['header'])) {
				$sProtocol=isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
				header("{$sProtocol} {$aHttpError['header']}");
			}
		}
		$this->Viewer_AddHtmlTitle($this->Lang_Get('error'));
		$this->SetTemplateAction('error');
	}


	protected function EventNotFound() {
		return Router::Action('admin', 'error', array('404'));
	}


	/**
	 * Добавить свои файлы JS и CSS для админки
	 */
	protected function AddJSAndCSSFiles () {
		/*
		 * обнулить списки скриптов и таблиц стилей
		 */
		$this->Viewer_ClearStyle (true);

		$sFrameworkPath = Config::Get ('path.framework.frontend.web');
		$sPluginTemplatePath = Plugin::GetTemplatePath (__CLASS__) . 'assets';

		/*
		 * набор стилей для админки
		 */
		$aStyles = array (
			/*
			 * стили, задаваемые фреймворком
			 */
			$sFrameworkPath . '/css/reset.css',
			$sFrameworkPath . '/css/helpers.css',
			$sFrameworkPath . '/css/text.css',
			$sFrameworkPath . '/css/dropdowns.css',
			$sFrameworkPath . '/css/buttons.css',
			$sFrameworkPath . '/css/forms.css',
			$sFrameworkPath . '/css/navs.css',
			$sFrameworkPath . '/css/modals.css',
			$sFrameworkPath . '/css/tooltip.css',
			$sFrameworkPath . '/css/typography.css',
			$sFrameworkPath . '/css/grid.css',
			$sFrameworkPath . '/css/alerts.css',
			$sFrameworkPath . '/css/toolbar.css',
			$sFrameworkPath . '/js/vendor/jquery-ui/css/smoothness/jquery-ui-1.10.2.custom.css', 			// todo: review (needed for datepicker)

			/*
			 * стили плагина
			 */
			$sPluginTemplatePath . '/css/base.css',
			$sPluginTemplatePath . '/css/grid.css',
			$sPluginTemplatePath . '/css/common.css',
			$sPluginTemplatePath . '/css/blocks.css',
			$sPluginTemplatePath . '/css/pagination.css',
			$sPluginTemplatePath . '/css/icons.css',
			$sPluginTemplatePath . '/css/navs.css',
			$sPluginTemplatePath . '/css/buttons.css',
			$sPluginTemplatePath . '/css/forms.css',
			$sPluginTemplatePath . '/css/parameters.css',
			$sPluginTemplatePath . '/css/skins.css',
			$sPluginTemplatePath . '/css/users.css',
			$sPluginTemplatePath . '/css/table.css',
			$sPluginTemplatePath . '/css/dashboard.css',
			$sPluginTemplatePath . '/css/dropdowns.css',
			$sPluginTemplatePath . '/css/helpers.css',
			$sPluginTemplatePath . '/css/user.css',
			$sPluginTemplatePath . '/css/stats.css',
			
			$sPluginTemplatePath . '/css/vendor/jquery.notifier.css',
			$sPluginTemplatePath . '/css/vendor/icheck/skins/livestreet/minimal.css',
		);

		/*
		 * скрипты для админки
		 */
		$aScripts = array (
			/*
			 * скрипты, задаваемые фреймворком
			 */
			$sFrameworkPath . '/js/vendor/jquery-1.9.1.min.js',
			$sFrameworkPath . '/js/vendor/jquery-ui/js/jquery-ui-1.10.2.custom.min.js',
			$sFrameworkPath . '/js/vendor/jquery-ui/js/localization/jquery-ui-datepicker-ru.js',
			$sFrameworkPath . '/js/vendor/jquery.browser.js',
			$sFrameworkPath . '/js/vendor/jquery.scrollto.js',
			$sFrameworkPath . '/js/vendor/jquery.rich-array.min.js',
			$sFrameworkPath . '/js/vendor/jquery.form.js',
			$sFrameworkPath . '/js/vendor/jquery.jqplugin.js',
			$sFrameworkPath . '/js/vendor/jquery.cookie.js',
			$sFrameworkPath . '/js/vendor/jquery.serializejson.js',
			$sFrameworkPath . '/js/vendor/jquery.file.js',
			$sFrameworkPath . '/js/vendor/jcrop/jquery.Jcrop.js',
			$sFrameworkPath . '/js/vendor/jquery.placeholder.min.js',
			$sFrameworkPath . '/js/vendor/jquery.charcount.js',
			$sFrameworkPath . '/js/vendor/jquery.imagesloaded.js',
			$sFrameworkPath . '/js/vendor/notifier/jquery.notifier.js',
			$sFrameworkPath . '/js/vendor/markitup/jquery.markitup.js',
			$sFrameworkPath . '/js/vendor/prettify/prettify.js',
			$sFrameworkPath . '/js/vendor/prettyphoto/js/jquery.prettyphoto.js',
			$sFrameworkPath . '/js/vendor/parsley/parsley.js',

			$sFrameworkPath . '/js/core/main.js',
			$sFrameworkPath . '/js/core/hook.js',
			$sFrameworkPath . '/js/core/i18n.js',
			$sFrameworkPath . '/js/core/ie.js',
			$sFrameworkPath . '/js/core/ajax.js',
			$sFrameworkPath . '/js/core/registry.js',
			$sFrameworkPath . '/js/core/swfupload.js',
			$sFrameworkPath . '/js/core/utilities.js',
			$sFrameworkPath . '/js/core/timer.js',

			$sFrameworkPath . '/js/ui/tooltip.js',
			$sFrameworkPath . '/js/ui/autocomplete.js',
			$sFrameworkPath . '/js/ui/notification.js',
			$sFrameworkPath . '/js/ui/alert.js',
			$sFrameworkPath . '/js/ui/dropdown.js',
			$sFrameworkPath . '/js/ui/tab.js',
			$sFrameworkPath . '/js/ui/modal.js',
			$sFrameworkPath . '/js/ui/toolbar.js',
			/*
			 * for stream list in dashboard
			 */
			//Config::Get('path.application.web') . '/frontend/common/js/stream.js',	// не нужна, в адмике своя активность todo: delete
			/*
			 * for managing user note
			 */
			//Config::Get('path.application.web') . '/frontend/common/js/usernote.js',	// todo: review

			/*
			 * скрипты плагина
			 */
			$sPluginTemplatePath . '/js/init.js',
			$sPluginTemplatePath . '/js/admin_settings_save.js',
			$sPluginTemplatePath . '/js/admin_settings_array.js',
			$sPluginTemplatePath . '/js/admin_misc.js',
			$sPluginTemplatePath . '/js/admin_stream.js',
			$sPluginTemplatePath . '/js/admin_users_stats_living.js',
			$sPluginTemplatePath . '/js/more.js',

			/*
			 * 3rd party vendor
			 */
			$sPluginTemplatePath . '/js/vendor/highcharts/highcharts.src.js',
			$sPluginTemplatePath . '/js/vendor/icheck/jquery.icheck.js',
		);

		array_map(array($this, 'Viewer_AppendStyle'), $aStyles);
		array_map(array($this, 'Viewer_AppendScript'), $aScripts);
	}

}

?>