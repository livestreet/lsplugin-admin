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
class PluginArticle_ModuleRbac extends PluginArticle_Inherit_ModuleRbac
{

    /**
     * Проверка прав на редактирование статьи
     *
     * @param $oUser
     * @param $aParams
     *
     * @return bool
     */
    public function CheckCustomPluginArticleUpdate($oUser, $aParams)
    {
        if (!$oUser or !isset($aParams['article'])) {
            return false;
        }
        /**
         * Допускаем до редактирования всех с разрешением 'update_all'
         */
        if ($this->Rbac_IsAllowUser($oUser, 'update_all', 'article')) {
            return true;
        }
        /**
         * Допускаем до редактирования автора статьи
         */
        if ($aParams['article']->getUserId() == $oUser->getId()) {
            return true;
        }
        /**
         * Запрещаем
         */
        return false;
    }
}