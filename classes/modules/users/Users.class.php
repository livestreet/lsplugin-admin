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
class PluginAdmin_ModuleUsers extends Module
{

    protected $oMapper = null;

    /*
     * тип ограничения пользования сайтом для бана
     */
    const BAN_RESTRICTION_TYPE_FULL = 1;
    const BAN_RESTRICTION_TYPE_READ_ONLY = 2;

    /*
     * типы правила бана
     */
    const BAN_BLOCK_TYPE_USER_ID = 1;
    const BAN_BLOCK_TYPE_IP = 2;
    const BAN_BLOCK_TYPE_IP_RANGE = 4;
    /*
     * смешанный тип: пользователь + айпи
     */
    const BAN_BLOCK_TYPE_USER_ID_AND_IP = 3;

    /*
     * типы времени бана (постоянный и на период)
     */
    const BAN_TIME_TYPE_PERMANENT = 1;
    const BAN_TIME_TYPE_PERIOD = 2;

    /*
     * имя параметра хранилища для сбора статистики по банам
     */
    const BAN_STATS_PARAM_NAME = 'users_bans_stats';

    /*
     * Ключ хранилища, в котором хранится время последнего входа в админку и айпи последнего входа
     */
    const ADMIN_LAST_VISIT_DATA_STORAGE_KEY = 'admin_last_visit_data';

    /*
     * направление сортировки по-умолчанию (если она не задана или некорректна)
     */
    protected $sSortingWayByDefault = 'desc';

    /*
     * корректные направления сортировки
     * (не менять порядок!)
     */
    protected $aSortingOrderWays = array('desc', 'asc');

    /*
     * Кешированная сущность бана для текущего пользователя на время сессии
     */
    private $oCurrentUserBan = null;
    /*
     * Флаг одноразовой проверки на бан для текущего пользователя на время сессии
     */
    private $bCurrentUserBanChecked = false;


    public function Init()
    {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }


    /**
     * Возвращает список пользователей по фильтру
     *
     * @param array $aFilter Фильтр
     * @param array $aOrder Сортировка
     * @param int $iPage Номер страницы
     * @param int $iPerPage Количество элментов на страницу
     * @param array $aAllowData Список типов данных для подгрузки к пользователям
     * @return array('collection'=>array, 'count'=>int)
     */
    public function GetUsersByFilter(
        $aFilter = array(),
        $aOrder = array(),
        $iPage = 1,
        $iPerPage = PHP_INT_MAX,
        $aAllowData = null
    ) {
        if (is_null($aAllowData)) {
            $aAllowData = array('session');
        }
        $sOrder = $this->GetCorrectSortingOrder(
            $aOrder,
            Config::Get('plugin.admin.users.correct_sorting_order'),
            Config::Get('plugin.admin.users.default_sorting_order')
        );
        $mData = $this->oMapper->GetUsersByFilter($aFilter, $sOrder, $iPage, $iPerPage);

        $mData['collection'] = $this->User_GetUsersAdditionalData($mData['collection'], $aAllowData);
        return $mData;
    }


    /**
     * Проверяет корректность сортировки и возращает часть sql запроса для сортировки
     *
     * @param array $aOrder поля, по которым нужно сортировать вывод пользователей (array('login' => 'desc', 'rating' => 'desc'))
     * @param array $aCorrectSortingOrderList список разрешенных сортировок
     * @param            $sSortingOrderByDefault        сортировка по-умолчанию
     * @return string                                часть sql запроса
     */
    protected function GetCorrectSortingOrder(
        $aOrder = array(),
        $aCorrectSortingOrderList = array(),
        $sSortingOrderByDefault
    ) {
        $sOrder = '';
        foreach ($aOrder as $sRow => $sDir) {
            if (!in_array($sRow, $aCorrectSortingOrderList)) {
                unset($aOrder[$sRow]);
            } elseif (in_array($sDir, $this->aSortingOrderWays)) {
                $sOrder .= " {$sRow} {$sDir},";
            }
        }
        $sOrder = rtrim($sOrder, ',');
        if (empty($sOrder)) {
            $sOrder = $sSortingOrderByDefault . ' ' . $this->sSortingWayByDefault;
        }
        return $sOrder;
    }


    /**
     * Получить поле сортировки по-умолчанию, если оно не указано или некорректно
     *
     * @param $sOrder                    текущее поле сортировки
     * @param $aAllowedSortingOrders    массив разрешенных сортировок
     * @param $sSortingOrderByDefault    сортировка по-умолчанию (будет выбрана, если сортировка не входит в список разрешенных)
     * @return mixed                    поле сортировки по-умолчанию (если не корректно) или указанное
     */
    public function GetDefaultSortingOrderIfIncorrect($sOrder, $aAllowedSortingOrders, $sSortingOrderByDefault)
    {
        if (!in_array($sOrder, $aAllowedSortingOrders)) {
            return $sSortingOrderByDefault;
        }
        return $sOrder;
    }


    /**
     * Получить направление сортировки по-умолчанию, если она не задана или некорректна
     *
     * @param $sWay            текущий тип сортировки
     * @return string        текущий или по-умолчанию (если не корректен)
     */
    public function GetDefaultOrderDirectionIfIncorrect($sWay)
    {
        if (!in_array($sWay, $this->aSortingOrderWays)) {
            return $this->sSortingWayByDefault;
        }
        return $sWay;
    }


    /**
     * Получить сортировку наоборот
     *
     * @param $sWay            текущий тип сортировки
     * @return string        противоположный
     */
    public function GetReversedOrderDirection($sWay)
    {
        $sWay = $this->GetDefaultOrderDirectionIfIncorrect($sWay);
        return $this->aSortingOrderWays[(int)($sWay == $this->sSortingWayByDefault)];
    }


    /*
     *
     * --- Голосования ---
     *
     */

    /**
     * Получить статистическую информацию о том, за что, как и сколько раз голосовал пользователь
     *
     * @param $oUser        объект пользователя
     * @return array        ассоциативный массив голосований за обьекты
     */
    public function GetUserVotingStats($oUser)
    {
        $sCacheKey = 'get_user_voting_stats_' . $oUser->getId();
        if (($aData = $this->Cache_Get($sCacheKey)) === false) {
            $aData = $this->CalcUserVotingStats($oUser);
            $this->Cache_Set($aData, $sCacheKey, array(
                'vote_update_topic',
                'vote_update_comment',
                'vote_update_blog',
                'vote_update_user'
            ), 60 * 30);            // reset every 30 min
        }
        return $aData;
    }


