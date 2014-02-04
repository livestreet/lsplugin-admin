{**
 * Добавление бана
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	{$aLang.plugin.admin.bans.add.title}
{/block}


{block name='layout_content_actionbar'}
	<a href="{router page='admin/users/bans'}" class="button">{$aLang.plugin.admin.bans.back_to_list}</a>
{/block}


{block name='layout_content'}
	<form action="{router page='admin/users/bans/add'}" method="post" enctype="application/x-www-form-urlencoded">
		{* Скрытые поля *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.tpl" sFieldName='ban_id' sFieldValue=$_aRequest.id}

		{* Пользователь *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				sFieldName    = 'user_sign'
				sFieldClasses = 'width-250 autocomplete-users'
				sFieldNote    = $aLang.plugin.admin.bans.add.user_sign_info
				sFieldLabel   = $aLang.plugin.admin.bans.add.user_sign
				sFieldId	  = 'admin_bans_user_sign'
		}

		{*
			если блокировка по сущности - добавить возможность одновременного бана по айпи
			tip: битовое логическое И
		*}
		<div id="js_admin_users_bans_secondary_rule_wrapper" {if !($_aRequest.block_type & PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID)}style="display: none;"{/if}>
			{* Допоплнительное правило бана *}
			{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				sFieldName    = 'secondary_rule'
				sFieldClasses = 'width-250'
				sFieldNote    = $aLang.plugin.admin.bans.add.secondary_rule_info
				sFieldLabel   = $aLang.plugin.admin.bans.add.secondary_rule
				sFieldId	  = 'admin_bans_secondary_rule'
			}
		</div>

		{* Результат ajax-проверки поля *}
		<div id="admin_bans_checking_msg" class="alert alert-info" style="display: none;"></div>

		{* Тип ограничения пользования сайтом для бана *}
		<label class="mb-15 mt-20">{$aLang.plugin.admin.bans.add.restriction_title}</label>
		<select name="restriction_type" class="width-full mb-30">
			{foreach from=array(PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_FULL, PluginAdmin_ModuleUsers::BAN_RESTRICTION_TYPE_READ_ONLY) item=iRestrictionType}
				<option value="{$iRestrictionType}" {if $_aRequest.restriction_type==$iRestrictionType}selected="selected"{/if}>
					{$aLang.plugin.admin.bans.add.restriction_types.$iRestrictionType}
				</option>
			{/foreach}
		</select>


		<label class="mb-15">{$aLang.plugin.admin.bans.add.ban_time_title}</label>

		{* Пожизненно *}
		<div class="form-field form-field-inline form-field-option">
			<label class="form-field-label">
				<input type="radio" name="bantype[]" value="unlimited"
					   {if in_array('unlimited', (array) $_aRequest.bantype) or is_null($_aRequest.bantype)}checked="checked"{/if} />
				{$aLang.plugin.admin.bans.add.ban_timing.unlimited}
			</label>

		    <div class="form-field-holder">
				{$aLang.plugin.admin.bans.add.ban_timing.unlimited_info}
		    </div>
		</div>

		{* На период времени *}
		<div class="form-field form-field-inline form-field-option">
			<label class="form-field-label">
				<input type="radio" name="bantype[]" value="period"
					   {if in_array('period', (array) $_aRequest.bantype)}checked="checked"{/if} />
				{$aLang.plugin.admin.bans.add.ban_timing.period}
			</label>

		    <div class="form-field-holder">
				<p class="mb-10">{$aLang.plugin.admin.bans.add.ban_timing.period_info}</p>

				{$aLang.plugin.admin.from}
				<input type="text" name="date_start" value="{if $_aRequest.date_start}{$_aRequest.date_start}{else}{date('Y-m-d')}{/if}" class="input-text width-150 date-picker-php" />
				&nbsp;&nbsp;&nbsp;

				{$aLang.plugin.admin.to}
				<input type="text" name="date_finish" value="{$_aRequest.date_finish}" class="input-text width-150 date-picker-php" />

				<small class="note">{$aLang.plugin.admin.bans.add.ban_timing.period_info2}</small>
		    </div>
		</div>

		{* На количество дней *}
		<div class="form-field form-field-inline form-field-option">
			<label class="form-field-label">
				<input type="radio" name="bantype[]" value="days"
					   {if in_array('days', (array) $_aRequest.bantype)}checked="checked"{/if} />
				{$aLang.plugin.admin.bans.add.ban_timing.days}
			</label>

		    <div class="form-field-holder">
				<p class="mb-10">{$aLang.plugin.admin.bans.add.ban_timing.days_info}</p>

				<input type="text" name="days_count" value="{$_aRequest.days_count}" class="input-text width-100" />

				<small class="note">{$aLang.plugin.admin.bans.add.ban_timing.period_info2}</small>
		    </div>
		</div>

		{* Причина *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName    = 'reason_for_user'
				 sFieldNote    = $aLang.plugin.admin.bans.add.reason_tip
				 sFieldLabel   = $aLang.plugin.admin.bans.add.reason}

		{* Заметка *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
				 sFieldName    = 'comment'
				 sFieldNote    = $aLang.plugin.admin.bans.add.comment_for_yourself_tip
				 sFieldLabel   = $aLang.plugin.admin.bans.add.comment}

		{* Кнопки *}
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl" sFieldName='submit_add_ban' sFieldStyle='primary' sFieldText=$aLang.plugin.admin.save}
	</form>
{/block}