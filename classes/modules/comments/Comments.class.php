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
class PluginAdmin_ModuleComments extends Module
{

    protected $oMapper = null;


    public function Init()
    {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }


    /**
     * Получить статистику по новым комментариям
     *
     * @param $aPeriod        период
     * @return mixed
     */
    public function GetCommentsStats($aPeriod)
    {
        return $this->oMapper->GetCommentsStats($aPeriod,
            $this->PluginAdmin_Stats_BuildDateFormatFromPHPToMySQL($aPeriod['format']));
    }


    /**
     * Получить количество всех опубликованных комментариев
     *
     * @return int
     */
    public function GetCountCommentsTotal($sType = null)
    {
        return $this->oMapper->GetCountCommentsTotal($sType);
    }


    /**
     * Корректно удалить комментарий и все его ответы и связанные с ним данные (избранное, теги избранного и голоса)
     *
     * @param $oComment        объект комментария
     */
    public function DeleteComment($oComment)
    {
        /*
         * отключить ограничение по времени для обработки
         */
        @set_time_limit(0);
        /*
         * отключить проверку внешних связей
         * (каждая таблица будет чиститься вручную)
         */
        $this->PluginAdmin_Deletecontent_DisableForeignKeysChecking();
        /*
         * удалить сам комментарий
         */
        $this->PluginAdmin_Deletecontent_DeleteComment($oComment);
        /*
         * теперь в таблице комментариев могут быть ответы у которых comment_pid указывает на этот несуществующий комментарий
         * очистка таблицы прямого эфира - там могут быть записи, указывающие на несуществующие комментарии, которые только что были удалены
         */
        $this->PluginAdmin_Deletecontent_DeleteBrokenChainsFromCommentsTreeAndOnlineCommentsAndCleanUpOtherTables();
        /*
         * включить проверку внешних связей
         */
        $this->PluginAdmin_Deletecontent_EnableForeignKeysChecking();
        /*
         * удалить весь кеш - слишком много зависимостей
         */
        $this->Cache_Clean();
        /*
         * Найти родителя и если это "топик" - уменьшить к-во комментариев
         */
        if ($oComment->getTargetType() == 'topic') {
            if ($oTopic = $this->Topic_GetTopicById($oComment->getTargetId())) {
                $aComments = $this->Comment_GetCommentsByFilter(array('target_id' => $oTopic->getId(), 'target_type' => 'topic', 'publish' => 1), array(), 1, 1,
                    array());
                $oTopic->setCountComment($aComments['count']);
                $this->Topic_UpdateTopic($oTopic);
            }
        }
        /**
         * Дополнительно вызываем хук
         */
        $this->Hook_Run('admin_comment_delete', array('comment' => $oComment, 'target_type' => $oComment->getTargetType()));
    }

}

?>