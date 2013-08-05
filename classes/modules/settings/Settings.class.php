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
 *	Модуль для работы с настройками
 */

class PluginAdmin_ModuleSettings extends ModuleStorage {

	/*
	 * Ключ конфига, который хранит описатели настроек каждого конфига
	 */
	const CONFIG_SCHEME_KEY = '$config_scheme$';

	/*
	 * Имя параметра для плагина или ядра для сохранения конфига в хранилище
	 */
	const CONFIG_DATA_PARAM_NAME = '__config__';

	/*
	 * Скрытый системный идентификатор данных о настройках из формы (для проверки что данный набор данных - параметр настроек)
	 */
	const ADMIN_SETTINGS_FORM_SYSTEM_ID = 'LS-Admin';

	/*
	 * До момента сохранения настроек в БД они будут хранится в этой инстанции конфига
	 */
	const ADMIN_TEMP_CONFIG_INSTANCE = 'temporary_instance';


	/*
	 * индекс массива с подписью параметра
	 */
	const POST_RAW_DATA_ARRAY_SIGNATURE = 0;

	/*
	 * индекс массива с ключем параметра
	 */
	const POST_RAW_DATA_ARRAY_KEY = 1;

	/*
	 * индекс массива с данными параметра (от этого номера и до конца массива)
	 */
	const POST_RAW_DATA_ARRAY_VALUE_FIRST = 2;

	/*
	 * путь к схеме и языковым файлам главного конфига относительно корня папки плагина
	 */
	const PATH_TO_ROOT_CONFIG_SCHEME = 'config/root_config/';
	

	public function Init() {
		parent::Init();
	}


	/**
	 * Сохранить конфиг ключа
	 *
	 * @param $sConfigName		имя конфига
	 * @param $mData			данные
	 * @param $sInstance		инстанция хранилища
	 * @return mixed
	 */
	public function SaveConfigData($sConfigName, $mData, $sInstance = self::DEFAULT_INSTANCE) {
		$sKey = $this->GetCorrectStorageKey($sConfigName);
		return $this->SetOneParam($sKey, self::CONFIG_DATA_PARAM_NAME, $mData, $sInstance);
	}


	/**
	 * Начать загрузку всех конфигов в системе
	 */
	public function AutoLoadConfigs() {
		$aData = $this->GetFieldsAll();
		if ($aData ['count']) {
			foreach($aData ['collection'] as $aFieldData) {
				$this->LoadConfig($aFieldData ['key']);
			}
		}
	}


	/**
	 * Загрузить конфиг ключа
	 *
	 * @param $sKey		ключ
	 */
	private function LoadConfig($sKey) {
		/*
		 * Получить конфиг текущего ключа (если существует)
		 */
		if ($aConfigData = $this->GetOneParam($sKey, self::CONFIG_DATA_PARAM_NAME)) {
			if ($sKey == ModuleStorage::DEFAULT_KEY_NAME) {
				/*
				 * ядро
				 */
				$this->LoadRootConfig($aConfigData);
			} else {
				/*
				 * плагин
				 */
				$this->LoadPluginConfig($this->StripPluginPrefix($sKey), $aConfigData);
			}
		}
	}


	/**
	 * Удалить префикс перед именем плагина
	 *
	 * @param $sKey		ключ
	 * @return mixed	ключ без префикса
	 */
	private function StripPluginPrefix($sKey) {
		return str_replace(ModuleStorage::PLUGIN_PREFIX, '', $sKey);
	}


	/**
	 * Загрузить конфиг ядра
	 *
	 * @param $mValue	данные (конфиг)
	 */
	private function LoadRootConfig($mValue) {
		/*
		 * Загрузить настройки обьеденив их с существующими(из конфига)
		 */
		Config::getInstance()->SetConfig($mValue, false);
	}


