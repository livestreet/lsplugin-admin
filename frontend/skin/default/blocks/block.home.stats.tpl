{**
 * Статистика по комментариям, топикам и т.д.
 *
 * @styles blocks.css
 *}

{extends file="{$aTemplatePathPlugin.admin}blocks/block.aside.base.tpl"}

{block name='block_title'}{$aLang.plugin.admin.index.new_items}{/block}
{block name='block_type'}home-stats{/block}
{block name='block_class'}block-home{/block}

{block name='block_header_end'}
	<form action="" method="get" enctype="application/x-www-form-urlencoded" id="admin_index_growth_block_form">
		{component 'admin:field.hidden.security-key'}

		{* Скрытые поля *}
		{include file="{$aTemplatePathPlugin.admin}forms/preset_interval.tpl"
			sName='filter[newly_added_items_period]'
			sId='admin_index_growth_period_select'
			sCurrentPeriod=$_aRequest.filter.newly_added_items_period
		}
	</form>
{/block}

{block name='block_content'}
	<div id="admin_index_new_items_block">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_table.tpl"}
	</div>
{/block}