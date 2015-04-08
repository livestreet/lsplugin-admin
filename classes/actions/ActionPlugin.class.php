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
 * От этого класса должны быть унаследованы все екшены плагинов, которые нужно интегрировать в админку
 *
 */

abstract class PluginAdmin_ActionPlugin extends ActionPlugin
{

    protected $sMenuSubItemSelect = '';

    protected function SetTemplateAction($sTemplate)
    {
        $aDelegates = $this->Plugin_GetDelegationChain('action', $this->GetActionClass());
        $sActionTemplatePath = $sTemplate . '.tpl';
        foreach ($aDelegates as $sAction) {
            if (preg_match('/^Plugin([\w]+)_Action([\w]+)$/i', $sAction, $aMatches)) {
                $sTemplatePath = 'actions/Action' . ucfirst($aMatches[2]) . '/' . $sTemplate . '.tpl';

                $sPath = Plugin::GetPath($sAction);
                $aSkins = array('admin_default', 'default', Config::Get('view.skin'));
                foreach ($aSkins as $sSkin) {
                    $sTpl = $sPath . 'frontend/skin/' . $sSkin . '/' . $sTemplatePath;
                    if (is_file($sTpl)) {
                        $sActionTemplatePath = $sTpl;
                        break(2);
                    }
                }
            }
        }
        $this->Viewer_Assign('sAdminTemplateInclude', $sActionTemplatePath);
        $this->sActionTemplate = Plugin::GetPath('admin') . 'frontend/skin/default/actions/ActionAdmin/embed_plugin/plugin.tpl';
    }


    protected function EventNotFound()
    {
        return Router::Action('admin', 'error', array('404'));
    }


    protected function EventError()
    {
        return Router::Action('admin', 'error');
    }

    public function EventShutdown()
    {
        $this->Viewer_Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
    }

}