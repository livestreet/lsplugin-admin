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

/**
 * Регистрация хука
 *
 */
class PluginArticle_HookMain extends Hook {
	public function RegisterHook() {
		$this->AddHook('init_action_admin','InitActionAdmin');
	}

	public function InitActionAdmin() {
		$oMenu = $this->PluginAdmin_Ui_GetMenuMain();
		$oMenu->AddSection(
			Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Статьи')->SetName('article')->SetUrl('plugin/article')
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Список статей')->SetUrl(''))
				->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')->SetCaption('Создать')->SetUrl('create'))
		);
	}
}