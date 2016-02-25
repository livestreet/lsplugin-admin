{**
 * Список банов
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.bans.title} <span>({$iBansTotalCount})</span>
{/block}

{block 'layout_content_actionbar'}
    {component 'admin:button' text=$aLang.plugin.admin.bans.add_ban url={router page='admin/users/bans/add'} mods='primary'}

	<div class="ls-fl-r">
		{*
			тип ограничения
		*}
		<a href="{$sFullPagePathToEvent}{request_filter
			name=array('ban_restriction_type', 'ban_time_type')
			value=array(null, $sBanTimeType)
		}" class="button {if $sBanRestrictionType==null}active{/if}">{$aLang.plugin.admin.bans.filter.restriction.all}</a>

		<a href="{$sFullPagePathToEvent}{request_filter
			name=array('ban_restriction_type', 'ban_time_type')
			value=array('full', $sBanTimeType)
		}" class="button {if $sBanRestrictionType=='full'}active{/if}">{$aLang.plugin.admin.bans.filter.restriction.full}</a>

		<a href="{$sFullPagePathToEvent}{request_filter
			name=array('ban_restriction_type', 'ban_time_type')
			value=array('readonly', $sBanTimeType)
		}" class="button {if $sBanRestrictionType=='readonly'}active{/if}">{$aLang.plugin.admin.bans.filter.restriction.readonly}</a>

		&nbsp;&mdash;&nbsp;

		{*
			временной тип банов
		*}
		<a href="{$sFullPagePathToEvent}{request_filter
			name=array('ban_restriction_type', 'ban_time_type')
			value=array($sBanRestrictionType, null)
		}" class="button {if $sBanTimeType==null}active{/if}">{$aLang.plugin.admin.bans.filter.time.all}</a>

		<a href="{$sFullPagePathToEvent}{request_filter
			name=array('ban_restriction_type', 'ban_time_type')
			value=array($sBanRestrictionType, 'permanent')
		}" class="button {if $sBanTimeType=='permanent'}active{/if}">{$aLang.plugin.admin.bans.filter.time.permanent}</a>

		<a href="{$sFullPagePathToEvent}{request_filter
			name=array('ban_restriction_type', 'ban_time_type')
			value=array($sBanRestrictionType, 'period')
		}" class="button {if $sBanTimeType=='period'}active{/if}">{$aLang.plugin.admin.bans.filter.time.period}</a>
	</div>
{/block}


{block 'layout_content'}
	{component 'admin:alert' text="{$aLang.plugin.admin.bans.list.current_date_on_server}: <b>{date('Y-m-d H:i:s')}</b>" mods='info'}
	{component 'admin:p-user' template='ban-list' bans=$aBans}
{/block}