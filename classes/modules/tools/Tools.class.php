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

/**
 *
 *	Разные методы
 *
*/

class PluginAdmin_ModuleTools extends Module {

	public function Init() {}


	/**
	 * Возвращает путь к плагинам админки для смарти
	 *
	 * @return string
	 */
	public function GetSmartyPluginsPath() {
		return Plugin::GetPath(__CLASS__) . 'include/smarty/';
	}


	/**
	 * Вернуть путь к шаблону админки для плагина
	 *
	 * @param $sName			имя плагина
	 * @return bool|string
	 */
	public function GetPluginTemplatePath($sName) {
		$sNamePlugin = Engine::GetPluginName($sName);
		$sNamePlugin = $sNamePlugin ? $sNamePlugin : $sName;
		$sNamePlugin = func_underscore($sNamePlugin);

		$sPath = Plugin::GetPath($sNamePlugin);
		$aSkins = array('admin_default', 'default', Config::Get('view.skin'));
		foreach($aSkins as $sSkin) {
			$sTpl = $sPath . 'templates/skin/' . $sSkin . '/';
			if (is_dir($sTpl)) {
				return $sTpl;
			}
		}
		return false;
	}


	/**
	 * Вернуть веб-путь к шаблону админки для плагина
	 *
	 * @param $sName			имя плагина
	 * @return bool|string
	 */
	public function GetPluginTemplateWebPath($sName) {
		if ($sPath = $this->GetPluginTemplatePath($sName)) {
			return str_replace(Config::Get('path.root.server'), Config::Get('path.root.web'), $sPath);
		}
		return false;
	}

}

?>