{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

	<h2 class="Title mb20">
		{$aLang.plugin.admin.settings.titles.current_skin}
	</h2>
	
	<div class="SkinList">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/skin/skin.tpl" oSkin=$oCurrentSkin}
	</div>
	
	<h2 class="Title mb20">
		{$aLang.plugin.admin.settings.titles.skin_config}
	</h2>
	
	<div class="SkinList">
		{foreach from=$aSkins item=oSkin name=SkinForCycle}
			{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/skin/skin.tpl"}
		{/foreach}
	</div>
	
{/block}