{**
 * Информация о бане
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page='admin/users/bans'}" class="button">{$aLang.plugin.admin.bans.back_to_list}</a>
{/block}


{block name='layout_page_title'}
	<div class="ls-fl-r">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/bans_controls.tpl"}
	</div>
	{$aLang.plugin.admin.bans.view.title} <span>#{$oBan->getId()}</span>
{/block}


{block name='layout_content'}
	{* Описание правила бана *}
	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.block_type}
		</dt>
		<dd class="dotted-list-item-value width-350">
			{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/bans_block_type_description.tpl"}
		</dd>
	</dl>

	{* Тип ограничения бана *}
	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.restriction_type}
		</dt>
		<dd class="dotted-list-item-value width-350">
			{$aLang.plugin.admin.bans.list.restriction_types[$oBan->getRestrictionType()]}
		</dd>
	</dl>

	{* Тип временного ограничения, даты начала и окончания бана (если тип == период) *}
	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.time_type}
		</dt>
		<dd class="dotted-list-item-value width-350">
			{if $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT}
				{$aLang.plugin.admin.bans.list.time_type.permanent}
			{elseif $oBan->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
				{$aLang.plugin.admin.bans.list.time_type.period}:
				<b>
					{$oBan->getDateStart()} - {$oBan->getDateFinish()}
				</b>
			{/if}
		</dd>
	</dl>

	{* Добавлен *}
	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.add_date}
		</dt>
		<dd class="dotted-list-item-value width-350">
			{$oBan->getAddDate()}
		</dd>
	</dl>

	{* Отредактирован *}
	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.edit_date}
		</dt>
		<dd class="dotted-list-item-value width-350">
			{if $oBan->getEditDate()}
				{$oBan->getEditDate()}
			{else}
				&mdash;
			{/if}
		</dd>
	</dl>

	{* Причина, которая будет показана пользователю *}
	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.reason_for_user}
		</dt>
		<dd class="dotted-list-item-value width-350">
			{if $oBan->getReasonForUser()}
				{$oBan->getReasonForUser()|escape:'html'}
			{else}
				&mdash;
			{/if}
		</dd>
	</dl>

	{* Комментарий "для себя" *}
	<dl class="dotted-list-item">
		<dt class="dotted-list-item-label">
			{$aLang.plugin.admin.bans.table_header.comment}
		</dt>
		<dd class="dotted-list-item-value width-350">
			{if $oBan->getComment()}
				{$oBan->getComment()|escape:'html'}
			{else}
				&mdash;
			{/if}
		</dd>
	</dl>
{/block}