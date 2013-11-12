{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.skin.title}
{/block}


{block name='layout_content'}
	<h2 class="page-sub-header">{$aLang.plugin.admin.settings.titles.current_skin}</h2>
	
	<div class="skin-list">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/skin/skin.tpl" oSkin=$oCurrentSkin}
	</div>
	
	<h2 class="page-sub-header"> {$aLang.plugin.admin.settings.titles.skin_config} </h2>

	<div class="skin-list">
		{foreach from=$aSkins item=oSkin name=SkinForCycle}
			{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/skin/skin.tpl"}
		{/foreach}
	</div>
{/block}