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
 * 
 */

class PluginAdmin_ModuleUi_EntityAdminUrl extends Entity {
	/**
	 * Текущий плагин
	 *
	 * @var string|null
	 */
	protected $sPlugin=null;

	/**
	 * Устанавливает текущий плагин
	 *
	 * @param string $sPlugin
	 */
	public function setPlugin($sPlugin) {
		$this->sPlugin=$sPlugin;
	}
	/**
	 * Возвращает полный URL до необходимой страницы плагина
	 *
	 * @param string $sPath
	 * @param string $sPlugin
	 *
	 * @return string
	 */
	public function get($sPath=null,$sPlugin=null) {
		$sPlugin=$sPlugin ? $sPlugin : $this->sPlugin;
		return Router::GetPath("admin/plugin/{$sPlugin}".($sPath ? '/'.$sPath : ''));
	}

	/**
	 * Возвращает текущий плагин
	 *
	 * @return null|string
	 */
	public function getPlugin() {
		return $this->sPlugin;
	}

}

?>