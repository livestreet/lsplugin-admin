{**
 * Список событий активности
 *}

{if count($aStreamEvents)}
	<ul id="activity-event-list">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/index/activity/events.tpl"}
	</ul>

	{if ! $bDisableGetMoreButton}
		<input type="hidden" id="activity-last-id" value="{$iStreamLastId}" />
	{/if}
{else}
	{$aLang.stream_no_events}
{/if}
