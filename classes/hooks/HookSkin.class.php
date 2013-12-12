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
 *
 */

class PluginAdmin_HookSkin extends Hook {

	public function RegisterHook() {
		/*
		 * наивысший приоритет, который можно установить, но ниже чем загрузка настроек в HookSettings.class (вторая очередь)
		 */
		/*
		 *
		 * todo:
		 * исправить имя хука "lang_init_start" на "lang_init_names_set" и добавить этот хук в модуль Lang в Init():
		 *
		 * $this->Hook_Run('lang_init_names_set');
		 *
		 * весь метод:
		 *
		 */
/*		public function Init() {
			$this->Hook_Run('lang_init_start');

			$this->sCurrentLang = Config::Get('lang.current');
			$this->sDefaultLang = Config::Get('lang.default');
			$this->sLangPath = Config::Get('lang.path');
			$this->Hook_Run('lang_init_names_set');														// NEW HOOK
			$this->InitLang();
		}*/
		/*
		 * без этого хука не будет работь получение xml данных из файлов из модуля шаблонов админки т.к. та в ините получает язык,
		 * но первый вызов модуля шаблонов происходит здесь как раз на ините языкового модуля и ДО момента установки языков по-умолчанию.
		 *
		 *
		 * ИЛИ можно сделать хак в модуле шаблонов в Инит(): вместо получения языка из модуля ланг:
		 *
		 * $this->sLang = $this->Lang_GetLang();
		 *
		 * получить его из конфига
		 *
		 * $this->sLang = Config::Get('lang.current');
		 *
		 * но это костыль и не факт, что в будущем не возникнет похожей ситуации
		 */

		/*
		 *
		 *
		 * А пока что предпросмотр шаблона будет отключен т.к. он ломает работую других методов
		 *
		 *
		 */
		//$this->AddHook('lang_init_start', 'LangInitStart', __CLASS__, PHP_INT_MAX - 100);
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