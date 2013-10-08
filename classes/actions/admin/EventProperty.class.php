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
 * @author PSNet <light.feel@gmail.com>
 * 
 */

/*
 *	Работа с механизмом дополнительных полей, модуль Property
 */

class PluginAdmin_ActionAdmin_EventProperty extends Event {

	public function EventPropertiesTarget() {
		$sTargetType=$this->GetParam(0);
		if (!$this->Property_IsAllowTargetType($sTargetType)) {
			return $this->EventNotFound();
		}
		/**
		 * Получаем список полей для данного типа
		 */
		$aProperties=$this->Property_GetPropertyItemsByFilter(array('target_type'=>$sTargetType,'#order'=>array('sort'=>'desc')));
		$this->Viewer_Assign('aPropertyItems',$aProperties);
		$this->Viewer_Assign('sPropertyTargetType',$sTargetType);

		$this->SetTemplateAction('property/target');
	}

	public function EventPropertyUpdate() {
		$sTargetType=$this->GetParam(0);
		if (!$this->Property_IsAllowTargetType($sTargetType)) {
			return $this->EventNotFound();
		}
		if (!($oProperty=$this->Property_GetPropertyById($this->GetParam(2)))) {
			return $this->EventNotFound();
		}
		if ($oProperty->getTargetType()!=$sTargetType) {
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
					$this->Message_AddNotice('Обновление прошло успешно',$this->Lang_Get('attention'),true);
					Router::Location($oProperty->getUrlAdminUpdate());
				} else {
					$this->Message_AddError('Возникла ошибка при обновлении',$this->Lang_Get('error'));
				}
			} else {
				$this->Message_AddError($oProperty->_getValidateError(),$this->Lang_Get('error'));
			}
		}

		$this->Viewer_Assign('oProperty',$oProperty);
		$this->SetTemplateAction('property/update');
	}

	public function EventPropertyCreate() {
		$sTargetType=$this->GetParam(0);
		if (!$this->Property_IsAllowTargetType($sTargetType)) {
			return $this->EventNotFound();
		}

		if (getRequest('property_create_submit')) {
			$this->Security_ValidateSendForm();
			$oProperty=Engine::GetEntity('ModuleProperty_EntityProperty');
			$oProperty->_setValidateScenario('create');
			$oProperty->_setDataSafe(getRequest('property'));
			$oProperty->setTargetType($sTargetType);
			if ($oProperty->_Validate()) {
				if ($oProperty->Add()) {
					$this->Message_AddNotice('Добавление прошло успешно',$this->Lang_Get('attention'),true);
					Router::Location($oProperty->getUrlAdminUpdate());
				} else {
					$this->Message_AddError('Возникла ошибка при добавлении',$this->Lang_Get('error'));
				}
			} else {
				$this->Message_AddError($oProperty->_getValidateError(),$this->Lang_Get('error'));
			}
		}
		$this->SetTemplateAction('property/create');
	}

}