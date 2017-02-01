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
 * Работа с пользователями
 *
 */

class PluginAdmin_ActionAdmin_EventUsers extends Event
{

    /*
     * страница результатов
     */
    protected $iPage = 1;

    /*
     * результатов на страницу
     */
    protected $iPerPage = 20;


    /**
     * Список пользователей
     */
    public function EventUsersList()
    {
        $this->GetUsersListByRules(Router::GetPath('admin/users/list'));
    }


    /**
     * Список админов
     */
    public function EventAdminsList()
    {
        $this->GetUsersListByRules(Router::GetPath('admin/users/admins'), array('admins_only' => true));
    }


    /**
     * Получить список пользователей по фильтру из формы и доп. фильтру, добавить постраничность и вывести списком с сортировкой
     *
     * @param            $sFullPagePathToEvent        путь к екшену
     * @param array $aAdditionalUsersFilter дополнительный фильтр поиска по пользователям
     */
    protected function GetUsersListByRules($sFullPagePathToEvent, $aAdditionalUsersFilter = array())
    {
        $this->SetTemplateAction('users/list');
        $this->SetPaging();

        /*
         * сортировка
         */
        $sOrder = $this->GetDataFromFilter('order_field');
        $sWay = $this->GetDataFromFilter('order_way');

        /*
         * поиск по полям - отобрать корректные поля для поиска среди кучи других параметров
         */
        $aValidatedSearchRules = $this->GetSearchRule($this->GetDataFromFilter());
        /*
         * получить правила (фильтр для поиска)
         */
        $aSearchRules = $aValidatedSearchRules['filter_queries'];
        /*
         * получить правила только с оригинальными тектовыми запросами
         */
        $aSearchRulesWithOriginalQueries = $aValidatedSearchRules['filter_queries_with_original_values'];

        /*
         * получение пользователей
         */
        $aResult = $this->PluginAdmin_Users_GetUsersByFilter(
            array_merge($aSearchRules, $aAdditionalUsersFilter),
            array($sOrder => $sWay),
            $this->iPage,
            $this->iPerPage
        );

        /*
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging(
            $aResult['count'],
            $this->iPage,
            $this->iPerPage,
            Config::Get('pagination.pages.count'),
            $sFullPagePathToEvent,
            $this->GetPagingAdditionalParamsByArray(
                array_merge(
                    array(
                        'order_field' => $sOrder,
                        'order_way'   => $sWay
                    ),
                    $aSearchRulesWithOriginalQueries
                )
            )
        );

        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aUsers', $aResult['collection']);
        $this->Viewer_Assign('iUsersTotalCount', $aResult['count']);
        $this->Viewer_Assign('sFullPagePathToEvent', $sFullPagePathToEvent);

        /*
         * сортировка
         */
        $this->Viewer_Assign('sOrder', $this->PluginAdmin_Users_GetDefaultSortingOrderIfIncorrect(
            $sOrder,
            Config::Get('plugin.admin.users.correct_sorting_order'),
            Config::Get('plugin.admin.users.default_sorting_order')
        ));
        $this->Viewer_Assign('sWay', $this->PluginAdmin_Users_GetDefaultOrderDirectionIfIncorrect($sWay));
        $this->Viewer_Assign('sReverseOrder', $this->PluginAdmin_Users_GetReversedOrderDirection($sWay));

        /*
         * поиск
         */
        $this->Viewer_Assign('aSearchRulesWithOriginalQueries', $aSearchRulesWithOriginalQueries);

        /*
         * добавить нужные текстовки
         */
        $this->Lang_AddLangJs(array(
            'plugin.admin.users.restricted_values',
            'plugin.admin.users.search',
        ));
    }


    /**
     * Изменить количество пользователей на странице
     */
    public function EventAjaxUsersOnPage()
    {
        $this->Viewer_SetResponseAjax('json');
        $this->PluginAdmin_Users_ChangeUsersPerPage((int)getRequestStr('onpage'));
    }


    /**
     * Показать страницу информации о пользователе
     *
     * @return string
     */
    public function EventUserProfile()
    {
        $this->SetTemplateAction('users/profile');
        /*
         * проверяем корректность id пользователя
         */
        if (!$oUser = $this->User_GetUserById((int)$this->GetParam(1))) {
            return $this->EventNotFound();
        }
        /*
         * получить гео-запись данных пользователя, которые он указал в профиле
         */
        $oGeoTarget = $this->Geo_GetTargetByTarget('user', $oUser->getId());

        /*
         * создал топиков и комментариев
         */
        $iCountTopicUser = $this->Topic_GetCountTopicsPersonalByUser($oUser->getId(), 1);
        $iCountCommentUser = $this->Comment_GetCountCommentsByUserId($oUser->getId(), 'topic');

        /*
         * топиков и комментариев в избранном
         */
        $iCountTopicFavourite = $this->Topic_GetCountTopicsFavouriteByUserId($oUser->getId());
        $iCountCommentFavourite = $this->Comment_GetCountCommentsFavouriteByUserId($oUser->getId());

        /*
         * todo: почистить, если не нужно будет
         */
        /*
         * создал заметок
         */
        //$iCountNoteUser = $this->User_GetCountUserNotesByUserId($oUser->getId());

        /*
         * записей на стене
         */
        //$iWallItemsCount = $this->Wall_GetCountWall (array ('wall_user_id' => $oUser->getId (), 'pid' => null));
        /*
         * получаем количество созданных блогов
         */
        $iCountBlogsUser = count($this->Blog_GetBlogsByOwnerId($oUser->getId(), true));

        /*
         * количество читаемых блогов
         */
        $iCountBlogReads = count($this->Blog_GetBlogUsersByUserId($oUser->getId(), ModuleBlog::BLOG_USER_ROLE_USER,
            true));

        /*
         * количество друзей у пользователя
         */
        $iCountFriendsUser = $this->User_GetCountUsersFriend($oUser->getId());

        /*
         * переменные в шаблон
         */
        $this->Viewer_Assign('iCountTopicUser', $iCountTopicUser);
        $this->Viewer_Assign('iCountCommentUser', $iCountCommentUser);
        $this->Viewer_Assign('iCountBlogsUser', $iCountBlogsUser);

        $this->Viewer_Assign('iCountTopicFavourite', $iCountTopicFavourite);
        $this->Viewer_Assign('iCountCommentFavourite', $iCountCommentFavourite);

        $this->Viewer_Assign('iCountBlogReads', $iCountBlogReads);

        $this->Viewer_Assign('iCountFriendsUser', $iCountFriendsUser);

        //$this->Viewer_Assign('iCountNoteUser', $iCountNoteUser);
        //$this->Viewer_Assign('iCountWallUser', $iWallItemsCount);
        /*
         * общее число публикаций и избранного
         */
        /*
        $this->Viewer_Assign('iCountCreated',
            (($this->oUserCurrent and $this->oUserCurrent->getId() == $oUser->getId()) ? $iCountNoteUser : 0) + $iCountTopicUser + $iCountCommentUser
        );
        $this->Viewer_Assign('iCountFavourite', $iCountCommentFavourite + $iCountTopicFavourite);
        /*
         * заметка текущего пользователя о юзере
         */
        /*
        if ($this->oUserCurrent) {
            $this->Viewer_Assign('oUserNote', $oUser->getUserNote());
        }
        */

        /*
         * подсчитать за что, как и сколько раз голосовал пользователь
         */
        $aVotedStats = $this->PluginAdmin_Users_GetUserVotingStats($oUser);

        /*
         * загрузить начальный список гео данных
         */
        $aCountries = $this->Geo_GetCountries(array(), array('sort' => 'asc'), 1, 300);
        if ($oGeoTarget) {
            if ($oGeoTarget->getCountryId()) {
                $aRegions = $this->Geo_GetRegions(array('country_id' => $oGeoTarget->getCountryId()),
                    array('sort' => 'asc'), 1, 500);
                $this->Viewer_Assign('aGeoRegions', $aRegions['collection']);
            }
            if ($oGeoTarget->getRegionId()) {
                $aCities = $this->Geo_GetCities(array('region_id' => $oGeoTarget->getRegionId()),
                    array('sort' => 'asc'), 1, 500);
                $this->Viewer_Assign('aGeoCities', $aCities['collection']);
            }
        }
        $this->Viewer_Assign('aGeoCountries', $aCountries['collection']);
        $this->Viewer_Assign('oGeoTarget', $oGeoTarget);

        $this->Viewer_Assign('aUserVotedStat', $aVotedStats);
        $this->Viewer_Assign('oUser', $oUser);

        /*
         * если была отправлена форма редактирования
         */
        if (isPost('submit_edit')) {
            $this->SubmitEditProfile($oUser);
        }
    }


