<?php


class PluginArticle_ModuleMain extends ModuleORM {

	public function GetPropertyTargetType() {
		return Config::Get('plugin.article.property_target_type');
	}

	public function GetArticleItemsByTag($sTag,$iCurrPage,$iPerPage) {
		$aResult=$this->Property_GetTargetsByTag($sTag,$iCurrPage,$iPerPage);
		if ($aResult['collection']) {
			$aResult['collection']=$this->GetArticleItemsByFilter(array('id in'=>$aResult['collection'],'#order'=>array('FIELD:id'=>$aResult['collection'])));
		}
		return $aResult;
	}
}