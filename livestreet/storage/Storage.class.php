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
		Хранилище "ключ=значение"
		Позволяет легко и быстро работать с небольшими обьемами данных,
		CRUD операции с которыми теперь занимают всего одну строку кода.
		
		Например:
			$this -> Storage_Set ('keyname', 'some_mixed_value', $this);	// сохранить 'some_mixed_value' под имененем 'keyname' для вашего плагина
			$this -> Storage_Get ('keyname', $this);											// получить данные по ключу 'keyname' для вашего плагина
		
		by PSNet
		http://psnet.lookformp3.net
*/

class ModuleStorage extends Module {
	
	protected $oMapper = null;

	// Группа настроек по-умолчанию
	const DEFAULT_SYSTEM_INSTANCE = 'default';
	
	// Префикс полей для кеша
	const CACHE_FIELD_DATA_PREFIX = 'storage_field_data_';
	
	// Нужно ли данные параметров хранить также сериализированными
	const SERIALIZE_PARAM_VALUES = true;
	
	// Имя ключа для ядра
	const ENGINE_KEY_NAME = '__system__';

	// Кеширование параметров на время работы сессии
	//protected $aSessionCache = array ();																											// todo, проверять и хранить в GetOneParam ()

	// ---

	public function Init () {
		$this -> oMapper = Engine::GetMapper (__CLASS__);
	}
	
	//
	// --- Низкоуровневые обертки для работы с БД ---
	//
	// Для highload проектов эти обертки можно будет переопределить через плагин чтобы подключить не РСУБД хранилища, такие, например, как Redis
	//
	
	/*
		Записать в БД строку одного ключа
	*/
	protected function SetFieldOne ($sKey, $sValue, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$sKey = (string) $sKey;
		$sValue = (string) $sValue;
		$sInstance = (string) $sInstance;
		
		$sCacheKey = self::CACHE_FIELD_DATA_PREFIX . $sKey . '_' . $sInstance;
		$this -> Cache_Delete ($sCacheKey);
		
		return $this -> oMapper -> SetData ($sKey, $sValue, $sInstance);
	}

	// ---
	
	/*
		Получить из БД значение одного ключа
	*/
	protected function GetFieldOne ($sKey, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$sKey = (string) $sKey;
		$sInstance = (string) $sInstance;
		
		$sCacheKey = self::CACHE_FIELD_DATA_PREFIX . $sKey . '_' . $sInstance;
		if (($mData = $this -> Cache_Get ($sCacheKey)) === false) {
			$sFilter = $this -> oMapper -> BuildFilter (array (
				'skey' => $sKey,
				'instance' => $sInstance
			));
			$mData = null;
			$aResult = $this -> oMapper -> GetData ($sFilter, 1, 1);
			
			if ($aResult ['count'] != 0) {
				$mData = $aResult ['collection']['svalue'];
				$this -> Cache_Set ($mData, $sCacheKey, array ('storage_field_data'), 60 * 60 * 24 * 365);  // 1 year
			}
		}
		return $mData;
	}
	
	// ---
	
	/*
		Удалить из БД ключ
	*/
	protected function DeleteFieldOne ($sKey, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$sKey = (string) $sKey;
		$sInstance = (string) $sInstance;
		
		$sCacheKey = self::CACHE_FIELD_DATA_PREFIX . $sKey . '_' . $sInstance;
		$this -> Cache_Delete ($sCacheKey);
		
		$sFilter = $this -> oMapper -> BuildFilter (array (
			'skey' => $sKey,
			'instance' => $sInstance
		));
		
		return $this -> oMapper -> DeleteData ($sFilter, 1);
	}
	
	//
	// --- Высокоуровневые обертки для работы непосредственно с параметрами каждого ключа
	//
	
	/*
		Подготовка значения параметра перед сохранением
	*/
	protected function PrepareParamValueBeforeSaving ($mValue) {
		if (is_resource ($mValue)) {
			throw new Exception ('Storage: your data must be scalar value, not resource!');
		}
		if (self::SERIALIZE_PARAM_VALUES) {
			return serialize ($mValue);
		}
		return $mValue;
	}
	
