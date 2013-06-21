<?php

class PluginAdmin_ActionAdmin_EventPlugin extends Event {

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
		} while (false!==$oClass);
		return false;
	}

}