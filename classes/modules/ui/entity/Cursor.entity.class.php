<?php

class PluginAdmin_ModuleUi_EntityCursor extends Entity
{
    // Getters

    public function GetMenu($sName)
    {
        if (is_array(@$this->_aData['menus'])) {
            foreach ($this->_aData['menus'] as $oMenu) {
                if ($oMenu->GetName() == $sName) {
                    return $oMenu;
                }
            }
        }
        $oMenu = Engine::GetEntity('PluginAdmin_Ui_Menu');
        $this->AddMenu($oMenu->SetName($sName));
        return $oMenu;
    }


    public function GetMenus()
    {
        return is_array(@$this->_aData['menus'])
            ? $this->_aData['menus']
            : array();
    }


    public function GetMenuNames()
    {
        $aMenus = $this->GetMenus();
        $aNames = array();
        foreach ($aMenus as $oMenu) {
            $aNames[] = $oMenu->GetName();
        }
        return $aNames;
    }


    public function GetActiveSection()
    {
        if (!($aMenuNames = func_get_args())) {
            $aMenuNames = $this->GetMenuNames();
        }
        foreach ($aMenuNames as $sMenuName) {
            if (is_object(@$this->_aData['active'][$sMenuName]['section'])) {
                return $this->_aData['active'][$sMenuName]['section'];
            }
        }
    }


    public function GetActiveItem()
    {
        if (!($aMenuNames = func_get_args())) {
            $aMenuNames = $this->GetMenuNames();
        }
        foreach ($aMenuNames as $sMenuName) {
            if (is_object(@$this->_aData['active'][$sMenuName]['item'])) {
                return $this->_aData['active'][$sMenuName]['item'];
            }
        }
    }

    //
    // Setters
    //

    public function SetActiveSection(PluginAdmin_ModuleUi_EntityMenuSection $oMenuSection)
    {
        $this->_aData['active'][$oMenuSection
            ->GetMenu()
            ->GetName()]['section']
            = $oMenuSection;
        return $this;
    }


    public function SetActiveItem(PluginAdmin_ModuleUi_EntityMenuItem $oMenuItem)
    {
        $this->_aData['active'][$oMenuItem
            ->GetSection()
            ->GetMenu()
            ->GetName()]['item']
            = $oMenuItem;
        return $this;
    }


    public function SetInActiveSection(PluginAdmin_ModuleUi_EntityMenuSection $oMenuSection)
    {
        $sMenuName = $oMenuSection->GetMenu()->GetName();
        $oActiveSection = $this->GetActiveSection($sMenuName);
        if ($oActiveSection && $oActiveSection == $oMenuSection) {
            unset($this->_aData['active'][$sMenuName]['section']);
        }
        return $this;
    }


    public function SetInActiveItem(PluginAdmin_ModuleUi_EntityMenuItem $oMenuItem)
    {
        $sMenuName = $oMenuItem->GetSection()->GetMenu()->GetName();
        $oActiveItem = $this->GetActiveItem($sMenuName);
        if ($oActiveItem && $oActiveItem == $oMenuItem) {
            unset($this->_aData['active'][$sMenuName]['item']);
        }
        return $this;
    }


    public function PostSetActive($oEntity)
    {
        $bActive = $oEntity->GetActive();
        if ($bActive) {
            if ($oEntity instanceof PluginAdmin_ModuleUi_EntityMenuItem) {
                $oMenuSection = $oEntity->GetSection()->SetActive(true);
                $sMenuName = $oMenuSection->GetMenu()->GetName();
                $oActiveItem = $this->GetActiveItem($sMenuName);
                if (!$oActiveItem) {
                    $this->SetActiveItem($oEntity);
                    return $this;
                }
                $aMenuItems = $oMenuSection->GetItems();
                foreach ($aMenuItems as $oMenuItem) {
                    if (!$oMenuItem->GetActive()) {
                        continue;
                    }
                    if ($oMenuItem == $oEntity) {
                        $this->SetActiveItem($oEntity);
                    } else {
                        $oMenuItem->SetActive(false);
                    }
                }
            } elseif ($oEntity instanceof PluginAdmin_ModuleUi_EntityMenuSection) {
                $oMenu = $oEntity->GetMenu();
                $sMenuName = $oMenu->GetName();
                $oActiveSection = $this->GetActiveSection($sMenuName);
                if (!$oActiveSection) {
                    $this->SetActiveSection($oEntity);
                    return $this;
                }
                $aMenuSections = $oMenu->GetSections();
                foreach ($aMenuSections as $oMenuSection) {
                    if (!$oMenuSection->GetActive()) {
                        continue;
                    }
                    if ($oMenuSection == $oEntity) {
                        $this->SetActiveSection($oEntity);
                    } else {
                        $oMenuSection->SetActive(false);
                    }
                }
            }
        } else {
            if ($oEntity instanceof PluginAdmin_ModuleUi_EntityMenuItem) {
                $this->SetInActiveItem($oEntity);
            } elseif ($oEntity instanceof PluginAdmin_ModuleUi_EntityMenuSection) {
                $this->SetInActiveSection($oEntity);
            }
        }
        return $this;
    }

    //
    // Adders
    //

    public function AddMenu(PluginAdmin_ModuleUi_EntityMenu $oMenu)
    {
        if (!is_array(@$this->_aData['menus'])) {
            $this->_aData['menus'] = array($oMenu);
        } else {
            $this->_aData['menus'][] = $oMenu;
        }
        $oMenu->SetCursor($this);
        return $this;
    }

    //
    // Misc
    //

    public function Highligh()
    {
        $this->PluginAdmin_Ui_HighlightMenus($this);
        return $this;
    }

}

?>