	/**
	 * Загрузить конфиг плагина
	 *
	 * @param $sPluginName				имя плагина
	 * @param $aSavedSettingsFromDB		данные (конфиг)
	 * @return bool
	 */
	private function LoadPluginConfig($sPluginName, $aSavedSettingsFromDB) {
		$aOriginalSettingsFromConfig = Config::Get('plugin.' . $sPluginName);

		/*
		 * Проверка активирован ли плагин
		 * Если плагин активирован и есть его данные из хранилища, то его текущий конфиг из файла php не будет пустым
		 * Данное решение намного быстрее чем получать список плагинов
		 */
		if (is_null($aOriginalSettingsFromConfig)) return false;

		/*
		 * Применить настройки, обьеденив их с существующими
		 */
		$aMixedSettings = array_merge($aOriginalSettingsFromConfig, $aSavedSettingsFromDB);
		Config::Set('plugin.' . $sPluginName, $aMixedSettings);
	}
	
	
	/*
	 *	Хелперы
	 */


	/**
	 * Проверка активирован ли плагин
	 *
	 * @param $sConfigName		имя плагина
	 * @return bool
	 */
	public function CheckPluginNameIsActive($sConfigName) {
		return array_key_exists($sConfigName, Engine::getInstance()->GetPlugins());
	}


	/**
	 * Получить текущее значение из конфига, учитывая имя конфига
	 *
	 * @param $sConfigName			имя конфига (имя плагина или ядра)
	 * @param $sConfigKey			ключ конфига
	 * @return mixed				значение
	 */
	protected function GetConfigKeyValue($sConfigName, $sConfigKey) {
		return Config::Get($this->GetRealFullKey($sConfigName) . $sConfigKey);
	}


	/**
	 * Получить полное название ключа по имени конфига (имя плагина или ядра),
	 * вернет для плагинов префикс "plugin.имяплагина." или пустое значение для ядра (без префикса)
	 *
	 * @param      $sConfigName		имя конфига
	 * @param bool $bAddDot			добавлять ли точку в конце (удобно для получения всего конфига)
	 * @return string				полное представление ключа
	 */
	protected function GetRealFullKey($sConfigName, $bAddDot = true) {
		return $sConfigName == ModuleStorage::DEFAULT_KEY_NAME ? '' : 'plugin.' . $sConfigName .($bAddDot ? '.' : '');
	}


	/**
	 * Превратить ключи языковых констант в текст из языкового файла, на который они указывают
	 * На основе имени конфига
	 *
	 * @param       $sConfigName	имя конфига
	 * @param       $aParam			параметр в котором указаны ключи текстовок для данного имени конфига
	 * @param array $aKeys			ключи, которые нужно заполнить текстовками
	 * @return mixed				параметр с текстовками вместо ключей, указывающих на них
	 */
	protected function ConvertLangKeysToTexts($sConfigName, $aParam, $aKeys = array('name', 'description')) {
		foreach($aKeys as $sNamesToExtend) {
			if (!isset($aParam [$sNamesToExtend]) or empty($aParam [$sNamesToExtend])) continue;
			$aParam [$sNamesToExtend] = $this->Lang_Get($this->GetRealFullKey($sConfigName) . $aParam [$sNamesToExtend]);
		}
		return $aParam;
	}


	/**
	 * Получить описание схемы конфига для имени конфига
	 *
	 * @param $sConfigName			имя конфига
	 * @return array|mixed			массив с описанием структуры
	 */
	protected function GetConfigSettingsSchemeInfo($sConfigName) {
		$aData = $this->GetConfigKeyValue($sConfigName, self::CONFIG_SCHEME_KEY);
		return $aData ? $aData : array();
	}


	/**
	 * Проводит валидацию значения параметра (используется валидатор движка)
	 *
	 * @param $aValidatorInfo		данные для валидатора
	 * @param $mValue				значение, которое нужно проверит
	 * @return bool					результат проверки
	 */
	protected function ValidateParameter($aValidatorInfo, $mValue) {
		if (!isset($aValidatorInfo ['type'])) return true;
		return $this->Validate_Validate(
			$aValidatorInfo ['type'],
			$mValue,
			isset($aValidatorInfo ['params']) ? $aValidatorInfo ['params'] : array()
		);
	}


