<?php

class PluginAdmin_ModuleUi_EntityMenuItem extends Entity
{
    // Getters

    public function GetSection()
    {
        if (isset($this->_aData['section'])
            && is_object($this->_aData['section'])
        ) {
            $oMenuSection = $this->_aData['section'];
        } else {
            $oMenuSection
                = $this->_aData['section']
                = Engine::GetEntity('PluginAdmin_Ui_MenuSection');
        }
        return $oMenuSection;
    }

    public function GetUrl()
    {
        return (string)@$this->_aData['url'];
    }

    public function GetUrlArray()
    {
        $oMenuSection = $this->GetSection();
        $oMenu = $oMenuSection->GetMenu();
        $sUrlItem = $this->GetUrl();
        if (strpos($sUrlItem, '/') === 0) {
            $aUrl = array_filter(array_map(
                'urlencode',
                explode('/', $sUrlItem)
            ));
        } else {
            $aUrl = array_filter(array_map(
                'urlencode',
                array_merge(
                    $oMenu->GetUrlPrefix(),
                    explode('/', $oMenuSection->GetUrl()),
                    explode('/', $sUrlItem)
                )
            ));
        }

        return $aUrl;
    }

    public function GetUrlFull($bAbsolute = true)
    {
        if ((string)@$this->_aData['url_full']) {
            $sUrl = (string)@$this->_aData['url_full'];
        } else {
            $sUrl = join('/', $this->GetUrlArray());
        }
        return $bAbsolute ? Router::GetPath($sUrl) : $sUrl;
    }

    public function GetActive()
    {
        return (bool)@$this->_aData['active'];
    }

    public function GetCaption()
    {
        return (string)@$this->_aData['caption'];
    }


    // Setters

    public function SetSection(PluginAdmin_ModuleUi_EntityMenuSection $oMenuSection)
    {
        $this->_aData['section'] = $oMenuSection;
        return $this;
    }

    public function SetUrl($sUrl)
    {
        $this->_aData['url'] = (string)$sUrl;
        return $this;
    }

    public function SetUrlFull($sUrl)
    {
        $this->_aData['url_full'] = (string)$sUrl;
        return $this;
    }

    public function SetActive($bActive = true)
    {
        $this->_aData['active'] = (bool)$bActive;
        $oCursor = $this->GetSection()->GetMenu()->GetCursor();
        $oCursor->PostSetActive($this);
        return $this;
    }

    public function SetCaption($sCaption)
    {
        $this->_aData['caption'] = (string)@$sCaption;
        return $this;
    }

}

?>