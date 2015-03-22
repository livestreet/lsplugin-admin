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
 *	Работа с механизмом дополнительных полей, модуль Property
 */

class PluginAdmin_ActionAdmin_EventProperty extends Event
{


    public function EventAjaxSortSave()
    {
        $this->Viewer_SetResponseAjax('json');

        $aData = getRequest('data');
        if (is_array($aData)) {
            foreach ($aData as $aItem) {
                if (isset($aItem['id']) and isset($aItem['sort'])) {
                    if ($oProperty = $this->Property_GetPropertyById($aItem['id'])) {
                        $oProperty->setSort((int)$aItem['sort']);
                        $oProperty->Update();
                    }
                }
            }
            $this->Message_AddNotice('Сортировка сохранена');    // todo: add lang
        }
    }


    public function EventPropertiesTarget()
    {
        $sTargetType = $this->GetParam(0);
        if (!$this->Property_IsAllowTargetType($sTargetType)) {
            return $this->EventNotFound();
        }
        /**
         * Получаем список полей для данного типа
         */
        $aProperties = $this->Property_GetPropertyItemsByFilter(array(
                'target_type' => $sTargetType,
                '#order'      => array('sort' => 'desc')
            ));
        $this->Viewer_Assign('aPropertyItems', $aProperties);
        $this->Viewer_Assign('sPropertyTargetType', $sTargetType);
        $this->Viewer_Assign('aPropertyTargetParams', $this->Property_GetTargetTypeParams($sTargetType));

        $this->SetTemplateAction('property/list');
    }


