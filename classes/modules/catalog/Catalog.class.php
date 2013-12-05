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
 * @author Serge Pustovit (PSNet) <light.feel@gmail.com>
 * 
 */

/*
 *
 * Модуль работы с официальным каталогом плагинов для LiveStreet CMS
 *
 */

class PluginAdmin_ModuleCatalog extends Module {

	/*
	 * строка замены на код плагина в урле метода
	 */
	const PLUGIN_CODE_PLACEHOLDER = '{plugin_code}';

	/*
	 * Префикс вызовов методов
	 */
	const CALLING_METHOD_PREFIX = 'RequestDataFor';

	/*
	 * Базовый путь к АПИ каталога
	 */
	private $sCatalogBaseApiUrl = null;

	/*
	 * Методы для работы с каталогом
	 */
	private $aCatalogMethodPath = array();


	public function Init() {
		$this->sCatalogBaseApiUrl = Config::Get('plugin.admin.catalog_base_api_url');
		$this->aCatalogMethodPath = Config::Get('plugin.admin.catalog_methods_pathes');
	}


	/**
	 * Построить относительный путь к методу по коду плагина, группе методов и методе из указанной группы
	 *
	 * @param $sPluginCode		код плагина
	 * @param $sMethodGroup		группа методов
	 * @param $sMethod			метод группы
	 * @return mixed			строка с относительным путем к методу
	 */
	private function BuildMethodPathForPlugin($sPluginCode, $sMethodGroup, $sMethod) {
		return str_replace(self::PLUGIN_CODE_PLACEHOLDER, $sPluginCode, $this->aCatalogMethodPath[$sMethodGroup][$sMethod]);
	}


	/**
	 * Получить абсолютный путь к АПИ по коду плагина, группе методов и методе из указанной группы
	 *
	 * @param $sPluginCode		код плагина
	 * @param $sMethodGroup		группа методов
	 * @param $sMethod			метод группы
	 * @return mixed			строка с абсолютным путем к методу
	 */
	public function GetApiPath($sPluginCode, $sMethodGroup, $sMethod) {
		return $this->sCatalogBaseApiUrl . $this->BuildMethodPathForPlugin($sPluginCode, $sMethodGroup, $sMethod);
	}


	public function __call($sName, $aArgs) {
		/*
		 * если это вызов АПИ
		 */
		if (strpos($sName, self::CALLING_METHOD_PREFIX) !== false) {
			/*
			 * убрать префикс
			 */
			$sName = str_replace(self::CALLING_METHOD_PREFIX, '', $sName);
			/*
			 * найти группу методов и сам метод
			 */
			list($sMethodGroup, $sMethod) = explode('_', func_underscore($sName), 2);

			/*
			 * добавить их в набор параметров
			 */
			$aArgsToSend = array_merge($aArgs, array($sMethodGroup, $sMethod));

			/*
			 * вернуть путь к методу
			 */
			return call_user_func_array(array($this, 'GetApiPath'), $aArgsToSend);
		} else {
			/*
			 * обычный вызов ядра
			 */
			return parent::__call($sName, $aArgs);
		}
	}


}

?>