    /**
     * Рассчитать статистику голосования пользователя
     *
     * @param $oUser        объект пользователя
     * @throws Exception
     * @return array
     */
    protected function CalcUserVotingStats($oUser)
    {
        /*
         * заполнить значениями по-умолчанию
         */
        $aVotingStats = array(
            'topic'   => array('plus' => 0, 'minus' => 0, 'abstain' => 0),
            'comment' => array('plus' => 0, 'minus' => 0, 'abstain' => 0),
            'blog'    => array('plus' => 0, 'minus' => 0, 'abstain' => 0),
            'user'    => array('plus' => 0, 'minus' => 0, 'abstain' => 0),
        );
        $aResult = $this->oMapper->GetUserVotingStats($oUser->getId());
        /*
         * собрать данные в удобном виде
         */
        foreach ($aResult as $aData) {
            switch ($aData['vote_direction']) {
                case 1:
                    $aVotingStats[$aData['target_type']]['plus'] = $aData['count'];
                    break;
                case -1:
                    $aVotingStats[$aData['target_type']]['minus'] = $aData['count'];
                    break;
                case 0:
                    $aVotingStats[$aData['target_type']]['abstain'] = $aData['count'];
                    break;
                default:
                    throw new Exception('Admin: error: unknown voting direction "' . $aData['vote_direction'] . '" in ' . __METHOD__);
            }
        }
        return $aVotingStats;
    }


    /**
     * Получить списки голосований пользователя по фильтру
     *
     * @param            $oUser            объект пользователя
     * @param            $aFilter        фильтр
     * @param            $aOrder            сортировка
     * @param int $iPage номер страницы
     * @param int $iPerPage результатов на страницу
     * @return mixed                    коллекция и количество
     */
    public function GetUserVotingByFilter($oUser, $aFilter, $aOrder = array(), $iPage = 1, $iPerPage = PHP_INT_MAX)
    {
        $sCacheKey = 'get_user_voting_list_' . implode('_',
                array($oUser->getId(), serialize($aFilter), serialize($aOrder), $iPage, $iPerPage));
        if (($aData = $this->Cache_Get($sCacheKey)) === false) {
            $aData = $this->oMapper->GetUserVotingListByFilter(
                $oUser->getId(),
                $this->BuildFilterForVotingList($aFilter),
                $this->GetCorrectSortingOrder(
                    $aOrder,
                    Config::Get('plugin.admin.votes.correct_sorting_order'),
                    Config::Get('plugin.admin.votes.default_sorting_order')
                ),
                $iPage,
                $iPerPage
            );
            $this->Cache_Set($aData, $sCacheKey, array(
                'vote_update_topic',
                'vote_update_comment',
                'vote_update_blog',
                'vote_update_user'
            ), 60 * 30);            // reset every 30 min
        }
        return $aData;
    }


    /**
     * Построить фильтр для запроса списка голосований пользователя
     *
     * @param $aFilter            фильтр
     * @return string            строка sql запроса
     * @throws Exception
     */
    protected function BuildFilterForVotingList($aFilter)
    {
        $sWhere = '';
        /*
         * тип голосования (топик, блог и т.п.)
         */
        if (isset($aFilter['type']) and $aFilter['type']) {
            $sWhere .= ' AND `target_type` = "' . $aFilter['type'] . '"';
        }
        /*
         * направление голосов (плюс, минус, воздержался)
         */
        if (isset($aFilter['direction']) and $aFilter['direction']) {
            switch ($aFilter['direction']) {
                case 'plus':
                    $sWhere .= ' AND `vote_direction` = 1';
                    break;
                case 'minus':
                    $sWhere .= ' AND `vote_direction` = -1';
                    break;
                case 'abstain':
                    $sWhere .= ' AND `vote_direction` = 0';
                    break;
                default:
                    throw new Exception('Admin: error: unknown direction type "' . $aFilter['direction'] . '" for votings in ' . __METHOD__);
            }
        }
        return $sWhere;
    }


    /**
     * Для списка голосов получить объект и задать новые универсализированные параметры (заголовок и ссылку на сам обьект)
     *
     * @param array $aVotingList массив голосов
     * @throws Exception
     */
    public function GetTargetObjectsFromVotingList($aVotingList)
    {
        foreach ($aVotingList as $oVote) {
            switch ($oVote->getTargetType()) {
                case 'topic':
                    if ($oTopic = $this->Topic_GetTopicById($oVote->getTargetId())) {
                        $oVote->setTargetTitle($oTopic->getTitle());
                        $oVote->setTargetFullUrl($oTopic->getUrl());
                    }
                    break;
                case 'blog':
                    if ($oBlog = $this->Blog_GetBlogById($oVote->getTargetId())) {
                        $oVote->setTargetTitle($oBlog->getTitle());
                        $oVote->setTargetFullUrl($oBlog->getUrlFull());
                    }
                    break;
                case 'user':
                    if ($oUser = $this->User_GetUserById($oVote->getTargetId())) {
                        $oVote->setTargetTitle($oUser->getLogin());
                        $oVote->setTargetFullUrl($oUser->getUserWebPath());
                    }
                    break;
                case 'comment':
                    if ($oComment = $this->Comment_GetCommentById($oVote->getTargetId())) {
                        $oVote->setTargetTitle($oComment->getText());
                        /*
                         * пока только для топиков
                         */
                        if ($oComment->getTargetType() == 'topic') {
                            $oVote->setTargetFullUrl($oComment->getTarget()->getUrl() . '#comment' . $oComment->getId());
                        }
                    }
                    break;
                default:
                    throw new Exception('Admin: error: unsupported target type: "' . $oVote->getTargetType() . '" in ' . __METHOD__);
            }
        }
    }


    /*
     *
     * --- Изменение количества элементов на страницу ---
     *
     */

    /**
     * Установить количество пользователей на странице
     *
     * @param $iPerPage        количество
     */
    public function ChangeUsersPerPage($iPerPage)
    {
        /*
         * установить количество пользователей на странице
         */
        $aData = array(
            'users' => array(
                'per_page' => $iPerPage,
            )
        );
        $this->PluginAdmin_Settings_SaveConfigByKey('admin', $aData);
    }


    /**
     * Установить количество банов на странице
     *
     * @param $iPerPage        количество
     */
    public function ChangeBansPerPage($iPerPage)
    {
        /*
         * установить количество банов на странице
         */
        $aData = array(
            'bans' => array(
                'per_page' => $iPerPage,
            )
        );
        $this->PluginAdmin_Settings_SaveConfigByKey('admin', $aData);
    }