	// ---
	
	/*
		Восстановление значения параметра
	*/
	protected function RetrieveParamValueFromSavedValue ($mValue) {
		if (self::SERIALIZE_PARAM_VALUES) {
			if (($mData = @unserialize ($mValue)) !== false) {
				return $mData;
			}
			return null;
		}
		return $mValue;
	}
	
	/*
		Получить список всех параметров ключа
	*/
	protected function GetParamsAll ($sKey, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		// Если есть запись для ключа и она не повреждена и корректна
		if ($sFieldData = $this -> GetFieldOne ($sKey, $sInstance)) {
			if (($aData = @unserialize ($sFieldData)) !== false and is_array ($aData)) {
				return $aData;
			}
		}
		return array ();
	}
	
	// ---
	
	/*
		Сохранить значение параметра для ключа
	*/
	protected function SetOneParam ($sKey, $sParamName, $mValue, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$aParamsContainer = $this -> GetParamsAll ($sKey, $sInstance);
		$aParamsContainer [(string) $sParamName] = $this -> PrepareParamValueBeforeSaving ($mValue);
		return $this -> SetFieldOne ($sKey, serialize ($aParamsContainer), $sInstance);
	}
	
	// ---
	
	/*
		Получить значение параметра для ключа
	*/
	protected function GetOneParam ($sKey, $sParamName, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		if ($aFieldData = $this -> GetParamsAll ($sKey, $sInstance) and isset ($aFieldData [(string) $sParamName])) {
			return $this -> RetrieveParamValueFromSavedValue ($aFieldData [(string) $sParamName]);
		}
		return null;
	}
	
	// ---
	
	/*
		Удалить значение параметра для ключа
	*/
	protected function RemoveOneParam ($sKey, $sParamName, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$aParamsContainer = $this -> GetParamsAll ($sKey, $sInstance);
		unset ($aParamsContainer [(string) $sParamName]);
		return $this -> SetFieldOne ($sKey, serialize ($aParamsContainer), $sInstance);
	}
	
	// ---
	
	/*
		Удалить все параметры ключа
	*/
	protected function RemoveAllParams ($sKey, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		return $this -> DeleteFieldOne ($sKey, $sInstance);
	}
	
	//
	// --- Хелперы ---
	//
	
	protected function GetKeyForCaller ($oCaller) {
		// Получаем имя плагина, если возможно
		if (!$sCaller = strtolower (Engine::GetPluginName ($oCaller))) {
			// Если имени нет - значит это вызов ядра
			return self::ENGINE_KEY_NAME;
		}
		return $sCaller;
	}
	
	// ---
	
	protected function CheckCaller ($oCaller) {
		if (!is_object ($oCaller)) throw new Exception ('Storage: caller is not correct. Always use "$this"');
	}
	
	// --- Методы для работы ---
	
	/*
		Установить значение
	*/
	public function Set ($sParamName, $mValue, $oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$this -> CheckCaller ($oCaller);
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> SetOneParam ($sCallerName, $sParamName, $mValue, $sInstance);
	}
	
	// ---
	
	/*
		Получить значение
	*/
	public function Get ($sParamName, $oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$this -> CheckCaller ($oCaller);
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> GetOneParam ($sCallerName, $sParamName, $sInstance);
	}
	
	// ---
	
	/*
		Получить все значения
	*/
	public function GetAll ($oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$this -> CheckCaller ($oCaller);
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return array_map (array ($this, 'RetrieveParamValueFromSavedValue'), $this -> GetParamsAll ($sCallerName, $sInstance));
	}
	
	// ---
	
	/*
		Удалить значение
	*/
	public function Remove ($sParamName, $oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$this -> CheckCaller ($oCaller);
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> RemoveOneParam ($sCallerName, $sParamName, $sInstance);
	}
	
	// ---
	
	/*
		Удалить все значения
	*/
	public function RemoveAll ($oCaller, $sInstance = self::DEFAULT_SYSTEM_INSTANCE) {
		$this -> CheckCaller ($oCaller);
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> RemoveAllParams ($sCallerName, $sInstance);
	}

}

?>