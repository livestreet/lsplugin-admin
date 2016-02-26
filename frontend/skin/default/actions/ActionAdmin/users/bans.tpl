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
        {* тип ограничения *}
        {component 'admin:button' template='group' buttons=[
            [
                text => $aLang.plugin.admin.bans.filter.restriction.all,
                url => "{$sFullPagePathToEvent}{request_filter name=array('ban_restriction_type', 'ban_time_type') value=array(null, $sBanTimeType)}",
                classes => "{if $sBanRestrictionType == null}active{/if}"
            ],
            [
                text => $aLang.plugin.admin.bans.filter.restriction.full,
                url => "{$sFullPagePathToEvent}{request_filter name=array('ban_restriction_type', 'ban_time_type') value=array('full', $sBanTimeType)}",
                classes => "{if $sBanRestrictionType == 'full'}active{/if}"
            ],
            [
                text => $aLang.plugin.admin.bans.filter.restriction.readonly,
                url => "{$sFullPagePathToEvent}{request_filter name=array('ban_restriction_type', 'ban_time_type') value=array('readonly', $sBanTimeType)}",
                classes => "{if $sBanRestrictionType == 'readonly'}active{/if}"
            ]
        ]}

        {* временной тип банов *}
        {component 'admin:button' template='group' buttons=[
            [
                text => $aLang.plugin.admin.bans.filter.time.all,
                url => "{$sFullPagePathToEvent}{request_filter name=array('ban_restriction_type', 'ban_time_type') value=array($sBanRestrictionType, null)}",
                classes => "{if $sBanTimeType == null}active{/if}"
            ],
            [
                text => $aLang.plugin.admin.bans.filter.time.permanent,
                url => "{$sFullPagePathToEvent}{request_filter name=array('ban_restriction_type', 'ban_time_type') value=array($sBanRestrictionType, 'permanent')}",
                classes => "{if $sBanTimeType == 'permanent'}active{/if}"
            ],
            [
                text => $aLang.plugin.admin.bans.filter.time.period,
                url => "{$sFullPagePathToEvent}{request_filter name=array('ban_restriction_type', 'ban_time_type') value=array($sBanRestrictionType, 'period')}",
                classes => "{if $sBanTimeType == 'period'}active{/if}"
            ]
        ]}
    </div>
{/block}

{block 'layout_content'}
    {component 'admin:alert' text="{$aLang.plugin.admin.bans.list.current_date_on_server}: <b>{date('Y-m-d H:i:s')}</b>" mods='info'}
    {component 'admin:p-user' template='ban-list' bans=$aBans pagination=$aPaging}
{/block}