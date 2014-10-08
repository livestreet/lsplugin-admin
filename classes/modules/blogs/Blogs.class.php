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
class PluginAdmin_ModuleBlogs extends Module
{

    protected $oMapper = null;


    public function Init()
    {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }


    /**
     * Получить количество не персональных блогов
     *
     * @return int
     */
    public function GetCountBlogs()
    {
        return $this->oMapper->GetCountBlogs();
    }

}

?>