    /**
     * Выполнить редактирование профиля пользователя
     *
     * @param $oUser        объект пользователя
     */
    protected function SubmitEditProfile($oUser)
    {
        $this->Security_ValidateSendForm();
        /*
         * массив полей с новыми значениями
         */
        $aDataToChange = array();
        /*
         * проверить логин
         */
        if (($sErrorMsg = $this->PluginAdmin_Users_ValidateUserLoginChange(getRequestStr('login'), $oUser)) === true) {
            $aDataToChange['user_login'] = getRequestStr('login');
        } else {
            $this->Message_AddError($sErrorMsg, '', true);
            $this->RedirectToReferer();
        }
        /*
         * проверить имя
         */
        if ($this->Validate_Validate('string', getRequestStr('profile_name'),
            array('allowEmpty' => false, 'min' => 2, 'max' => Config::Get('module.user.name_max')))
        ) {
            $aDataToChange['user_profile_name'] = getRequestStr('profile_name');
        }
        /*
         * проверить почту
         */
        if (($sErrorMsg = $this->PluginAdmin_Users_ValidateUserMailChange(getRequestStr('mail'), $oUser)) === true) {
            $aDataToChange['user_mail'] = getRequestStr('mail');
        } else {
            $this->Message_AddError($sErrorMsg, '', true);
            $this->RedirectToReferer();
        }
        /*
         * проверить пол
         */
        if (in_array(getRequestStr('profile_sex'), array('man', 'woman', 'other'))) {
            $aDataToChange['user_profile_sex'] = getRequestStr('profile_sex');
        }
        /**
         * проверить рейтинг
         */
        if (preg_match('#^(\d{1,9})(\.\d{1,3})?$#', getRequestStr('profile_rating'), $aMatch)) {
            $aDataToChange['user_rating'] = getRequestStr('profile_rating');
        }
        /*
         * проверить др
         */
        $aDataToChange['user_profile_birthday'] = null;
        if ($this->Validate_Validate('date', getRequestStr('profile_birthday'),
            array('format' => 'dd.MM.yyyy', 'allowEmpty' => false))
        ) {
            $iBirthdayTime = strtotime(getRequestStr('profile_birthday'));
            if ($iBirthdayTime < time() and $iBirthdayTime > strtotime('-100 year')) {
                $aDataToChange['user_profile_birthday'] = date("Y-m-d H:i:s", $iBirthdayTime);
            }
        }
        /*
         * получить гео-данные
         */
        $aGeo = getRequest('geo');

        if (isset($aGeo['city']) && $aGeo['city']) {
            $oGeoObject = $this->Geo_GetGeoObject('city', (int) $aGeo['city']);
        } elseif (isset($aGeo['region']) && $aGeo['region']) {
            $oGeoObject = $this->Geo_GetGeoObject('region', (int) $aGeo['region']);
        } elseif (isset($aGeo['country']) && $aGeo['country']) {
            $oGeoObject = $this->Geo_GetGeoObject('country', (int) $aGeo['country']);
        } else {
            $oGeoObject = null;
        }
        /*
         * если задан смена пароля
         */
        if (getRequestStr('password')) {
            if (($sErrorMsg = $this->PluginAdmin_Users_ValidateUserPasswordChange(getRequestStr('password'))) === true) {
                $aDataToChange['user_password'] = $this->User_MakeHashPassword(getRequestStr('password'));
            } else {
                $this->Message_AddError($sErrorMsg, '', true);
                $this->RedirectToReferer();
            }
        }
        /*
         * поле "о себе"
         */
        if ($this->Validate_Validate('string', getRequestStr('profile_about'),
            array('allowEmpty' => false, 'min' => 1, 'max' => 3000))
        ) {
            $aDataToChange['user_profile_about'] = $this->Text_JevixParser(getRequestStr('profile_about'));
        }
        /*
         * последнего изменения профиля
         */
        $aDataToChange['user_profile_date'] = date("Y-m-d H:i:s");

        /*
         * записать гео-данные
         * tip: делаем это первым, чтобы вносить изменения в пользователя только один раз и избежать двойного обновления как в стандартном варианте настроек лс
         */
        if ($oGeoObject) {
            $this->Geo_CreateTarget($oGeoObject, 'user', $oUser->getId());
            $aDataToChange['user_profile_country'] = '';
            if ($oCountry = $oGeoObject->getCountry()) {
                $aDataToChange['user_profile_country'] = $oCountry->getName();
            }
            $aDataToChange['user_profile_region'] = '';
            if ($oRegion = $oGeoObject->getRegion()) {
                $aDataToChange['user_profile_region'] = $oRegion->getName();
            }
            $aDataToChange['user_profile_city'] = '';
            if ($oCity = $oGeoObject->getCity()) {
                $aDataToChange['user_profile_city'] = $oCity->getName();
            }
        } else {
            $this->Geo_DeleteTargetsByTarget('user', $oUser->getId());
            $aDataToChange['user_profile_country'] = '';
            $aDataToChange['user_profile_region'] = '';
            $aDataToChange['user_profile_city'] = '';
        }
        $this->PluginAdmin_Users_ModifyUserData($oUser, $aDataToChange);
        $this->Message_AddNotice($this->Lang('notices.user_profile_edit.updated'), '', true);
        $this->RedirectToReferer();
    }


    /**
     * Задать страницу и количество элементов в пагинации
     *
     * @param int $iParamNum номер параметра, в котором нужно искать номер страницы
     * @param string $sConfigKeyPerPage ключ конфига, в котором хранится количество элементов на страницу
     */
    protected function SetPaging($iParamNum = 1, $sConfigKeyPerPage = 'users.per_page')
    {
        if (!$this->iPage = intval(preg_replace('#^page(\d+)$#iu', '$1', $this->GetParam($iParamNum)))) {
            $this->iPage = 1;
        }
        $this->iPerPage = Config::Get('plugin.admin.' . $sConfigKeyPerPage) ?: 10;
    }