    /**
     * Установить количество голосов на странице
     *
     * @param $iPerPage        количество
     */
    public function ChangeVotesPerPage($iPerPage)
    {
        /*
         * установить количество голосов на странице
         */
        $aData = array(
            'votes' => array(
                'per_page' => $iPerPage,
            )
        );
        $this->PluginAdmin_Settings_SaveConfigByKey('admin', $aData);
    }


    /*
     *
     * --- Баны ---
     *
     */

    /**
     * Добавить запись о бане
     *
     * @param $oBan        объект бана
     * @return mixed
     */
    public function AddBanRecord($oBan)
    {
        // todo: cache
        return $this->oMapper->AddBanRecord($oBan);
    }


    /**
     * Возвращает список банов по фильтру
     *
     * @param array $aFilter Фильтр
     * @param array $aOrder Сортировка
     * @param int $iPage Номер страницы
     * @param int $iPerPage Количество элментов на страницу
     * @return array('collection'=>array,'count'=>int)
     */
    public function GetBansByFilter($aFilter = array(), $aOrder = array(), $iPage = 1, $iPerPage = PHP_INT_MAX)
    {
        // todo: cache
        $sOrder = $this->GetCorrectSortingOrder(
            $aOrder,
            Config::Get('plugin.admin.bans.correct_sorting_order'),
            Config::Get('plugin.admin.bans.default_sorting_order')
        );
        $mData = $this->oMapper->GetBansByFilter($aFilter, $sOrder, $iPage, $iPerPage);
        return $mData;
    }


    /**
     * Получить объект бана по id
     *
     * @param $iId        ид бана
     * @return mixed
     */
    public function GetBanById($iId)
    {
        $aFilter = array(
            'id' => $iId,
        );
        $aData = $this->GetBansByFilter($aFilter, array(), 1, 1);
        return ($aData['count'] ? array_shift($aData['collection']) : null);
    }


    /**
     * Удалить бан по id
     *
     * @param $iId        ид бана
     * @return mixed
     */
    public function DeleteBanById($iId)
    {
        // todo: cache
        return $this->oMapper->DeleteBanById($iId);
    }


    /**
     * Удалить старые записи банов, дата окончания которых уже прошла
     */
    public function DeleteOldBanRecords()
    {
        // todo: cache
        return $this->oMapper->DeleteOldBanRecords();
    }


    /*
     *
     * --- Проверка пользователя на бан ---
     *
     */

    /**
     * Проверка на бан указанного пользователя или айпи на указанную дату
     *
     * @param $oUser            сущность пользователя
     * @param $sIp                указанный айпи
     * @param $sDate            на указанную дату
     * @return Entity|null
     */
    protected function IsUserBanned($oUser = null, $sIp = null, $sDate = null)
    {
        /*
         * если пользователь не указан - проверять текущего
         */
        if (is_null($oUser)) {
            $oUser = $this->User_GetUserCurrent();
        }
        /*
         * если айпи не указан - использовать текущий айпи
         */
        if (is_null($sIp)) {
            $sIp = func_getIp();
        }
        /*
         * если не указана дата - значит проверять на текущий момент
         */
        if (is_null($sDate)) {
            $sDate = date('Y-m-d H:i:s');
        }
        /*
         * ip представляется в бд в виде целого числа
         */
        $mIp = convert_ip2long($sIp);
        /*
         * кешированию не подлежит
         */
        return $this->oMapper->IsUserBanned($oUser, $mIp, $sDate);
    }


    /**
     * Проверить является ли ТЕКУЩИЙ пользователь забаненным (поиск по текущему пользователю (если есть) и текущему айпи)
     *
     * tip: с использованием кеширования ответа на момент сессии, чтобы проверка на бан для текущего пользователя выполнялась только один раз за всю сессию работы движка
     *
     * tip: использовать этот метод для проверки на бан ТЕКУЩЕГО пользователя, не обьеденять с GetUserBannedByUser
     *        т.к. этот метод работает с текущим айпи, что позволит сработать правилам и для не залогиненного пользователя
     *        потому что GetUserBannedByUser использует данные сущности пользователя, в т.ч. и айпи - либо последнего входа либо регистрации
     *
     * @return Entity|null        объект бана или нулл
     */
    public function IsCurrentUserBanned()
    {
        if (!$this->bCurrentUserBanChecked) {
            $this->oCurrentUserBan = $this->IsUserBanned();
            $this->bCurrentUserBanChecked = true;
        }
        return $this->oCurrentUserBan;
    }


    /**
     * Проверить является ли указанный пользователь забаненным (по его сущности, айпи последнего входа или айпи регистрации)
     *
     * tip: использовать этот метод для проверки на бан конкретной сущности пользователя,
     *        из которой будет получен айпи для проверки - либо последнего входа либо регистрации (но не текущий айпи!)
     *
     * @param $oUser            объект пользователя
     * @return Entity|null
     */
    public function GetUserBannedByUser($oUser)
    {
        /*
         * для указанного пользователя брать айпи либо из последней сессии либо регистрации
         */
        if ($oSession = $oUser->getSession()) {
            $sIp = $oSession->getIpLast();
        } else {
            $sIp = $oUser->getIpRegister();
        }
        return $this->IsUserBanned($oUser, $sIp);
    }


    /*
     *
     * --- Обертки для проверки на бан ТЕКУЩЕГО пользователя с указанным типом ограничений ---
     * tip: системные методы, не для использования плагинами. Плагинам следует использовать методы из сущности пользователя
     *
     */

    /**
     * Попадает ли ТЕКУЩИЙ пользователь под полный бан с лишением доступа ко всему сайту, возвращает объект бана в случае успеха
     * tip: используется в хуке банов для общей блокировки доступа
     *
     * @return Entity|bool
     */
    public function IsCurrentUserBannedFully()
    {
        if ($oBan = $this->IsCurrentUserBanned() and $oBan->getIsFull()) {
            return $oBan;
        }
        return false;
    }


    /**
     * Попадает ли ТЕКУЩИЙ пользователь под "read only" бан (есть возможность читать сайт, без возможности что либо публиковать, комментировать и т.п.),
     * возвращает объект бана в случае успеха
     * tip: используется в наследуемом модуле ACL, может быть вызван плагинами для проверки возможности публикации для текущего (!) пользователя
     *
     * @return Entity|bool
     */
    public function IsCurrentUserBannedForReadOnly()
    {
        if ($oBan = $this->IsCurrentUserBanned() and $oBan->getIsReadOnly()) {
            return $oBan;
        }
        return false;
    }