	/**
	 * Получить последнюю ошибку валидатора
	 *
	 * @return mixed				текст ошибки
	 */
	protected function ValidatorGetLastError() {
		return $this->Validate_GetErrorLast(true);
	}


	/**
	 * Получение обьектов информации о настройках конфига
	 *
	 * @param       $sConfigName				имя конфига
	 * @param array $aOnlyThisKeysAllowed		список разрешенных ключей для показа из этого конфига
	 * @param array $aExcludeKeys				список запрещенных ключей для показа из этого конфига
	 * @return array							настройки конфига
	 */
	public function GetConfigSettings($sConfigName, $aOnlyThisKeysAllowed = array(), $aExcludeKeys = array()) {
		/*
		 * Получить описание настроек из конфига
		 */
		$aSettingsInfo = $this->GetConfigSettingsSchemeInfo($sConfigName);
		
		$aSettingsAll = array();
		foreach($aSettingsInfo as $sConfigKey => $aOneParamInfo) {
			/*
			 * Получить только нужные ключи
			 */
			if (!empty($aOnlyThisKeysAllowed) and !$this->CheckIfThisKeyInArray($sConfigKey, $aOnlyThisKeysAllowed)) continue;
			
			/*
			 * Исключить не нужные ключи
			 */
			if (!empty($aExcludeKeys) and $this->CheckIfThisKeyInArray($sConfigKey, $aExcludeKeys)) continue;
			
			/*
			 * Получить текущее значение параметра
			 */
			if (($mValue = $this->GetConfigKeyValue($sConfigName, $sConfigKey)) === null) {
				$this->Message_AddError(
					$this->Lang_Get('plugin.admin.errors.wrong_description_key', array('key' => $sConfigKey)),
					$this->Lang_Get('error')
				);
				continue;
			}
			
			/*
			 * Получить текстовки имени и описания параметра из ключей, указывающих на языковый файл
			 */
			$aOneParamInfo = $this->ConvertLangKeysToTexts($sConfigName, $aOneParamInfo);
			
			/*
			 * Собрать данные параметра и получить сущность
			 */
			$aParamData = array_merge($aOneParamInfo, array('key' => $sConfigKey, 'value' => $mValue));
			$aSettingsAll [$sConfigKey] = Engine::GetEntity('PluginAdmin_Settings', $aParamData);
		}
		return $aSettingsAll;
	}


	/**
	 * Сравнение начала ключей из массива с текущим ключем, в списке ключей массива можно использовать первые символы ключей
	 *
	 * @param $sCurrentKey				текущий ключ (в виде ключ1.ключ2.ключ3...)
	 * @param $aOnlyThisKeysAllowed		список разрешенных ключей
	 * @return bool						результат проверки
	 */
	private function CheckIfThisKeyInArray($sCurrentKey, $aOnlyThisKeysAllowed) {
		if (empty($aOnlyThisKeysAllowed)) return false;
		foreach($aOnlyThisKeysAllowed as $sKey) {
			if (substr_compare($sKey, $sCurrentKey, 0, strlen($sKey), true) === 0) return true;
		}
		return false;
	}


