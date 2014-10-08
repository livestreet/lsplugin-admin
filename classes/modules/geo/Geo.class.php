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
 * Расширение возможностей модуля для гео-локации
 *
 */

class PluginAdmin_ModuleGeo extends PluginAdmin_Inherits_ModuleGeo
{


    /**
     * Получить страны по массиву переданных данных в фильтре
     *
     * @param $aFilter        фильтр
     * @return mixed
     */
    public function GetCountriesByArrayFilter($aFilter)
    {
        return $this->oMapper->GetCountriesByArrayFilter($aFilter);
    }


    /**
     * Получить города по массиву переданных данных в фильтре
     *
     * @param $aFilter        фильтр
     * @return mixed
     */
    public function GetCitiesByArrayFilter($aFilter)
    {
        return $this->oMapper->GetCitiesByArrayFilter($aFilter);
    }


}

?>