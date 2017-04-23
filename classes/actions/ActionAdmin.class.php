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
class PluginAdmin_ActionAdmin extends ActionPlugin
{

    protected $oUserCurrent = null;
    protected $sMenuSubItemSelect = '';

    /*
     * Списки групп настроек системного конфига
     */
    protected $aCoreSettingsGroups = array();

    /*
     * Имя виртуального метода, который будет пойман в __call для групп системных настроек
     */
    protected $sCallbackMethodToShowSystemSettings = 'EventShowSystemSettings';


    public function Init()
    {
        /*
         * Если нет прав доступа - перекидываем на 404 страницу
         */
        if (!$this->oUserCurrent = $this->User_GetIsAdmin(true)) {
            return parent::EventNotFound();
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
        $this->InitMenu();
        /*
         * добавить нужные текстовки
         */
        $this->Lang_AddLangJs(array(
            'plugin.admin.notices.items_per_page.value_changed'
        ));

        /**
         * Запускается только один раз при первой инициализации экшена (не учитывает внутренние редиректы)
         */
        if (!$this->Cache_GetLife('init_action_admin')) {
            $this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.admin.title'));
            $this->Hook_Run('init_action_admin');
            $this->Cache_SetLife(1, 'init_action_admin');
        }
    }


    protected function RegisterEvent()
    {
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
         * Модуль "Category"
         */
        $this->RegisterEventExternal('Category', 'PluginAdmin_ActionAdmin_EventCategory');
        /*
         * Работа с пользователями
         */
        $this->RegisterEventExternal('Users', 'PluginAdmin_ActionAdmin_EventUsers');
        /*
         * Работа с правами пользователей
         */
        $this->RegisterEventExternal('Rbac', 'PluginAdmin_ActionAdmin_EventRbac');
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
        $this->AddEventPreg('#^properties$#i', '#^[\w-]+$#i', '#^$#i', 'Property::EventPropertiesTarget');
        $this->AddEventPreg('#^properties$#i', '#^[\w-]+$#i', '#^remove$#i', '#^\d{1,5}$#i',
            'Property::EventPropertyRemove');
        $this->AddEventPreg('#^properties$#i', '#^[\w-]+$#i', '#^update$#i', '#^\d{1,5}$#i',
            'Property::EventPropertyUpdate');
        $this->AddEventPreg('#^properties$#i', '#^[\w-]+$#i', '#^create$#i', '#^$#i', 'Property::EventPropertyCreate');
        $this->AddEventPreg('#^ajax$#i', '#^properties$#i', '#^sort-save$#i', '#^$#i', 'Property::EventAjaxSortSave');

        /*
         *
         * --- Модуль категорий ----
         *
         */
        $this->AddEventPreg('#^categories$#i', '#^[\w-]+$#i', '#^$#i', 'Category::EventCategoriesTarget');
        $this->AddEventPreg('#^categories$#i', '#^[\w-]+$#i', '#^remove$#i', '#^\d{1,5}$#i',
            'Category::EventCategoryRemove');
        $this->AddEventPreg('#^categories$#i', '#^[\w-]+$#i', '#^update$#i', '#^\d{1,5}$#i',
            'Category::EventCategoryUpdate');
        $this->AddEventPreg('#^categories$#i', '#^[\w-]+$#i', '#^create$#i', '#^$#i', 'Category::EventCategoryCreate');

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
        $this->AddEventPreg('#^users$#iu', '#^complaints$#iu', '#^$#', 'Users::EventShowUserComplaints');
        /*
         * удалить жалобу
         */
        $this->AddEventPreg('#^users$#iu', '#^complaints$#iu', '#^delete$#', '#^\d+$#i', 'Users::EventDeleteComplaint');
        /*
         * управление правами: список ролей
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^(|role)$#', 'Rbac::EventRoleList');
        /*
         * управление правами: добавление роли
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^role-create$#', '#^$#', 'Rbac::EventRoleCreate');
        /*
         * управление правами: редактирование роли
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^role-update$#', '#^\d+$#i', '#^$#',
            'Rbac::EventRoleUpdate');
        /*
         * управление правами: удаление роли
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^role-remove$#', '#^\d+$#i', '#^$#',
            'Rbac::EventRoleRemove');
        /*
         * управление правами: управление разрешениями у роли
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^role-permissions$#', '#^\d+$#i', '#^$#',
            'Rbac::EventRolePermissions');
        $this->AddEventPreg('#^ajax$#iu', '#^rbac$#iu', '#^role-permission-add$#', '#^$#',
            'Rbac::EventAjaxRolePermissionAdd');
        $this->AddEventPreg('#^ajax$#iu', '#^rbac$#iu', '#^role-permission-remove$#', '#^$#',
            'Rbac::EventAjaxRolePermissionRemove');
        /*
         * управление правами: управление пользователями у роли
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^role-users$#', '#^\d+$#i', '#^(page(\d{1,7}))?$#', '#^$#',
            'Rbac::EventRoleUsers');
        $this->AddEventPreg('#^ajax$#iu', '#^rbac$#iu', '#^role-user-add$#', '#^$#', 'Rbac::EventAjaxRoleUserAdd');
        $this->AddEventPreg('#^ajax$#iu', '#^rbac$#iu', '#^role-user-remove$#', '#^$#',
            'Rbac::EventAjaxRoleUserRemove');
        /*
         * управление правами: список групп
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^group$#', '#^$#', 'Rbac::EventGroupList');
        /*
         * управление правами: добавление группы
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^group-create$#', '#^$#', 'Rbac::EventGroupCreate');
        /*
         * управление правами: редактирование группы
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^group-update$#', '#^\d+$#i', '#^$#',
            'Rbac::EventGroupUpdate');
        /*
         * управление правами: удаление группы
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^group-remove$#', '#^\d+$#i', '#^$#',
            'Rbac::EventGroupRemove');
        /*
         * управление правами: список разрешений
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^permission$#', '#^$#', 'Rbac::EventPermissionList');
        /*
         * управление правами: добавление разрешения
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^permission-create$#', '#^$#',
            'Rbac::EventPermissionCreate');
        /*
         * управление правами: редактирование разрешения
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^permission-update$#', '#^\d+$#i', '#^$#',
            'Rbac::EventPermissionUpdate');
        /*
         * управление правами: удаление разрешения
         */
        $this->AddEventPreg('#^users$#iu', '#^rbac$#iu', '#^permission-remove$#', '#^\d+$#i', '#^$#',
            'Rbac::EventPermissionRemove');
        /*
         * настройка полей контактов
         */
        $this->AddEventPreg('#^users$#iu', '#^contact-fields$#iu', '#^$#', 'Users::EventContactFields');
        $this->AddEventPreg('#^users$#iu', '#^contact-fields$#iu', '#^create$#', '#^$#', 'Users::EventContactFieldsCreate');
        $this->AddEventPreg('#^users$#iu', '#^contact-fields$#iu', '#^update$#', '#^\d+$#i', '#^$#',
            'Users::EventContactFieldsUpdate');
        $this->AddEventPreg('#^users$#iu', '#^contact-fields$#iu', '#^remove$#', '#^\d+$#i', '#^$#',
            'Users::EventContactFieldsRemove');

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
        $this->AddEventPreg('#^users$#iu', '#^manageadmins$#iu', '#^(?:add|delete)$#iu', '#^\d++$#iu',
            'Users::EventManageAdmins');
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
         * изменение количества жалоб на страницу
         */
        $this->AddEventPreg('#^users$#i', '#^complaints$#iu', '#^ajax-on-page$#iu',
            'Users::EventAjaxUsersComplaintsOnPage');
        /*
         * проверить правило бана на корректность
         */
        $this->AddEventPreg('#^bans$#iu', '#^ajax-check-user-sign$#iu', 'Users::EventAjaxBansCheckUserSign');
        /*
         * просмотр и ответ на жалобу пользователя
         */
        $this->AddEventPreg('#^users$#iu', '#^complaints$#iu', '#^ajax-modal-view$#iu',
            'Users::EventAjaxModalUserComplaintView');

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
        $this->AddEventPreg('#^plugins$#iu', '#^(?:list)?$#iu', '#^(?:activated|deactivated|updates)?$#iu',
            'Plugins::EventPluginsList');
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
        $this->AddEventPreg('#^settings$#iu', '#^topic-type$#iu', '#^update$#iu', '#^\d{1,6}$#iu',
            'Settings::EventTopicTypeUpdate');
        $this->AddEventPreg('#^settings$#iu', '#^topic-type$#iu', '#^remove$#iu', '#^\d{1,6}$#iu',
            'Settings::EventTopicTypeRemove');
        $this->AddEventPreg('#^settings$#iu', '#^topic-type$#iu', '#^ajax-sort$#iu',
            'Settings::EventTopicTypeAjaxSort');

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
        $this->AddEventPreg('#^skins$#iu', '#^(?:list|use|preview|turnoffpreview)?$#iu', 'Skins::EventSkinsList');
        $this->AddEventPreg('#^skins$#iu', '#^install$#iu', 'Skins::EventSkinsInstall');

        /*
         *
         * --- Утилиты ---
         *
         */
        /*
         * Оптимизации
         */
        $this->AddEventPreg('#^utils$#iu', '#^optimization$#iu', 'Utils::EventOptimization');
        /*
         * Планировщик cron
         */
        $this->AddEventPreg('#^utils$#iu', '#^cron$#iu', '#^$#iu', 'Utils::EventCron');
        $this->AddEventPreg('#^utils$#iu', '#^cron$#iu', '#^create$#iu', 'Utils::EventCronCreate');
        $this->AddEventPreg('#^utils$#iu', '#^cron$#iu', '#^update$#iu', '#^\d{1,6}$#iu', 'Utils::EventCronUpdate');
        $this->AddEventPreg('#^utils$#iu', '#^cron$#iu', '#^remove$#iu', '#^\d{1,6}$#iu', 'Utils::EventCronRemove');
        $this->AddEventPreg('#^utils$#iu', '#^cron$#iu', '#^ajax-run$#iu', 'Utils::EventCronAjaxRun');

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
         * Все автоматические настройки конфига по урлу /settings/config/[name_group]/
         */
        foreach (array_keys(Config::Get(PluginAdmin_ModuleSettings::ROOT_CONFIG_GROUPS_KEY)) as $sKey) {
            $this->AddEventPreg('#^settings$#iu', '#^config$#iu', '#^' . $sKey . '$#iu',
                'Settings::' . $this->sCallbackMethodToShowSystemSettings . $sKey);
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
    private function InitMenu()
    {
        $oMenu = $this->PluginAdmin_Ui_GetMenuMain();
        if ($oMenu->GetSections()) {
            return;
        }
        $oMenu->AddSection(
            Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Главная')->SetUrl('')->setIcon('home')        // todo: add lang
        )// /AddSection
        ->AddSection(
            Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Пользователи')->SetName('users')->SetUrl('users')
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Статистика')->SetUrl('stats'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Весь список')->SetUrl('list'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Бан-листы')->SetUrl('bans'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Администраторы')->SetUrl('admins'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Жалобы')->SetUrl('complaints'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Управление правами')->SetUrl('rbac'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Виды контактов')->SetUrl('contact-fields'))
        )// /AddSection
        ->AddSection(
            Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Плагины')->SetName('plugins')->SetUrl('plugins')
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Список плагинов')->SetUrl('list'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Установить')->SetUrl('install')->SetColor('#f00'))
        )// /AddSection
        ->AddSection(
            Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Шаблоны')->SetName('skins')->SetUrl('skins')
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Список шаблонов')->SetUrl('list'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Установить')->SetUrl('install')->SetColor('#f00'))
        )// /AddSection
        ->AddSection(
            Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Настройки')->SetName('settings')->SetUrl('settings')->setIcon('wrench')
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Конфигурация сайта')->SetUrl('config/main'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Типы топиков')->SetUrl('topic-type'))
        )// /AddSection
        ->AddSection(
            Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Утилиты')->SetName('utils')->SetUrl('utils')->setIcon('gears')
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Планировщик Cron')->SetUrl('cron'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Оптимизация')->SetUrl('optimization'))
        )    // /AddSection
        ;
        $this->Hook_Run('init_admin_menu');
    }


    /*
     *
     * --- Хелперы ---
     *
     */

    /**
     * Делает редирект на страницу, с которой пришел запрос
     */
    public function RedirectToReferer()
    {
        Router::Location(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : Router::GetPath('admin'));
        return false;
    }


    /**
     * Быстрое получение текстовки плагина без указания префикса
     *
     * @param       $sKey            ключ языкового файла (без префикса "plugin.имяплагина.")
     * @param array $aParams параметры подстановки значений для передачи в текстовку
     * @return mixed                значение
     */
    public function Lang($sKey, $aParams = array())
    {
        return $this->Lang_Get('plugin.admin.' . $sKey, $aParams);
    }


    /**
     * Получить значение из фильтра (массива-переменной "filter" из реквеста) или весь фильтр
     *
     * @param $sName                имя ключа из массива фильтра или null для получения всего фильтра
     * @return mixed|array|null        значение
     */
    protected function GetDataFromFilter($sName = null)
    {
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


    /**
     * Завершение экшена
     */
    public function EventShutdown()
    {
        $this->Viewer_Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
        $this->Viewer_Assign('oMenuMain', $this->PluginAdmin_Ui_GetMenuMain());

        if (Router::GetActionEvent() != 'error') {
            $this->PluginAdmin_Ui_HighlightMenus();
        }
        /*
         * получить данные последнего входа в админку
         * tip: вывод даты последнего входа происходит только внизу главной страницы админки (на других страницах это не столь важно)
         */
        $this->PluginAdmin_Users_GetLastVisitMessageAndCompareIp();
    }


    /**
     * Отображение ошибки
     */
    public function EventError()
    {
        $aHttpErrors = array(
            '404' => array(
                'header' => '404 Not Found',
            ),
            '403' => array(
                'header' => '403 Forbidden',
            ),
            '500' => array(
                'header' => '500 Internal Server Error',
            ),
        );
        $iNumber = $this->GetParam(0);
        if (array_key_exists($iNumber, $aHttpErrors)) {
            /**
             * Смотрим есть ли сообщения об ошибках
             */
            if (!$this->Message_GetError()) {
                $this->Message_AddErrorSingle($this->Lang_Get('common.error.system.code.' . $iNumber), $iNumber);
            }
            $aHttpError = $aHttpErrors[$iNumber];
            if (isset($aHttpError['header'])) {
                $sProtocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
                header("{$sProtocol} {$aHttpError['header']}");
            }
        }
        $this->Viewer_AddHtmlTitle($this->Lang_Get('common.error.error'));
        $this->SetTemplateAction('error');
    }


    /**
     * Эвент не найден
     *
     * @return string
     */
    protected function EventNotFound()
    {
        return Router::Action('admin', 'error', array('404'));
    }


    /**
     * Добавить свои файлы JS и CSS для админки
     */
    protected function AddJSAndCSSFiles()
    {
        /**
         * Сбрасываем списки скриптов и таблиц стилей
         */
        $this->Asset_ClearAssets();
        Config::Set('head.template.js', array());
        Config::Set('head.template.css', array());
        /**
         * Переопределеям список компонентов
         */
        $this->Component_RemoveAll();
        Config::Set('components', Config::Get('plugin.admin.components'));
        $this->Component_InitComponentsList();
        /**
         * Отключаем
         */
        /**
         * Основные скрипты
         */
        $aScripts = Config::Get('plugin.admin.assets.js');
        /**
         * Основные стили
         */
        $aStyles = Config::Get('plugin.admin.assets.css');
        /**
         * Подключаем срипты плагинов
         */
        $aPluginsList = array_keys(Engine::getInstance()->GetPlugins());
        foreach ($aPluginsList as $sPlugin) {
            $sPluginTemplatePath = Plugin::GetTemplateWebPath($sPlugin);
            $sPluginPath = Plugin::GetWebPath($sPlugin);
            /**
             * Скрипты
             */
            if ($aAssets = Config::Get("plugin.{$sPlugin}.admin.assets.js")) {
                foreach ($aAssets as $k => $v) {
                    if (is_int($k)) {
                        $aScripts[] = (substr($v, 0, 1) == '/' ? trim($sPluginPath, '/\\') : $sPluginTemplatePath) . $v;
                    } else {
                        $aScripts[(substr($k, 0, 1) == '/' ? trim($sPluginPath,
                            '/\\') : $sPluginTemplatePath) . $k] = $v;
                    }
                }
            }
            /**
             * Стили
             */
            if ($aAssets = Config::Get("plugin.{$sPlugin}.admin.assets.css")) {
                foreach ($aAssets as $k => $v) {
                    if (is_int($k)) {
                        $aStyles[] = (substr($v, 0, 1) == '/' ? trim($sPluginPath, '/\\') : $sPluginTemplatePath) . $v;
                    } else {
                        $aStyles[(substr($k, 0, 1) == '/' ? trim($sPluginPath,
                            '/\\') : $sPluginTemplatePath) . $k] = $v;
                    }
                }
            }
        }
        foreach ($aScripts as $k => $v) {
            $this->Viewer_AppendScript(is_int($k) ? $v : $k, is_int($k) ? array() : $v);
        }
        foreach ($aStyles as $k => $v) {
            $this->Viewer_AppendStyle(is_int($k) ? $v : $k, is_int($k) ? array() : $v);
        }
    }

}