	/**
	 * Весь процесс получения настроек из формы
	 *
	 * @param $sConfigName				имя конфига
	 * @return bool
	 */
	public function ParsePOSTDataIntoSeparateConfigInstance($sConfigName) {
		$bResult = true;
		/*
		 * Получить описание настроек из конфига
		 */
		$aSettingsInfo = $this->GetConfigSettings($sConfigName);
		foreach($_POST as $aPostRawData) {
			/*
			 * Проверка это ли параметр настроек формы
			 */
			if (is_array($aPostRawData) and $aPostRawData [self::POST_RAW_DATA_ARRAY_SIGNATURE] == self::ADMIN_SETTINGS_FORM_SYSTEM_ID) {
				/*
				 * Структура принимаемых данных - массив с значениями по ключам:
				 *
				 *
				 * [self::POST_RAW_DATA_ARRAY_SIGNATURE] - идентификатор приналежности значения к параметрам
				 * (всегда должен быть self::ADMIN_SETTINGS_FORM_SYSTEM_ID)
				 * [self::POST_RAW_DATA_ARRAY_KEY] - ключ параметра(как прописан в конфиге)
				 * [self::POST_RAW_DATA_ARRAY_VALUE_FIRST] - значение параметра из формы
				 * [n] - n-е значение из формы(для типа "массив" улучшеного отображения)
				 */
				$sKey = $aPostRawData [self::POST_RAW_DATA_ARRAY_KEY];
				/*
				 * Если существует запись в конфиге о таком параметре, который был передан
				 */
				if ($sKey and array_key_exists($sKey, $aSettingsInfo)) {
					$oParamInfo = $aSettingsInfo [$sKey];
					
					/*
					 * получить значение данного параметра на основе данных о нем
					 */
					$mValue = $this->GetFormParameterValue($aPostRawData, $oParamInfo);
					
					/*
					 * Валидация параметра
					 */
					if ($oParamInfo->getValidator() and !$this->ValidateParameter($oParamInfo->getValidator(), $mValue)) {
						$this->Message_AddOneParamError(
							$this->Lang_Get('plugin.admin.errors.wrong_parameter_value', array('key' => $sKey)) . $this->ValidatorGetLastError(),
							$sKey
						);
						$bResult = false;
						/*
						 * продолжить если неверное значение указано для одного параметра
						 * чтобы получить список всех ошибок
						 */
						continue;
					}
					/*
					 * Проверить текущее значение и предыдущее, вызов событий
					 */
					if (($mResult = $this->FireEvents($sConfigName, $sKey, $mValue, $oParamInfo)) !== true) {
						$this->Message_AddOneParamError(
							$this->Lang_Get('plugin.admin.errors.disallowed_parameter_value', array('key' => $sKey)) . $mResult,
							$sKey
						);
						$bResult = false;
						/*
						 * продолжить, если вызванное событие подписчика на изменение запретило (забраковало) данное значение
						 * чтобы собрать все ошибки
						 */
						continue;
					}
					/*
					 * Сохранить значение ключа во временной инстанции конфига
					 */
					$this->SaveKeyValue($sConfigName, $sKey, $mValue);
				} else {
					$this->Message_AddOneParamError(
						$this->Lang_Get('plugin.admin.errors.unknown_parameter', array('key' => $sKey)),
						$sKey
					);
					$bResult = false;
				}
			}
		}
		return $bResult;
	}


	/**
	 * Получить данные параметра из формы
	 *
	 * @param $aPostRawData		значение одного параметра из пост данных
	 * @param $oParamInfo		описание структуры парамера из конфига
	 * @return mixed			значение параметра
	 * @throws Exception		если данные для параметра не были отправлены формой
	 */
	private function GetFormParameterValue($aPostRawData, $oParamInfo) {
		$mValue = null;
		switch($oParamInfo->getType()) {
			case 'array':
				/*
				 * для массива у которого особый вид отображения, нужно собрать значения
				 */
				if ($oParamInfo->getNeedToShowSpecialArrayForm()) {
					$mValue = array();
					/*
					 * собрать значения
					 */
					for($i = self::POST_RAW_DATA_ARRAY_VALUE_FIRST; $i < count($aPostRawData); $i ++) {
						$mValue [] = $aPostRawData [$i];
					}
					break;
				}
				/*
				 * для стандартного отображения массива в виде php array логика не меняется - получение идентично как и для других типов данных
				 */
			default:
				if (!isset($aPostRawData [self::POST_RAW_DATA_ARRAY_VALUE_FIRST])) {
					throw new Exception('Admin: error: value was not sent by request, raw post data: ' . print_r($aPostRawData, true));
				}
				$mValue = $aPostRawData [self::POST_RAW_DATA_ARRAY_VALUE_FIRST];
				break;
		}
		return $mValue;
	}


