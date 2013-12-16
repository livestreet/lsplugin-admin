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
 * Работа с шаблонами
 *
 */

class PluginAdmin_HookSkin extends Hook {

	public function RegisterHook() {
		/*
		 * наивысший приоритет, который можно установить, но ниже чем загрузка настроек в HookSettings.class (вторая очередь)
		 */
		/*
		 *
		 * ждать появления хука в модуле Lang в public function Init()
		 *
		 */
/*		public function Init() {
			$this->Hook_Run('lang_init_start');

			$this->InitConfig();
			$this->Hook_Run('lang_initconfig_done');		// this is it
			$this->InitLang();
		}*/

		/*
		 *
		 * пока предпросмотр шаблона не работает
		 *
		 */
		//$this->AddHook('module_lang_initconfig_after', 'LangInitStart', __CLASS__, PHP_INT_MAX - 100);
		$this->AddHook('engine_init_complete', 'EngineInitComplete');
	}


	public function LangInitStart() {
		/*
		 * показать предпросмотр шаблона, если он был выбран в админке
		 */
		$this->PluginAdmin_Skin_SetPreviewTemplate();
	}


	public function EngineInitComplete() {
		/*
		 * показать сообщение о предпросмотре шаблона с ссылкой для выключения
		 */
		if ($sSkinName = $this->PluginAdmin_Skin_GetPreviewSkinName()) {
			$this->ShowPreviewSkinMessage($sSkinName);
		}
	}


	/**
	 * Показать сообщение что включен режим предпросмотра шаблона с ссылкой для выключения
	 *
	 * @param $sSkinName	имя шаблона
	 * @return mixed
	 */
	protected function ShowPreviewSkinMessage($sSkinName) {
		$this->Viewer_Assign('oSkin', $this->PluginAdmin_Skin_GetSkinByName($sSkinName));
		/*
		 * ключ безопасности ещё не передан, поэтому создадим его вручную
		 */
		$this->Security_SetSessionKey();
		$this->Message_AddNotice($this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'actions/ActionAdmin/skins/preview_skin_message.tpl'));
	}

}

?>