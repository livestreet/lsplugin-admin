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
 * Языковый модуль
 *
 */

class PluginAdmin_ModuleLang extends PluginAdmin_Inherits_ModuleLang
{

    /**
     * Инициализирует языковые параметры из конфига
     */
    protected function InitConfig()
    {
        parent::InitConfig();
        /*
         * показать предпросмотр шаблона, если он был выбран в админке
         * tip: наивысший приоритет, который можно установить, но ниже чем загрузка настроек в HookSettings.class (вторая очередь)
         */
        $this->PluginAdmin_Skin_SetPreviewTemplate();
    }

}

?>