    /**
     * Получить правила для поиска по полям
     *
     * @param string|array $aFilter имена полей и запросы, по которым будет происходить поиск
     * @return array                            правило для фильтра
     */
    protected function GetSearchRule($aFilter)
    {
        $aUserSearchFieldsRules = Config::Get('plugin.admin.users.search_allowed_types');
        /*
         * здесь будут пары "поле=>запрос" для запроса через фильтр
         */
        $aQueries = array();
        /*
         * здесь будут хранится проверенные поля по которым можно искать, но с оригинальными данными значений для поиска
         */
        $aCorrectFieldsWithOriginalValues = array();
        /*
         * набор правил для поиска представляет собой массив поле_поиска => запрос (в данном массиве хранится все вместе)
         */
        foreach ((array)$aFilter as $sField => $sQuery) {
            /*
             * если имя поля для поиска разрешено (получить корректное поле среди остальных данных)
             */
            if (in_array($sField, array_keys($aUserSearchFieldsRules))) {
                /*
                 * до начала обработки поискового запроса сохранить оригинал для каждого корректного поля из данных фильтра
                 */
                $aCorrectFieldsWithOriginalValues[$sField] = $sQuery;
                /*
                 * экранировать спецсимволы
                 */
                $sQuery = str_replace(array('_', '%'), array('\_', '\%'), $sQuery);
                /*
                 * если разрешено искать по данному параметру как по части строки
                 */
                if ($aUserSearchFieldsRules[$sField]['search_as_part_of_string']) {
                    /*
                     * искать в любой части строки
                     */
                    $sQuery = '%' . $sQuery . '%';
                }
                /*
                 * добавить новую поисковую пару "поле=>запрос" для фильтра
                 */
                $aQueries[$sField] = $sQuery;
            }
        }
        return array(
            'filter_queries'                      => $aQueries,
            'filter_queries_with_original_values' => $aCorrectFieldsWithOriginalValues
        );
    }


    /**
     * Получить списки голосований пользователя
     *
     * @return string
     */
    public function EventUserVotesList()
    {
        $this->SetTemplateAction('users/votes');
        $this->SetPaging(2, 'votes.per_page');

        /*
         * сортировка
         */
        $sOrder = $this->GetDataFromFilter('order_field');
        $sWay = $this->GetDataFromFilter('order_way');

        /*
         * проверяем корректность id пользователя
         */
        if (!$oUser = $this->User_GetUserById((int)$this->GetParam(1))) {
            return $this->EventNotFound();
        }
        /*
         * проверяем корректность типа обьекта, голоса по которому нужно показать
         */
        if (!$sVotingTargetType = $this->GetDataFromFilter('type') or !in_array($sVotingTargetType,
                array('topic', 'comment', 'blog', 'user'))
        ) {
            return $this->EventNotFound();
        }
        /*
         * проверяем направление голосования
         */
        if ($sVotingDirection = $this->GetDataFromFilter('dir') and !in_array($sVotingDirection,
                array('plus', 'minus', 'abstain'))
        ) {
            return $this->EventNotFound();
        }
        /*
         * строим фильтр
         */
        $aFilter = array(
            'type'      => $sVotingTargetType,
            'direction' => $sVotingDirection,
        );

        /*
         * получаем данные голосований
         */
        $aResult = $this->PluginAdmin_Users_GetUserVotingByFilter(
            $oUser,
            $aFilter,
            array($sOrder => $sWay),
            $this->iPage,
            $this->iPerPage
        );

        /*
         * дополнить данные голосований названиями обьектов и ссылками на них
         */
        $this->PluginAdmin_Users_GetTargetObjectsFromVotingList($aResult['collection']);

        /*
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging(
            $aResult['count'],
            $this->iPage,
            $this->iPerPage,
            Config::Get('pagination.pages.count'),
            Router::GetPath('admin') . Router::GetActionEvent() . '/votes/' . $oUser->getId(),
            $this->GetPagingAdditionalParamsByArray(array(
                'type'        => $sVotingTargetType,
                'dir'         => $sVotingDirection,
                'order_field' => $sOrder,
                'order_way'   => $sWay
            ))
        );

        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aVotingList', $aResult ['collection']);
        $this->Viewer_Assign('oUser', $oUser);
        $this->Viewer_Assign('sVotingTargetType', $sVotingTargetType);
        $this->Viewer_Assign('sVotingDirection', $sVotingDirection);

        /*
         * сортировка
         */
        $this->Viewer_Assign('sOrder', $this->PluginAdmin_Users_GetDefaultSortingOrderIfIncorrect(
            $sOrder,
            Config::Get('plugin.admin.votes.correct_sorting_order'),
            Config::Get('plugin.admin.votes.default_sorting_order')
        ));
        $this->Viewer_Assign('sWay', $this->PluginAdmin_Users_GetDefaultOrderDirectionIfIncorrect($sWay));
        $this->Viewer_Assign('sReverseOrder', $this->PluginAdmin_Users_GetReversedOrderDirection($sWay));
    }


    /**
     * Изменить количество голосов на странице
     */
    public function EventAjaxVotesOnPage()
    {
        $this->Viewer_SetResponseAjax('json');
        $this->PluginAdmin_Users_ChangeVotesPerPage((int)getRequestStr('onpage'));
    }


    /**
     * Построить дополнительные параметры для пагинации
     *
     * @param array $aParams набор параметров ключ=>значение
     * @return array|null            массив параметров, которые имеют значение
     */
    protected function GetPagingAdditionalParamsByArray($aParams = array())
    {
        $aFilter = array();
        foreach ($aParams as $sKey => $mData) {
            if ($mData) {
                $aFilter[$sKey] = $mData;
            }
        }
        return ($aFilter ? array('filter' => $aFilter) : null);
    }


    /*
     *
     * --- Работа с банами ---
     *
     */

    /**
     * Список банов
     */
    public function EventBansList()
    {
        $this->SetTemplateAction('users/bans');
        $this->SetPaging(2, 'bans.per_page');

        $aSearchFilter = array();

        /*
         * получить тип ограничения банов
         */
        $sBanRestrictionType = $this->GetDataFromFilter('ban_restriction_type');
        switch ($sBanRestrictionType) {
            case 'full':
                /*
                 * показывать полные баны
                 */
                $aSearchFilter['restriction_type'] = PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_FULL;
                break;
            case 'readonly':
                /*
                 * показать read only баны
                 */
                $aSearchFilter['restriction_type'] = PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_READ_ONLY;
                break;
            default:
                /*
                 * показывать баны всех типов ограничений
                 */
                $sBanRestrictionType = null;
        }

        /*
         * получить временной тип банов
         */
        $sBanTimeType = $this->GetDataFromFilter('ban_time_type');
        switch ($sBanTimeType) {
            case 'permanent':
                /*
                 * показывать только постоянные баны
                 */
                $aSearchFilter['time_type'] = PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT;
                break;
            case 'period':
                /*
                 * показать временные баны
                 */
                $aSearchFilter['time_type'] = PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD;
                break;
            default:
                /*
                 * показывать все баны
                 */
                $sBanTimeType = null;
        }

        /*
         * полный путь к данному действию (для пагинации и сортировки)
         */
        $sFullPagePathToEvent = Router::GetPath('admin/users/bans');

        /*
         * сортировка
         */
        $sOrder = $this->GetDataFromFilter('order_field');
        $sWay = $this->GetDataFromFilter('order_way');

        /*
         * получение списка банов
         */
        $aResult = $this->PluginAdmin_Users_GetBansByFilter(
            $aSearchFilter,
            array($sOrder => $sWay),
            $this->iPage,
            $this->iPerPage
        );

        /*
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging(
            $aResult['count'],
            $this->iPage,
            $this->iPerPage,
            Config::Get('pagination.pages.count'),
            $sFullPagePathToEvent,
            $this->GetPagingAdditionalParamsByArray(
                array_merge(
                    array(
                        'order_field' => $sOrder,
                        'order_way'   => $sWay
                    ),
                    $aSearchFilter
                )
            )
        );

        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aBans', $aResult['collection']);
        $this->Viewer_Assign('iBansTotalCount', $aResult['count']);
        $this->Viewer_Assign('sFullPagePathToEvent', $sFullPagePathToEvent);
        $this->Viewer_Assign('sBanTimeType', $sBanTimeType);
        $this->Viewer_Assign('sBanRestrictionType', $sBanRestrictionType);

        /*
         * сортировка
         */
        $this->Viewer_Assign('sOrder', $this->PluginAdmin_Users_GetDefaultSortingOrderIfIncorrect(
            $sOrder,
            Config::Get('plugin.admin.bans.correct_sorting_order'),
            Config::Get('plugin.admin.bans.default_sorting_order')
        ));
        $this->Viewer_Assign('sWay', $this->PluginAdmin_Users_GetDefaultOrderDirectionIfIncorrect($sWay));
        $this->Viewer_Assign('sReverseOrder', $this->PluginAdmin_Users_GetReversedOrderDirection($sWay));

        /*
         * статистика
         */
        $this->Viewer_Assign('aBansStats', $this->PluginAdmin_Users_GetBanStats());
    }


