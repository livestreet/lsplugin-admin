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
	
	const CONFIG_SCHEME_KEY = '$config_scheme$';							// Ключ конфига, который хранит описатели настроек данного конфига
	const CONFIG_DATA_PARAM_NAME = '__config__';							// Имя параметра для плагина или ядра для сохранения конфига в хранилище

	const ADMIN_SETTINGS_FORM_SYSTEM_ID = 'LS-Admin';					// Скрытый системный идентификатор данных о настройках из формы
	const ADMIN_TEMP_CONFIG_INSTANCE = 'temporary_instance';	// До момента сохранения настроек в БД они будут хранится здесь
	
	const POST_RAW_DATA_ARRAY_SIGNATURE = 0;									// индекс массива с подписью параметра
	const POST_RAW_DATA_ARRAY_KEY = 1;												// индекс массива с ключем параметра
	const POST_RAW_DATA_ARRAY_VALUE_FIRST = 2;								// индекс массива с данными параметра (от этого номера и до конца массива)
	
	const PATH_TO_ROOT_CONFIG_SCHEME = 'config/root_config/';	// путь к схеме и языковым файлам главного конфига относительно корня папки плагина
	

	public function Init() {
		parent::Init ();
	}
	
	
	/*
	 *	Сохранить конфиг ключа
	 */
	public function SaveConfigData ($sConfigName, $mData, $sInstance = self::DEFAULT_INSTANCE) {
		$sKey = $this -> GetCorrectStorageKey ($sConfigName);
		return $this -> SetOneParam ($sKey, self::CONFIG_DATA_PARAM_NAME, $mData, $sInstance);
	}
	
	
	/*
	 *	Начать загрузку всех конфигов в системе
	 */
	public function AutoLoadConfigs () {
		$aData = $this -> GetFieldsAll ();
		if ($aData ['count']) {
			foreach ($aData ['collection'] as $aFieldData) {
				$this -> LoadConfig ($aFieldData ['key']);
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
	 *	Хелперы
	 */
	
	
	public function CheckPluginNameIsActive ($sConfigName) {
		return in_array ($sConfigName, array_keys (Engine::getInstance () -> GetPlugins ()));
	}
	
	
	protected function GetConfigKeyValue ($sConfigName, $sConfigKey) {
		return Config::Get ($this -> GetRealFullKey ($sConfigName) . $sConfigKey);
	}
	
	
	protected function GetRealFullKey ($sConfigName, $bAddDot = true) {
		return $sConfigName == ModuleStorage::DEFAULT_KEY_NAME ? '' : 'plugin.' . $sConfigName . ($bAddDot ? '.' : '');
	}
	
	
	protected function ConvertLangKeysToTexts ($sConfigName, $aParam, $aKeys = array ('name', 'description')) {
		foreach ($aKeys as $sNamesToExtend) {
			if (!isset ($aParam [$sNamesToExtend])) continue;
			$aParam [$sNamesToExtend] = $this -> Lang_Get ($this -> GetRealFullKey ($sConfigName) . $aParam [$sNamesToExtend]);
		}
		return $aParam;
	}
	
	
	protected function GetConfigSettingsSchemeInfo ($sConfigName) {
		$aData = $this -> GetConfigKeyValue ($sConfigName, self::CONFIG_SCHEME_KEY);
		return $aData ? $aData : array ();
	}
	
	
	/*
	 *	Принудительное приведение значения к типу, заданному в описании конфига
	 */
	// deprecated. todo: review: delete
/*	protected function SwitchValueToType ($mValue, $sType) {
		switch ($sType) {
			case 'array':
				if (!is_array ($mValue)) {
					$mValue = @eval ('return ' . $mValue . ';');
				}
				break;
			case 'integer':
			case 'string':
			case 'boolean':
			case 'float':
				settype ($mValue, $sType);
				break;
			default:
				throw new Exception ('Admin: value parsing error: unknown variable type defined in config`s description as "' . $sType . '"');
		}
		return $mValue;
	}*/
	
	
	/*
	 *	Проводит валидацию значения параметра (используется валидатор движка)
	 */
	protected function ValidateParameter ($aValidatorInfo, $mValue) {
		if (!isset ($aValidatorInfo ['type'])) return true;
		return $this -> Validate_Validate (
			$aValidatorInfo ['type'],
			$mValue,
			isset ($aValidatorInfo ['params']) ? $aValidatorInfo ['params'] : array ()
		);
	}
	
	
	protected function ValidatorGetLastError () {
		return $this -> Validate_GetErrorLast (true);
	}
	
	
	/*
	 *	Получение обьектов информации и настройках конфига
	 */
	public function GetConfigSettings ($sConfigName, $aOnlyThisKeysAllowed = array (), $aExcludeKeys = array ()) {
		// Получить описание настроек из конфига
		$aSettingsInfo = $this -> GetConfigSettingsSchemeInfo ($sConfigName);
		
		$aSettingsAll = array ();
		foreach ($aSettingsInfo as $sConfigKey => $aOneParamInfo) {
			// Получить только нужные ключи
			if (!empty ($aOnlyThisKeysAllowed) and !$this -> CheckIfThisKeyInArray ($sConfigKey, $aOnlyThisKeysAllowed)) continue;
			
			// Исключить не нужные ключи
			if (!empty ($aExcludeKeys) and $this -> CheckIfThisKeyInArray ($sConfigKey, $aExcludeKeys)) continue;
			
			// Получить текущее значение параметра
			if (($mValue = $this -> GetConfigKeyValue ($sConfigName, $sConfigKey)) === null) {
				$this -> Message_AddError (
					$this -> Lang_Get ('plugin.admin.Errors.Wrong_Description_Key', array ('key' => $sConfigKey)),
					$this -> Lang_Get ('error')
				);
				continue;
			}
			
			// Получить текстовки имени и описания параметра из ключей
			$aOneParamInfo = $this -> ConvertLangKeysToTexts ($sConfigName, $aOneParamInfo);
			
			// Собрать данные параметра и получить сущность
			$aParamData = array_merge ($aOneParamInfo, array ('key' => $sConfigKey, 'value' => $mValue));
			$aSettingsAll [$sConfigKey] = Engine::GetEntity ('PluginAdmin_Settings', $aParamData);
		}
		return $aSettingsAll;
	}
	
	
	/*
	 *	Сравнение начала ключей из массива с текущим ключем, в списке ключей массива можно использовать первые символы ключей
	 */
	private function CheckIfThisKeyInArray ($sCurrentKey, $aOnlyThisKeysAllowed) {
		if (empty ($aOnlyThisKeysAllowed)) return false;
		foreach ($aOnlyThisKeysAllowed as $sKey) {
			if (substr_compare ($sKey, $sCurrentKey, 0, strlen ($sKey), true) === 0) return true;
		}
		return false;
	}
	
	
	/*
	 *	Весь процесс получения настроек из формы
	 */
	public function ParsePOSTDataIntoSeparateConfigInstance ($sConfigName) {
		$bResult = true;
		// Получить описание настроек из конфига
		$aSettingsInfo = $this -> GetConfigSettings ($sConfigName);
		foreach ($_POST as $aPostRawData) {
			// Проверка это ли параметр настроек формы
			if (is_array ($aPostRawData) and $aPostRawData [self::POST_RAW_DATA_ARRAY_SIGNATURE] == self::ADMIN_SETTINGS_FORM_SYSTEM_ID) {
				//
				// Структура принимаемых данных - массив с значениями по ключам:
				//
				// [self::POST_RAW_DATA_ARRAY_SIGNATURE] - идентификатор приналежности значения к параметрам
				//		(всегда должен быть self::ADMIN_SETTINGS_FORM_SYSTEM_ID)
				// [self::POST_RAW_DATA_ARRAY_KEY] - ключ параметра (как прописан в конфиге)
				// [self::POST_RAW_DATA_ARRAY_VALUE_FIRST] - значение параметра из формы
				// [n] - n-е значение из формы (для типа "массив" улучшеного отображения)
				//
				$sKey = $aPostRawData [self::POST_RAW_DATA_ARRAY_KEY];
				// Если существует запись в конфиге о таком параметре, который был передан
				if ($sKey and array_key_exists ($sKey, $aSettingsInfo)) {
					$oParamInfo = $aSettingsInfo [$sKey];
					
					// получить значение данного параметра на основе данных о нем
					$mValue = $this -> GetFormParameterValue ($aPostRawData, $oParamInfo);
					
					// Приведение значения к нужному типу
					//$mValue = $this -> SwitchValueToType ($mValue, $oParamInfo -> getType ());		// todo: review: delete
					
					// Валидация параметра
					if ($oParamInfo -> getValidator () and !$this -> ValidateParameter ($oParamInfo -> getValidator (), $mValue)) {
						$this -> Message_AddOneParamError (
							$this -> Lang_Get ('plugin.admin.Errors.Wrong_Parameter_Value', array ('key' => $sKey)) . $this -> ValidatorGetLastError (),
							$sKey
						);
						$bResult = false;
						continue;																					// continue if wrong value for one parameter is set
					}
					// Сохранить значение ключа
					$this -> SaveKeyValue ($sConfigName, $sKey, $mValue);
				} else {
					$this -> Message_AddOneParamError (
						$this -> Lang_Get ('plugin.admin.Errors.Unknown_Parameter', array ('key' => $sKey)),
						$sKey
					);
					$bResult = false;
				}
			}
		}
		return $bResult;
	}
	
	
	/*
	 *	Получить данные параметра из формы
	 */
	private function GetFormParameterValue ($aPostRawData, $oParamInfo) {
		$mValue = null;
		switch ($oParamInfo -> getType ()) {
			case 'array':
				// для массива у которого особый вид отображения, нужно собрать значения
				if ($oParamInfo -> getNeedToShowSpecialArrayForm ()) {
					$mValue = array ();
					// собрать значения
					for ($i = self::POST_RAW_DATA_ARRAY_VALUE_FIRST; $i < count ($aPostRawData); $i ++) {
						$mValue [] = $aPostRawData [$i];
					}
					break;
				}
				// для стандартного отображения массива в виде php array логика не меняется - получение идентично как и для других типов данных
			default:
				$mValue = $aPostRawData [self::POST_RAW_DATA_ARRAY_VALUE_FIRST];
				break;
		}
		return $mValue;
	}
	
	
	/*
	 *	Сохранение данных одного ключа в временной инстанции конфига
	 */
	private function SaveKeyValue ($sConfigName, $sKey, $mValue) {
		// Сохранить значение ключа в отдельной области видимости для дальнейшего получения списка настроек
		// Это очень удобно делать через отдельную инстанцию конфига - не нужно разбирать вручную ключи
		Config::Set ($this -> GetRealFullKey ($sConfigName) . $sKey, $mValue, self::ADMIN_TEMP_CONFIG_INSTANCE);
	}
	
	
	/*
	 *	Получение всех данных ранее сохраненных ключей из временной инстанции
	 */
	private function GetKeysData ($sConfigName) {
		// Все параметры из формы сохранены в отдельной инстанции конфига
		return Config::Get ($this -> GetRealFullKey ($sConfigName, false), self::ADMIN_TEMP_CONFIG_INSTANCE);
	}
	
	
	/*
	 *	Сохранить полученные настройки из кастомной инстанции конфига в хранилище
	 */
	public function SaveConfigByKey ($sConfigName) {
		// получить данные, которые были сохранены во временной инстанции конфига после их парсинга и анализа
		$aData = $this -> GetKeysData ($sConfigName);
		// получить ранее сохраненные данные, если есть
		if ($aConfigOldData = $this -> GetOneParam ($this -> GetCorrectStorageKey ($sConfigName), self::CONFIG_DATA_PARAM_NAME)) {
			// обьеденить сохраненные ранее настройки с новыми
			// это необходимо если настройки разбиты на группы и показываются в разных разделах частями (например, настройки ядра)
			$aData = array_merge ($aConfigOldData, $aData);
		}
		return $this -> SaveConfigData ($sConfigName, $aData);
	}
	
	
	/*
	 *	Получить корректное имя ключа для сохранения в хранилище
	 *	Для системного конфига название - ModuleStorage::DEFAULT_KEY_NAME.
	 *	Если же это плагин, то к его имени должен быть добавлен префикс ModuleStorage::PLUGIN_PREFIX
	 */
	protected function GetCorrectStorageKey ($sConfigName) {
		if ($sConfigName == ModuleStorage::DEFAULT_KEY_NAME) {
			return ModuleStorage::DEFAULT_KEY_NAME;
		}
		return ModuleStorage::PLUGIN_PREFIX . $sConfigName;
	}
	
	
	/*
	 *	Cохранения ключей конфига плагина и последующей их автозагрузки как части конфига
	 */
	public function SavePluginConfig ($aKeysToSave = array (), $sCallerName, $sInstance = self::DEFAULT_INSTANCE) {
		// Получить сохраненный конфиг из хранилища
		$aConfigData = array ();
		if ($aConfigDataOld = $this -> GetOneParam ($sCallerName, self::CONFIG_DATA_PARAM_NAME, $sInstance)) {
			$aConfigData = $aConfigDataOld;
		}
		$sKey = $this -> StripPluginPrefix ($sCallerName);
		
		// Получить текущие данные конфига по ключам
		$aDataToSave = array ();
		foreach ($aKeysToSave as $sConfigKey) {
			if (($mValue = $this -> GetConfigKeyValue ($sKey, $sConfigKey)) === null) {
				// Значение удалили, значит нужно удалить и из хранилища вместо добавления
				unset ($aConfigData [$sConfigKey]);
				continue;
			}
			$aDataToSave [$sConfigKey] = $mValue;
		}
		// Обьеденить и записать данные
		return $this -> SaveConfigData ($sKey, array_merge ($aConfigData, $aDataToSave), $sInstance);
	}
	
	
	/*
	 *	--- Функции работы с описанием главного конфига ---
	 */
	
	protected function GetRootConfigSchemePath () {
		return Plugin::GetPath (__CLASS__) . self::PATH_TO_ROOT_CONFIG_SCHEME;
	}
	
	
	protected function GetRootConfigLanguge ($sFileName) {
		return $this -> GetRootConfigSchemePath () . 'language/' . $sFileName . '.php';
	}
	
	
	/*
	 *	Добавить к главному конфигу движка схему его настроек, которая находится внутри плагина админки
	 */
	protected function AddConfigSchemeToRootConfig () {
		$sPathRootConfigScheme = $this -> GetRootConfigSchemePath () . 'scheme.php';
		if (!is_readable ($sPathRootConfigScheme)) {
			throw new Exception ('Admin: error: can`t read root config scheme "' . $sPathRootConfigScheme . '". Check rights for this file.');
		}
		
		$aRootConfigScheme = require_once ($sPathRootConfigScheme);
		if (!is_array ($aRootConfigScheme)) {
			throw new Exception ('Admin: error: scheme of root config is not an array. Last error: ' . print_r (error_get_last (), true));
		}
		
		Config::Set ('$config_scheme$', $aRootConfigScheme);
	}
	
	
	/*
	 *	Добавить к главному конфигу движка описание его настроек, которое находится внутри плагина админки
	 */
	protected function AddConfigLanguageToRootConfig () {
		$sPathRootConfigLang = $this -> GetRootConfigLanguge (Config::Get ('lang.current'));
		if (!is_readable ($sPathRootConfigLang)) {
			$sPathRootConfigLang = $this -> GetRootConfigLanguge (Config::Get ('lang.default'));
			if (!is_readable ($sPathRootConfigLang)) {
				throw new Exception (
					'Admin: error: can`t read root config language file "' . $sPathRootConfigLang . '" (current and default). Check rights for this file.'
				);
			}
		}
		
		$aRootConfigLang = require_once ($sPathRootConfigLang);
		if (!is_array ($aRootConfigLang)) {
			throw new Exception ('Admin: error: language file of root config is not an array. Last error: ' . print_r (error_get_last (), true));
		}
		
		$this -> Lang_AddMessages ($aRootConfigLang);
	}
	
	
	/*
	 *	Добавить к главному конфигу движка схему его конфига и описание в языковый файл
	 */
	public function AddSchemeAndLangToRootConfig () {
		$this -> AddConfigSchemeToRootConfig ();
		$this -> AddConfigLanguageToRootConfig ();
	}
	
	
}

?>