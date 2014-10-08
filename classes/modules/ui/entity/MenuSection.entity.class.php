<?php

class PluginAdmin_ModuleUi_EntityMenuSection extends Entity
{
    // Getters

    public function GetUrl()
    {
        return (string)@$this->_aData['url'];
    }

    public function GetUrlArray()
    {
        $oMenu = $this->GetMenu();
        $aUrl = array_filter(array_map(
            'urlencode',
            array_merge(
                $oMenu->GetUrlPrefix(),
                explode('/', $this->GetUrl())
            )
        ));
        return $aUrl;
    }

    public function GetUrlFull()
    {
        return Router::GetPath(join('/', $this->GetUrlArray()));
    }

    public function GetMenu()
    {
        if (isset($this->_aData['menu'])
            && is_object($this->_aData['menu'])
        ) {
            $oMenu = $this->_aData['menu'];
        } else {
            $oMenu
                = $this->_aData['menu']
                = Engine::GetEntity('PluginAdmin_Ui_Menu');
        }
        return $oMenu;
    }

    public function GetActive()
    {
        return (bool)@$this->_aData['active'];
    }

    public function GetItems()
    {
        return is_array(@$this->_aData['items'])
            ? $this->_aData['items']
            : array();
    }

    public function GetCaption()
    {
        return (string)@$this->_aData['caption'];
    }

    public function GetName()
    {
        return (string)@$this->_aData['name'];
    }

    public function GetCssClass()
    {
        return (string)@$this->_aData['css_class'];
    }

    // Setters

    public function SetUrl($sUrl)
    {
        $this->_aData['url'] = (string)$sUrl;
        return $this;
    }

    public function SetMenu(PluginAdmin_ModuleUi_EntityMenu $oMenu)
    {
        $this->_aData['menu'] = $oMenu;
        return $this;
    }

    public function SetActive($bActive = true)
    {
        $this->_aData['active'] = (bool)$bActive;
        $oCursor = $this->GetMenu()->GetCursor();
        $oCursor->PostSetActive($this);
        if (!$this->GetActive()) {
            $aMenuItems = $this->GetItems();
            foreach ($aMenuItems as $oMenuItem) {
                $oMenuItem->SetActive(false);
            }
        }
        return $this;
    }

    public function SetCaption($sCaption)
    {
        $this->_aData['caption'] = (string)@$sCaption;
        return $this;
    }

    public function SetName($sName)
    {
        $this->_aData['name'] = (string)@$sName;
        return $this;
    }

    public function SetCssClass($sCssClass)
    {
        $this->_aData['css_class'] = (string)@$sCssClass;
        return $this;
    }


    // Adders

    public function AddItem(PluginAdmin_ModuleUi_EntityMenuItem $oMenuItem)
    {
        if (!is_array(@$this->_aData['items'])) {
            $this->_aData['items'] = array($oMenuItem);
        } else {
            $this->_aData['items'][] = $oMenuItem;
        }
        $oMenuItem->SetSection($this);
        return $this;
    }

    // Misc

    public function HasItems()
    {
        return !empty($this->_aData['items']);
    }
}

?>