    /**
     * Добавить новую запись о бане пользователя
     *
     * @return bool
     */
    public function EventAddBan()
    {
        $this->SetTemplateAction('users/bans.add');
        /*
         * если была нажата кнопка
         */
        if (isPost('submit_add_ban')) {
            $this->SubmitBan();
        }
        /*
         * если передан параметр id для бана пользователя для передачи значения в поле формы
         */
        if ($iUserId = (int)getRequestStr('user_id')) {
            $_REQUEST['user_sign'] = $iUserId;
        }
    }


    /**
     * Добавить новую запись о бане
     *
     * @return bool
     * @throws Exception
     */
    protected function SubmitBan()
    {
        $this->Security_ValidateSendForm();

        /*
         * проверка id бана (если было редактирование)
         */
        if ($iBanId = (int)getRequestStr('ban_id') and !$oBan = $this->PluginAdmin_Users_GetBanById($iBanId)) {
            $this->Message_AddError($this->Lang('errors.bans.wrong_ban_id'));
            return false;
        }
        /*
         * получить идентификацию пользователя (правило поиска)
         */
        $sUserSign = getRequestStr('user_sign');
        /*
         * получить и проверить тип ограничения бана
         */
        $iRestrictionType = getRequestStr('restriction_type');
        if (!in_array($iRestrictionType, array(
            PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_FULL,
            PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_READ_ONLY
        ))
        ) {
            $iRestrictionType = PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_FULL;
        }
        /*
         * тип временной блокировки бана (unlimited, period, days)
         */
        $sBanType = getRequest('bantype');
        if (is_array($sBanType)) {
            $sBanType = array_shift($sBanType);
        }
        /*
         * получить временные интервалы для типа бана "period"
         */
        $sPeriodFrom = getRequestStr('date_start');
        $sPeriodTo = getRequestStr('date_finish');
        /*
         * получить количество дней бана для типа бана "days"
         */
        $iDaysCount = (int)getRequestStr('days_count');
        /*
         * получить причину бана (отображается для пользователя)
         */
        $sBlockingReasonForUser = getRequestStr('reason_for_user');
        /*
         * комментарий бана для админа
         */
        $sBlockingComment = getRequestStr('comment');

        /*
         * проверить правило бана
         */
        if (!$aRuleData = $this->GetBanRuleTypeByRawBanRule($sUserSign)) {
            $this->Message_AddError($this->Lang('errors.bans.unknown_rule_sign'));
            return false;
        }
        /*
         * проверить тип бана
         */
        switch ($sBanType) {
            /*
             * постоянный
             */
            case 'unlimited':
                break;
            /*
             * интервал дат
             */
            case 'period':
                /*
                 * параметры для валидатора дат: формат даты мускула date и datetime
                 */
                $aDateValidatorParams = array(
                    'format'     => array('yyyy-MM-dd hh:mm:ss', 'yyyy-MM-dd'),
                    'allowEmpty' => false
                );
                /*
                 * проверить корректность даты начала
                 */
                if (!$sPeriodFrom or !$this->Validate_Validate('date', $sPeriodFrom, $aDateValidatorParams)) {
                    $this->Message_AddError($this->Lang('errors.bans.incorrect_period_from'));
                    return false;
                }
                /*
                 * проверить чтобы дата начала была не меньше текущей даты
                 * tip: только при создании бана чтобы не возникало неудобств при редактировании старых банов
                 */
                if (!isset($oBan) and strtotime($sPeriodFrom) < strtotime(date("Y-m-d"))) {
                    $this->Message_AddError($this->Lang('errors.bans.period_from_must_be_gte_current_day'));
                    return false;
                }
                /*
                 * проверить корректность даты финиша
                 */
                if (!$sPeriodTo or !$this->Validate_Validate('date', $sPeriodTo, $aDateValidatorParams)) {
                    $this->Message_AddError($this->Lang('errors.bans.incorrect_period_to'));
                    return false;
                }
                /*
                 * проверить чтобы дата финиша была больше даты старта
                 */
                if (strtotime($sPeriodTo) <= strtotime($sPeriodFrom)) {
                    $this->Message_AddError($this->Lang('errors.bans.period_to_must_be_greater_than_from'));
                    return false;
                }
                break;
            /*
             * количество дней, начиная с текущего
             */
            case 'days':
                /*
                 * проверить количество дней
                 */
                if (!$iDaysCount) {
                    $this->Message_AddError($this->Lang('errors.bans.incorrect_days_count'));
                    return false;
                }
                break;
            /*
             * неизвестный временной интервал
             */
            default:
                $this->Message_AddError($this->Lang('errors.bans.unknown_ban_timing_rule', array('type' => $sBanType)));
                return false;
        }
        /*
         * парсинг комментариев
         */
        $sBlockingReasonForUser = $this->Text_JevixParser($sBlockingReasonForUser);
        $sBlockingComment = $this->Text_JevixParser($sBlockingComment);

        /*
         * заполнение сущности
         */
        $oEnt = Engine::GetEntity('PluginAdmin_Users_Ban');
        $oEnt->setId($iBanId);
        $oEnt->setRestrictionType($iRestrictionType);
        /*
         * тип блокировки
         */
        switch ($aRuleData['type']) {
            case 'user':
                /*
                 * можно ли банить этого пользователя
                 */
                if (in_array($aRuleData['user']->getId(), Config::Get('plugin.admin.bans.block_ban_user_ids'))) {
                    $this->Message_AddError($this->Lang('errors.bans.this_user_id_blocked_for_bans'));
                    return false;
                }
                /*
                 * если установлено дополнительное правило бана по айпи
                 */
                if ($aSecondaryRule = $this->GetBanRuleTypeByRawBanRule(getRequestStr('secondary_rule')) and $aSecondaryRule['type'] == 'ip') {
                    $oEnt->setBlockType(PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID_AND_IP);
                    $oEnt->setIp(convert_ip2long($aSecondaryRule['ip']));                                            // todo: review for ipv6
                } else {
                    $oEnt->setBlockType(PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID);
                }
                $oEnt->setUserId($aRuleData['user']->getId());
                break;
            case 'ip':
                $oEnt->setBlockType(PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP);
                $oEnt->setIp(convert_ip2long($aRuleData['ip']));                                            // todo: review for ipv6
                break;
            case 'ip_range':
                $oEnt->setBlockType(PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP_RANGE);
                $aIps = preg_split('#\s*+-\s*+#iu', $aRuleData['ip_range']);
                $oEnt->setIpStart(convert_ip2long(array_shift($aIps)));                                        // todo: review for ipv6
                $oEnt->setIpFinish(convert_ip2long(array_shift($aIps)));
                break;
            default:
                throw new Exception('Admin: error: unknown block rule "' . $oEnt->getBlockType() . '" in ' . __METHOD__);
        }
        /*
         * тип временного интервала блокировки
         */
        switch ($sBanType) {
            case 'unlimited':
                $oEnt->setTimeType(PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT);
                $oEnt->setDateStart('2000-01-01');
                $oEnt->setDateFinish('2030-01-01');
                break;
            case 'period':
                $oEnt->setTimeType(PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD);
                $oEnt->setDateStart($sPeriodFrom);
                $oEnt->setDateFinish($sPeriodTo);
                break;
            case 'days':
                $oEnt->setTimeType(PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD);
                $oEnt->setDateStart(date('Y-m-d'));
                $oEnt->setDateFinish(date('Y-m-d',
                    mktime(date("H"), date("i"), date("s"), date("n"), date("j") + $iDaysCount, date("Y"))));
                break;
            default:
                throw new Exception('Admin: error: unknown blocking time type "' . $sBanType . '" in ' . __METHOD__);
        }
        /*
         * дата создания и редактирования
         */
        if (isset($oBan)) {
            $oEnt->setAddDate($oBan->getAddDate());
            $oEnt->setEditDate(date('Y-m-d H:i:s'));
        } else {
            $oEnt->setAddDate(date('Y-m-d H:i:s'));
        }
        /*
         * причина бана и комментарий
         */
        $oEnt->setReasonForUser($sBlockingReasonForUser);
        $oEnt->setComment($sBlockingComment);
        /*
         * проверить чтобы пользователь не забанил случайно сам себя
         */
        if ($this->PluginAdmin_Users_IsCurrentUserMatchAnyRuleOfBan($oEnt)) {
            $this->Message_AddError($this->Lang('errors.bans.you_are_tried_to_ban_yourself'));
            return false;
        }

        /*
         * валидация внесенных данных
         */
        if (!$oEnt->_Validate()) {
            $this->Message_AddError($oEnt->_getValidateError());
            return false;
        }
        $this->PluginAdmin_Users_AddBanRecord($oEnt);

        $this->Message_AddNotice($this->Lang('notices.bans.updated'), '', true);
        Router::LocationAction('admin/users/bans');
    }