    public function EventPropertyRemove()
    {
        $this->Security_ValidateSendForm();

        $sTargetType = $this->GetParam(0);
        if (!$this->Property_IsAllowTargetType($sTargetType)) {
            return $this->EventNotFound();
        }
        if (!($oProperty = $this->Property_GetPropertyById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }
        if ($oProperty->getTargetType() != $sTargetType) {
            return $this->EventNotFound();
        }

        /**
         * Удаляем
         */
        if ($oProperty->Delete()) {
            $this->Message_AddNotice($this->Lang('notices.properties.remove_done'), null, true);
        } else {
            $this->Message_AddError($this->Lang('errors.properties.not_removed'), null, true);
        }

        Router::LocationAction("admin/properties/{$sTargetType}");
    }


    public function EventPropertyUpdate()
    {
        $sTargetType = $this->GetParam(0);
        if (!$this->Property_IsAllowTargetType($sTargetType)) {
            return $this->EventNotFound();
        }
        if (!($oProperty = $this->Property_GetPropertyById($this->GetParam(2)))) {
            return $this->EventNotFound();
        }
        if ($oProperty->getTargetType() != $sTargetType) {
            return $this->EventNotFound();
        }

        if (getRequest('property_update_submit')) {
            $this->Security_ValidateSendForm();
            $oProperty->_setValidateScenario('update');
            $oProperty->_setDataSafe(getRequest('property'));
            $oProperty->setValidateRulesRaw(getRequest('validate'));
            $oProperty->setParamsRaw(getRequest('param'));
            if ($oProperty->_Validate()) {
                if ($oProperty->Update()) {
                    /**
                     * Дополнительная обработка, например, сохранение значений селекта
                     */
                    if ($oProperty->getType() == ModuleProperty::PROPERTY_TYPE_SELECT) {
                        $aItems = getRequest('items');
                        if (isset($aItems['value']) and is_array($aItems['value'])) {
                            /**
                             * Текущие элементы (для удаления)
                             */
                            $aSelectItems = $this->Property_GetSelectItemsByFilter(array(
                                    'property_id' => $oProperty->getId(),
                                    '#index-from-primary'
                                ));
                            $aSelectItemsUse = array();
                            foreach ($aItems['value'] as $k => $v) {
                                if (isset($aItems['sort'][$k]) and isset($aItems['id'][$k])) {
                                    if ($aItems['id'][$k]) {
                                        if ($oSelect = $this->Property_GetSelectByFilter(array(
                                                'property_id' => $oProperty->getId(),
                                                'id'          => (int)$aItems['id'][$k]
                                            ))
                                        ) {
                                            $oSelect->setValue(htmlspecialchars((string)$aItems['value'][$k]));
                                            $oSelect->setSort((int)$aItems['sort'][$k]);
                                            $oSelect->Update();
                                            $aSelectItemsUse[] = $oSelect->getId();
                                        }
                                    } else {
                                        $oSelect = Engine::GetEntity('ModuleProperty_EntitySelect');
                                        $oSelect->setPropertyId($oProperty->getId());
                                        $oSelect->setTargetType($oProperty->getTargetType());
                                        $oSelect->setValue(htmlspecialchars((string)$aItems['value'][$k]));
                                        $oSelect->setSort((int)$aItems['sort'][$k]);
                                        $oSelect->Add();
                                    }
                                }
                            }
                            $aSelectItems = array_keys($aSelectItems);
                            foreach ($aSelectItems as $iId) {
                                if (!in_array($iId,
                                        $aSelectItemsUse) and $oSelect = $this->Property_GetSelectById($iId)
                                ) {
                                    /**
                                     * Проходимся по всем элементам с этим значением и удаляем его
                                     */
                                    $aValueSelectItems = $this->Property_GetValueSelectItemsByFilter(array('select_id ' => $oSelect->getId()));
                                    foreach ($aValueSelectItems as $oValueSelect) {
                                        /**
                                         * Формируем свойство для конкретной сущности
                                         */
                                        $aProperties = array($oProperty);
                                        $this->Property_AttachValueForProperties($aProperties,
                                            $oValueSelect->getTargetType(), $oValueSelect->getTargetId());

                                        $oValue = $oProperty->getValue();
                                        $oValueType = $oValue->getValueTypeObject();
                                        $aValuesForSelect = $oValue->getDataOne('values');
                                        if (is_array($aValuesForSelect)) {
                                            unset($aValuesForSelect[$oSelect->getId()]);
                                            $oValueType->setValue(array_keys($aValuesForSelect));
                                            $this->Property_UpdatePropertiesValue($aProperties,
                                                $oValueSelect->getTargetId());
                                        }
                                    }
                                    $oSelect->Delete();
                                }
                            }
                        }
                    }
                    $this->Message_AddNotice('Обновление прошло успешно', $this->Lang_Get('common.attention'),
                        true);// todo: add lang
                    Router::Location($oProperty->getUrlAdminUpdate());
                } else {
                    $this->Message_AddError('Возникла ошибка при обновлении',
                        $this->Lang_Get('common.error.error'));// todo: add lang
                }
            } else {
                $this->Message_AddError($oProperty->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        }

        $this->Viewer_Assign('oProperty', $oProperty);
        $this->Viewer_Assign('sPropertyTargetType', $sTargetType);
        $this->Viewer_Assign('aPropertyTargetParams', $this->Property_GetTargetTypeParams($sTargetType));
        $this->SetTemplateAction('property/update');
    }


    public function EventPropertyCreate()
    {
        $sTargetType = $this->GetParam(0);
        if (!$this->Property_IsAllowTargetType($sTargetType)) {
            return $this->EventNotFound();
        }

        if (getRequest('property_create_submit')) {
            $this->Security_ValidateSendForm();
            $oProperty = Engine::GetEntity('ModuleProperty_EntityProperty');
            $oProperty->_setValidateScenario('create');
            $oProperty->_setDataSafe(getRequest('property'));
            $oProperty->setTargetType($sTargetType);
            if ($oProperty->_Validate()) {
                if ($oProperty->Add()) {
                    $this->Message_AddNotice('Добавление прошло успешно', $this->Lang_Get('common.attention'),
                        true);// todo: add lang
                    Router::Location($oProperty->getUrlAdminUpdate());
                } else {
                    $this->Message_AddError('Возникла ошибка при добавлении',
                        $this->Lang_Get('common.error.error'));// todo: add lang
                }
            } else {
                $this->Message_AddError($oProperty->_getValidateError(), $this->Lang_Get('common.error.error'));
            }
        }
        $this->Viewer_Assign('sPropertyTargetType', $sTargetType);
        $this->Viewer_Assign('aPropertyTargetParams', $this->Property_GetTargetTypeParams($sTargetType));
        $this->SetTemplateAction('property/create');
    }

}