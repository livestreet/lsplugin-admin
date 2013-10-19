{**
 * Статитстика по кмментам, топикам и т.д.
 *
 * @styles blocks.css
 *}

{extends file="{$aTemplatePathPlugin.admin}blocks/block.aside.base.tpl"}

{block name='block_title'}{$aLang.plugin.admin.index.new_items}{/block}
{block name='block_type'}home-stats{/block}
{block name='block_class'}block-home{/block}

{block name='block_header_end'}
	<form action="" method="get" enctype="application/x-www-form-urlencoded" id="admin_index_growth_block_form">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		<select name="filter[newly_added_items_period]" class="width-150" id="admin_index_growth_period_select">
			<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}"
					{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_TODAY}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.today}</option>
			<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}"
					{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_YESTERDAY}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.yesterday}</option>
			<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}"
					{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_WEEK}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.week}</option>
			<option value="{PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}"
					{if $_aRequest.filter.newly_added_items_period==PluginAdmin_ModuleStats::TIME_INTERVAL_MONTH}selected="selected"{/if}>{$aLang.plugin.admin.index.period_bar.month}</option>
		</select>
	</form>
{/block}

{block name='block_content'}
	<div id="admin_index_new_items_block">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/new_items_table.tpl"}
	</div>
{/block}

{block name='block_footer'}
	{* <button class="button width-full">More</button> *}
{/block}