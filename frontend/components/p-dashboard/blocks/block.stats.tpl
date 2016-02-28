{**
 * Статистика по комментариям, топикам и т.д.
 *}

{extends 'component@admin:block'}

{block 'block_options' append}
	{$title = $aLang.plugin.admin.index.new_items}
	{$content = ' '}
{/block}

{block 'block_header_inner' append}
	<form action="" method="get" enctype="application/x-www-form-urlencoded" id="admin_index_growth_block_form">
		{component 'admin:field.hidden.security-key'}

		{* Скрытые поля *}
		{include file="{$aTemplatePathPlugin.admin}forms/preset_interval.tpl"
			sName='filter[newly_added_items_period]'
			sId='admin_index_growth_period_select'
			sCurrentPeriod=$_aRequest.filter.newly_added_items_period}
	</form>
{/block}

{block 'block_content_inner'}
	<div id="admin_index_new_items_block">
		{include '../new_items_table.tpl'}
	</div>
{/block}