	/**
	 * Сохранение данных одного ключа в временной инстанции конфига
	 *
	 * @param $sConfigName		имя конфига
	 * @param $sKey				ключ
	 * @param $mValue			значение
	 */
	private function SaveKeyValue($sConfigName, $sKey, $mValue) {
		/*
		 * Сохранить значение ключа в отдельной области видимости для дальнейшего получения списка настроек
		 * Это очень удобно делать через отдельную инстанцию конфига - не нужно разбирать вручную ключи
		 */
		Config::Set($this->GetRealFullKey($sConfigName) . $sKey, $mValue, self::ADMIN_TEMP_CONFIG_INSTANCE);
	}


	/**
	 * Получение всех данных ранее сохраненных ключей из временной инстанции
	 *
	 * @param $sConfigName		имя конфига
	 * @return array			массив данных
	 */
	private function GetKeysData($sConfigName) {
		/*
		 * Все параметры из формы сохранены в отдельной инстанции конфига
		 */
		return Config::Get($this->GetRealFullKey($sConfigName, false), self::ADMIN_TEMP_CONFIG_INSTANCE);
	}


	/**
	 * Сохранить полученные настройки из кастомной инстанции конфига в хранилище
	 *
	 * @param      $sConfigName			имя конфига
	 * @param null $aData				ручное указание данных, вместо получения их временной инстанции конфига
	 * @return mixed
	 */
	public function SaveConfigByKey($sConfigName, $aData = null) {
		if (is_null($aData)) {
			/*
			 * получить данные, которые были сохранены во временной инстанции конфига после их парсинга и анализа
			 */
			$aData = $this->GetKeysData($sConfigName);
		}
		/*
		 * получить ранее сохраненные данные, если есть
		 */
		if ($aConfigOldData = $this->GetOneParam($this->GetCorrectStorageKey($sConfigName), self::CONFIG_DATA_PARAM_NAME)) {
			/*
			 * обьеденить сохраненные ранее настройки с новыми
			 * это необходимо если настройки разбиты на группы и показываются в разных разделах частями(например, настройки ядра)
			 */
			$aData = array_merge_recursive_distinct($aConfigOldData, $aData);							// dont use "array_merge_recursive"
		}
		return $this->SaveConfigData($sConfigName, $aData);
	}


	/**
	 * Получить корректное имя ключа для сохранения в хранилище.
	 * Для системного конфига название - ModuleStorage::DEFAULT_KEY_NAME.
	 * Если же это плагин, то к его имени должен быть добавлен префикс ModuleStorage::PLUGIN_PREFIX
	 *
	 * @param $sConfigName		имя конфига
	 * @return string			ключ
	 */
	protected function GetCorrectStorageKey($sConfigName) {
		if ($sConfigName == ModuleStorage::DEFAULT_KEY_NAME) {
			return ModuleStorage::DEFAULT_KEY_NAME;
		}
		return ModuleStorage::PLUGIN_PREFIX . $sConfigName;
	}


	/**
	 * Cохранения ключей конфига плагина и последующей их автозагрузки как части конфига
	 *
	 * @param array $aKeysToSave		ключи из конфига плагина, данные которых нужно сохранить
	 * @param       $sCallerName		имя плагина
	 * @param       $sInstance			инстанция хранилища
	 * @return mixed
	 */
	public function SavePluginConfig($aKeysToSave = array(), $sCallerName, $sInstance = self::DEFAULT_INSTANCE) {
		/*
		 * Получить сохраненный конфиг из хранилища
		 */
		$aConfigData = array();
		if ($aConfigDataOld = $this->GetOneParam($sCallerName, self::CONFIG_DATA_PARAM_NAME, $sInstance)) {
			$aConfigData = $aConfigDataOld;
		}
		$sKey = $this->StripPluginPrefix($sCallerName);
		
		/*
		 * Получить текущие данные конфига по ключам
		 */
		$aDataToSave = array();
		foreach($aKeysToSave as $sConfigKey) {
			if (($mValue = $this->GetConfigKeyValue($sKey, $sConfigKey)) === null) {
				/*
				 * Значение удалили, значит нужно удалить и из хранилища вместо добавления
				 */
				unset($aConfigData [$sConfigKey]);
				continue;
			}
			$aDataToSave [$sConfigKey] = $mValue;
		}
		/*
		 * Обьеденить и записать данные
		 */
		return $this->SaveConfigData($sKey, array_merge($aConfigData, $aDataToSave), $sInstance);
	}
	
	
	/*
	 *
	 *	--- Функции работы с описанием главного конфига ---
	 *
	 */


