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

class PluginAdmin extends Plugin
{

    /*
     * Массив с записями о наследовании плагином части функционала
     */
    protected $aInherits = array(
        'module' => array(
            /*
             * Расширение возможностей работы со Smarty
             */
            'ModuleViewer',
            /*
             * Расширение возможностей работы с Asset
             */
            'ModuleAsset',
            /*
             * Расширение возможностей работы с хранилищем и сохранением данных конфигов
             */
            'ModuleStorage',
            /*
             * Расширение возможностей показа сообщений об ошибках
             */
            'ModuleMessage',
            /*
             * Нужен для точки загрузки предпросмотра шаблона
             */
            'ModuleLang',
            /*
             * Для реализации механизма read only банов для движка
             */
            'ModuleACL',
            /*
             * Для дополнения методов, нужных для статистики пользователей
             */
            'ModuleGeo',
        ),
        'mapper' => array(
            /*
             * Для дополнения методов, нужных для статистики пользователей
             */
            'ModuleGeo_MapperGeo',
        ),
        'entity' => array(
            /*
             * Добавляем новый тип валидатора - Array
             */
            'ModuleValidate_EntityValidatorArray',
            /*
             * Для добавления информации о бане пользователя
             */
            'ModuleUser_EntityUser',
            /*
             * Для установки счетчика последнего сброса кеша для ксс файлов
             */
            'ModuleAsset_EntityTypeCss',
            /*
             * Для установки счетчика последнего сброса кеша для жс файлов
             */
            'ModuleAsset_EntityTypeJs',
        )
    );

    /**
     * Выполнение действий перед инициализацией ядра
     * В этом метода крайне не рекомендуется использовать модули движка, т.к. ядро еще полностью не инициализировалось
     */
    public function BeforeInitEngine()
    {
        parent::BeforeInitEngine();
        /**
         * присоеденить схему главного конфига
         */
        $this->PluginAdmin_Settings_AddConfigSchemeToRootConfig();
        /**
         * выполнить загрузку конфигов системы и плагинов
         */
        $this->PluginAdmin_Settings_AutoLoadConfigs();
        /**
         * Фикс загрузки параметров кеша
         */
        $this->Cache_InitParams();
    }


    /**
     * Активация плагина
     *
     * @return bool
     */
    public function Activate()
    {
        /*
         * проверить необходимый минимум для запуска плагина
         */
        if (!$this->CheckDependencies()) {
            return false;
        }
        /*
         * импортировать дампы таблиц
         */
        $this->ImportSqlDumps();
        return true;
    }


    /**
     * Инициализация плагина
     */
    public function Init()
    {
        /*
         * блокировка использования одновременно с другой админкой (для особо умных, включивших вторую админку после активации этой)
         */
        if (defined('ACEADMINPANEL_VERSION')) {
            throw new Exception('Admin: error: You must fully remove old AceAdminPanel plugin and never use two admin panels at the same time');
        }
		/*
		 * @todo: delete
		 */
		// if (!isAjaxRequest()) {
		// 	$this->Message_AddNotice(
		// 		'В данный момент в админке часть функционала не работает либо работает некорректно, в т.ч. верстка.
		// 		Это связано с тем, что после основного этапа разработки админки был переделан LiveStreet Framework и продолжается активная работа над ним.
		// 		Админка будет адаптирована как только фреймворк войдет в более стабильное состояние.<br /><br />
		// 		Спасибо за понимание.',
		// 		'Внимание'
		// 	);
		// }
    }


    /**
     * Проверка зависимостей плагина
     *
     * @return bool
     */
    protected function CheckDependencies()
    {
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
        if (defined('ACEADMINPANEL_VERSION') or $this->isTableExists('prefix_adminset') or $this->isTableExists('prefix_adminban') or $this->isTableExists('prefix_adminips')) {
            Engine::getInstance()->Message_AddError(
                'You should fully remove old AceAdminPanel plugin and its all tables (prefix_adminset, prefix_adminban, prefix_adminips) before enabling this admin panel',
                'Error',
                true
            );
            return false;
        }
        return true;
    }


    /**
     * Импортировать дампы таблиц админки
     */
    protected function ImportSqlDumps()
    {
        /*
         * дамп таблицы для банов пользователя
         */
        if (!$this->isTableExists('prefix_admin_users_ban')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql_dumps/admin_users_ban.sql');
        }
    }

}

?>