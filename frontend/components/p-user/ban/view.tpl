{**
 * Бан
 *}

{$component = 'p-user-ban-view'}
{$lang = $aLang.plugin.admin.bans.table_header}
{component_define_params params=[ 'ban', 'stats', 'mods', 'classes', 'attributes' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    {* Вывод статистики сколько раз данный бан сработал *}
    {if isset($stats[$ban->getId()])}
        {lang 'plugin.admin.bans.list.this_ban_triggered' count=$stats[$ban->getId()]}
    {/if}

    {* Тип временного ограничения, даты начала и окончания бана (если тип == период) *}
    {capture 'ban_time_type'}
        {if $ban->getTimeType() == PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT}
            {$aLang.plugin.admin.bans.list.time_type.permanent}
        {elseif $ban->getTimeType() == PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
            {$aLang.plugin.admin.bans.list.time_type.period}:
            <b>{$ban->getDateStart()} - {$ban->getDateFinish()}</b>
        {/if}
    {/capture}

    {component 'admin:info-list' list=[
        [ label => $lang.block_type,       content => {component 'admin:p-user.ban-desc' ban=$ban} ],
        [ label => $lang.restriction_type, content => "{$aLang.plugin.admin.bans.list.restriction_types[$ban->getRestrictionType()]}" ],
        [ label => $lang.time_type,        content => $smarty.capture.ban_time_type ],
        [ label => $lang.add_date,         content => $ban->getAddDate() ],
        [ label => $lang.edit_date,        content => $ban->getEditDate()|default:"&mdash;" ],
        [ label => $lang.reason_for_user,  content => $ban->getReasonForUser()|default:"&mdash;" ],
        [ label => $lang.comment,          content => $ban->getComment()|default:"&mdash;" ]
    ]}
</div>