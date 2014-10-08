<?php

class PluginAdmin_ModuleUi_EntityMenu extends Entity
{
    //
    // Getters
    //

    public function GetUrlPrefix()
    {
        return is_array($this->_aData['url_prefix'])
            ? $this->_aData['url_prefix']
            : array();
    }

    public function GetSections()
    {
        return is_array(@$this->_aData['sections'])
            ? $this->_aData['sections']
            : array();
    }

    public function GetSection($sName)
    {
        foreach ($this->GetSections() as $oSection) {
            if ($oSection->getName() == $sName) {
                return $oSection;
            }
        }
        return null;
    }

    public function AddItemToSection($sName, PluginAdmin_ModuleUi_EntityMenuItem $oMenuItem)
    {
        if ($oSection = $this->GetSection($sName)) {
            $oSection->AddItem($oMenuItem);
        }
        return $this;
    }

    public function GetCursor()
    {
        if (is_object(@$this->_aData['cursor'])) {
            $oCursor = $this->_aData['cursor'];
        } else {
            $oCursor = Engine::GetEntity('PluginAdmin_Ui_Cursor');
            $oCursor->AddMenu($this);
        }
        return $oCursor;
    }

    public function GetName()
    {
        return isset($this->_aData['name'])
            ? $this->_aData['name']
            : join('_', $this->GetUrlPrefix());
    }

    public function GetCaption()
    {
        return (string)@$this->_aData['caption'];
    }

    // Setters

    public function SetUrlPrefix($aPrefix)
    {
        if (!is_array($aPrefix)) {
            $aPrefix = explode('/', $aPrefix);
        }
        $this->_aData['url_prefix'] = $aPrefix;
        return $this;
    }

    public function SetCursor(PluginAdmin_ModuleUi_EntityCursor $oCursor)
    {
        $this->_aData['cursor'] = $oCursor;
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


    // Adders

    public function AddSection(PluginAdmin_ModuleUi_EntityMenuSection $oMenuSection)
    {
        if (!is_array(@$this->_aData['sections'])) {
            $this->_aData['sections'] = array($oMenuSection);
        } else {
            $this->_aData['sections'][] = $oMenuSection;
        }
        $oMenuSection->SetMenu($this);
        return $this;
    }
}

?>