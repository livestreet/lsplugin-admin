{**
 * Список шаблонов
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.skin.title}
{/block}


{block name='layout_content'}
	<h2 class="page-sub-header">{$aLang.plugin.admin.settings.titles.current_skin}</h2>
	
	<div class="skin-list">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/skins/skin.tpl" oSkin=$oSkinCurrent}
	</div>

	{if $aSkins and count($aSkins)}
		<h2 class="page-sub-header">{$aLang.plugin.admin.settings.titles.other_skins}</h2>

		<div class="skin-list">
			{foreach $aSkins as $oSkin}
				{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/skins/skin.tpl"}
			{/foreach}
		</div>
	{/if}
{/block}