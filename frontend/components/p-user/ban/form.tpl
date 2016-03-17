{**
 * Форма добавления/редактирования бана
 *}

{$component = 'p-user-ban-form'}
{$lang = 'plugin.admin.bans.add'}
{component_define_params params=[ 'field', 'types' ]}

{capture form}
    {component 'admin:field' template='hidden' name='ban_id'}

    {* Идентификация пользователя *}
    {component 'admin:field' template='text' name='user_sign' id='admin_bans_user_sign' label={lang "$lang.user_sign"} note={lang "$lang.user_sign_info"}}

    {**
     *  если блокировка по сущности пользователя - добавить возможность одновременного бана по айпи
     *  tip: битовое логическое И
     *}
    <div id="js_admin_users_bans_secondary_rule_wrapper" class="ls-mb-30" {if !($_aRequest.block_type & PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID)}style="display: none;"{/if}>
        {* Дополнительное правило бана *}
        {component 'admin:field' template='text' name='secondary_rule' id='admin_bans_secondary_rule' label={lang "$lang.secondary_rule"} note={lang "$lang.secondary_rule_info"}}
    </div>

    {* Результат ajax-проверки поля *}
    <div id="admin_bans_checking_msg" class="alert alert-info ls-mb-30" style="display: none;"></div>

    {* Тип ограничения пользования сайтом для бана *}
    {$items = []}

    {foreach [ PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_FULL, PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_READ_ONLY ] as $type}
        {$items[] = [ text => $aLang.plugin.admin.bans.add.restriction_types.$type, value => $type ]}
    {/foreach}

    {component 'admin:field.select' name='restriction_type' items=$items label=$aLang.plugin.admin.bans.add.restriction_title}

    <div class="p-user-ban-form-periods">
        <label class="p-user-ban-form-periods-label">{$aLang.plugin.admin.bans.add.ban_time_title}:</label>

        {* Пожизненно *}
        <div class="p-user-ban-form-period">
            {component 'admin:field.radio'
                name='bantype[]'
                label=$aLang.plugin.admin.bans.add.ban_timing.unlimited
                value='unlimited'
                checked=(in_array('unlimited', (array) $_aRequest.bantype) or is_null($_aRequest.bantype))}

            <div class="p-user-ban-form-period-body">
                {$aLang.plugin.admin.bans.add.ban_timing.unlimited_info}
            </div>
        </div>

        {* На период времени *}
        <div class="p-user-ban-form-period">
            {component 'admin:field.radio'
                name='bantype[]'
                label=$aLang.plugin.admin.bans.add.ban_timing.period
                value='period'
                checked=(in_array('period', (array) $_aRequest.bantype))}

            <div class="p-user-ban-form-period-body">
                <p class="mb-10">{$aLang.plugin.admin.bans.add.ban_timing.period_info}</p>

                {$aLang.plugin.admin.from}
                <input type="text" name="date_start" value="{if $_aRequest.date_start}{$_aRequest.date_start}{else}{date('Y-m-d')}{/if}" class="input-text width-150 date-picker-php" />
                &nbsp;&nbsp;&nbsp;

                {$aLang.plugin.admin.to}
                <input type="text" name="date_finish" value="{$_aRequest.date_finish}" class="input-text width-150 date-picker-php" />

                <small class="p-user-ban-form-period-note">{$aLang.plugin.admin.bans.add.ban_timing.period_info2}</small>
            </div>
        </div>

        {* На количество дней *}
        <div class="p-user-ban-form-period">
            {component 'admin:field.radio'
                name='bantype[]'
                label=$aLang.plugin.admin.bans.add.ban_timing.days
                value='days'
                checked=(in_array('days', (array) $_aRequest.bantype))}

            <div class="p-user-ban-form-period-body">
                <p class="mb-10">{$aLang.plugin.admin.bans.add.ban_timing.days_info}</p>

                <input type="text" name="days_count" value="{$_aRequest.days_count}" class="input-text width-100" />

                <small class="p-user-ban-form-period-note">{$aLang.plugin.admin.bans.add.ban_timing.period_info2}</small>
            </div>
        </div>
    </div>

    {component 'admin:field' template='text' name='reason_for_user' label={lang "$lang.reason"} note={lang "$lang.reason_tip"}}
    {component 'admin:field' template='text' name='comment' label={lang "$lang.comment"} note={lang "$lang.comment_for_yourself_tip"}}
{/capture}

{component 'admin:p-form'
    action={router page='admin/users/bans/add'}
    isEdit=$_aRequest
    form=$smarty.capture.form
    submit=[ name => 'submit_add_ban' ]}