    /**
     * Проверка правила бана (пользователь, ip или диапазон ip-адресов)
     *
     * @param $sSign            правило бана (строка)
     * @return array|bool        тип бана
     */
    protected function GetBanRuleTypeByRawBanRule($sSign)
    {
        $aMatches = array();
        if (preg_match('#^\d++$#iu', $sSign, $aMatches)) {
            /*
             * это id пользователя
             */
            if ($oUser = $this->User_GetUserById($sSign)) {
                return array(
                    'user' => $oUser,
                    'type' => 'user',
                );
            }

        } elseif (preg_match('#^[\w-]++$#iu', $sSign, $aMatches)) {
            /*
             * это логин пользователя
             */
            if ($oUser = $this->User_GetUserByLogin($sSign)) {
                return array(
                    'user' => $oUser,
                    'type' => 'user',
                );
            }

        } elseif (preg_match('#^[\w\.-]++@[\w-]++\.\w++$#iu', $sSign, $aMatches)) {
            /*
             * это почта пользователя
             */
            if ($oUser = $this->User_GetUserByMail($sSign)) {
                return array(
                    'user' => $oUser,
                    'type' => 'user',
                );
            }

        } elseif (preg_match('#^\d++\.\d++\.\d++\.\d++$#iu', $sSign, $aMatches)) {                // todo: ipv6
            /*
             * это ip адрес
             */
            return array(
                'ip'   => $sSign,
                'type' => 'ip',
            );

        } elseif (preg_match('#^\d++\.\d++\.\d++\.\d++\s*+-\s*+\d++\.\d++\.\d++\.\d++$#iu', $sSign, $aMatches)) {
            /*
             * это диапазон ip-адресов
             */
            return array(
                'ip_range' => $sSign,
                'type'     => 'ip_range',
            );

        }
        /*
         * правило не распознано
         */
        return false;
    }


    /**
     * Изменить количество банов на странице
     */
    public function EventAjaxBansOnPage()
    {
        $this->Viewer_SetResponseAjax('json');
        $this->PluginAdmin_Users_ChangeBansPerPage((int)getRequestStr('onpage'));
    }


    /**
     * Редактирование бана
     *
     * @return string
     * @throws Exception
     */
    public function EventEditBan()
    {
        $this->SetTemplateAction('users/bans.add');

        if (!$oBan = $this->PluginAdmin_Users_GetBanById((int)$this->GetParam(2))) {
            $this->Message_AddError($this->Lang('errors.bans.wrong_ban_id'));
            return false;
        }
        /*
         * Получить запись правила
         */
        switch ($oBan->getBlockType()) {
            case PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID:
                $_REQUEST['user_sign'] = $this->User_GetUserById($oBan->getUserId())->getLogin();
                break;
            case PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP:
                $_REQUEST['user_sign'] = convert_long2ip($oBan->getIp());                                                        // todo: ipv6
                break;
            case PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP_RANGE:
                $_REQUEST['user_sign'] = convert_long2ip($oBan->getIpStart()) . ' - ' . convert_long2ip($oBan->getIpFinish());    // todo: ipv6
                break;
            case PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID_AND_IP:
                $_REQUEST['user_sign'] = $this->User_GetUserById($oBan->getUserId())->getLogin();
                $_REQUEST['secondary_rule'] = convert_long2ip($oBan->getIp());                                                    // todo: ipv6
                break;
            default:
                throw new Exception('Admin: error: wrong block type "' . $oBan->getBlockType() . '" in ' . __METHOD__);
        }
        /*
         * Получить временной интервал (количество дней будет превращено в интервал)
         */
        if ($oBan->getTimeType() == PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT) {
            $_REQUEST['bantype'] = 'unlimited';
        } elseif ($oBan->getTimeType() == PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD) {
            $_REQUEST['bantype'] = 'period';
        }
        /*
         * Остальные данные уже в удобном формате
         */
        $_REQUEST = array_merge($_REQUEST, $oBan->_getDataArray());
    }


