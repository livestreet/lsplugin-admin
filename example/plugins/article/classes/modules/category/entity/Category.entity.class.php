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
class PluginArticle_ModuleCategory_EntityCategory extends PluginArticle_Inherit_ModuleCategory_EntityCategory
{

    /**
     * Возвращает URL категории
     *
     * @return string
     */
    public function getWebUrl()
    {
        if ($oType = $this->getTypeByCacheLife() and $oType->getTargetType() == 'article') {
            return Router::GetPath('article/category') . $this->getUrlFull() . '/';
        }
        return parent::getWebUrl();
    }
}