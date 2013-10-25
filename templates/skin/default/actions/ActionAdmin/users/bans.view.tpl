{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page='admin/users/bans'}" class="button">{$aLang.plugin.admin.bans.back_to_list}</a>
{/block}


{block name='layout_page_title'}
	{$aLang.plugin.admin.bans.view.title} #{$oBan->getId()}
{/block}


{block name='layout_content'}
	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.block_type}
		</dt>
		<dd class="dotted-list-item-value">
			{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/bans_block_type_description.tpl"}
		</dd>
	</dl>

	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.time_type}
		</dt>
		<dd class="dotted-list-item-value">
			{if $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT}
				{$aLang.plugin.admin.bans.list.time_type.permanent}
			{elseif $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
				{$aLang.plugin.admin.bans.list.time_type.period}
				<br />
				{$oBan->getDateStart()} - {$oBan->getDateFinish()}
			{/if}
		</dd>
	</dl>

	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.add_date}
		</dt>
		<dd class="dotted-list-item-value">
			{$oBan->getAddDate()}
		</dd>
	</dl>

	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.edit_date}
		</dt>
		<dd class="dotted-list-item-value">
			{if $oBan->getEditDate()}
				{$oBan->getEditDate()}
			{else}
				&mdash;
			{/if}
		</dd>
	</dl>

	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.reason_for_user}
		</dt>
		<dd class="dotted-list-item-value">
			{if $oBan->getReasonForUser()}
				{$oBan->getReasonForUser()|escape:'html'}
			{else}
				&mdash;
			{/if}
		</dd>
	</dl>

	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.comment}
		</dt>
		<dd class="dotted-list-item-value">
			{if $oBan->getComment()}
				{$oBan->getComment()|escape:'html'}
			{else}
				&mdash;
			{/if}
		</dd>
	</dl>

{/block}