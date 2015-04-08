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
 * @link      http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author    PSNet <light.feel@gmail.com>
 *
 */
/*
 *	Работа с механизмом универсальных категорий, модуль Category
 */

class PluginAdmin_ActionAdmin_EventCategory extends Event
{


    public function EventCategoriesTarget()
    {
        $sTargetType = $this->GetParam(0);
        if (!$oType = $this->Category_GetTypeByTargetTypeAndState($sTargetType, ModuleCategory::TARGET_STATE_ACTIVE)) {
            return $this->EventNotFound();
        }
        /**
         * Получаем список категорий для данного типа
         */
        $aCategories = $this->Category_LoadTreeOfCategory(array(
                'type_id' => $oType->getId(),
                '#order'  => array('order' => 'desc')
            ));
        $aCategories = ModuleORM::buildTree($aCategories);

        $this->Viewer_Assign('aCategoryItems', $aCategories);
        $this->Viewer_Assign('oCategoryType', $oType);

        $this->SetTemplateAction('category/list');
    }


    public function EventCategoryRemove()
    {
        $this->Security_ValidateSendForm();

        $sTargetType = $this->GetParam(0);
        if (!$oType = $this->Category_GetTypeByTargetTypeAndState($sTargetType, ModuleCategory::TARGET_STATE_ACTIVE)) {
            return $this->EventNotFound();
        }
        if (!($oCategory = $this->Category_GetCategoryById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }
        if ($oCategory->getTypeId() != $oType->getId()) {
            return $this->EventNotFound();
        }

        /**
         * Удаляем
         */
        if ($oCategory->Delete()) {
            $this->Message_AddNotice('Удаление прошло успешно', null, true);
        } else {
            $this->Message_AddError('Возникла ошибка при удалении', null, true);
        }

        Router::LocationAction("admin/categories/{$sTargetType}");
    }


    public function EventCategoryUpdate()
    {
        $sTargetType = $this->GetParam(0);
        if (!$oType = $this->Category_GetTypeByTargetTypeAndState($sTargetType, ModuleCategory::TARGET_STATE_ACTIVE)) {
            return $this->EventNotFound();
        }
        if (!($oCategory = $this->Category_GetCategoryById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }
        if ($oCategory->getTypeId() != $oType->getId()) {
            return $this->EventNotFound();
        }
        /**
         * Получаем список категорий для данного типа
         */
        $aCategories = $this->Category_LoadTreeOfCategory(array(
                'type_id' => $oType->getId(),
                '#order'  => array('order' => 'desc')
            ));
        $aCategories = ModuleORM::buildTree($aCategories);

        if (getRequest('category_submit')) {
            $this->Security_ValidateSendForm();
            $oCategory->_setDataSafe(getRequest('category'));
            if ($oCategory->_Validate()) {
                $oCategory->setTitle(htmlspecialchars($oCategory->getTitle()));
                if ($oCategory->getDescription()) {
                    $oCategory->setDescription($this->Category_ParserText($oCategory->getDescription(), $oCategory));
                }
                if ($oCategory->Update()) {
                    /**
                     * Защита от некорректного вложения
                     */
                    $aCategories = $this->Category_LoadTreeOfCategory(array(
                            'type_id' => $oType->getId(),
                            '#order'  => array('order' => 'desc')
                        ));
                    $aCategories = ModuleORM::buildTree($aCategories);
                    if (count($aCategories) < count($this->Category_GetCategoryItemsByFilter(array('type_id' => $oType->getId())))) {
                        $oCategory->setPid(null);
                        $oCategory->setUrlFull($oCategory->getUrl());
                        $oCategory->Update();
                    }
                    $this->Category_RebuildCategoryUrlFull($oCategory);

                    $this->Message_AddNotice('Обновление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/categories/" . $oType->getTargetType());
                } else {
                    $this->Message_AddError('Возникла ошибка при обновлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oCategory->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        } else {
            $_REQUEST['category'] = array(
                'pid'         => $oCategory->getPid(),
                'title'       => htmlspecialchars_decode($oCategory->getTitle()),
                'description' => $oCategory->getDescription(),
                'url'         => $oCategory->getUrl(),
                'order'       => $oCategory->getOrder(),
            );
        }

        $this->Viewer_Assign('oCategory', $oCategory);
        $this->Viewer_Assign('aCategoryItems', $aCategories);
        $this->Viewer_Assign('oCategoryType', $oType);
        $this->SetTemplateAction('category/create');
    }


    public function EventCategoryCreate()
    {
        $sTargetType = $this->GetParam(0);
        if (!$oType = $this->Category_GetTypeByTargetTypeAndState($sTargetType, ModuleCategory::TARGET_STATE_ACTIVE)) {
            return $this->EventNotFound();
        }

        if (getRequest('category_submit')) {
            $this->Security_ValidateSendForm();

            $oCategory = Engine::GetEntity('ModuleCategory_EntityCategory');
            $oCategory->_setDataSafe(getRequest('category'));
            $oCategory->setTypeId($oType->getId());
            if ($oCategory->_Validate()) {
                $oCategory->setTitle(htmlspecialchars($oCategory->getTitle()));
                if ($oCategory->getDescription()) {
                    $oCategory->setDescription($this->Category_ParserText($oCategory->getDescription(), $oCategory));
                }
                if ($oCategory->Add()) {
                    $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'), true);
                    Router::LocationAction("admin/categories/" . $oType->getTargetType());
                } else {
                    $this->Message_AddError('Возникла ошибка при добавлении', $this->Lang_Get('common.error.error'));
                }
            } else {
                $this->Message_AddError($oCategory->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        }
        /**
         * Получаем список категорий для данного типа
         */
        $aCategories = $this->Category_LoadTreeOfCategory(array(
                'type_id' => $oType->getId(),
                '#order'  => array('order' => 'desc')
            ));
        $aCategories = ModuleORM::buildTree($aCategories);

        $this->Viewer_Assign('aCategoryItems', $aCategories);
        $this->Viewer_Assign('oCategoryType', $oType);
        $this->SetTemplateAction('category/create');
    }

}