    /*
     * tip: для метода GetUserBannedByUser здесь не нужны методы проверки на тип бана - они есть в сущности пользователя: getBannedCachedFully и getBannedCachedForReadOnly соответственно
     */


    /**
     * Попадает ли текущий пользователь под одно из правил бана
     *
     * @param $oBan            сущность бана
     * @return bool
     * @throws Exception
     */
    public function IsCurrentUserMatchAnyRuleOfBan($oBan)
    {
        $oUser = $this->User_GetUserCurrent();
        switch ($oBan->getBlockType()) {
            /*
             * бан по сущности пользователя
             */
            case PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID:
                if ($oUser and $oBan->getUserId() == $oUser->getId()) {
                    return true;
                }
                break;
            /*
             * бан по айпи
             */
            case PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP:
                if (convert_long2ip($oBan->getIp()) == func_getIp()) {
                    return true;
                }
                break;
            /*
             * бан по диапазону айпи адресов
             */
            case PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP_RANGE:
                if ($oBan->getIpStart() <= convert_ip2long(func_getIp()) and $oBan->getIpFinish() >= convert_ip2long(func_getIp())) {
                    return true;
                }
                break;
            /*
             * бан по сущности пользователя и по айпи (смешанный тип)
             */
            case PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID_AND_IP:
                if (($oUser and $oBan->getUserId() == $oUser->getId()) or convert_long2ip($oBan->getIp()) == func_getIp()) {
                    return true;
                }
                break;
            /*
             * тип не распознан
             */
            default:
                throw new Exception('Admin: error: unknown ban type "' . $oBan->getBlockType() . '" in ' . __METHOD__);
        }
        return false;
    }


    /*
     *
     * --- Статистика по банам ---
     *
     */

    /**
     * Добавить запись о срабатывании бана в статистику
     *
     * @param $oBan            объект бана
     * @return bool
     */
    public function AddBanTriggering($oBan)
    {
        if (!Config::Get('plugin.admin.bans.gather_bans_running_stats')) {
            return false;
        }
        /*
         * получить статистику по банам
         */
        $aStats = $this->GetBanStats();
        /*
         * увеличить счетчик статистики на единицу
         */
        $aStats[$oBan->getId()] = (isset($aStats[$oBan->getId()]) ? $aStats[$oBan->getId()] + 1 : 1);
        /*
         * сохранить данные статистики
         */
        $this->Storage_Set(self::BAN_STATS_PARAM_NAME, $aStats, $this);
    }


    /**
     * Получить статистику по банам
     *
     * @return array
     */
    public function GetBanStats()
    {
        return (array)$this->Storage_Get(self::BAN_STATS_PARAM_NAME, $this);
    }


    /**
     * Удалить статистику бана
     *
     * @param $oBan                объект бана
     */
    public function DeleteBanStats($oBan)
    {
        /*
         * получить статистику по банам
         */
        $aStats = $this->GetBanStats();
        /*
         * удалить счетчик статистики бана
         */
        unset($aStats[$oBan->getId()]);
        /*
         * сохранить данные статистики
         */
        $this->Storage_Set(self::BAN_STATS_PARAM_NAME, $aStats, $this);
    }


    /**
     * Удалить все записи статистики срабатываний банов
     */
    public function DeleteAllBansStats()
    {
        $this->Storage_Set(self::BAN_STATS_PARAM_NAME, null, $this);
    }


    /*
     *
     * --- Назначение/удаление администраторов ---
     *
     */

    /**
     * Добавить права админа пользователю
     *
     * @param $oUser        объект пользователя
     * @return mixed
     */
    public function AddAdmin($oUser)
    {
        $oUser->setAdmin(1);
        return $this->User_Update($oUser);
    }


    /**
     * Удалить права админа у пользователя
     *
     * @param $oUser        объект пользователя
     * @return mixed
     */
    public function DeleteAdmin($oUser)
    {
        $oUser->setAdmin(0);
        return $this->User_Update($oUser);
    }


    /*
     *
     * --- Удаление контента ---
     *
     */

	/**
	 * Удалить контент пользователя и самого пользователя
	 *
	 * @param      $oUser        объект пользователя
	 * @param bool $bDeleteUser  удалять ли самого пользователя
	 */
    public function PerformUserContentDeletion($oUser, $bDeleteUser = false)
    {
        /*
         * отключить ограничение по времени для обработки
         */
        @set_time_limit(0);
        /*
         * блокировать пользователя перед удалением данных. Например, если это бот,
         * то чтобы не получилось одновременно удаление его данных и набивание им контента на сайте
         */
        $iBanId = $this->BanUserPermanently($oUser);
        /*
         * отключить проверку внешних связей
         * (каждая таблица будет чиститься вручную)
         */
        $this->PluginAdmin_Deletecontent_DisableForeignKeysChecking();
        /*
         * выполнить непосредственное удаление контента
         */
        $this->DeleteUserContent($oUser, $bDeleteUser);
        /*
         * удаление самого пользователя из сайта
         */
        if ($bDeleteUser) {
            $this->DeleteUser($oUser);
        }
        /*
         * включить проверку внешних связей
         */
        $this->PluginAdmin_Deletecontent_EnableForeignKeysChecking();
        /*
         * удалить весь кеш - слишком много зависимостей
         */
        $this->Cache_Clean();
        /*
         * удалить временную блокировку пользователя
         */
        $this->DeleteBanById($iBanId);
    }


    /**
     * Заблокировать пользователя (постоянный бан)
     *
     * @param $oUser            объект пользователя
     * @return bool|mixed
     */
    protected function BanUserPermanently($oUser)
    {
        $oEnt = Engine::GetEntity('PluginAdmin_Users_Ban');
        /*
         * тип ограничения
         */
        $oEnt->setRestrictionType(self::BAN_RESTRICTION_TYPE_FULL);
        /*
         * тип блокировки
         */
        $oEnt->setBlockType(PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID);
        $oEnt->setUserId($oUser->getId());
        /*
         * тип временного интервала блокировки
         */
        $oEnt->setTimeType(PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT);
        $oEnt->setDateStart('2000-01-01');
        $oEnt->setDateFinish('2030-01-01');
        /*
         * дата создания и редактирования
         */
        $oEnt->setAddDate(date('Y-m-d H:i:s'));
        $oEnt->setEditDate($oEnt->getAddDate());
        /*
         * причина бана и комментарий
         */
        $oEnt->setReasonForUser('admin: auto blocking before deleting content');
        $oEnt->setComment($oEnt->getReasonForUser());

        /*
         * валидация внесенных данных
         */
        if (!$oEnt->_Validate()) {
            $this->Message_AddError($oEnt->_getValidateError());
            return false;
        }
        return $this->AddBanRecord($oEnt);
    }


