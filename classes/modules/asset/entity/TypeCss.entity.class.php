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
 * @link      http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author    Serge Pustovit (PSNet) <light.feel@gmail.com>
 *
 */
/*
 *
 * Сущность работы с CSS файлами
 *
 */

class PluginAdmin_ModuleAsset_EntityTypeCss extends PluginAdmin_Inherit_ModuleAsset_EntityTypeCss
{

    /**
     * Возвращает HTML обертку для файла
     *
     * @param $sFile
     * @param $aParams
     *
     * @return string
     */
    public function getHeadHtml($sFile, $aParams)
    {
        $sFile .= $this->Asset_AddCacheLastResetCounterToAssetFile($sFile);
        return parent::getHeadHtml($sFile, $aParams);
    }

}

?>