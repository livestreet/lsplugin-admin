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
//            $this->Security_ValidateSendForm();
//
//            $oCategory = Engine::GetEntity('ModuleCategory_EntityCategory');
//            $oCategory->_setDataSafe(getRequest('category'));
//            $oCategory->setTypeId($oType->getId());
//            if ($oCategory->_Validate()) {
//                $oCategory->setTitle(htmlspecialchars($oCategory->getTitle()));
//                if ($oCategory->getDescription()) {
//                    $oCategory->setDescription($this->Category_ParserText($oCategory->getDescription(), $oCategory));
//                }
//                if ($oCategory->Add()) {
//                    $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'), true);
//                    Router::LocationAction("admin/categories/" . $oType->getTargetType());
//                } else {
//                    $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
//                }
//            } else {
//                $this->Message_AddError($oCategory->_getValidateError(), $this->Lang_Get('common.error.error'));
//            }
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
}
