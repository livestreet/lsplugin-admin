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
class PluginAdmin_ModuleBlogs_MapperBlogs extends Mapper
{

    /**
     * Получить количество не персональных блогов
     *
     * @return int
     */
    public function GetCountBlogs()
    {
        $sql = "SELECT COUNT(*)
			FROM
				`" . Config::Get('db.table.blog') . "`
			WHERE
				`blog_type` IN ('open', 'invite', 'close')
		";
        return (int)$this->oDb->selectCell($sql);
    }

}

?>