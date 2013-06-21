<?php 

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginAdmin_ModuleUi
extends Module {
	
	protected $oMenuMain;
	protected $oMenuAddition;
	protected $oCursor;
	protected $aAjaxArray = array();
	protected $aViewerArray = array(
		'aAdminNotice'	=> array(),
	);
	
	/**
	 * Инициализация
	 *
	 */
	public function Init() {
		// init menu
		$this->oCursor = Engine::GetEntity('PluginAdmin_Ui_Cursor');
		$this->oMenuMain = $this->oCursor->GetMenu('main')
			->SetUrlPrefix('admin')
		;
		$this->oMenuAddition = $this->oCursor->GetMenu('addition')
			->SetUrlPrefix('admin/p')
			->SetCaption('Дополнительно')
		;
		$this->Viewer_AddSmartyPluginsDir(Plugin::GetPath(__CLASS__).'include/smarty/');
	}
	
	public function GetMenuMain() {
		return $this->oMenuMain;
	}
	
	public function GetMenuAddition() {
		return $this->oMenuAddition;
	}
	
	public function GetCursor() {
		return $this->oCursor;
	}

	
	public function HighlightMenus($oCursor = null){
		if(is_null($oCursor)){
			$oCursor = $this->oCursor;
		}
		$aEventParams = Router::GetParams();
		$aUrlParams = array_merge(
			array(Router::GetAction(), Router::GetActionEvent()),
			$aEventParams
		);
		$aMenus = $oCursor->GetMenus();
		foreach($aMenus as $sName => $oMenu){
			$aMenuSections = $oMenu->GetSections();
			foreach($aMenuSections as $oMenuSection){
				$oMenuSection->SetActive(false);
				if(count($aUrlParams) < count($aSectionUrlParams = $oMenuSection->GetUrlArray())){
					continue;
				}else{
					$aSlice = array_slice($aUrlParams, 0, count($aSectionUrlParams));
					if($aSlice != $aSectionUrlParams){
						continue;
					}
				}
				$oMenuSection->SetActive(true);
				$aMenuItems = $oMenuSection->GetItems();
				foreach($aMenuItems as $oMenuItem){
					$oMenuItem->SetActive(false);
					if(count($aUrlParams) < count($aItemUrlParams = $oMenuItem->GetUrlArray())){
						continue;
					}else{
						$aSlice = array_slice($aUrlParams, 0, count($aItemUrlParams));
						if($aSlice != $aItemUrlParams){
							continue;
						}
					}
					$oMenuItem->SetActive(true);
				}
			}
		}
		return $oCursor;
	}
	
	
	public function MergeMessages(){
		$aErrors = $this->Message_GetError();
		$aNotices = $this->Message_GetNotice();
		if(count($aErrors)>1){
			$sMsg = $sTitle = '';
			foreach($aErrors as $aError){
				$sTitle = $sTitle ? $sTitle : $aError['title'];
				$sMsg .= ($sMsg ? '<br>' : '').$aError['msg'];
			}
			$this->Message_AddErrorSingle($sMsg, $sTitle);
		}elseif(!$aErrors && count($aNotices)>1){
			$sMsg = $sTitle = '';
			foreach($aNotices as $aNotice){
				$sTitle = $sTitle ? $sTitle : $aNotice['title'];
				$sMsg .= ($sMsg ? '<br>' : '').$aNotice['msg'];
			}
			$this->Message_AddNoticeSingle($sMsg, $sTitle);
		}
	}
	
	public function DisplayJson($bMergeMessages = true){
		if($bMergeMessages){
			$this->MergeMessages();
		}
		$this->AjaxArraysToViewer();
		$this->Viewer_DisplayAjax('json');
	}
	
	public function AjaxArraysToViewer(){
		foreach($this->aAjaxArray as $sName => $aArray){
			$this->Viewer_AssignAjax($sName, $aArray);
		}
	}
	
	public function AddAjaxArrayElement($sArrayName, $mValue, $sKey = null){
		if(is_null($sKey)){
			$this->aAjaxArray[$sArrayName][] = $mValue;
		}else{
			$this->aAjaxArray[$sArrayName][$sKey] = $mValue;
		}
	}
	
	public function ArraysToViewer(){
		foreach($this->aViewerArray as $sName => $aArray){
			$this->Viewer_Assign($sName, $aArray);
		}
	}
	
	public function AddViewerArrayElement($sArrayName, $mValue, $sKey = null){
		if(is_null($sKey)){
			$this->aViewerArray[$sArrayName][] = $mValue;
		}else{
			$this->aViewerArray[$sArrayName][$sKey] = $mValue;
		}
	}
	
	public function GetViewerArray($sArrayName){
		if(isset($this->aViewerArray[$sArrayName])
		&& is_array($this->aViewerArray[$sArrayName])){
			return $this->aViewerArray[$sArrayName];
		}
		return array();
	}
	
	public function AddHeadJsDefine($sName, $mValue){
		$this->AddViewerArrayElement('aHeadJsDefine', $mValue, $sName);
	}
}
 
?>