    /**
     * Удалить весь контент пользователя
     *
     * @param $oUser        объект пользователя
     * @param $bDeleteUser    флаг удаления пользователя (нужен для удаления личного блога)
     */
    protected function DeleteUserContent($oUser, $bDeleteUser)
    {
        /*
         * вызов хука для удаления контента от плагинов сторонних разработчиков ПЕРЕД удалением внутренних данных
         */
        $this->Hook_Run('admin_delete_content_before', array('oUser' => $oUser));
        /*
         * удаление контента формируемого и управляемого движком
         */
        $this->DeleteInternalUserContent($oUser, $bDeleteUser);
        /*
         * вызов хука для удаления контента от плагинов сторонних разработчиков ПОСЛЕ удаления внутренних данных
         * (запись пользователя в таблице prefix_user ещё существует)
         */
        $this->Hook_Run('admin_delete_content_after', array('oUser' => $oUser));
    }


    /**
     * Удалить весь контент пользователя, который обрабатывается и управляется движком (все блоги, топики, сообщения и т.п.)
     *
     * @param $oUser        объект пользователя
     * @param $bDeleteUser    флаг удаления пользователя (нужен для удаления личного блога)
     */
    protected function DeleteInternalUserContent($oUser, $bDeleteUser)
    {
        /*
         *
         * удалить блоги пользователя и все дочерние элементы блога
         *
         */
        /*
         * получить ид всех блогов пользователя (кроме персонального)
         */
        if ($aBlogsId = $this->Blog_GetBlogsByOwnerId($oUser->getId(), true)) {
            foreach ($aBlogsId as $iBlogId) {
                /*
                 * удалить блог
                 * 		его топики (связанные данные топиков:
                 * 			контент топика
                 * 			комментарии к топику (
                 * 				удаляются из избранного,
                 * 				прямого эфира
                 * 				голоса за них
                 * 			)
                 * 			из избранного
                 * 			из прочитанного
                 * 			голосование к топику
                 * 			теги
                 * 			фото у топика-фотосета
                 * 		)
                 * 		связи пользователей блога
                 *		голосование за блог
                 * 		уменьшение счетчика в категории блога
                 */
                $this->Blog_DeleteBlog($iBlogId);
            }
        }

        /*
         * удалить персональный блог (только если удаляется и сам пользователь)
         */
        if ($bDeleteUser and $oBlog = $this->Blog_GetPersonalBlogByUserId($oUser->getId())) {
            /*
             * удаляет все тоже самое что и из предыдущего списка
             */
            $this->Blog_DeleteBlog($oBlog);
        }

        /*
         * удаление личных сообщений
         */
        $aTalks = $this->Talk_GetTalksByFilter(array('user_id' => $oUser->getId()), 1, PHP_INT_MAX);
        if ($aTalks['count']) {
            /*
             * получить ид всех личных сообщений
             */
            $aTalkIds = array();
            foreach ($aTalks['collection'] as $oTalk) {
                $aTalkIds[] = $oTalk->getId();
            }
            if ($aTalkIds) {
                $this->Talk_DeleteTalkUserByArray($aTalkIds, $oUser->getId());
            }
        }

        /*
         * удалить голоса за профиль пользователя
         */
        $this->Vote_DeleteVoteByTarget($oUser->getId(), 'user');

        /*
         * tip: если будут проблемы с удалением объектов выше - можно весь процесс удаления перевести на модуль удаления (как в вызовах ниже)
         */

        /*
         *
         * Удаление каждого типа контента по очереди через модуль удаления контента.
         * Методы для удаления контента идут в алфавитном порядке т.е. в порядке вывода таблиц в пхпмайадмин по-умолчанию,
         * также сгруппированы логически (например, "удаление записей друзей у пользователя" и рядом "удаление записи пользователя как друга у других пользователей")
         *
         */

        /*
         * удалить избранное пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserFavourite($oUser);
        /*
         * удалить теги избранного пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserFavouriteTag($oUser);

        /*
         * удалить друзей пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUsersFriends($oUser);
        /*
         * удалить пользователя как друга у других пользователей
         */
        $this->PluginAdmin_Deletecontent_DeleteUserIsFriendForOtherUsers($oUser);

        /*
         * удалить гео-данные пользователя (запись с указанием его страны, области и города)
         */
        $this->PluginAdmin_Deletecontent_DeleteUserGeoTargets($oUser);

        /*
         * удалить записи про инвайты: кого пригласил этот пользователь
         */
        $this->PluginAdmin_Deletecontent_DeleteUserInviteFrom($oUser);
        /*
         * удалить записи про инвайты: кем был приглашен этот пользователь
         */
        $this->PluginAdmin_Deletecontent_DeleteUserInviteTo($oUser);
        $this->PluginAdmin_Deletecontent_DeleteUserInviteCode($oUser);

        /*
         * удалить записи рассылки уведомлений
         */
        $this->PluginAdmin_Deletecontent_DeleteUserNotifyTask($oUser);

        /*
         * удалить напоминания про пароль
         */
        $this->PluginAdmin_Deletecontent_DeleteUserReminder($oUser);

        /*
         * удалить события активности пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserStreamEvents($oUser);
        /*
         * удалить подписку активности пользователя на других пользователей
         */
        $this->PluginAdmin_Deletecontent_DeleteUserStreamSubscribe($oUser);
        /*
         * удалить подписку активности других пользователей на этого пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserStreamSubscribeTarget($oUser);
        /*
         * удалить опции типов на что подписался в активности пользователь
         */
        $this->PluginAdmin_Deletecontent_DeleteUserStreamUserType($oUser);

        /*
         * удалить подписку пользователя на разные события (оповещения)
         */
        $this->PluginAdmin_Deletecontent_DeleteUserSubscribe($oUser);

        /*
         * удалить подписку фида пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserFeedSubscribe($oUser);
        /*
         * удалить подписку фида других пользователей на этого пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserFeedSubscribeTarget($oUser);

        /*
         * удалить смену почты пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserChangeMail($oUser);

        /*
         * удалить данные произвольных полей профиля пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserFieldValue($oUser);

        /*
         * удалить заметки пользователя о других пользователях
         */
        $this->PluginAdmin_Deletecontent_DeleteUserOwnNotes($oUser);
        /*
         * удалить заметки других пользователей об этом пользователе
         */
        $this->PluginAdmin_Deletecontent_DeleteUserNotesFromOtherUsers($oUser);

        /*
         * удалить голоса пользователя за другие объекты
         */
        $this->PluginAdmin_Deletecontent_DeleteUserVotes($oUser);

        /*
         * удалить стену пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserWall($oUser);
        /*
         * удалить записи пользователя на других стенах
         */
        $this->PluginAdmin_Deletecontent_DeleteUserWroteOnWalls($oUser);
        /*
         * удалить жалобы от пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUsersComplaintsFrom($oUser);
        /*
         * удалить жалобы на пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUsersComplaintsTarget($oUser);

        /*
         *
         * Удалить комментарии пользователя и все дочерние ответы на них и связанные с ними данные
         *
         * Комментарии - не линейная структура, поэтому процесс удаления будет состоять из удаления комментариев пользователя,
         * очистки оставшихся дочерних комментариев (ответов) и перестроения структуры дерева (если используется "nested set")
         * и удаляения записей голосований и избранного для удаленных веток комментариев
         *
         */
        $this->DeleteUserCommentsTree($oUser);

        /*
         * Очистка активности (стрима) от ссылок на записи, которых больше нет
         */
        $this->PluginAdmin_Deletecontent_CleanStreamForEventsNotExists();
        /*
         * Очистка голосов, которые указывают на объекты, которых больше нет
         */
        $this->PluginAdmin_Deletecontent_CleanVotingsTableTargetingObjectsNotExists();
        /*
         * Очистить записи избранного и тегов для избранного, указывающие на несуществующие объекты
         */
        $this->PluginAdmin_Deletecontent_CleanFavouritesAndItsTagsTargetingObjectsNotExists();
    }


