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

class PluginAdmin_ActionAdmin_EventComments extends Event
{

    /**
     * Показать страницу полного удаления комментария
     *
     * @return mixed
     */
    public function EventFullCommentDelete()
    {
        $this->SetTemplateAction('comments/delete');

        /*
         * есть ли такой комментарий
         */
        if (!$oComment = $this->Comment_GetCommentById((int)getRequestStr('id'))) {
            return $this->EventNotFound();
        }
        $this->Viewer_Assign('oComment', $oComment);

        /*
         * если была нажата кнопка удаления
         */
        if (isPost('submit_comment_delete')) {
            $this->Security_ValidateSendForm();

            $this->PluginAdmin_Comments_DeleteComment($oComment);

            $this->Message_AddNotice($this->Lang('notices.comments.comment_deleted'), '', true);
            Router::LocationAction('admin');
        }
    }

}

?>