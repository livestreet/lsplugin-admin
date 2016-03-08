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
 * Работа с комментариями
 *
 */

class PluginAdmin_HookComments extends Hook
{

    public function RegisterHook()
    {
        /*
         * добавить ссылку на полное удаление комментария и всех его ответов
         */
        $this->AddHook('template_comment_actions_end', 'CommentAddFullDeleteLink');
    }


    /**
     * Добавить к каждому комментарию ссылку, ведущую на страницу для полного его удаления
     *
     * @param $aVars    передаваемые параметры из хука
     * @return mixed
     */
    public function CommentAddFullDeleteLink($aVars)
    {
        $this->Viewer_Assign('comment', $aVars['params']['comment'], true);
        return $this->Viewer_Fetch('component@admin:p-comment.hook-delete');
    }

}

?>