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
		Модуль для работы с настройками

		by PSNet
		http://psnet.lookformp3.net
*/

class PluginAdmin_ModuleSettings extends ModuleStorage {
	
	const CONFIG_SCHEMA_KEY = '$config_schema$';					// Ключ конфига, который хранит описатели настроек данного конфига
	const CONFIG_DATA_PARAM_NAME = '__config__';					// Имя параметра для плагина или ядра для сохранения конфига в хранилище
	const SYSTEM_CONFIG_ID = '__root_config__';						// Имя системного конфига
	
	

	public function Init() {
		parent::Init ();
	}
	
	
	/*
	 *	Сохранить конфиг ключа
	 */
	public function SaveConfig ($sConfigName, $mData) {
		if ($sConfigName == self::SYSTEM_CONFIG_ID) {
			$sKey = ModuleStorage::DEFAULT_KEY_NAME;
		} else {
			$sKey = ModuleStorage::PLUGIN_PREFIX . $sConfigName;
		}
		return $this -> SetOneParam ($sKey, self::CONFIG_DATA_PARAM_NAME, $mData);
	}
	
	
	/*
	 *	Начать загрузку всех конфигов в системе
	 */
	public function AutoLoadConfigs () {
		$aData = $this -> GetFieldsAll ();
		if ($aData ['count']) {
			foreach ($aData ['collection'] as $aFieldData) {
				$sKey = $aFieldData ['key'];
				$this -> LoadConfig ($sKey);
			}
		}
	}
	
	
	/*
	 *	Загрузить конфиг ключа
	 */
	private function LoadConfig ($sKey) {
		// Получить конфиг текущего ключа (если существует)
		if ($aConfigData = $this -> GetOneParam ($sKey, self::CONFIG_DATA_PARAM_NAME)) {
			if ($sKey == ModuleStorage::DEFAULT_KEY_NAME) {
				// Данные ядра
				$this -> LoadRootConfig ($aConfigData);
			} else {
				// Данные плагина
				$this -> LoadPluginConfig ($this -> StripPluginPrefix ($sKey), $aConfigData);
			}
		}
	}
	

	/*
	 *	Удалить префикс перед именем плагина
	 */
	private function StripPluginPrefix ($sKey) {
		return str_replace (ModuleStorage::PLUGIN_PREFIX, '', $sKey);
	}
	
	
	/*
	 *	Загрузить конфиг ядра
	 */
	private function LoadRootConfig ($mValue) {
		// Загрузить настройки обьеденив их с существующими (из конфига)
		Config::getInstance () -> SetConfig ($mValue, false);
	}

	

	/*
	 *	Загрузить конфиг плагина
	 */
	private function LoadPluginConfig ($sPluginName, $aSavedSettingsFromDB) {
		$aOriginalSettingsFromConfig = Config::Get ('plugin.' . $sPluginName);

		// Проверка активирован ли плагин
		// Если плагин активирован и есть его данные из хранилища, то его текущий конфиг из файла php не будет пустым
		// Данное решение намного быстрее чем получать список плагинов
		if (is_null ($aOriginalSettingsFromConfig)) return false;

		// Применить настройки, обьеденив их с существующими
		$aMixedSettings = array_merge ($aOriginalSettingsFromConfig, $aSavedSettingsFromDB);
		Config::Set ('plugin.' . $sPluginName, $aMixedSettings);
	}
	
	
	/*
	 * Хелперы
	 */
	 
	
	public function ConvertLangKeysToTexts ($sConfigName, $aParam, $aKeys = array ('name', 'description')) {
		foreach ($aKeys as $sNamesToExtend) {
			$aParam [$sNamesToExtend] = $this -> Lang_Get ($this -> GetRealFullKey ($sConfigName) . $aParam [$sNamesToExtend]);
		}
		return $aParam;
	}
	
	
	public function GetRealFullKey ($sConfigName, $bAddDot = true) {
		return $sConfigName == self::SYSTEM_CONFIG_ID ? '' : 'plugin.' . $sConfigName . ($bAddDot ? '.' : '');
	}
	
	
	public function GetConfigSettingsSchemeInfo ($sConfigName) {
		$aData = Config::Get ($this -> GetRealFullKey ($sConfigName) . PluginAdmin_ModuleSettings::CONFIG_SCHEMA_KEY);
		return $aData ? $aData : array ();
	}
	
	
	public function GetParameterValue ($sConfigName, $sConfigKey) {
		return Config::Get ($this -> GetRealFullKey ($sConfigName) . $sConfigKey);
	}
	
	
	public function CheckIfThisPluginIsActive ($sConfigName) {
		return in_array ($sConfigName, array_keys (Engine::getInstance () -> GetPlugins ()));
	}
	
	
	/*
	 * Принудительное приведение значения к типу, заданному в описании конфига
	 */
	public function SwitchValueToType ($mValue, $sType) {
		switch ($sType) {
			case 'array':
				$mValue = @eval ('return ' . $mValue . ';');
				break;
			case 'integer':
			case 'string':
			case 'boolean':
			case 'float':
				settype ($mValue, $sType);
				break;
			default:
				throw new Exception ('Admin: value parsing error: unknown variable type defined in config`s description');
		}
		return $mValue;
	}
	
	
	/*
	 * Проводит валидацию значения параметра (используется валидатор движка)
	 */
	public function ValidateParameter ($aValidatorInfo, $mValue) {
		if (!isset ($aValidatorInfo ['type'])) return true;
		return $this -> Validate_Validate (
			$aValidatorInfo ['type'],
			$mValue,
			isset ($aValidatorInfo ['params']) ? $aValidatorInfo ['params'] : array ()
		);
	}
	
	
	public function ValidatorGetLastError () {
		return $this -> Validate_GetErrorLast (true);
	}

	
}

?>