    /**
     * Удалить запись бана
     *
     * @return bool
     */
    public function EventDeleteBan()
    {
        $this->Security_ValidateSendForm();
        if (!$oBan = $this->PluginAdmin_Users_GetBanById((int)$this->GetParam(2))) {
            $this->Message_AddError($this->Lang('errors.bans.wrong_ban_id'));
            return false;
        }
        /*
         * Удалить статистику бана
         */
        if (Config::Get('plugin.admin.bans.gather_bans_running_stats')) {
            $this->PluginAdmin_Users_DeleteBanStats($oBan);
        }
        $this->PluginAdmin_Users_DeleteBanById($oBan->getId());
        $this->Message_AddNotice($this->Lang('notices.bans.deleted'), '', true);
        Router::LocationAction('admin/users/bans');
    }


    /**
     * Показать страницу информации о бане
     *
     * @return bool
     */
    public function EventViewBanInfo()
    {
        $this->SetTemplateAction('users/bans.view');
        /*
         * есть ли такой бан
         */
        if (!$oBan = $this->PluginAdmin_Users_GetBanById((int)$this->GetParam(2))) {
            $this->Message_AddError($this->Lang('errors.bans.wrong_ban_id'));
            return false;
        }
        $this->Viewer_Assign('oBan', $oBan);
    }


    /**
     * Проверить правило бана на корректность
     */
    public function EventAjaxBansCheckUserSign()
    {
        $this->Viewer_SetResponseAjax('json');
        $sResponse = '';
        /*
         * получить правило идентификации пользователя
         */
        if ($sUserSign = getRequestStr('value')) {
            /*
             * распознать правило
             */
            if (!$aData = $this->GetBanRuleTypeByRawBanRule($sUserSign)) {
                return $this->Message_AddError($this->Lang('bans.user_sign_check.wrong_rule'));
            }
            /*
             * вернуть информацию о правиле на основе его типа
             */
            switch ($aData['type']) {
                case 'user':
                    $oUser = $aData['user'];
                    $oSession = $oUser->getSession();

                    $sResponse = $this->Lang('bans.user_sign_check.user', array(
                        'login'      => $oUser->getLogin(),
                        'id'         => $oUser->getId(),
                        'mail'       => $oUser->getMail(),
                        'reg_ip'     => $oUser->getIpRegister(),
                        'session_ip' => $oSession ? $oSession->getIpLast() : null,
                    ));
                    /*
                     * для использования дополнительного правила
                     */
                    $this->Viewer_AssignAjax('bAllowSecondaryRule', true);
                    $this->Viewer_AssignAjax('sSecondaryRuleFieldData',
                        $oSession ? $oSession->getIpLast() : $oUser->getIpRegister());
                    break;
                default:
                    $sResponse = $this->Lang('bans.user_sign_check.' . $aData['type']);
                    break;
            }
        }
        $this->Viewer_AssignAjax('sResponse', $sResponse);
    }


    /**
     * Управление администраторами
     *
     * @return bool
     */
    public function EventManageAdmins()
    {
        $this->Security_ValidateSendForm();
        /*
         * тип операции - добавление или удаление
         */
        if (!$sType = $this->GetParam(1) or !in_array($sType, array('add', 'delete'))) {
            $this->Message_AddError($this->Lang('errors.bans.incorrect_admins_action_type'));    // todo: lang error array group - export from "bans"
            return false;
        }
        /*
         * проверка id пользователя (нельзя удалять права админа у пользователей из спец. списка из конфига)
         */
        if (!$iUserId = (int)$this->GetParam(2) or in_array($iUserId,
                Config::Get('plugin.admin.users.block_managing_admin_rights_user_ids')) or !$oUser = $this->User_GetUserById($iUserId)
        ) {
            $this->Message_AddError($this->Lang('errors.bans.incorrect_user_id'));                // todo: lang error array group - export from "bans"
            return false;
        }
        if ($sType == 'add') {
            $this->PluginAdmin_Users_AddAdmin($oUser);
        } else {
            $this->PluginAdmin_Users_DeleteAdmin($oUser);
        }
        $this->Message_AddNotice($this->Lang('notices.admins.' . $sType), '', true);
        $this->RedirectToReferer();
    }


    /**
     * Удалить созданный пользователем контент и самого пользователя
     *
     * @return bool
     */
    public function EventDeleteUserContent()
    {
        $this->SetTemplateAction('users/delete_user');
        /*
         * проверка id пользователя (нельзя удалять контент у пользователей из спец. списка из конфига)
         */
        if (!$iUserId = (int)getRequestStr('user_id') or in_array($iUserId,
                Config::Get('plugin.admin.users.block_deleting_user_ids')) or !$oUser = $this->User_GetUserById($iUserId)
        ) {
            $this->Message_AddError($this->Lang('errors.bans.incorrect_user_id'));                // todo: lang error array group - export from "bans"
            return $this->EventError();
        }

        /*
         * если была нажата кнопка подтверждения - начать процесс удаления
         */
        if (isPost('submit_delete_user_contents')) {
            if ($this->SubmitDeleteUser($oUser)) {
                $this->Message_AddNotice($this->Lang('notices.users.content_deleted'), '', true);
                Router::LocationAction('admin');
                return true;
            }
        }
        /*
         * для формы с настройками
         */
        $this->Viewer_Assign('oUser', $oUser);
    }


    /**
     * Хендлер сабмита формы удаления пользователя
     *
     * @param $oUser            объект пользователя
     * @return bool
     */
    protected function SubmitDeleteUser($oUser)
    {
        $this->Security_ValidateSendForm();
        /*
         * флаг удаления самого пользователя
         */
        $bAlsoDeleteUser = getRequestStr('delete_user');

        /*
         * проверка на администратора
         */
        if ($oUser->isAdministrator()) {
            $this->Message_AddError($this->Lang('errors.bans.delete_admin_rights_first'));        // todo: lang error array group - export from "bans"
            return false;
        }
        /*
         * удаление контента и пользователя
         */
        $this->PluginAdmin_Users_PerformUserContentDeletion($oUser, $bAlsoDeleteUser);
        return true;
    }


    /**
     * Статистика пользователей
     */
    public function EventShowUserStats()
    {
        /*
         * дело в том, что данный метод может вызываться и через обычную загрузку страницы так и через аякс для подгрузки нужных данных
         * это сделано для того, чтобы не дублировать (пусть и небольшую) часть кода для подгрузки данных через аякс
         */
        if (isAjaxRequest()) {
            $this->GetAjaxAnswerForUsersStats();
            return true;
        }

        $this->SetTemplateAction('users/stats');

        /*
         * получить статистику по проживанию
         */
        $aLivingStatsData = $this->GetLivingStats();
        /*
         * получить статистику стран или городов
         */
        $this->Viewer_Assign('aLivingStats', $aLivingStatsData['aLivingStats']);
        /*
         * тип текущего отображения: страны или города
         */
        $this->Viewer_Assign('sCurrentLivingSection', $aLivingStatsData['sCurrentLivingSection']);
        /*
         * тип текущей сортировки: топ или по алфавиту
         */
        $this->Viewer_Assign('sCurrentLivingSorting', $aLivingStatsData['sCurrentLivingSorting']);

        /*
         * получить график
         */
        $this->GetGraphStats();

        /*
         * получить количество хороших и не очень пользователей
         */
        $this->Viewer_Assign('aGoodAndBadUsers', $this->PluginAdmin_Users_GetCountGoodAndBadUsers());
        /*
         * получить базовую статистику
         */
        $this->Viewer_Assign('aStats', $this->User_GetStatUsers());
        /*
         * получить возрастное распределение
         */
        $this->Viewer_Assign('aBirthdaysStats', $this->PluginAdmin_Users_GetUsersBirthdaysStats());
    }


