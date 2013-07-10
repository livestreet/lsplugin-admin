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
			$this -> Storage_Get ('keyname', $this);			// получить данные по ключу 'keyname' для вашего плагина
		
		by PSNet
		http://psnet.lookformp3.net
*/

class ModuleStorage extends Module {
	
	protected $oMapperStorage = null;
        
  /*
   * Группа настроек по-умолчанию
   */
	const DEFAULT_INSTANCE = 'default';
	
	/*
   * Префикс полей для кеша
   */
	const CACHE_FIELD_DATA_PREFIX = 'storage_field_data_';
	
	/*
   *  Нужно ли данные параметров хранить также сериализированными
   */
	const SERIALIZE_PARAM_VALUES = true;
	
	/*
   *  Имя ключа для ядра
   */
	const DEFAULT_KEY_NAME = '__default__';
	
	/*
	 *	Префикс для плагина в таблице
	 */
	const PLUGIN_PREFIX = 'plugin_';

	/*
   *  Кеширование параметров на время работы сессии
   *  structure: array('instance' => array('key' => array('param1' => 'value1', 'param2' => 'value2')))
   */
	protected $aSessionCache = array();


	public function Init () {
		$this -> oMapperStorage = Engine::GetMapper (__CLASS__);
	}
	
	
	
	/*
	 *
   * --- Низкоуровневые обертки для работы с БД ---
   * Для highload проектов эти обертки можно будет переопределить через плагин чтобы подключить не РСУБД хранилища, такие, например, как Redis
	 *
   */
	
	/*
   * Записать в БД строку одного ключа
	*/
	protected function SetFieldOne ($sKey, $sValue, $sInstance = self::DEFAULT_INSTANCE) {
		$sKey = (string) $sKey;
		$sValue = (string) $sValue;
		$sInstance = (string) $sInstance;
		
		$sCacheKey = self::CACHE_FIELD_DATA_PREFIX . $sKey . '_' . $sInstance;
		$this -> Cache_Delete ($sCacheKey);
		
		return $this -> oMapperStorage -> SetData ($sKey, $sValue, $sInstance);
	}
	
	
	/*
   * Получить из БД строковое значение одного ключа
	*/
	protected function GetFieldOne ($sKey, $sInstance = self::DEFAULT_INSTANCE) {
		$sKey = (string) $sKey;
		$sInstance = (string) $sInstance;
		
		$sCacheKey = self::CACHE_FIELD_DATA_PREFIX . $sKey . '_' . $sInstance;
		if (($mData = $this -> Cache_Get ($sCacheKey)) === false) {
			$sFilter = $this -> oMapperStorage -> BuildFilter (array(
				'key' => $sKey,
				'instance' => $sInstance
			));
			$mData = null;
			$aResult = $this -> oMapperStorage -> GetData ($sFilter, 1, 1);
			
			if ($aResult ['count'] != 0) {
				$mData = $aResult ['collection']['value'];
				$this -> Cache_Set ($mData, $sCacheKey, array('storage_field_data'), 60 * 60 * 24 * 365);  // 1 year
			}
		}
		return $mData;
	}
	
	
	/*
   * Удалить из БД ключ
	*/
	protected function DeleteFieldOne ($sKey, $sInstance = self::DEFAULT_INSTANCE) {
		$sKey = (string) $sKey;
		$sInstance = (string) $sInstance;
		
		$sCacheKey = self::CACHE_FIELD_DATA_PREFIX . $sKey . '_' . $sInstance;
		$this -> Cache_Delete ($sCacheKey);
		
		$sFilter = $this -> oMapperStorage -> BuildFilter (array(
			'key' => $sKey,
			'instance' => $sInstance
		));
		
		return $this -> oMapperStorage -> DeleteData ($sFilter, 1);
	}
	
	
	/*
   * Получить из БД все ключи в "сыром" виде
	*/
	protected function GetFieldsAll ($sInstance = self::DEFAULT_INSTANCE) {
		$sInstance = (string) $sInstance;
		
		$sCacheKey = self::CACHE_FIELD_DATA_PREFIX . '_fields_all_' . $sInstance;
		if (($mData = $this -> Cache_Get ($sCacheKey)) === false) {
			$sFilter = $this -> oMapperStorage -> BuildFilter (array(
				'instance' => $sInstance
			));
			$mData = $this -> oMapperStorage -> GetData ($sFilter);
			$this -> Cache_Set ($mData, $sCacheKey, array('storage_field_data'), 60 * 60 * 24 * 365);  // 1 year
		}
		return $mData;
	}
	
	
	
