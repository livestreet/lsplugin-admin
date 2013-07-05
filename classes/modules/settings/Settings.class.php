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
	
	// ---

	public function Init() {}
	
	// ---
	
	//
	// Сохранить конфиг ключа
	//
	public function SaveConfig ($sConfigName, $aData) {
		if ($sConfigName == PluginAdmin_ActionAdmin_EventSettings::SYSTEM_CONFIG_ID) {
			$sKey = PluginAdmin_ModuleStorage::ENGINE_KEY_NAME;
		} else {
			$sKey = $sConfigName;
		}
		return $this -> PluginAdmin_Storage_SetOneParam ($sKey, self::CONFIG_DATA_PARAM_NAME, $aData);
	}
	
	// ---
	
	//
	// Начать загрузку всех конфигов в системе
	//
	public function AutoLoadConfigs () {
		$aData = $this -> PluginAdmin_Storage_GetFieldsAll ();
		if ($aData ['count']) {
			foreach ($aData ['collection'] as $aFieldData) {
				$sKey = $aFieldData ['skey'];
				$this -> LoadConfig ($sKey);
			}
		}
	}
	
	// ---
	
	//
	// Загрузить конфиг ключа
	//
	private function LoadConfig ($sKey) {
		// Получить конфиг текущего ключа (если существует)
		if ($aConfigData = $this -> PluginAdmin_Storage_GetOneParam ($sKey, self::CONFIG_DATA_PARAM_NAME)) {
			if ($sKey == ModuleStorage::ENGINE_KEY_NAME) {
				// Данные ядра
				$this -> LoadRootConfig ($aConfigData);
			} else {
				// Данные плагина
				$this -> LoadPluginConfig ($sKey, $aConfigData);
			}
		}
	}
	
	// ---
	
	//
	// Загрузить конфиг ядра
	//
	private function LoadRootConfig ($mValue) {
		// Загрузить настройки обьеденив их с существующими (из конфига)
		Config::getInstance () -> SetConfig ($mValue, false);
	}

	// ---
	
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