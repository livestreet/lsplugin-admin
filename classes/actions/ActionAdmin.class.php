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
		/*
		 * проверка авторизации админа
		 */
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
		$this->aCoreSettingsGroups = Config::Get(PluginAdmin_ModuleSettings::ROOT_CONFIG_GROUPS_KEY);

		/*
		 * по-умолчанию показывать главную страницу
		 */
		$this->SetDefaultEvent('index');

		$this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.admin.title'));
		$this->InitMenu();
		/*
		 * добавить нужные текстовки
		 */
		$this->Lang_AddLangJs(array(
			'plugin.admin.notices.items_per_page.value_changed'
		));
		$this->Hook_Run('init_action_admin');
	}


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
		$this->RegisterEventExternal('EmbedPlugin', 'PluginAdmin_ActionAdmin_EventEmbedPlugin');
		/*
		 * Работа со списком плагинов
		 */
		$this->RegisterEventExternal('Plugins', 'PluginAdmin_ActionAdmin_EventPlugins');
		/*
		 * Работа с настройками плагинов и движка
		 */
		$this->RegisterEventExternal('Settings', 'PluginAdmin_ActionAdmin_EventSettings');
		/*
		 * Работа с шаблонами
		 */
		$this->RegisterEventExternal('Skins', 'PluginAdmin_ActionAdmin_EventSkins');
		/*
		 * Дашбоард
		 */
		$this->RegisterEventExternal('Dashboard', 'PluginAdmin_ActionAdmin_EventDashboard');
		/*
		 * Комментарии
		 */
		$this->RegisterEventExternal('Comments', 'PluginAdmin_ActionAdmin_EventComments');
		/*
		 * Утилиты
		 */
		$this->RegisterEventExternal('Utils', 'PluginAdmin_ActionAdmin_EventUtils');


		/*
		 *
		 * --- Эвенты ---
		 *
		 */

		/*
		 *
		 * --- Модуль свойств ----
		 *
		 */
		$this->AddEventPreg('#^properties$#i', '#^\w+$#i', '#^$#i', 'Property::EventPropertiesTarget');
		$this->AddEventPreg('#^properties$#i', '#^\w+$#i', '#^remove$#i', '#^\d{1,5}$#i', 'Property::EventPropertyRemove');
		$this->AddEventPreg('#^properties$#i', '#^\w+$#i', '#^update$#i', '#^\d{1,5}$#i', 'Property::EventPropertyUpdate');
		$this->AddEventPreg('#^properties$#i', '#^\w+$#i', '#^create$#i', '#^$#i', 'Property::EventPropertyCreate');
		$this->AddEventPreg('#^ajax$#i', '#^properties$#i', '#^sort-save$#i', '#^$#i', 'Property::EventAjaxSortSave');

		/*
		 *
		 * --- Дашборд ---
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

		/*
		 *
		 * --- Пользователи ---
		 *
		 */

		/*
		 * статистика пользователей
		 */
		$this->AddEventPreg('#^users$#iu', '#^stats$#iu', 'Users::EventShowUserStats');
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
		 * жалобы на пользователей
		 */
		$this->AddEventPreg('#^users$#iu', '#^complaints$#iu', 'Users::EventShowUserComplaints');

		/*
		 *
		 * --- Баны ---
		 *
		 */

		/*
		 * добавить бан
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^add$#iu', 'Users::EventAddBan');
		/*
		 * список банов
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^(page(\d{1,5}))?$#iu', 'Users::EventBansList');
		/*
		 * редактировать бан
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^edit$#iu', '#^\d++$#iu', 'Users::EventEditBan');
		/*
		 * удалить бан
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^delete$#iu', '#^\d++$#iu', 'Users::EventDeleteBan');
		/*
		 * показать страницу информации о бане
		 */
		$this->AddEventPreg('#^users$#iu', '#^bans$#iu', '#^view$#iu', '#^\d++$#iu', 'Users::EventViewBanInfo');

		/*
		 *
		 * --- Операции над пользователями ---
		 *
		 */

		/*
		 * добавить или удалить админа
		 */
		$this->AddEventPreg('#^users$#iu', '#^manageadmins$#iu', '#^(?:add|delete)$#iu', '#^\d++$#iu', 'Users::EventManageAdmins');
		/*
		 * удалить контент пользователя и самого пользователя
		 */
		$this->AddEventPreg('#^users$#iu', '#^deleteuser$#iu', 'Users::EventDeleteUserContent');
		/*
		 * активировать пользователя
		 */
		$this->AddEventPreg('#^users$#iu', '#^activate$#iu', 'Users::EventActivateUser');

		/*
		 *
		 * --- Аякс обработчики для раздела пользователей ---
		 *
		 */

		/*
		 * изменение данных пользователя в его профиле
		 */
		$this->AddEventPreg('#^users$#iu', '#^ajax-profile-edit$#iu', 'Users::EventAjaxProfileEdit');
		/*
		 * изменение количества пользователей на страницу
		 */
		$this->AddEventPreg('#^users$#iu', '#^ajax-on-page$#iu', 'Users::EventAjaxUsersOnPage');
		/*
		 * изменение количества голосов на страницу
		 */
		$this->AddEventPreg('#^votes$#iu', '#^ajax-on-page$#iu', 'Users::EventAjaxVotesOnPage');
		/*
		 * изменение количества банов на страницу
		 */
		$this->AddEventPreg('#^bans$#iu', '#^ajax-on-page$#iu', 'Users::EventAjaxBansOnPage');
		/*
		 * проверить правило бана на корректность
		 */
		$this->AddEventPreg('#^bans$#iu', '#^ajax-check-user-sign$#iu', 'Users::EventAjaxBansCheckUserSign');

		/*
		 *
		 * --- Комментарии ---
		 *
		 */
		/*
		 * показать форму полного удаления комментария
		 */
		$this->AddEventPreg('#^comments$#iu', '#^delete$#iu', 'Comments::EventFullCommentDelete');

		/*
		 *
		 * --- Плагины ---
		 *
		 */

		/*
		 * показать страницу настроек плагина в админке, управление которыми осуществляет сам плагин
		 */
		$this->AddEventPreg('#^plugin$#i', '#^[\w-]+$#i', 'EmbedPlugin::EventShowEmbedPlugin');
		/*
		 * список установленных плагинов (по фильтру)
		 */
		$this->AddEventPreg('#^plugins$#iu', '#^(?:list)?$#iu', 'Plugins::EventPluginsList');
		/*
		 * сброс кеша списка дополнений из каталога
		 */
		$this->AddEventPreg('#^plugins$#iu', '#^install$#iu', '#^resetcache$#iu', 'Plugins::EventPluginsResetCache');
		/*
		 * установка дополнений из каталога
		 */
		$this->AddEventPreg('#^plugins$#iu', '#^install$#iu', 'Plugins::EventPluginsInstall');
		/*
		 * активация/деактивация плагина
		 */
		$this->AddEventPreg('#^plugins$#iu', '#^toggle$#iu', 'Plugins::EventTogglePlugin');
		/*
		 * показать страницу инструкций по установке плагина (файл install.txt)
		 */
		$this->AddEventPreg('#^plugins$#iu', '#^instructions$#iu', 'Plugins::EventPluginInstructions');


		/*
		 *
		 * --- Настройки ---
		 *
		 */

		/*
		 * Показать настройки плагина
		 */
		$this->AddEventPreg('#^settings$#iu', '#^plugin$#iu', 'Settings::EventShowPluginSettings');
		/*
		 * Сохранить настройки (плагина или движка)
		 */
		$this->AddEventPreg('#^settings$#iu', '#^save$#iu', 'Settings::EventSaveConfig');
		/*
		 * Настройки типов топиков
		 */
		$this->AddEventPreg('#^settings$#iu', '#^topic-type$#iu', '#^$#iu', 'Settings::EventTopicTypeList');
		$this->AddEventPreg('#^settings$#iu', '#^topic-type$#iu', '#^create$#iu', 'Settings::EventTopicTypeCreate');
		$this->AddEventPreg('#^settings$#iu', '#^topic-type$#iu', '#^update$#iu', '#^\d{1,6}$#iu', 'Settings::EventTopicTypeUpdate');
		$this->AddEventPreg('#^settings$#iu', '#^topic-type$#iu', '#^remove$#iu', '#^\d{1,6}$#iu', 'Settings::EventTopicTypeRemove');
		$this->AddEventPreg('#^settings$#iu', '#^topic-type$#iu', '#^ajax-sort$#iu', 'Settings::EventTopicTypeAjaxSort');

		/*
		 *
		 * --- Шаблоны ---
		 *
		 */

		/*
		 * Изменение темы текущего шаблона
		 */
		$this->AddEventPreg('#^skins$#iu', '#^changetheme$#iu', 'Skins::EventChangeSkinTheme');
		/*
		 * Список шаблонов
		 */
		$this->AddEventPreg('#^skins$#iu', 'Skins::EventSkinsList');

		/*
		 *
		 * --- Утилиты ---
		 *
		 */
		/*
		 * Проверка и восстановление
		 */
		$this->AddEventPreg('#^utils$#iu', '#^check_n_repair$#iu', 'Utils::EventCheckAndRepair');
		/*
		 * Сброс и очистка
		 */
		$this->AddEventPreg('#^utils$#iu', '#^reset_n_clear$#iu', 'Utils::EventResetAndClear');

		/*
		 *
		 * --- Системные настройки ---
		 *
		 */

		/*
		 * для каждой группы настроек добавим виртуальный эвент и будем ловить их через __call()
		 * чтобы не плодить полупустых методов, так компактнее и удобнее.
		 * todo: нужно что-то ещё с меню придумать чтобы полностью автоматизировать процесс создания групп.
		 * пока в меню нужно прописывать вручную пункты групп
		 */
		foreach(array_keys(Config::Get(PluginAdmin_ModuleSettings::ROOT_CONFIG_GROUPS_KEY)) as $sKey) {
			$this->AddEventPreg('#^settings$#iu', '#^' . $sKey . '$#iu', 'Settings::' . $this->sCallbackMethodToShowSystemSettings . $sKey);
		}


		/*
		 * Обработка ошибок, аналог ActionError
		 */
		$this->AddEvent('error', 'EventError');
	}


	/*
	 *
	 * --- Методы ---
	 *
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
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Жалобы')->SetUrl('complaints'))
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Плагины')->SetName('plugins')->SetUrl('plugins')
				
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Список плагинов')->SetUrl('list'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Установить')->SetUrl('install'))
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Шаблоны')->SetName('skins')->SetUrl('skins')

					->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Список шаблонов')->SetUrl('list'))
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Настройки')->SetName('settings')->SetUrl('settings')
				
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Типы топиков')->SetUrl('topic-type'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Внешний вид сайта')->SetUrl('view'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Интерфейс')->SetUrl('interface'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Системные')->SetUrl('system'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Почта')->SetUrl('sysmail'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('ACL')->SetUrl('acl'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Блоги')->SetUrl('moduleblog'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль топиков')->SetUrl('moduletopic'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль пользователей')->SetUrl('moduleuser'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль комментариев')->SetUrl('modulecomment'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль писем')->SetUrl('moduletalk'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль уведомлений')->SetUrl('modulenotify'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль изображений')->SetUrl('moduleimage'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модуль стены')->SetUrl('modulewall'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Модули разные')->SetUrl('moduleother'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Обработка JS и CSS')->SetUrl('compress'))
			)	// /AddSection
			->AddSection(
				Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Утилиты')->SetName('utils')->SetUrl('utils')

				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Проверка и восстановление')->SetUrl('check_n_repair'))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Сброс и очистка')->SetUrl('reset_n_clear'))
			)	// /AddSection
		;
	}
	
	
	/*
	 *
	 * --- Хелперы ---
	 *
	 */


	/**
	 * Делает редирект на страницу, с которой пришел запрос
	 */
	public function RedirectToReferer() {
		Router::Location(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : Router::GetPath('admin'));
		return false;
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

		$this->Viewer_AddBlock('right', 'blocks/block.nav.tpl', array('plugin'=>'admin'));

		if (Router::GetActionEvent() != 'error') {
			$this->PluginAdmin_Ui_HighlightMenus();
		}

		/*
		 * записать данные последнего входа пользователя в админку
		 */
		$this->PluginAdmin_Users_SetLastVisitData();
	}


	public function EventError() {
		/*
		 * todo: исправить на новые ключи текстовок
		 */
		$aHttpErrors = array(
			'404' => array(
				'header' => '404 Not Found',
			),
		);
		$iNumber = $this->GetParam(0);
		if (array_key_exists($iNumber, $aHttpErrors)) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error_'.$iNumber), $iNumber);
			$aHttpError = $aHttpErrors[$iNumber];
			if (isset($aHttpError['header'])) {
				$sProtocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
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
	protected function AddJSAndCSSFiles() {
		/*
		 * обнулить списки скриптов и таблиц стилей
		 */
		$this->Viewer_ClearStyle(true);

		$sFrameworkPath = Config::Get('path.framework.frontend.web');
		$sPluginTemplatePath = Plugin::GetTemplatePath(__CLASS__) . 'assets';

		/*
		 * набор стилей для админки
		 */
		$aStyles = array(
			/*
			 * стили, задаваемые фреймворком
			 */
			$sFrameworkPath . '/css/reset.css',
			$sFrameworkPath . '/css/helpers.css',
			$sFrameworkPath . '/css/text.css',
			$sFrameworkPath . '/css/icons.css',
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
			$sPluginTemplatePath . '/css/skins.css',
			$sPluginTemplatePath . '/css/user.css',
			$sPluginTemplatePath . '/css/table.css',
			$sPluginTemplatePath . '/css/dropdowns.css',
			$sPluginTemplatePath . '/css/helpers.css',
			$sPluginTemplatePath . '/css/stats.css',
			$sPluginTemplatePath . '/css/plugins.css',
			$sPluginTemplatePath . '/css/addon.css',
			$sPluginTemplatePath . '/css/rating.stars.css',
			$sPluginTemplatePath . '/css/_temp.css',
			$sPluginTemplatePath . '/css/flags.css',
			
			$sPluginTemplatePath . '/css/vendor/jquery.notifier.css',
			$sPluginTemplatePath . '/css/vendor/icheck/skins/livestreet/minimal.css',
		);

		/*
		 * скрипты для админки
		 */
		$aScripts = array(
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
			 * for managing user note
			 */
			//Config::Get('path.application.web') . '/frontend/common/js/usernote.js',	// todo: пересмотреть
			/*
			 * для редактирования профиля пользователя
			 */
			Config::Get('path.application.web') . '/frontend/common/js/geo.js',

			/*
			 * скрипты плагина
			 */
			$sPluginTemplatePath . '/js/init.js',
			$sPluginTemplatePath . '/js/admin_settings_save.js',
			$sPluginTemplatePath . '/js/admin_settings_array.js',
			$sPluginTemplatePath . '/js/admin_misc.js',
			$sPluginTemplatePath . '/js/admin_stream.js',
			$sPluginTemplatePath . '/js/admin_users_stats_living.js',
			$sPluginTemplatePath . '/js/admin_profile_edit.js',
			$sPluginTemplatePath . '/js/admin_catalog.js',
			$sPluginTemplatePath . '/js/admin_users_search.js',
			$sPluginTemplatePath . '/js/nav.main.js',
			$sPluginTemplatePath . '/js/more.js',
			$sPluginTemplatePath . '/js/property.js',
			$sPluginTemplatePath . '/js/topic.js',

			/*
			 * 3rd party vendor
			 */
			$sPluginTemplatePath . '/js/vendor/highcharts/highcharts.src.js',
			$sPluginTemplatePath . '/js/vendor/icheck/jquery.icheck.js',
			$sPluginTemplatePath . '/js/vendor/jeditable/jquery.jeditable.js',
		);

		array_map(array($this, 'Viewer_AppendStyle'), $aStyles);
		array_map(array($this, 'Viewer_AppendScript'), $aScripts);
	}

}

?>