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
 * Интеграция интерфейса плагина в админку
 */

class PluginAdmin_ActionAdmin_EventEmbedPlugin extends Event
{

    /*
     * имя экшена админки который должны унаследовать все плагины, которые хотят встраивать свой интерфейс в админку
     */
    const ACTION_PLUGIN_NAME = 'PluginAdmin_ActionPlugin';


    /**
     * Интегрирует настройки плагина в админку и запускает класс "PluginИмяплагина_ActionAdmin", который должен быть унаследован от PluginAdmin_ActionPlugin
     *
     * @return string
     */
    public function EventShowEmbedPlugin()
    {
        $aParams = $this->GetParams();
        $sPlugin = strtolower(array_shift($aParams));

        /*
         * активирован ли плагин
         */
        if (in_array($sPlugin, $this->PluginAdmin_Plugins_GetActivePluginsCodes())) {
            /*
             * построить полное имя класса екшена (на него будет выполнен редирект)
             */
            $sActionClass = 'Plugin' . func_camelize($sPlugin) . '_ActionAdmin';
            /*
             * наследует ли екшен плагина "PluginИмяплагина_ActionAdmin" требуемый класс "PluginAdmin_ActionPlugin" этой админки
             * tip: автозагрузка класса, получение родительских классов экшена плагина "ActionAdmin"
             */
            if (class_exists($sActionClass) and $aParentActionClasses = class_parents($sActionClass) and in_array(self::ACTION_PLUGIN_NAME,
                    $aParentActionClasses)
            ) {
                /*
                 * в роутер добавить новую запись для экшена плагина, на которую будет выполнен редирект
                 */
                $sRouterPage = 'admin_plugin_' . $sPlugin;
                Config::Set('router.page.' . $sRouterPage, $sActionClass);
                /*
                 * перезагрузить заново правила роутера
                 */
                Router::getInstance()->LoadConfig();
                /*
                 * загрузить в шаблон объект для удобного получения URL внутри админки плагина
                 */
                $oAdminUrl = Engine::GetEntity('PluginAdmin_Ui_AdminUrl');
                $oAdminUrl->setPluginCode($sPlugin);

                $this->Viewer_Assign('oAdminUrl', $oAdminUrl);
                /*
                 * выполнить редирект на экшен "PluginИмяплагина_ActionAdmin" плагина с нужным эвентом и параметрами
                 */
                $sEventPlugin = array_shift($aParams);
                return Router::Action($sRouterPage, $sEventPlugin, $aParams);
            }
        }
        return $this->EventNotFound();
    }

}

?>