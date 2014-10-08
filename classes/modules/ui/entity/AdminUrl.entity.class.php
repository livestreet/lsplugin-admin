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
 * Сущность для удобного управления урлами интегрированного плагина
 *
 */

class PluginAdmin_ModuleUi_EntityAdminUrl extends Entity
{

    /*
     * Код плагина
     */
    protected $sPluginCode = null;
    /*
     * Сущность плагина
     */
    protected $oPlugin = null;


    /**
     * Установить код плагина
     *
     * @param $sPluginCode        код плагина
     */
    public function setPluginCode($sPluginCode)
    {
        $this->sPluginCode = $sPluginCode;
    }


    /**
     * Получить код плагина
     *
     * @return string|null
     */
    public function getPluginCode()
    {
        return $this->sPluginCode;
    }


    /**
     * Получить сущность плагина
     *
     * @return Entity|null
     */
    public function getPlugin()
    {
        if ($this->sPluginCode and is_null($this->oPlugin)) {
            $this->oPlugin = $this->PluginAdmin_Plugins_GetPluginByCode($this->sPluginCode);
        }
        return $this->oPlugin;
    }


    /**
     * Получить заголовок плагина
     *
     * @return string|null
     */
    public function getPluginName()
    {
        return $this->getPlugin() ? $this->oPlugin->getName() : $this->sPluginCode;
    }


    /**
     * Получить полный URL до необходимой страницы плагина
     *
     * @param string $sPath относительный урл
     * @param null $sPluginCode код плагина (или взять из сущности)
     * @return string
     */
    public function get($sPath = '', $sPluginCode = null)
    {
        $sPluginCode = $sPluginCode ? $sPluginCode : $this->sPluginCode;
        return Router::GetPath('admin/plugin/' . $sPluginCode) . ($sPath ? $sPath . '/' : '');
    }

}

?>