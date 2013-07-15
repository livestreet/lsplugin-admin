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
	
	/*
	 *	Показать настройки
	 */
	public function EventShow () {
		// Корректно ли имя конфига
		if (!$sConfigName = $this -> getParam (1) or !is_string ($sConfigName)) {
			$this -> Message_AddError ($this -> Lang_Get ('plugin.admin.Errors.Wrong_Config_Name'), $this -> Lang_Get ('error'));
			return false;
		}
		
		// Загрузить конфиг плагина
		if (!$this -> PluginAdmin_Settings_CheckIfThisPluginIsActive ($sConfigName)) {
			$this -> Message_AddError ($this -> Lang_Get ('plugin.admin.Errors.Plugin_Need_To_Be_Activated'), $this -> Lang_Get ('error'));
			return false;
		}

		$aSettingsAll = $this -> PluginAdmin_Settings_GetConfigSettings ($sConfigName);
		
		$this -> Viewer_Assign ('aSettingsAll', $aSettingsAll);
		$this -> Viewer_Assign ('sConfigName', $sConfigName);
	}

	
	/*
	 *	Сохранить настройки
	 */
	public function EventSaveConfig () {
		$this -> Security_ValidateSendForm ();

		if (isPost ('submit_save_settings')) {
			// Корректно ли имя конфига
			if (!$sConfigName = $this -> getParam (1) or !is_string ($sConfigName)) {
				$this -> Message_AddError ($this -> Lang_Get ('plugin.admin.Errors.Wrong_Config_Name'), $this -> Lang_Get ('error'));
				return false;
			}

			// Получение всех параметров, их валидация и сверка с описанием структуры и запись в отдельную инстанцию конфига
			if ($this -> PluginAdmin_Settings_ParsePOSTDataIntoSeparateConfigInstance ($sConfigName)) {
				// Сохранить все настройки плагина в БД
				$this -> PluginAdmin_Settings_SaveConfigByKey ($sConfigName);
				
				$this -> Message_AddNotice ('Ok', '', true);
			}
		}

		return Router::Location (Router::GetPath ('admin') . 'settings/plugin/' . $sConfigName);
	}
	
	
	/////////////
	
	protected function ShowSystemSettings ($aKeysToShow) {
		$sConfigName = PluginAdmin_ModuleSettings::SYSTEM_CONFIG_ID;
		$aSettingsAll = $this -> PluginAdmin_Settings_GetConfigSettings ($sConfigName, false, $aKeysToShow);

		$this -> Viewer_Assign ('aSettingsAll', $aSettingsAll);
		$this -> Viewer_Assign ('sConfigName', $sConfigName);
		$this -> Viewer_Assign ('aKeysToShow', $aKeysToShow);
	}
	
	
	public function EventShowSystemSettings () {
		$aKeysToShow = array(
			// первые символы разрешенных ключей для этой группы
			//'view',
			//'seo',
			//'block',
			'pagination',
			'path',
			'smarty',
			'sys',
			'general',
			//'lang',
			//'acl',
			//'module',
			'db',
			'memcache',
			'router',
			'head',
			'compress',
		);
		return $this -> ShowSystemSettings ($aKeysToShow);
	}


	public function EventShowTopicsSettings () {
		$aKeysToShow = array(
			// первые символы разрешенных ключей для этой группы
			'view',
			'seo',
			'block',
			//'pagination',
			//'path',
			//'smarty',
			//'sys',
			//'general',
			'lang',
			//'acl',
			//'module',
			'db',
			'memcache',
			'router',
			'head',
			'compress',
		);
		return $this -> ShowSystemSettings ($aKeysToShow);
	}

	
	public function EventShowUsersSettings () {
		$aKeysToShow = array(
			// первые символы разрешенных ключей для этой группы
			//'view',
			//'seo',
			//'block',
			//'pagination',
			//'path',
			//'smarty',
			//'sys',
			//'general',
			//'lang',
			'acl',
			'module',
			//'db',
			//'memcache',
			//'router',
			//'head',
			//'compress',
		);
		return $this -> ShowSystemSettings ($aKeysToShow);
	}
	
}

?>