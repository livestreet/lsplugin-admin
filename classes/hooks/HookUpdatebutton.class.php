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
 * Добавление для админов кнопки на тулбар с количеством плагинов, для которых есть обновления
 *
 */

class PluginAdmin_HookUpdatebutton extends Hook
{


    public function RegisterHook()
    {
        /*
         * должен быть запущен после загрузки настроек и предпросмотра шаблона (третья очередь)
         */
        $this->AddHook('engine_init_complete', 'EngineInitComplete');
    }


    public function EngineInitComplete()
    {
        /*
         * включена ли кнопка
         */
        if (!Config::Get('plugin.admin.catalog.updates.show_updates_count_in_toolbar')) {
            return false;
        }
        /*
         * если это админ и он не в админке (там про обновления пишется отдельно)
         *
         * tip: проверка на принудительный кеш нужна для того, чтобы не задергать сервер каталога если на сайте активный админ (т.к. запросы будет посылаться при каждом открытии страницы),
         */
        if ($this->User_GetIsAdmin() and Router::GetAction() != 'admin' and Config::Get('sys.cache.force')) {
            /*
             * если есть обновления для плагинов
             */
            if ($mData = $this->PluginAdmin_Catalog_GetPluginUpdatesCached() and is_array($mData)) {
                /*
                 * добавить кнопку на тулбар с количеством обновлений для плагинов
                 */
                $this->Viewer_AddBlock(
                    'toolbar',
                    'toolbars/plugins_updates.tpl',
                    array('plugin' => 'admin', 'iUpdatesCount' => count($mData)),
                    50
                );
            }
        }
    }

}

?>