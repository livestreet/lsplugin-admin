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
 * tip: сам предпросмотр шаблона включается в HookSettings.class.php
 * 		Код оттуда не был перенесен сюда специально чтобы не затруднять отладку если она будет нужна в будущем
 *
 */

class PluginAdmin_HookSkin extends Hook {

	public function RegisterHook() {
		$this->AddHook('engine_init_complete', 'EngineInitComplete');
	}


	public function EngineInitComplete() {
		/*
		 * показать сообщение о предпросмотре шаблона с ссылкой для выключения
		 */
		if ($this->PluginAdmin_Skin_GetPreviewSkinName()) {
			$this->ShowPreviewSkinMessage();
		}
	}


	/**
	 * Показать сообщение что включен режим предпросмотра шаблона с ссылкой для выключения
	 *
	 * @return mixed
	 */
	protected function ShowPreviewSkinMessage() {
		/*
		 * ключ безопасности ещё не передан, поэтому создадим его вручную
		 */
		$this->Security_SetSessionKey();
		$this->Message_AddNotice($this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'actions/ActionAdmin/skin/preview_skin_message.tpl'));
	}

}

?>