<?php

/*
 * todo: пересмотреть методы - код старый, нужен рефакторинг
 * узнать для чего они были нужны
 */

class PluginAdmin_ModuleUi extends Module
{

    protected $oMenuMain;
    protected $oCursor;

    public function Init()
    {
        $this->oCursor = Engine::GetEntity('PluginAdmin_Ui_Cursor');
        $this->oMenuMain = $this->oCursor->GetMenu('main')->SetUrlPrefix('admin');
    }


    public function GetMenuMain()
    {
        return $this->oMenuMain;
    }

    public function AddItemMenuAddition($oItem)
    {
        if (!($oSection = $this->oMenuMain->GetSection('addition'))) {
            /**
             * Если секции еще нет, то добавляем
             */
            $this->oMenuMain->AddSection(
                $oSection = Engine::GetEntity('PluginAdmin_Ui_MenuSection')->SetCaption('Дополнительно')->SetName('addition')->SetUrl('plugin')
            );
        }
        $oSection->AddItem($oItem);
    }

    public function GetCursor()
    {
        return $this->oCursor;
    }


    public function HighlightMenus($oCursor = null)
    {
        if (is_null($oCursor)) {
            $oCursor = $this->oCursor;
        }
        $aUrlParams = explode('/', trim(str_replace(Router::GetPathRootWeb(), '', Router::GetPathWebCurrent()), '/'));
        $aMenus = $oCursor->GetMenus();
        foreach ($aMenus as $sName => $oMenu) {
            $aMenuSections = $oMenu->GetSections();

            foreach ($aMenuSections as $oMenuSection) {
                $oMenuSection->SetActive(false);
                if (count($aUrlParams) < count($aSectionUrlParams = $oMenuSection->GetUrlArray())) {
                    continue;
                } else {
                    $aSlice = array_slice($aUrlParams, 0, count($aSectionUrlParams));
                    if ($aSlice != $aSectionUrlParams) {
                        continue;
                    }
                }
                if ($oMenuSection->getUrl() == '') {
                    continue;
                }

                $oMenuSection->SetActive(true);
                $aMenuItems = $oMenuSection->GetItems();
                foreach ($aMenuItems as $oMenuItem) {
                    $oMenuItem->SetActive(false);
                    if (count($aUrlParams) < count($aItemUrlParams = explode('/', $oMenuItem->GetUrlFull(false)))) {
                        continue;
                    } else {
                        $aSlice = array_slice($aUrlParams, 0, count($aItemUrlParams));
                        if ($aSlice != $aItemUrlParams) {
                            continue;
                        }
                    }
                    $oMenuItem->SetActive(true);
                }
            }
        }
        return $oCursor;
    }


}

?>