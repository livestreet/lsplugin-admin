{**
 * Бан
 *}

{$component = 'p-user-ban-view'}
{component_define_params params=[ 'ban', 'stats', 'mods', 'classes', 'attributes' ]}

<div class="{$component} {cmods name=$component mods=$mods} {$classes}" {cattr list=$attributes}>
    {* Вывод статистики сколько раз данный бан сработал *}
    {if isset($stats[$ban->getId()])}
        {lang 'plugin.admin.bans.list.this_ban_triggered' count=$stats[$ban->getId()]}
    {/if}

    {* Описание правила бана *}
    <dl class="dotted-list-item">
        <dt class="dotted-list-item-label">
            {$aLang.plugin.admin.bans.table_header.block_type}
        </dt>
        <dd class="dotted-list-item-value width-350">
            {include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/users/bans_block_type_description.tpl" oBan=$ban}
        </dd>
    </dl>

    {* Тип ограничения бана *}
    <dl class="dotted-list-item">
        <dt class="dotted-list-item-label">
            {$aLang.plugin.admin.bans.table_header.restriction_type}
        </dt>
        <dd class="dotted-list-item-value width-350">
            {$aLang.plugin.admin.bans.list.restriction_types[$ban->getRestrictionType()]}
        </dd>
    </dl>

    {* Тип временного ограничения, даты начала и окончания бана (если тип == период) *}
    <dl class="dotted-list-item">
        <dt class="dotted-list-item-label">
            {$aLang.plugin.admin.bans.table_header.time_type}
        </dt>
        <dd class="dotted-list-item-value width-350">
            {if $ban->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERMANENT}
                {$aLang.plugin.admin.bans.list.time_type.permanent}
            {elseif $ban->getTimeType()==PluginAdmin_ModuleUsers::BAN_TIME_TYPE_PERIOD}
                {$aLang.plugin.admin.bans.list.time_type.period}:
                <b>
                    {$ban->getDateStart()} - {$ban->getDateFinish()}
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
            {$ban->getAddDate()}
        </dd>
    </dl>

    {* Отредактирован *}
    <dl class="dotted-list-item">
        <dt class="dotted-list-item-label">
            {$aLang.plugin.admin.bans.table_header.edit_date}
        </dt>
        <dd class="dotted-list-item-value width-350">
            {if $ban->getEditDate()}
                {$ban->getEditDate()}
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
            {if $ban->getReasonForUser()}
                {$ban->getReasonForUser()|escape}
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
            {if $ban->getComment()}
                {$ban->getComment()|escape}
            {else}
                &mdash;
            {/if}
        </dd>
    </dl>
</div>