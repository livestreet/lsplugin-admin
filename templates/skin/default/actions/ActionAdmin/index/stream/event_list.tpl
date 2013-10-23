{**
 * Список событий активности

 * (создан на основе активности из шаблона синьйо дев-версии и упрощен (выкинуто лишнее)
 * todo: потом удалить этот и комментарий выше
 *}

{if count($aStreamEvents)}
	<ul id="activity-event-list">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/stream/events.tpl"}
	</ul>

	{if ! $bDisableGetMoreButton}
		<input type="hidden" id="activity-last-id" value="{$iStreamLastId}" />
		<div class="get-more" id="activity-get-more">{$aLang.stream_get_more}</div>
	{/if}
{else}
	{$aLang.stream_no_events}
{/if}
