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
 * Сущность для работы с баном пользователей
 *
 */

class PluginAdmin_ModuleUsers_EntityBan extends Entity
{

    /*
     * правила валидации данных сущности
     */
    protected $aValidateRules = array(
        /*
         * тип ограничения
         */
        array('restriction_type', 'number', 'min' => 1, 'max' => 2),
        /*
         * тип условия блокировки (пользователь, ip или диапазон ip-адресов)
         */
        array('block_type', 'number', 'min' => 1, 'max' => 4),
        array('user_id', 'number', 'min' => 1),
        /*
         * todo: для ip нужно что-то придумать т.к. одновременно ipv4 и ipv6 подружить нельзя
         */
        /*
        array ('ip', 'regexp', 'pattern' => '#^\d++\.\d++\.\d++\.\d++$#iu', 'allowEmpty' => true),				// todo: ipv6
        array ('ip_start', 'regexp', 'pattern' => '#^\d++\.\d++\.\d++\.\d++$#iu', 'allowEmpty' => true),
        array ('ip_finish', 'regexp', 'pattern' => '#^\d++\.\d++\.\d++\.\d++$#iu', 'allowEmpty' => true),
        */

        /*
         * тип блокировки по времени (постоянный или интервал)
         */
        array('time_type', 'number', 'min' => 1, 'max' => 2),
        array('date_start', 'date', 'format' => array('yyyy-MM-dd hh:mm:ss', 'yyyy-MM-dd'), 'allowEmpty' => false),
        array('date_finish', 'date', 'format' => array('yyyy-MM-dd hh:mm:ss', 'yyyy-MM-dd'), 'allowEmpty' => false),
        /*
         * дата добавления и последнего редактирования бана
         */
        array('add_date', 'date', 'format' => array('yyyy-MM-dd hh:mm:ss'), 'allowEmpty' => false),
        array('edit_date', 'date', 'format' => array('yyyy-MM-dd hh:mm:ss'), 'allowEmpty' => true),
        /*
         * причина для пользователя
         */
        array('reason_for_user', 'string', 'min' => 0, 'max' => 1000),
        /*
         * комментарий для себя
         */
        array('comment', 'string', 'min' => 0, 'max' => 500),
    );


    /**
     * Получить текст сообщения бана для пользователя в зависимости от типа (временный или постоянный)
     */
    public function getBanMessageForUser()
    {
        if ($this->getIsFull()) {
            /*
             * если это полный бан
             */
            $sLangPrefix = 'plugin.admin.bans.messages.full_ban.';
        } else {
            /*
             * если это бан типа "только чтение"
             */
            $sLangPrefix = 'plugin.admin.bans.messages.readonly_ban.';
        }
        /*
         * получить сообщение на основе временного типа бана
         */
        switch ($this->getTimeType()) {
            case PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT:
                return $this->Lang_Get($sLangPrefix . 'permanently_banned', array(
                    'reason' => $this->getReasonForUser(),
                ));
            case PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD:
                return $this->Lang_Get($sLangPrefix . 'banned_for_period', array(
                    'date_start'  => $this->getDateStart(),
                    'date_finish' => $this->getDateFinish(),
                    'reason'      => $this->getReasonForUser(),
                ));
            default:
                throw new Exception('Admin: error: unknown ban time type "' . $this->getTimeType() . '" in ' . __METHOD__);
        }
    }


    /**
     * Полный ли это бан (без доступа к сайту)
     *
     * @return bool
     */
    public function getIsFull()
    {
        return $this->getRestrictionType() == PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_FULL;
    }


    /**
     * Это бан "read only" (есть возможность читать сайт, без возможности что либо публиковать, комментировать и т.п.)
     *
     * @return bool
     */
    public function getIsReadOnly()
    {
        return $this->getRestrictionType() == PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_READ_ONLY;
    }


    /**
     * Получить урл на страницу полных данных бана
     *
     * @return string
     */
    public function getBanViewUrl()
    {
        return Router::GetPath('admin/users/bans/view') . $this->getId();
    }

}

?>