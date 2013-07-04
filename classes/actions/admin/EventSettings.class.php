<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/*
		Работа с настройками плагинов
		
		by PSNet
		http://psnet.lookformp3.net
*/

class PluginAdmin_ActionAdmin_EventSettings extends Event {
	
	const ADMIN_INTERFACE_DESCRIPTION_CONFIG_KEY = '__Admin_Interface__';		// Ключ конфига, который хранит описатели настроек данного конфига
	const ADMIN_SETTINGS_FORM_SYSTEM_ID = 'LS-Admin';												// Скрытый системный идентификатор данных о настройках
	const SYSTEM_CONFIG_ID = '__root_config__';															// Имя системного конфига
	const ADMIN_TEMP_CONFIG_INSTANCE = 'temporary_instance';								// До момента сохранения настроек в БД они будут хранится здесь
	
	// ---
	
	//
	// Показать настройки
	//
	public function EventShow () {
		$this -> Security_ValidateSendForm ();
		
    // Корректно ли имя конфига
		if (!$sConfigName = $this -> getParam (0) or !is_string ($sConfigName)) {
      $this -> Message_AddError ($this -> Lang_Get ('plugin.admin.Errors.Wrong_Config_Name'), $this -> Lang_Get ('error'));
      return false;
		}
		
		if ($sConfigName == self::SYSTEM_CONFIG_ID) {
			// Загрузить системный конфиг
      $aSettingsAll = $this -> GetConfigSettings ($sConfigName);
			$this -> Viewer_Assign ('aSettingsAll', $aSettingsAll);
			
		} else {
			// Загрузить конфиг плагина
			if (!$this -> CheckIfThisPluginIsActive ($sConfigName)) {
	      $this -> Message_AddError ($this -> Lang_Get ('plugin.admin.Errors.Plugin_Need_To_Be_Activated'), $this -> Lang_Get ('error'));
	      return false;
			}
			
      $aSettingsAll = $this -> GetConfigSettings ($sConfigName);
			$this -> Viewer_Assign ('aSettingsAll', $aSettingsAll);
		}
		
		//print_r($aSettingsAll);die();			// todo: delete
		$this -> Viewer_Assign ('sConfigName', $sConfigName);
		$this -> Viewer_Assign ('sAdminSettingsFormSystemId', self::ADMIN_SETTINGS_FORM_SYSTEM_ID);
		$this -> Viewer_Assign ('sAdminSystemConfigId', self::SYSTEM_CONFIG_ID);
	}
	
	// ---
	
	protected function GetConfigSettings ($sConfigName) {
		// Получить описание настроек из конфига
		$aSettingsInfo = $this -> GetConfigSettingsStructureInfo ($sConfigName);
		
		$aSettingsAll = array ();
		foreach ($aSettingsInfo as $sConfigKey => $aOneParamInfo) {
			// Получить текущее значение параметра
			if (!$mValue = $this -> GetParameterValue ($sConfigName, $sConfigKey)) {
	      $this -> Message_AddError (
					$this -> Lang_Get ('plugin.admin.Errors.Wrong_Description_Key', array ('key' => $sConfigKey)),
					$this -> Lang_Get ('error')
				);
	      continue;
			}
			
			// Получить текстовки имени и описания параметра из ключей
			$this -> ExpandLangs ($sConfigName, $aOneParamInfo);
			
			// Собрать данные параметра и получить сущность параметра
			$aParamData = array_merge ($aOneParamInfo, array (
				'key' => $sConfigKey,
				'value' => $mValue
			));
			$aSettingsAll [] = Engine::GetEntity ('PluginAdmin_ModuleSettings_EntitySettings', $aParamData);
		}
		
		return $aSettingsAll;
	}
	
	// ---
	
	private function ExpandLangs ($sConfigName, &$aParam, $aKeys = array ('name', 'description')) {
		foreach ($aKeys as $sNamesToExtend) {
			$aParam [$sNamesToExtend] = $this -> Lang_Get ($this -> GetRealFullKey ($sConfigName) . $aParam [$sNamesToExtend]);
		}
		return true;
	}
	
	// ---
	
	private function GetRealFullKey ($sConfigName, $bAddDot = true) {
		return $sConfigName == self::SYSTEM_CONFIG_ID ? '' : 'plugin.' . $sConfigName . ($bAddDot ? '.' : '');
	}
	
