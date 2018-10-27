<?php

/*
 * LiveStreet CMS
 * Copyright © 2018 OOO "ЛС-СОФТ"
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
 * @author Oleg Demodov <boxmilo@gmail.com>
 *
 */

/**
 * Редактирование меню
 *
 * @author oleg
 */
class PluginAdmin_ActionAdmin_EventMenu extends Event{
    
    public function EventList() {
        $oMenu = $this->Menu_GetMenuByFilter(['name' => $this->GetParam(0)]);
        if(!$oMenu){
            return $this->EventNotFound();
        }
        
        $aItems = $this->Menu_LoadTreeOfItem([
            'menu_id' => $oMenu->getId(),
            '#order'  => array('priority' => 'desc')
        ]);
        
        $aItems = ModuleORM::buildTree($aItems);
        
        $this->Viewer_Assign('aItems', $aItems);
        $this->Viewer_Assign('oMenu', $oMenu);

        $this->SetTemplateAction('menu/list');
    }
    
    public function EventItemCreate()
    {
        $oMenu = $this->Menu_GetMenuByFilter(['name' => $this->GetParam(0)]);
        if(!$oMenu){
            return $this->EventNotFound();
        }

        if (getRequest('item_submit')) {
            $this->Security_ValidateSendForm();

            $oItem = Engine::GetEntity('ModuleMenu_EntityItem');
            $oItem->_setDataSafe(getRequest('item')); 
            
            $oItem->setMenuId($oMenu->getId());
           
            if ($oItem->_Validate()) {
                $oItem->setTitle(htmlspecialchars($oItem->getTitle()));
               
                if ($oItem->Add()) {
                    $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/menu/" . $oMenu->getName());
                } else {
                    $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oItem->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        }
        /**
         * Получаем список пупнктов для данного меню
         */
        $aItems = $this->Menu_LoadTreeOfItem([
            'menu_id' => $oMenu->getId(),
            '#order'  => array('priority' => 'desc')
        ]);
        
        $aItems = ModuleORM::buildTree($aItems);
        
        $this->Viewer_Assign('aItems', $aItems);
        $this->Viewer_Assign('oMenu', $oMenu);
        $this->SetTemplateAction('menu/create');
    }
    
    public function EventCategoryUpdate()
    {
        $oMenu = $this->Menu_GetMenuByFilter(['name' => $this->GetParam(0)]);
        if(!$oMenu){
            return $this->EventNotFound();
        }
        if (!($oItem = $this->Menu_GetItemById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }
        
        /**
         * Получаем список пупнктов для данного меню
         */
        $aItems = $this->Menu_LoadTreeOfItem([
            'menu_id' => $oMenu->getId(),
            '#order'  => array('priority' => 'desc')
        ]);
        
        $aItems = ModuleORM::buildTree($aItems);

        if (getRequest('item_submit')) {
            $this->Security_ValidateSendForm();
            $oItem->_setDataSafe(getRequest('item'));
            
            if ($oItem->_Validate()) {
                $oItem->setTitle(htmlspecialchars($oItem->getTitle()));
               
                if ($oItem->Save()) {
                    $this->Message_AddNotice('Сохранение прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/menu/" . $oMenu->getName());
                } else {
                    $this->Message_AddError('Возникла ошибка при сохранении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oItem->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        } else {
            $_REQUEST['item'] = array(
                'pid'         => $oItem->getPid(),
                'title'       => htmlspecialchars_decode($oItem->getTitle()),
                'name'        => $oItem->getName(),
                'url'         => $oItem->getUrl(),
                'priority'    => $oItem->getPriority(),
                'enable'      => $oItem->getEnable(),
                'active'      => $oItem->getActive(),
            );
        }

        $this->Viewer_Assign('oItem', $oItem);
        $this->Viewer_Assign('aItems', $aItems);
        $this->Viewer_Assign('oMenu', $oMenu);
        $this->SetTemplateAction('menu/create');
    }
    
    public function EventCategoryRemove()
    {
        $oMenu = $this->Menu_GetMenuByFilter(['name' => $this->GetParam(0)]);
        if(!$oMenu){
            return $this->EventNotFound();
        }
        if (!($oItem = $this->Menu_GetItemById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }

        /**
         * Удаляем
         */
        if ($oItem->Delete()) {
            $this->Message_AddNotice('Удаление прошло успешно', null, true);
        } else {
            $this->Message_AddError('Возникла ошибка при удалении', null, true);
        }

        Router::LocationAction("admin/menu/{$oMenu->getName()}");
    }
}
