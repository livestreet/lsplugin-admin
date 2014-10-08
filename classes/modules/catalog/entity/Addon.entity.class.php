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
 * Сущность для работы с дополнениями (плагинами), полученными с помощью АПИ от каталога
 *
 */

class PluginAdmin_ModuleCatalog_EntityAddon extends Entity
{


    /**
     * Проверить совместимость версий лс у дополнения с текущей версией лс сайта
     *
     * @return bool
     */
    public function getCompatibleWithCurrentSitesLSVersion()
    {
        /*
         * по всем версиям ЛС, с которыми совместим плагин
         */
        foreach ($this->getCompatibilities() as $sVersion) {
            /*
             * если хоть одна из его версий больше или равна текущей версии сайта - совместим
             */
            if (version_compare($sVersion, LS_VERSION, '>=')) {
                return true;
            }
        }
        /*
         * плагин не совместим с текущей версией ЛС сайта
         */
        return false;
    }


    /**
     * Получить строку версий ЛС, с которыми совместимо дополнение
     *
     * @param string $sGlue разделитель версий
     * @return string
     */
    public function getCompatibleLSVersionsString($sGlue = ', ')
    {
        return implode($sGlue, $this->getCompatibilities());
    }


    /**
     * Получить оценку в процентном отношении для показа рейтинга
     *
     * @return int
     */
    public function getMarkPercent()
    {
        if ($this->getCountMark() == 0) {
            return 0;
        } else {
            return number_format(round(20 * $this->getMark() / $this->getCountMark(), 1), 1, '.', '');
        }
    }

}

?>