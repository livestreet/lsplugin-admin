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

class PluginAdmin_ActionAdmin_EventPlugin extends Event {
	
	/*
		Интегрирует настройки плагина в админку и запускает класс "PluginИмяплагина_ActionAdmin",
		который должен быть унаследован от PluginAdmin_ActionPlugin
	*/
	public function EventPlugin() {
		$aParams=$this->GetParams();
		$sPlugin=strtolower(array_shift($aParams));
		/**
		 * Проверяем плагин на активность
		 */
		$aPluginsActive=Engine::getInstance()->GetPlugins();
		if (array_key_exists($sPlugin,$aPluginsActive)) {
			$sActionClass='Plugin'.func_camelize($sPlugin).'_ActionAdmin';
			if ($this->IsInstanceClass($sActionClass,'PluginAdmin_ActionPlugin')) {
				/**
				 * Переопределяем конфиг роутинга и делаем редирект на экшен плагина
				 */
				$sRouterPage='admin_plugin_'.$sPlugin;
				Config::Set('router.page.'.$sRouterPage,$sActionClass);
				Router::getInstance()->LoadConfig();
				$sEventPlugin=array_shift($aParams);
				/**
				 * Загружаем в шаблон объект для удобного получения URL внутри админки плагина
				 */
				$oAdminUrl=Engine::GetEntity('PluginAdmin_ModuleUi_EntityAdminUrl');
				$oAdminUrl->setPlugin($sPlugin);
				$this->Viewer_Assign('oAdminUrl',$oAdminUrl);
				return Router::Action($sRouterPage,$sEventPlugin,$aParams);
			}
		}
		return $this->EventNotFound();
	}
	
	

	protected function IsInstanceClass($sClass,$sParent) {
		if (!class_exists($sClass)) {
			return false;
		}
		$oClass=new ReflectionClass($sClass);
		do {
			if ($oClass->getName()==$sParent) {
				return true;
			}
			$oClass=$oClass->getParentClass();
		} while(false!==$oClass);
		return false;
	}

}

?>