	/**
	 * Получить путь к схеме главного конфига движка
	 *
	 * @return string
	 */
	protected function GetRootConfigSchemePath() {
		return Plugin::GetPath(__CLASS__) . self::PATH_TO_ROOT_CONFIG_SCHEME;
	}


	/**
	 * Путь к языковым файлам, в которых храняться текстовки описания настроек главного конфига движка
	 *
	 * @param $sFileName		имя языкового файла (совпадает с языком движка)
	 * @return string
	 */
	protected function GetRootConfigLanguge($sFileName) {
		return $this->GetRootConfigSchemePath() . Config::Get('lang.dir') . '/' . $sFileName . '.php';
	}


	/**
	 * Добавить к главному конфигу движка схему его настроек, которая находится внутри плагина админки
	 *
	 * @throws Exception
	 */
	protected function AddConfigSchemeToRootConfig() {
		$sPathRootConfigScheme = $this->GetRootConfigSchemePath() . 'scheme.php';
		if (!is_readable($sPathRootConfigScheme)) {
			throw new Exception('Admin: error: can`t read root config scheme "' . $sPathRootConfigScheme . '". Check rights for this file.');
		}
		
		$aRootConfigScheme = require_once($sPathRootConfigScheme);
		if (!is_array($aRootConfigScheme)) {
			throw new Exception('Admin: error: scheme of root config is not an array. Last error: ' . print_r(error_get_last(), true));
		}
		
		Config::Set('$config_scheme$', $aRootConfigScheme);
	}


	/**
	 * Добавить к главному конфигу движка описание его настроек, которое находится внутри плагина админки
	 *
	 * @throws Exception
	 */
	protected function AddConfigLanguageToRootConfig() {
		$sPathRootConfigLang = $this->GetRootConfigLanguge(Config::Get('lang.current'));
		if (!is_readable($sPathRootConfigLang)) {
			$sPathRootConfigLang = $this->GetRootConfigLanguge(Config::Get('lang.default'));
			if (!is_readable($sPathRootConfigLang)) {
				throw new Exception(
					'Admin: error: can`t read root config language file "' . $sPathRootConfigLang . '" (current and default). Check rights for this file.'
				);
			}
		}
		
		$aRootConfigLang = require_once($sPathRootConfigLang);
		if (!is_array($aRootConfigLang)) {
			throw new Exception('Admin: error: language file of root config is not an array. Last error: ' . print_r(error_get_last(), true));
		}
		
		$this->Lang_AddMessages($aRootConfigLang);
	}


	/**
	 * Добавить к главному конфигу движка схему его конфига и описание в языковый файл
	 */
	public function AddSchemeAndLangToRootConfig() {
		$this->AddConfigSchemeToRootConfig();
		$this->AddConfigLanguageToRootConfig();
	}


	/**
	 * Сверка нового значения параметра и предыдущего, оповещение подписчикам о смене
	 *
	 * @param $sConfigName		имя конфига
	 * @param $sKey				ключ
	 * @param $mNewValue		новое значение
	 * @param $oParamInfo		описание параметра из схемы конфига
	 * @return bool				разрешение на установку данного значения для этого ключа
	 */
	protected function FireEvents($sConfigName, $sKey, $mNewValue, $oParamInfo) {
		$mPreviousValue = $oParamInfo->getValue();
		if ($mNewValue != $mPreviousValue) {
			return $this->PluginAdmin_Events_ConfigParameterChangeNotification($sConfigName, $sKey, $mNewValue, $mPreviousValue);
		}
		return true;
	}
	
	
}

?>