	/*
	 *
   * --- Обработка значений параметров ---
	 *
   */
	
	/*
   * Подготовка значения параметра перед сохранением
	*/
	protected function PrepareParamValueBeforeSaving ($mValue) {
		if (is_resource ($mValue)) {
			throw new Exception ('Storage: your data must be scalar value, not resource!');
		}
		if (self::SERIALIZE_PARAM_VALUES) {
			return $this -> PackValue ($mValue);
		}
		return $mValue;
	}
	
	
	/*
   * Восстановление значения параметра
	*/
	protected function RetrieveParamValueFromSavedValue ($mValue) {
		if (self::SERIALIZE_PARAM_VALUES) {
			if ($mData = $this -> UnpackValue ($mValue)) {
				return $mData;
			}
			return null;
		}
		return $mValue;
	}
	
	
	/*
   * Перевести данные в строковый вид (сериализировать)
	*/
	protected function PackValue ($mValue) {
		return serialize ($mValue);
	}
	
	
	/*
   * Восстановить данные из строкового вида (десериализировать)
	*/
	protected function UnpackValue ($mValue) {
		if (($mData = @unserialize ($mValue)) !== false) {
			return $mData;
		}
		return null;
	}
	
	
        
	/*
	 *
   * --- Высокоуровневые обертки для работы непосредственно с параметрами каждого ключа ---
	 *
   */
	
	/*
   * Получить список всех параметров ключа
	*/
	protected function GetParamsAll ($sKey, $sInstance = self::DEFAULT_INSTANCE) {
		// Если значение есть в кеше сессии - получить его
		if (isset ($this -> aSessionCache [$sInstance][$sKey])) {
			return $this -> aSessionCache [$sInstance][$sKey];
		}
		
		// Если есть запись для ключа и она не повреждена и корректна
		if ($sFieldData = $this -> GetFieldOne ($sKey, $sInstance)) {
			if ($aData = $this -> UnpackValue ($sFieldData) and is_array($aData)) {
				
				// Сохранить в кеше сессии распакованные значения
				$aData = array_map (array($this, 'RetrieveParamValueFromSavedValue'), $aData);
				$this -> aSessionCache [$sInstance][$sKey] = $aData;
				
				return $aData;
			}
		}
		return array();
	}
	
	
	/*
   * Сохранить значение параметра для ключа
	*/
	protected function SetOneParam ($sKey, $sParamName, $mValue, $sInstance = self::DEFAULT_INSTANCE) {
		$mValueChecked = $this -> PrepareParamValueBeforeSaving ($mValue);
		$aParamsContainer = $this -> GetParamsAll ($sKey, $sInstance);
		$aParamsContainer [$sParamName] = $mValueChecked;
		
		// Сохранить в кеше сессии
		$this -> aSessionCache [$sInstance][$sKey][$sParamName] = $mValue;
		
		return $this -> SetFieldOne ($sKey, $this -> PackValue ($aParamsContainer), $sInstance);
	}
	
	
	/*
   * Получить значение параметра для ключа
	*/
	protected function GetOneParam ($sKey, $sParamName, $sInstance = self::DEFAULT_INSTANCE) {
		// Если значение есть в кеше сессии - получить его
		if (isset ($this -> aSessionCache [$sInstance][$sKey][$sParamName])) {
			return $this -> aSessionCache [$sInstance][$sKey][$sParamName];
		}
		
		if ($aFieldData = $this -> GetParamsAll ($sKey, $sInstance) and isset ($aFieldData [$sParamName])) {
			return $aFieldData [$sParamName];
		}
		return null;
	}
	
	
	/*
   * Удалить значение параметра для ключа
	*/
	protected function RemoveOneParam ($sKey, $sParamName, $sInstance = self::DEFAULT_INSTANCE) {
		// Удалить значение из кеша сессии
		unset($this -> aSessionCache [$sInstance][$sKey][$sParamName]);
		
		$aParamsContainer = $this -> GetParamsAll ($sKey, $sInstance);
		unset($aParamsContainer [$sParamName]);
		return $this -> SetFieldOne ($sKey, $this -> PackValue ($aParamsContainer), $sInstance);
	}
	
	
	/*
   * Удалить все параметры ключа
	*/
	protected function RemoveAllParams ($sKey, $sInstance = self::DEFAULT_INSTANCE) {
		// Удалить все значения из кеша сессии
		unset($this -> aSessionCache [$sInstance][$sKey]);
		return $this -> DeleteFieldOne ($sKey, $sInstance);
	}
	
	
	/*
   * Сохранить значение параметра для ключа на время сессии (без записи в хранилище)
	*/
	protected function SetSmartParam ($sKey, $sParamName, $mValue, $sInstance = self::DEFAULT_INSTANCE) {
		// trick: В первый запрос все данные будут загружены в сессионное хранилище и при повторном вызове они не будут затираться
		$this -> GetParamsAll ($sKey, $sInstance);
		// Сохранить в кеше сессии
		$this -> aSessionCache [$sInstance][$sKey][$sParamName] = $mValue;
	}
	
	
	/*
   * Удалить значение параметра для ключа на время сессии (без записи в хранилище)
	*/
	protected function RemoveSmartParam ($sKey, $sParamName, $sInstance = self::DEFAULT_INSTANCE) {
		// trick: В первый запрос все данные будут загружены в сессионное хранилище и при повторном вызове они не будут затираться
		$this -> GetParamsAll ($sKey, $sInstance);
		// Удалить в кеше сессии
		unset ($this -> aSessionCache [$sInstance][$sKey][$sParamName]);
	}
	
	
	/*
   * Записать в хранилище значения параметров для ключа из кеша сессии
	*/
	protected function StoreParams ($sKey, $sInstance = self::DEFAULT_INSTANCE) {
		return $this -> SetFieldOne ($sKey, $this -> PackValue ($this -> aSessionCache [$sInstance][$sKey]), $sInstance);
	}
	
	
	/*
   * Сбросить кеш сессии (без записи в хранилище)
	*/
	protected function ResetSessionCache ($sKey = null, $sInstance = self::DEFAULT_INSTANCE) {
		if (!is_null ($sKey)) {
			unset ($this -> aSessionCache [$sInstance][$sKey]);
		} else {
			unset ($this -> aSessionCache [$sInstance]);
		}
	}
	
	
	
