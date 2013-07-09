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

class PluginAdmin_ModuleSettings extends Module {
	
	const CONFIG_DATA_PARAM_NAME = '__config__';					// имя параметра для плагина или ядра для сохранения конфига в хранилище
	const SYSTEM_CONFIG_ID = '__root_config__';						// Имя системного конфига
	
	

	public function Init() {}
	
	
	
	//
	// Сохранить конфиг ключа
	//
	public function SaveConfig ($sConfigName, $aData) {
		if ($sConfigName == self::SYSTEM_CONFIG_ID) {
			$sKey = PluginAdmin_ModuleStorage::DEFAULT_KEY_NAME;
		} else {
			$sKey = $sConfigName;
		}
		return $this -> PluginAdmin_Storage_SetOneParam ($sKey, self::CONFIG_DATA_PARAM_NAME, $aData);
	}
	
	
	
	//
	// Начать загрузку всех конфигов в системе
	//
	public function AutoLoadConfigs () {
		$aData = $this -> PluginAdmin_Storage_GetFieldsAll ();
		if ($aData ['count']) {
			foreach ($aData ['collection'] as $aFieldData) {
				$sKey = $aFieldData ['key'];
				$this -> LoadConfig ($sKey);
			}
		}
	}
	
	
	
	//
	// Загрузить конфиг ключа
	//
	private function LoadConfig ($sKey) {
		// Получить конфиг текущего ключа (если существует)
		if ($aConfigData = $this -> PluginAdmin_Storage_GetOneParam ($sKey, self::CONFIG_DATA_PARAM_NAME)) {
			if ($sKey == ModuleStorage::DEFAULT_KEY_NAME) {
				// Данные ядра
				$this -> LoadRootConfig ($aConfigData);
			} else {
				// Данные плагина
				$this -> LoadPluginConfig ($sKey, $aConfigData);
			}
		}
	}
	
	
	
	//
	// Загрузить конфиг ядра
	//
	private function LoadRootConfig ($mValue) {
		// Загрузить настройки обьеденив их с существующими (из конфига)
		Config::getInstance () -> SetConfig ($mValue, false);
	}

	
	
	//
	// Загрузить конфиг плагина
	//
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

}

?>