    /**
     * Удалить комментарии пользователя, все дочерние комментарии к ним и связанные данные
     *
     * @param $oUser    объект пользователя
     */
    protected function DeleteUserCommentsTree($oUser)
    {
        /*
         * удалить все прямые комментарии пользователя
         * (они не все были удалены ранее т.к. часть из них может находится в топиках других пользователей)
         */
        $this->PluginAdmin_Deletecontent_DeleteUserOwnComments($oUser);

        /*
         * теперь в таблице комментариев могут быть ответы у которых comment_pid указывает на несуществующие комментарии этого пользователя
         * (это нормально т.к. проверка ключей должна быть отключена на момент удаления).
         * очистка таблицы прямого эфира - там могут быть записи, указывающие на несуществующие комментарии, которые только что были удалены,
         * очистка других связанных данных
         */
        $this->PluginAdmin_Deletecontent_DeleteBrokenChainsFromCommentsTreeAndOnlineCommentsAndCleanUpOtherTables();
    }


    /**
     * Удалить запись пользователя из БД
     *
     * @param $oUser    сущность пользователя
     * @return mixed
     */
    protected function DeleteUser($oUser)
    {
        /*
         * вызов хука перед удалением самого пользователя
         */
        $this->Hook_Run('admin_delete_user_before', array('oUser' => $oUser));
        /*
         * удалить пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserItself($oUser);
        /*
         * удалить сессию пользователя
         */
        $this->PluginAdmin_Deletecontent_DeleteUserSession($oUser);
        /*
         * вызов хука после удаления пользователя
         */
        $this->Hook_Run('admin_delete_user_after', array('oUser' => $oUser));
    }


    /*
     *
     * --- Последний визит ---
     *
     */

    /**
     * Возвращает имя параметра данных последнего визита хранилища для текущего пользователя
     *
     * @return string
     */
    protected function GetAdminLastVisitKeyForUser()
    {
        return self::ADMIN_LAST_VISIT_DATA_STORAGE_KEY . '_' . $this->User_GetUserCurrent()->getId();
    }


    /**
     * Возвращает данные последнего входа на основе даты и ip персонально для каждого пользователя
     *
     * @return array
     */
    public function GetLastVisitData()
    {
        $aData = (array)$this->Storage_Get($this->GetAdminLastVisitKeyForUser(), $this);
        if (isset($aData['ip'])) {
            /*
             * не изменился ли текущий ip с момента прошлого входа
             */
            $aData['same_ip'] = func_getIp() == $aData['ip'];
        }
        return $aData;
    }


    /**
     * Записать данные последнего входа пользователя в админку персонально для каждого пользователя
     */
    public function SetLastVisitData()
    {
        $aData = array(
            /*
             * дата последнего входа
             */
            'date' => date("Y-m-d H:i:s"),
            /*
             * ip последнего входа
             */
            'ip'   => func_getIp(),
        );
        $this->Storage_Set($this->GetAdminLastVisitKeyForUser(), $aData, $this);
    }


    /**
     * Получить информацию о последнем входе пользователя в админку
     */
    public function GetLastVisitMessageAndCompareIp()
    {
        /*
         * получить и записать данные последнего входа пользователя в админку
         */
        $aLastVisitData = $this->GetLastVisitData();
        $this->SetLastVisitData();
        /*
         * если это первый вход - показать приветствие
         */
        if (!$aLastVisitData) {
            $this->Message_AddNotice($this->Lang_Get('plugin.admin.hello.first_run'),
                $this->Lang_Get('plugin.admin.hello.title'));
        } elseif (!$aLastVisitData['same_ip']) {
            /*
             * если айпи последнего входа и текущий не совпали - вывести предупреждение
             */
            $this->Message_AddNotice(
                $this->Lang_Get('plugin.admin.hello.last_visit_ip_not_match_current',
                    array('last_ip' => $aLastVisitData['ip'], 'current_ip' => func_getIp())),
                $this->Lang_Get('plugin.admin.attention')
            );
        }
        $this->Viewer_Assign('aLastVisitData', $aLastVisitData);
    }


    /*
     *
     * --- Статистика ---
     *
     */

