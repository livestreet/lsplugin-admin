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
 *	Работа с плагинами
 */

class PluginAdmin_ActionAdmin_EventPlugins extends Event {
	
	public function EventPluginsList() {
		$aPluginList = $this->GetAllPluginLists();
		
		$this->Viewer_Assign('aPluginsInfo', $aPluginList);
		$this->SetTemplateAction('plugins');
	}
	
	
	
	private function GetAllPluginLists() {
		return $this->Plugin_GetList(array('order' => 'name'));
	}

}

?>