    /**
     * Получить статистику по проживанию пользователей
     */
    protected function GetLivingStats()
    {
        /*
         * если не указано показывать статистику по городам - показать по странам
         */
        if (!$sLivingSection = $this->GetDataFromFilter('living_section') or $sLivingSection != 'cities') {
            $sLivingSection = 'countries';
        }

        /*
         * тип сортировки места жительства
         */
        if (!$sSorting = $this->GetDataFromFilter('living_sorting') or $sSorting != 'alphabetic') {
            $sSorting = 'top';
        }

        return array(
            /*
             * получить статистику стран или городов
             */
            'aLivingStats'          => $this->PluginAdmin_Users_GetUsersLivingStats($sLivingSection, $sSorting),
            /*
             * тип текущего отображения: страны или города
             */
            'sCurrentLivingSection' => $sLivingSection,
            /*
             * тип текущей сортировки: топ или по алфавиту
             */
            'sCurrentLivingSorting' => $sSorting
        );
    }


    /**
     * Получить данные графика
     */
    protected function GetGraphStats()
    {
        /*
         * получить данные для графика
         */
        $this->PluginAdmin_Stats_GatherAndBuildDataForGraph(
            PluginAdmin_ModuleStats::DATA_TYPE_REGISTRATIONS,
            $this->GetDataFromFilter('graph_period'),
            $this->GetDataFromFilter('date_start'),
            $this->GetDataFromFilter('date_finish')
        );
    }


    /**
     * Получить аякс ответ для статистики стран и городов пользователей в виде готового шаблона в виде строки
     */
    protected function GetAjaxAnswerForUsersStats()
    {
        $this->Viewer_SetResponseAjax('json');
        /*
         * если нужно вывести только нужные данные без рендеринга всей формы (через аякс)
         */
        if (getRequestStr('get_short_answer')) {
            /*
             * пока поддерживается только данные проживаний
             * tip: при добавлении новых методов переделать на свитч и разнести получение данных по методам
             */
            if (getRequestStr('request_type') == 'living_stats') {
                /*
                 * получить статистику по проживанию
                 */
                $aLivingStatsData = $this->GetLivingStats();
                $oViewer = $this->Viewer_GetLocalViewer();
                /*
                 * получить статистику стран или городов
                 */
                $oViewer->Assign('data', $aLivingStatsData['aLivingStats'], true);
                /*
                 * тип текущего отображения: страны или города
                 */
                $oViewer->Assign('section', $aLivingStatsData['sCurrentLivingSection'], true);
                /*
                 * тип текущей сортировки: топ или по алфавиту
                 */
                $oViewer->Assign('sorting', $aLivingStatsData['sCurrentLivingSorting'], true);
                /*
                 * настроить смарти
                 */
                $oViewer->AddSmartyPluginsDir($this->PluginAdmin_Tools_GetSmartyPluginsPath());
                /*
                 * для расчетов нужно количество всех пользователей, берем их уже из кеша
                 */
                $aStats = $this->User_GetStatUsers();
                $oViewer->Assign('total', $aStats['count_all'], true);
                /*
                 * вернуть скомпилированный шаблон
                 */
                $this->Viewer_AssignAjax('html', $oViewer->Fetch('component@admin:p-user.chart-location'));
            }
        }
    }


    /**
     * Инлайн редактирование данных профиля пользователя
     */
    public function EventAjaxProfileEdit()
    {
        $this->Viewer_SetResponseAjax('json');
        /*
         * есть ли редактируемый пользователь
         */
        if (!$oUser = $this->User_GetUserById((int)getRequestStr('user_id'))) {
            return $this->Message_AddError($this->Lang('errors.profile_edit.wrong_user_id'));
        };
        /*
         * проверить значение
         */
        if (!$sValue = getRequestStr('value') or !$this->Validate_Validate('string', $sValue,
                array('min' => 1, 'max' => 2000, 'allowEmpty' => false))
        ) {
            return $this->Message_AddError($this->Lang('errors.profile_edit.disallowed_value') . '. ' . $this->Validate_GetErrorLast());
        }
        /*
         * изменить данные
         */
        $aResult = $this->PluginAdmin_Users_PerformUserDataModification(getRequestStr('field_type'), $oUser, $sValue);
        /*
         * проверка на ошибку
         */
        if ($aResult['error']) {
            $this->Message_AddError($aResult['error_message']);
        }
        /*
         * вернуть ответ
         */
        $this->Viewer_AssignAjax('aData', $aResult['return_value']);
        $this->Message_AddNotice($this->Lang('notices.user_profile_edit.updated'));
    }


    /**
     * Активировать пользователя
     *
     * @return mixed
     */
    public function EventActivateUser()
    {
        $this->Security_ValidateSendForm();
        /*
         * есть ли такой пользователь
         */
        if (!$oUser = $this->User_GetUserById((int)getRequestStr('user_id'))) {
            return $this->EventNotFound();
        }
        $this->PluginAdmin_Users_ChangeUserActivate($oUser, 1);
        $this->Message_AddNotice($this->Lang('notices.users.activated'), '', true);
        $this->RedirectToReferer();
    }


    /*
     *
     * --- Жалобы на пользователей ---
     *
     */

    /**
     * Жалобы на пользователей
     */
    public function EventShowUserComplaints()
    {
        $this->SetTemplateAction('users/complaints');

        $this->SetPaging(1, 'users.complaints.per_page');

        /*
         * сортировка
         */
        $sOrder = $this->GetDataFromFilter('order_field');
        $sWay = $this->GetDataFromFilter('order_way');

        /*
         * фильтр
         */
        $aFilter = array();

        /*
         * статус
         */
        /*      $sStateCurrent = $this->GetDataFromFilter('state');
                if (in_array($sStateCurrent, array(ModuleUser::COMPLAINT_STATE_NEW, ModuleUser::COMPLAINT_STATE_READ))) {
                    $aFilter['state'] = $sStateCurrent;
                }*/

        /*
         * получение жалоб на пользователей
         */
        $aResult = $this->PluginAdmin_Users_GetUsersComplaintsByFilter(
            $aFilter,
            array($sOrder => $sWay),
            $this->iPage,
            $this->iPerPage
        );

        /*
         * установить статус "прочтен" для отображаемой страницы
         */
        if ($aResult['count'] != 0) {
            $this->PluginAdmin_Users_UpdateUsersComplaints($aResult['collection'],
                array('state' => ModuleUser::COMPLAINT_STATE_READ));
        }

        /*
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging(
            $aResult['count'],
            $this->iPage,
            $this->iPerPage,
            Config::Get('pagination.pages.count'),
            Router::GetPath('admin/users/complaints'),
            $this->GetPagingAdditionalParamsByArray(
                array_merge(
                    array(
                        'order_field' => $sOrder,
                        'order_way'   => $sWay
                    ),
                    $aFilter
                )
            )
        );

        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aUsersComplaints', $aResult['collection']);
        $this->Viewer_Assign('iUsersComplaintsTotalCount', $aResult['count']);
        //$this->Viewer_Assign('sStateCurrent', $sStateCurrent);

        /*
         * сортировка
         */
        $this->Viewer_Assign('sOrder', $this->PluginAdmin_Users_GetDefaultSortingOrderIfIncorrect(
            $sOrder,
            Config::Get('plugin.admin.users.complaints.correct_sorting_order'),
            Config::Get('plugin.admin.users.complaints.default_sorting_order')
        ));
        $this->Viewer_Assign('sWay', $this->PluginAdmin_Users_GetDefaultOrderDirectionIfIncorrect($sWay));
        $this->Viewer_Assign('sReverseOrder', $this->PluginAdmin_Users_GetReversedOrderDirection($sWay));
    }


