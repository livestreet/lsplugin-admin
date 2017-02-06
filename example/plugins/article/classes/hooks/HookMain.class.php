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
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */

/**
 * Хуки
 */
class PluginArticle_HookMain extends Hook
{
    /**
     * Регистрация необходимых хуков
     */
    public function RegisterHook()
    {
        /**
         * Хук на отображение админки
         */
        $this->AddHook('init_action_admin', 'InitActionAdmin');
        /**
         * Начало обработки экшена, выполняется всегда только 1 раз
         */
        $this->AddHook('start_action', 'StartAction');
    }

    /**
     * Добавляем в главное меню админки свой раздел с подпунктами
     */
    public function InitActionAdmin()
    {
        /**
         * Получаем объект главного меню
         */
        $oMenu = $this->PluginAdmin_Ui_GetMenuMain();
        /**
         * Добавляем новый раздел
         */
        $oMenu->AddSection(
            Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Статьи')->SetName('article')->SetUrl('plugin/article')
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Список статей')->SetUrl(''))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Создать')->SetUrl('create'))
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Настройки')->SetUrl('/admin/settings/plugin/article'))
        );
    }

    /**
     * Добавляем к загрузке компоненты плагина
     */
    public function StartAction()
    {
        $this->Component_Add('article:p-test');
    }
}