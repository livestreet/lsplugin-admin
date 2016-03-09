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

class PluginAdmin_HookSkins extends Hook
{

    public function RegisterHook()
    {
        /*
         * tip: сам шаблон для предпросмотра устанавливается в наследуемом модуле Lang после вызова родительского InitConfig()
         */

        $this->AddHook('engine_init_complete', 'EngineInitComplete');
    }


    public function EngineInitComplete()
    {
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
     * @param $sSkinName    имя шаблона
     * @return mixed
     */
    protected function ShowPreviewSkinMessage($sSkinName)
    {
        $this->Viewer_Assign('skin', $this->PluginAdmin_Skin_GetSkinByName($sSkinName), true);
        /*
         * ключ безопасности ещё не передан, поэтому создадим его вручную
         */
        $this->Viewer_Assign('token', $this->Security_GetSecurityKey(), true);
        $this->Message_AddNotice($this->Viewer_Fetch('component@admin:p-skin.preview-alert'));
    }

}

?>