	/*
	 *
   * --- Хелперы ---
	 *
   */

  /*
   * Получить имя ключа из текущего, вызывающего метод, контекста
   */
	protected function GetKeyForCaller ($oCaller) {
		$this -> CheckCaller ($oCaller);
		// Получаем имя плагина, если возможно
		if (!$sCaller = strtolower (Engine::GetPluginName ($oCaller))) {
			// Если имени нет - значит это вызов ядра
			return self::DEFAULT_KEY_NAME;
		}
		return self::PLUGIN_PREFIX . $sCaller;
	}
	
	
  /*
   * Проверить корректность указания контекста
   */
	protected function CheckCaller ($oCaller) {
		if (!is_object ($oCaller)) throw new Exception ('Storage: caller is not correct. Always use "$this"');
	}
	
	
	
	/*
	 *
   * --- Конечные методы для использования в движке и плагинах ---
	 *
   */
	
	/*
   * Установить значение
	*/
	public function Set ($sParamName, $mValue, $oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> SetOneParam ($sCallerName, $sParamName, $mValue, $sInstance);
	}
	
	
	/*
   * Получить значение
	*/
	public function Get ($sParamName, $oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> GetOneParam ($sCallerName, $sParamName, $sInstance);
	}
	
	
	/*
   * Получить все значения
	*/
	public function GetAll ($oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> GetParamsAll ($sCallerName, $sInstance);
	}
	
	
	/*
   * Удалить значение
	*/
	public function Remove ($sParamName, $oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> RemoveOneParam ($sCallerName, $sParamName, $sInstance);
	}
	
	
	/*
   * Удалить все значения
	*/
	public function RemoveAll ($oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> RemoveAllParams ($sCallerName, $sInstance);
	}

	
	/*
	 * --- Работа с параметрами только на момент сессии ---
	 */
	
	/*
   * Сохранить значение параметра на время сессии (без записи в хранилище)
	*/
	public function SetSmart ($sParamName, $mValue, $oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> SetSmartParam ($sCallerName, $sParamName, $mValue, $sInstance);
	}
	
	
	/*
   * Удалить параметр кеша сессии (без записи в хранилище)
	*/
	public function RemoveSmart ($sParamName, $oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> RemoveSmartParam ($sCallerName, $sParamName, $sInstance);
	}
	
	
	/*
   * Записать в хранилище значения параметров из кеша сессии
	*/
	public function Store ($oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> StoreParams ($sCallerName, $sInstance);
	}
	
	
	/*
   * Сбросить кеш сессии (без записи в хранилище)
	*/
	public function Reset ($oCaller, $sInstance = self::DEFAULT_INSTANCE) {
		$sCallerName = $this -> GetKeyForCaller ($oCaller);
		return $this -> ResetSessionCache ($sCallerName, $sInstance);
	}
	
}

?>