    /**
     * Получить статистику пользователей по возрасту
     *
     * @return mixed
     */
    public function GetUsersBirthdaysStats()
    {
        /*
         * кешировать здесь нечего - т.к. выборка идет по всей таблице, а данные пользователей меняются очень часто,
         * то смысла в кешировании нет, т.к. кеш будет постоянно сбрасываться, только лишние операции
         */
        $aData = $this->oMapper->GetUsersBirthdaysStats();
        /*
         * получить максимальное значение пользователей одного возраста для расчетов при выводе графиков
         */
        $iMaxOneAgeUsersCount = 0;
        foreach ($aData as $aItem) {
            if ($aItem['count'] > $iMaxOneAgeUsersCount) {
                $iMaxOneAgeUsersCount = $aItem['count'];
            }
        }
        return array(
            'collection'              => $aData,
            'max_one_age_users_count' => $iMaxOneAgeUsersCount
        );
    }


    /*
     *
     * --- Статистика стран и городов ---
     *
     */

    /**
     * Получить статистику стран или городов
     *
     * @param $sLivingSection    тип разреза: страны или города
     * @param $sSorting            сортировка
     * @return mixed
     */
    public function GetUsersLivingStats($sLivingSection, $sSorting)
    {
        /*
         * кешировать здесь нечего - т.к. выборка идет по всей таблице, а данные пользователей меняются очень часто,
         * то смысла в кешировании нет, т.к. кеш будет постоянно сбрасываться, только лишние операции
         */
        $aData = $this->oMapper->GetUsersLivingStats(
            $this->GetLivingStatsSQLGroupCondition($sLivingSection),
            $this->GetLivingStatsSQLSortingCondition($sSorting)
        );
        return array(
            /*
             * дополнить объектами
             */
            'collection' => $this->GetLivingStatsObjects($aData, $sLivingSection)
        );
    }


    /**
     * Получение поля таблицы по которому нужно отобрать и сгруппировать данные для показа статистики по странам/городам
     *
     * @param $sLivingSection    разрез отбора
     * @return string
     */
    protected function GetLivingStatsSQLGroupCondition($sLivingSection)
    {
        if ($sLivingSection == 'cities') {
            return 'user_profile_city';
        }
        return 'user_profile_country';
    }


    /**
     * Поле таблицы для сортировки и направление в зависимости от типа сортировки
     *
     * @param $sSorting            тип сортировки
     * @return string            поле таблицы и направление сортировки
     */
    protected function GetLivingStatsSQLSortingCondition($sSorting)
    {
        if ($sSorting == 'alphabetic') {
            /*
             * сортировка по полю группировки
             */
            return array('field' => 'item', 'way' => 'ASC');
        }
        /*
         * сортировка по количеству пользователей страны или города
         */
        return array('field' => 'count', 'way' => 'DESC');
    }


    /**
     * Получить объекты статистики проживаний за один запрос
     *
     * @param $aData            данные полученные при сборе статистики
     * @param $sLivingSection    тип отображаемых данных (города или страны)
     * @return mixed            дополненные данные
     */
    protected function GetLivingStatsObjects($aData, $sLivingSection)
    {
        /*
         * получить названия объектов
         */
        $aItemsNames = my_array_column($aData, 'item');
        /*
         * получить имя метода для сбора данных (по странам или городам)
         */
        if ($sLivingSection == 'cities') {
            $sMethodName = 'Geo_GetCitiesByArrayFilter';
        } else {
            $sMethodName = 'Geo_GetCountriesByArrayFilter';
        }
        /*
         * для отбора по нужному полю в зависимости от языка
         */
        $sTableFieldName = 'name_en';
        if ($this->Lang_GetLang() == 'ru') {
            $sTableFieldName = 'name_ru';
        }
        /*
         * получить объекты по фильтру
         */
        $aItems = $this->{$sMethodName}(array(
            $sTableFieldName => $aItemsNames,
            'page'           => 1,
            'per_page'       => count($aItemsNames),
        ));
        /*
         * собрать вместе данные
         */
        foreach ($aData as $iKey => &$aRow) {
            /*
             * проверка нужна если у пользователя была запись, а данные таблицы гео изменили и их части нет
             */
            $aRow['entity'] = isset($aItems[$iKey]) ? $aItems[$iKey] : null;
        }
        return $aData;
    }


    /*
     *
     * --- Статистика регистраций ---
     *
     */

    /**
     * Получить статистику регистраций пользователей
     *
     * @param $aPeriod        период
     * @return mixed
     */
    public function GetUsersRegistrationStats($aPeriod)
    {
        return $this->oMapper->GetUsersRegistrationStats($aPeriod,
            $this->PluginAdmin_Stats_BuildDateFormatFromPHPToMySQL($aPeriod['format']));
    }


    /**
     * Получить количество пользователей с позитивным и негативным рейтингом
     *
     * @return array
     */
    public function GetCountGoodAndBadUsers()
    {
        $aData = $this->oMapper->GetCountGoodAndBadUsers();
        $aData['total'] = $aData['good_users'] + $aData['bad_users'];
        return $aData;
    }


    /*
     *
     * --- Редактирование данных пользователя ---
     *
     */

    /**
     * Выполнить изменение данных в таблице пользователя
     *
     * @param $oUser        объект пользователя
     * @param $aChanges        массив необходимых изменений field => value
     */
    public function ModifyUserData($oUser, $aChanges)
    {
        $this->oMapper->Update($oUser, $aChanges);
        $this->Cache_Clean();
    }


    /**
     * Сменить рейтинг пользователя
     *
     * @param $oUser        объект пользователя
     * @param $sNewValue    новое значение
     */
    protected function ChangeUserRating($oUser, $sNewValue)
    {
        $this->ModifyUserData($oUser, array('user_rating' => $sNewValue));
    }


    /**
     * Сменить статус активированности пользователя
     *
     * @param $oUser        объект пользователя
     * @param $sNewValue    новое значение
     */
    public function ChangeUserActivate($oUser, $sNewValue)
    {
        $this->ModifyUserData($oUser, array('user_activate' => $sNewValue));
    }


    /**
     * Изменить данные пользователя
     *
     * @param $sType    тип поля для редактирования
     * @param $oUser    объект пользователя
     * @param $sValue    новое значение
     * @return mixed
     */
    public function PerformUserDataModification($sType, $oUser, $sValue)
    {
        /*
         * флаг ошибки
         */
        $bError = false;
        /*
         * текст ошибки
         */
        $sErrorMsg = null;
        /*
         * возвращаемое значение
         */
        $sReturnValue = $sValue;
        /*
         * выполнить действие на основе его типа
         */
        switch ($sType) {
            /*
             * редактировать рейтинг пользователя
             */
            case 'rating':
                // todo: export in method
                if ($this->Validate_Validate('number', $sValue, array('allowEmpty' => false, 'integerOnly' => false))) {
                    $this->ChangeUserRating($oUser, $sValue);
                } else {
                    $bError = true;
                    $sErrorMsg = $this->Lang_Get('plugin.admin.errors.profile_edit.wrong_number');
                    $sReturnValue = $oUser->getRating();
                }
                break;
            /*
             * действие не найдено
             */
            default:
                $bError = true;
                $sErrorMsg = $this->Lang_Get('plugin.admin.errors.profile_edit.unknown_action_type');
        }
        return array(
            'error'         => $bError,
            'error_message' => $sErrorMsg,
            'return_value'  => $sReturnValue,
        );
    }