    /**
     * Аякс обработчик загрузки модального окна с жалобой на пользователя
     */
    public function EventAjaxModalUserComplaintView()
    {
        $this->Viewer_SetResponseAjax('json');

        /*
         * есть ли такая жалоба
         */
        if (!$oComplaint = $this->PluginAdmin_Users_GetUserComplaintById((int)getRequestStr('complaint_id'))) {
            $this->Message_AddError($this->Lang('errors.complaints.not_found'));
            return false;
        }
        /*
         * нужно ли отправлять ответ
         */
        if (isPost('submit_answer')) {
            return $this->SubmitComplaintAnswer($oComplaint);
        }
        /*
         * получить код модального окна
         */
        $oViewer = $this->Viewer_GetLocalViewer();
        $oViewer->Assign('report', $oComplaint, true);
        $this->Viewer_AssignAjax('sText', $oViewer->Fetch('component@admin:p-user.report-reply-modal'));
    }


    /**
     * Ответ на жалобу
     *
     * @param $oComplaint    сущность жалобы
     * @return bool
     */
    protected function SubmitComplaintAnswer($oComplaint)
    {
        $sText = $this->Text_JevixParser(getRequestStr('answer'));
        /*
         * кому нужно отправить ответ
         */
        switch (getRequestStr('type')) {
            /*
             * на кого отправлена жалоба
             */
            case 'target_user':
                $oUser = $oComplaint->getTargetUser();
                $sTemplateName = 'user_complaint_answer_target_user.tpl';
                break;
            /*
             * или тому, кто отправил жалобу
             */
            default:
                $oUser = $oComplaint->getUser();
                $sTemplateName = 'user_complaint_answer_user.tpl';
        }
        /*
         * отправить письмо
         */
        $this->Notify_Send(
            $oUser,
            $sTemplateName,
            $this->Lang('users.complaints.mail.title'),
            array(
                'oUserTarget' => $oComplaint->getTargetUser(),
                'oUserFrom'   => $oComplaint->getUser(),
                'oComplaint'  => $oComplaint,
                'sText'       => $sText,
            ),
            'admin',
            true
        );
        $this->Message_AddNotice($this->Lang('notices.complaints.answer_sent'));
        return true;
    }


    /**
     * Удалить жалобу
     *
     * @return bool
     */
    public function EventDeleteComplaint()
    {
        $this->Security_ValidateSendForm();
        /*
         * есть ли такая жалоба
         */
        if (!$oComplaint = $this->PluginAdmin_Users_GetUserComplaintById((int)$this->GetParam(2))) {
            $this->Message_AddError($this->Lang('errors.complaints.not_found'));
            return false;
        }
        $this->PluginAdmin_Users_DeleteUsersComplaint($oComplaint);
        $this->Message_AddNotice($this->Lang('notices.complaints.deleted'), '', true);
        $this->RedirectToReferer();
    }


    /**
     * Изменить количество жалоб на странице
     */
    public function EventAjaxUsersComplaintsOnPage()
    {
        $this->Viewer_SetResponseAjax('json');
        $this->PluginAdmin_Users_ChangeUsersComplaintsPerPage((int)getRequestStr('onpage'));
    }

    /**
     * Список пользовательских полей
     */
    public function EventContactFields()
    {
        $this->SetTemplateAction('users/contact-fields');

        /**
         * Получаем список всех полей
         */
        $this->Viewer_Assign('aUserFields', $this->User_GetUserFields());
    }

    public function EventContactFieldsCreate()
    {
        $this->SetTemplateAction('users/contact-fields.create');
        $this->Viewer_Assign('aUserFieldTypes', $this->User_GetUserFieldTypes());
        if (getRequest('submit')) {
            $this->Security_ValidateSendForm();

            if (!$this->checkContactFields()) {
                return;
            }
            $oField = Engine::GetEntity('User_Field');
            $oField->setName(getRequestStr('name'));
            $oField->setTitle(getRequestStr('title'));
            $oField->setPattern(getRequestStr('pattern'));
            if (in_array(getRequestStr('type'), $this->User_GetUserFieldTypes())) {
                $oField->setType(getRequestStr('type'));
            } else {
                $oField->setType('');
            }

            $iId = $this->User_AddUserField($oField);
            if (!$iId) {
                $this->Message_AddError($this->Lang_Get('common.error.system.base'), $this->Lang_Get('common.error.error'));
                return;
            } else {
                $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'), true);
                Router::LocationAction("admin/users/contact-fields");
            }
        }
    }

    public function EventContactFieldsUpdate()
    {
        $this->SetTemplateAction('users/contact-fields.create');

        $aFieldsAll = $this->User_GetUserFields(); // треш
        foreach ($aFieldsAll as $oItem) {
            if ($oItem->getId() == $this->GetParam(2)) {
                $oField = $oItem;
                break;
            }
        }
        if (!$oField) {
            return $this->EventNotFound();
        }

        if (getRequest('submit')) {
            $this->Security_ValidateSendForm();

            $oField = Engine::GetEntity('User_Field');
            $oField->setId($this->GetParam(2));
            $oField->setName(getRequestStr('name'));
            $oField->setTitle(getRequestStr('title'));
            $oField->setPattern(getRequestStr('pattern'));
            if (in_array(getRequestStr('type'), $this->User_GetUserFieldTypes())) {
                $oField->setType(getRequestStr('type'));
            } else {
                $oField->setType('');
            }

            if ($this->User_updateUserField($oField)) {
                $this->Message_AddNotice('Обновление прошло успешно', $this->Lang_Get('common.attention'), true);
                Router::LocationAction("admin/users/contact-fields");
            } else {
                $this->Message_AddError($this->Lang_Get('common.error.system.base'), $this->Lang_Get('common.error.error'));
                return;
            }
        } else {
            $_REQUEST = array_merge($_REQUEST, array(
                'title'   => $oField->getTitle(),
                'name'    => $oField->getName(),
                'pattern' => $oField->getPattern(),
                'type'    => $oField->getType(),
            ));
        }

        $this->Viewer_Assign('oField', $oField);
        $this->Viewer_Assign('aUserFieldTypes', $this->User_GetUserFieldTypes());
    }

    public function EventContactFieldsRemove()
    {
        $this->Security_ValidateSendForm();
        $this->User_deleteUserField($this->GetParam(2));

        $this->Message_AddNotice('Удаление прошло успешно', $this->Lang_Get('common.attention'), true);
        Router::LocationAction("admin/users/contact-fields");
    }


    /**
     * Проверка поля пользователя на корректность из реквеста
     *
     * @return bool
     */
    public function checkContactFields()
    {
        if (!getRequestStr('title')) {
            $this->Message_AddError('Необходимо укзаать название');
            return false;
        }
        if (!getRequestStr('name')) {
            $this->Message_AddError('Необходимо указать имя');
            return false;
        }
        /**
         * Не допускаем дубликатов по имени
         */
        if ($this->User_UserFieldExistsByName(getRequestStr('name'), getRequestStr('id'))) {
            $this->Message_AddError('Контакт с таким именем уже существует');
            return false;
        }
        return true;
    }
}
