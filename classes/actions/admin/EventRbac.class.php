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
 *
 */
/*
 *
 * Работа с правами пользователей
 *
 */

class PluginAdmin_ActionAdmin_EventRbac extends Event
{


    /**
     * Список разрешений
     */
    public function EventPermissionList()
    {
        $this->sMenuSubItemSelect = 'permission';
        /**
         * Получаем разрешения в разрезе групп
         */
        $aPermissions = $this->Rbac_GetPermissionItemsByFilter(array(
                '#order'       => array('code' => 'asc'),
                '#index-group' => 'group_id'
            ));

        $aGroupIds = array_keys($aPermissions);
        if ($aGroupIds) {
            $aGroupItems = $this->Rbac_GetGroupItemsByFilter(array('id in' => $aGroupIds, '#index-from-primary'));
            $this->Viewer_Assign('aGroupItems', $aGroupItems);
        }

        $this->Viewer_Assign('aPermissionGroupItems', $aPermissions);

        $this->SetTemplateAction('rbac/permission.list');
    }

    public function EventPermissionCreate()
    {
        $this->sMenuSubItemSelect = 'permission';
        $aGroupItems = $this->Rbac_GetGroupItemsByFilter(array('#order' => array('code' => 'asc')));
        $this->Viewer_Assign('aGroupItems', $aGroupItems);

        if (getRequest('permission_submit')) {
            $this->Security_ValidateSendForm();

            $oPermission = Engine::GetEntity('ModuleRbac_EntityPermission');
            $oPermission->_setDataSafe(getRequest('permission'));
            $oPermission->setState(isset($_REQUEST['permission']['state']) ? ModuleRbac::PERMISSION_STATE_ACTIVE : ModuleRbac::PERMISSION_STATE_INACTIVE);
            if ($oPermission->_Validate()) {
                $oPermission->setTitle(htmlspecialchars($oPermission->getTitle()));
                $oPermission->setMsgError(htmlspecialchars($oPermission->getMsgError()));
                if ($oPermission->Add()) {
                    $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/users/rbac/permission");
                } else {
                    $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oPermission->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        }
        $this->SetTemplateAction('rbac/permission.create');
    }

    public function EventPermissionUpdate()
    {
        $this->sMenuSubItemSelect = 'permission';
        if (!($oPermission = $this->Rbac_GetPermissionById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }

        $aGroupItems = $this->Rbac_GetGroupItemsByFilter(array('#order' => array('code' => 'asc')));
        $this->Viewer_Assign('aGroupItems', $aGroupItems);

        if (getRequest('permission_submit')) {
            $this->Security_ValidateSendForm();
            $oPermission->_setDataSafe(getRequest('permission'));
            $oPermission->setState(isset($_REQUEST['permission']['state']) ? ModuleRbac::PERMISSION_STATE_ACTIVE : ModuleRbac::PERMISSION_STATE_INACTIVE);
            if ($oPermission->_Validate()) {
                $oPermission->setTitle(htmlspecialchars($oPermission->getTitle()));
                $oPermission->setMsgError(htmlspecialchars($oPermission->getMsgError()));
                if ($oPermission->Update()) {
                    $this->Message_AddNotice('Обновление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/users/rbac/permission");
                } else {
                    $this->Message_AddError('Возникла ошибка при обновлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oPermission->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        } else {
            $_REQUEST['permission'] = array(
                'title'     => htmlspecialchars_decode($oPermission->getTitle()),
                'group_id'  => $oPermission->getGroupId(),
                'code'      => $oPermission->getCode(),
                'plugin'    => $oPermission->getPlugin(),
                'msg_error' => htmlspecialchars_decode($oPermission->getMsgError()),
                'state'     => $oPermission->getState() == ModuleRbac::PERMISSION_STATE_ACTIVE ? 1 : 0,
            );
        }

        $this->Viewer_Assign('oPermission', $oPermission);
        $this->SetTemplateAction('rbac/permission.create');
    }

    public function EventPermissionRemove()
    {
        $this->Security_ValidateSendForm();
        $this->sMenuSubItemSelect = 'permission';
        if (!($oPermission = $this->Rbac_GetPermissionById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }

        if ($oPermission->Delete()) {
            $this->Message_AddNotice('Удаление прошло успешно', $this->Lang_Get('common.attention'), true);
        } else {
            $this->Message_AddError('Возникла ошибка при удалении', $this->Lang_Get('common.attention'), true);
        }
        Router::LocationAction("admin/users/rbac/permission");
    }


    /**
     * Список групп
     */
    public function EventGroupList()
    {
        $this->sMenuSubItemSelect = 'group';
        $aGroups = $this->Rbac_GetGroupItemsByFilter(array(
                '#order' => array('code' => 'asc'),
                '#with'  => array('permissions')
            ));

        $this->Viewer_Assign('aGroupItems', $aGroups);

        $this->SetTemplateAction('rbac/group.list');
    }


    public function EventGroupCreate()
    {
        $this->sMenuSubItemSelect = 'group';
        if (getRequest('group_submit')) {
            $this->Security_ValidateSendForm();

            $oGroup = Engine::GetEntity('ModuleRbac_EntityGroup');
            $oGroup->_setDataSafe(getRequest('group'));
            if ($oGroup->_Validate()) {
                $oGroup->setTitle(htmlspecialchars($oGroup->getTitle()));
                if ($oGroup->Add()) {
                    $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/users/rbac/group");
                } else {
                    $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oGroup->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        }
        $this->SetTemplateAction('rbac/group.create');
    }

    public function EventGroupUpdate()
    {
        $this->sMenuSubItemSelect = 'group';
        if (!($oGroup = $this->Rbac_GetGroupById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }

        if (getRequest('group_submit')) {
            $this->Security_ValidateSendForm();
            $oGroup->_setDataSafe(getRequest('group'));
            if ($oGroup->_Validate()) {
                $oGroup->setTitle(htmlspecialchars($oGroup->getTitle()));
                if ($oGroup->Update()) {
                    $this->Message_AddNotice('Обновление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/users/rbac/group");
                } else {
                    $this->Message_AddError('Возникла ошибка при обновлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oGroup->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        } else {
            $_REQUEST['group'] = array(
                'title' => htmlspecialchars_decode($oGroup->getTitle()),
                'code'  => $oGroup->getCode(),
            );
        }

        $this->Viewer_Assign('oGroup', $oGroup);
        $this->SetTemplateAction('rbac/group.create');
    }

    public function EventGroupRemove()
    {
        $this->Security_ValidateSendForm();
        $this->sMenuSubItemSelect = 'group';
        if (!($oGroup = $this->Rbac_GetGroupById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }

        if ($oGroup->Delete()) {
            $this->Message_AddNotice('Удаление прошло успешно', $this->Lang_Get('common.attention'), true);
        } else {
            $this->Message_AddError('Возникла ошибка при удалении', $this->Lang_Get('common.attention'), true);
        }
        Router::LocationAction("admin/users/rbac/group");
    }


    /**
     * Список ролей
     */
    public function EventRoleList()
    {
        $this->sMenuSubItemSelect = 'role';
        $aRoles = $this->Rbac_LoadTreeOfRole(array('#order' => array('code' => 'asc')));
        $aRoles = ModuleORM::buildTree($aRoles);

        $this->Viewer_Assign('aRoleItems', $aRoles);

        $this->SetTemplateAction('rbac/role.list');
    }


    public function EventRoleCreate()
    {
        $this->sMenuSubItemSelect = 'role';
        if (getRequest('role_submit')) {
            $this->Security_ValidateSendForm();

            $oRole = Engine::GetEntity('ModuleRbac_EntityRole');
            $oRole->_setDataSafe(getRequest('role'));
            $oRole->setState(isset($_REQUEST['role']['state']) ? ModuleRbac::ROLE_STATE_ACTIVE : ModuleRbac::ROLE_STATE_INACTIVE);
            if ($oRole->_Validate()) {
                $oRole->setTitle(htmlspecialchars($oRole->getTitle()));
                if ($oRole->Add()) {
                    $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/users/rbac");
                } else {
                    $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oRole->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        }
        /**
         * Получаем список ролей
         */
        $aRoles = $this->Rbac_LoadTreeOfRole(array('#order' => array('code' => 'asc')));
        $aRoles = ModuleORM::buildTree($aRoles);

        $this->Viewer_Assign('aRoleItems', $aRoles);
        $this->SetTemplateAction('rbac/role.create');
    }

    public function EventRoleUpdate()
    {
        $this->sMenuSubItemSelect = 'role';
        if (!($oRole = $this->Rbac_GetRoleById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }
        /**
         * Получаем список ролей
         */
        $aRoles = $this->Rbac_LoadTreeOfRole(array('#order' => array('code' => 'asc')));
        $aRoles = ModuleORM::buildTree($aRoles);

        if (getRequest('role_submit')) {
            $this->Security_ValidateSendForm();
            $oRole->_setDataSafe(getRequest('role'));
            $oRole->setState(isset($_REQUEST['role']['state']) ? ModuleRbac::ROLE_STATE_ACTIVE : ModuleRbac::ROLE_STATE_INACTIVE);
            if ($oRole->_Validate()) {
                $oRole->setTitle(htmlspecialchars($oRole->getTitle()));
                if ($oRole->Update()) {
                    /**
                     * Защита от некорректного вложения
                     */
                    $aRoleItems = $this->Rbac_LoadTreeOfRole(array('#order' => array('code' => 'asc')));
                    $aRoleItems = ModuleORM::buildTree($aRoleItems);
                    if (count($aRoleItems) < count($this->Rbac_GetRoleItemsByFilter(array()))) {
                        $oRole->setPid(null);
                        $oRole->Update();
                    }

                    $this->Message_AddNotice('Обновление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/users/rbac");
                } else {
                    $this->Message_AddError('Возникла ошибка при обновлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oRole->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        } else {
            $_REQUEST['role'] = array(
                'pid'   => $oRole->getPid(),
                'title' => htmlspecialchars_decode($oRole->getTitle()),
                'code'  => $oRole->getCode(),
                'state' => $oRole->getState() == ModuleRbac::ROLE_STATE_ACTIVE ? 1 : 0,
            );
        }

        $this->Viewer_Assign('oRole', $oRole);
        $this->Viewer_Assign('aRoleItems', $aRoles);
        $this->SetTemplateAction('rbac/role.create');
    }

    public function EventRoleRemove()
    {
        $this->sMenuSubItemSelect = 'role';
        if (!($oRole = $this->Rbac_GetRoleById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }

        if ($oRole->Delete()) {
            $this->Message_AddNotice('Удаление прошло успешно', $this->Lang_Get('common.attention'), true);
        } else {
            $this->Message_AddError('Возникла ошибка при удалении', $this->Lang_Get('common.attention'), true);
        }

        Router::LocationAction("admin/users/rbac/role");
    }

    public function EventRolePermissions()
    {
        $this->sMenuSubItemSelect = 'role';
        if (!($oRole = $this->Rbac_GetRoleById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }


        /**
         * Получаем разрешения в разрезе групп
         */
        $aPermissionsAll = $this->Rbac_GetPermissionItemsByFilter(array(
                '#order'       => array('code' => 'asc'),
                '#index-group' => 'group_id'
            ));
        $aGroupIds = array_keys($aPermissionsAll);
        if ($aGroupIds) {
            $aGroupItems = $this->Rbac_GetGroupItemsByFilter(array('id in' => $aGroupIds, '#index-from-primary'));
            $this->Viewer_Assign('aGroupItems', $aGroupItems);
        }
        $this->Viewer_Assign('aPermissionGroupItems', $aPermissionsAll);


        $this->Viewer_Assign('oRole', $oRole);
        $this->Viewer_Assign('aPermissionItems', $oRole->getPermissions());
        $this->SetTemplateAction('rbac/role.permissions');
    }

    public function EventAjaxRolePermissionAdd()
    {
        $this->Viewer_SetResponseAjax('json');
        $iRoleId = getRequestStr('role');
        $iPermissionId = getRequestStr('permission');

        if (!($oRole = $this->Rbac_GetRoleById($iRoleId))) {
            return $this->EventNotFound();
        }
        if (!($oPermission = $this->Rbac_GetPermissionById($iPermissionId))) {
            return $this->EventNotFound();
        }

        if (!$this->Rbac_GetRolePermissionByFilter(array(
                'role_id'       => $oRole->getId(),
                'permission_id' => $oPermission->getId()
            ))
        ) {
            /**
             * Добавляем
             */
            $oRolePermission = Engine::GetEntity('ModuleRbac_EntityRolePermission');
            $oRolePermission->setRoleId($oRole->getId());
            $oRolePermission->setPermissionId($oPermission->getId());
            if ($oRolePermission->Add()) {
                $this->Viewer_Assign('permission', $oPermission, true);
                $this->Viewer_Assign('role', $oRole, true);
                $this->Viewer_AssignAjax('sText',
                    $this->Viewer_Fetch('component@admin:p-rbac.role-permissions-item'));
            } else {
                $this->Message_AddError('Возникла ошибка при добавлении');
            }
        } else {
            $this->Message_AddError('У роли уже есть данное разрешение');
        }
    }

    public function EventAjaxRolePermissionRemove()
    {
        $this->Viewer_SetResponseAjax('json');
        $iRoleId = getRequestStr('role');
        $iPermissionId = getRequestStr('permission');

        if ($oRel = $this->Rbac_GetRolePermissionByFilter(array(
                'role_id'       => $iRoleId,
                'permission_id' => $iPermissionId
            ))
        ) {
            $oRel->Delete();
        }
    }


    public function EventRoleUsers()
    {
        $this->sMenuSubItemSelect = 'role';
        if (!($oRole = $this->Rbac_GetRoleById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }

        $iPage = $this->GetParamEventMatch(3, 2) ? $this->GetParamEventMatch(3, 2) : 1;
        /**
         * Сначала получаем постраничный список связей
         */
        $aRoleUsers = $this->Rbac_GetRoleUserItemsByFilter(array(
                'role_id'     => $oRole->getId(),
                '#index-from' => 'user_id',
                '#page'       => array($iPage, 20)
            ));
        /**
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging($aRoleUsers['count'], $iPage, 20, Config::Get('pagination.pages.count'),
            $oRole->getUrlAdminAction('users'));
        /**
         * Получаем список пользователей
         */
        if ($aRoleUsers['collection']) {
            $aUserItems = $this->User_GetUsersByArrayId(array_keys($aRoleUsers['collection']));
        } else {
            $aUserItems = array();
        }

        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('oRole', $oRole);
        $this->Viewer_Assign('aUserItems', $aUserItems);
        $this->SetTemplateAction('rbac/role.users');
    }


    public function EventAjaxRoleUserAdd()
    {
        $this->Viewer_SetResponseAjax('json');
        $iRoleId = getRequestStr('role');
        $sUserLogin = getRequestStr('login');

        if (!($oRole = $this->Rbac_GetRoleById($iRoleId))) {
            return $this->EventNotFound();
        }
        if (!($oUser = $this->User_GetUserByLogin($sUserLogin))) {
            return $this->EventNotFound();
        }

        if (!$this->Rbac_GetRoleUserByFilter(array('role_id' => $oRole->getId(), 'user_id' => $oUser->getId()))) {
            /**
             * Добавляем
             */
            $oRoleUser = Engine::GetEntity('ModuleRbac_EntityRoleUser');
            $oRoleUser->setRoleId($oRole->getId());
            $oRoleUser->setUserId($oUser->getId());
            if ($oRoleUser->Add()) {
                $this->Viewer_Assign('user', $oUser, true);
                $this->Viewer_Assign('role', $oRole, true);
                $this->Viewer_AssignAjax('sText',
                    $this->Viewer_Fetch('component@admin:p-rbac.role-users-item'));
            } else {
                $this->Message_AddError('Возникла ошибка при добавлении');
            }
        } else {
            $this->Message_AddError('У пользователя уже есть данная роль');
        }
    }

    public function EventAjaxRoleUserRemove()
    {
        $this->Viewer_SetResponseAjax('json');
        $iRoleId = getRequestStr('role');
        $iUserId = getRequestStr('user');

        if ($oRel = $this->Rbac_GetRoleUserByFilter(array('role_id' => $iRoleId, 'user_id' => $iUserId))) {
            $oRel->Delete();
        }
    }
}