    /*
     *
     * --- Хелперы изменения данных пользователя ---
     *
     */

    /**
     * Проверить новый логин пользователя на корректность написания и дубликат
     *
     * @param $sNewLogin    новый логин
     * @param $oUser        объект пользователя, которому будут применять изменение
     * @return bool
     */
    public function ValidateUserLoginChange($sNewLogin, $oUser)
    {
        /*
         * проверить на корректность написания логина
         */
        if (!$this->User_CheckLogin($sNewLogin)) {
            return $this->Lang_Get('plugin.admin.errors.profile_edit.login_has_unsupported_symbols');
        }
        /*
         * проверить не занят ли логин (даже если этим же пользователем)
         */
        if ($oUserFound = $this->User_GetUserByLogin($sNewLogin) and $oUserFound->getId() != $oUser->getId()) {
            return $this->Lang_Get('plugin.admin.errors.profile_edit.login_already_exists');
        }
        return true;
    }


    /**
     * Проверить новую почту пользователя на дубликат
     *
     * @param $sNewMail        новая почта
     * @param $oUser        объект пользователя, которому будут применять изменение
     * @return bool
     */
    public function ValidateUserMailChange($sNewMail, $oUser)
    {
        /*
         * проверить на корректность почту
         */
        if (!$this->Validate_Validate('email', $sNewMail, array('allowEmpty' => false))) {
            return $this->Lang_Get('plugin.admin.errors.profile_edit.mail_is_incorrect') . '. ' . $this->Validate_GetErrorLast();
        }
        /*
         * проверить не занята ли эта почта
         */
        if ($oUserFound = $this->User_GetUserByMail($sNewMail) and $oUserFound->getId() != $oUser->getId()) {
            return $this->Lang_Get('plugin.admin.errors.profile_edit.mail_already_exists');
        }
        return true;
    }


    /**
     * Проверить новый пароль пользователя
     *
     * @param $sNewPassword        новый пароль
     * @return bool
     */
    public function ValidateUserPasswordChange($sNewPassword)
    {
        /*
         * длина пароля должна быть больше 5 символов
         */
        if (mb_strlen($sNewPassword, 'utf-8') < 5) {
            return $this->Lang_Get('plugin.admin.errors.profile_edit.password_is_too_weak');
        }
        return true;
    }


    /*
     *
     * --- Жалобы на пользователя ---
     *
     */

    /**
     * Возвращает список жалоб на пользователей по фильтру
     *
     * @param array $aFilter Фильтр
     * @param array $aOrder Сортировка
     * @param int $iPage Номер страницы
     * @param int $iPerPage Количество элментов на страницу
     * @return array('collection'=>array, 'count'=>int)
     */
    public function GetUsersComplaintsByFilter(
        $aFilter = array(),
        $aOrder = array(),
        $iPage = 1,
        $iPerPage = PHP_INT_MAX
    ) {
        $sOrder = $this->GetCorrectSortingOrder(
            $aOrder,
            Config::Get('plugin.admin.users.complaints.correct_sorting_order'),
            Config::Get('plugin.admin.users.complaints.default_sorting_order')
        );
        return $this->oMapper->GetUsersComplaintsByFilter($aFilter, $sOrder, $iPage, $iPerPage);
    }


    /**
     * Получить жалобу на пользователя по ид
     *
     * @param $iId                ид жалобы на пользователя
     * @return mixed|null
     */
    public function GetUserComplaintById($iId)
    {
        $aData = $this->GetUsersComplaintsByFilter(array('id' => $iId), array(), 1, 1);
        if ($aData['count'] != 0) {
            return array_shift($aData['collection']);
        }
        return null;
    }


    /**
     * Получить количество жалоб на пользователей по фильтру
     *
     * @param array $aFilter фильтр
     * @return int
     */
    public function GetUsersComplaintsCountByFilter($aFilter = array())
    {
        return $this->oMapper->GetUsersComplaintsCountByFilter($aFilter);
    }


    /**
     * Получить количество новых жалоб на пользователей
     *
     * @return int
     */
    public function GetUsersComplaintsCountNew()
    {
        return $this->GetUsersComplaintsCountByFilter(array('state' => ModuleUser::COMPLAINT_STATE_NEW));
    }


    /**
     * Удалить записи жалоб по массиву ид
     *
     * @param $aIds                массив ид
     * @return mixed
     */
    public function DeleteUsersComplaintsByArrayId($aIds)
    {
        return $this->oMapper->DeleteUsersComplaintsByArrayId($aIds);
    }


    /**
     * Удалить жалобу
     *
     * @param $oComplaint        сущность жалобы
     * @return mixed
     */
    public function DeleteUsersComplaint($oComplaint)
    {
        return $this->DeleteUsersComplaintsByArrayId($oComplaint->getId());
    }


    /**
     * Выполнить изменение данных в таблице жалоб пользователя
     *
     * @param $aComplaints        массив сущностей жалоб
     * @param $aChanges            массив изменений
     * @return mixed
     */
    public function UpdateUsersComplaints($aComplaints, $aChanges)
    {
        if (!is_array($aComplaints)) {
            $aComplaints = (array)$aComplaints;
        }
        $aIds = array();
        foreach ($aComplaints as $oComplaint) {
            $aIds[] = $oComplaint->getId();
        }
        return $this->oMapper->UpdateUsersComplaints($aIds, $aChanges);
    }


    /**
     * Установить количество жалоб на странице
     *
     * @param $iPerPage        количество
     */
    public function ChangeUsersComplaintsPerPage($iPerPage)
    {
        /*
         * установить количество жалоб на странице
         */
        $aData = array(
            'users' => array(
                'complaints' => array(
                    'per_page' => $iPerPage,
                ),
            )
        );
        $this->PluginAdmin_Settings_SaveConfigByKey('admin', $aData);
    }


}

?>