	// ---
	
	private function GetConfigSettingsStructureInfo ($sConfigName) {
    $aData = Config::Get ($this -> GetRealFullKey ($sConfigName) . self::ADMIN_INTERFACE_DESCRIPTION_CONFIG_KEY);
		return $aData ? $aData : array ();
	}
	
	// ---
	
	private function GetParameterValue ($sConfigName, $sConfigKey) {
		return Config::Get ($this -> GetRealFullKey ($sConfigName) . $sConfigKey);
	}
	
  // ---
  
  private function CheckIfThisPluginIsActive ($sConfigName) {
    return in_array ($sConfigName, array_keys (Engine::getInstance () -> GetPlugins ()));
  }
	
	// ---
	
	//
	// Сохранить настройки
	//
	
	public function EventSaveConfig () {
		$this -> Security_ValidateSendForm ();
		//print_r($_POST);die();	// todo: delete
		
		if (isPost ('submit_save_settings')) {
	    // Корректно ли имя конфига
			if (!$sConfigName = $this -> getParam (0) or !is_string ($sConfigName)) {
	      $this -> Message_AddError ($this -> Lang_Get ('plugin.admin.Errors.Wrong_Config_Name'), $this -> Lang_Get ('error'));
	      return false;
			}
			
			// Получение всех параметров, их валидация и сверка с описанием структуры и запись в отдельную инстанцию конфига
			$this -> ParsePOSTDataIntoSeparateConfigInstance ($sConfigName);
			
			// Сохранить все настройки плагина в БД
			$this -> PluginAdmin_Settings_SaveConfig ($sConfigName, $this -> GetKeysData ($sConfigName));
		}
		
    $this -> Message_AddNotice ('Ok');
		return Router::Action ('admin', 'settings');
	}
	
	// ---
	
	private function ParsePOSTDataIntoSeparateConfigInstance ($sConfigName) {
		// Получить описание настроек из конфига
		$aSettingsInfo = $this -> GetConfigSettingsStructureInfo ($sConfigName);
		foreach ($_POST as $aPostRawData) {
			// Проверка это ли параметр настроек формы
			if (is_array ($aPostRawData) and count ($aPostRawData) == 4 and $aPostRawData [0] == self::ADMIN_SETTINGS_FORM_SYSTEM_ID) {
				$sKey = $aPostRawData [1];
				$mValue = $aPostRawData [3];
				// Если существует запись в конфиге о таком параметре, который был передан
				if (array_key_exists ($sKey, $aSettingsInfo)) {
					$aParamInfo = $aSettingsInfo [$sKey];
					if (!$this -> ValidateParameter ($aParamInfo ['validator'], $mValue)) {
			      $this -> Message_AddError (
							$this -> Lang_Get ('plugin.admin.Errors.Wrong_Parameter_Value', array ('key' => $sKey)),
							$this -> Lang_Get ('error')
						);
			      return false;		// todo: review: return false or continue if wrong value for one parameter is set?
					}
					// Сохранить значение ключа
					$this -> SaveKeyValue ($sConfigName, $sKey, $mValue);
				} else {
		      $this -> Message_AddError (
						$this -> Lang_Get ('plugin.admin.Errors.Unknown_Parameter', array ('key' => $sKey)),
						$this -> Lang_Get ('error')
					);
				}
			}
		}
	}
	
	// ---
	
	private function SaveKeyValue ($sConfigName, $sKey, $mValue) {
		// Сохранить значение ключа в отдельной области видимости для дальнейшего получения списка настроек
		// Это очень удобно делать через отдельную инстанцию конфига - не нужно разбирать вручную ключи
		Config::Set ($this -> GetRealFullKey ($sConfigName) . $sKey, $mValue, self::ADMIN_TEMP_CONFIG_INSTANCE);
	}
	
	// ---
	
	private function GetKeysData ($sConfigName) {
		// Все параметры из формы сохранены в отдельной инстанции конфига
		return Config::Get ($this -> GetRealFullKey ($sConfigName, false), self::ADMIN_TEMP_CONFIG_INSTANCE)
	}
	
	// ---
	
	private function ValidateParameter ($aValidatorInfo, $mValue) {
		return $this -> Validate_Validate ($aValidatorInfo ['type'], $mValue, $aValidatorInfo ['params']);
	}

}

?>