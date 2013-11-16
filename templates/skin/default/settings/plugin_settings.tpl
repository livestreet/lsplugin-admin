{*
	Вывод настроек
*}

{if $aSettingsAll and count($aSettingsAll) > 0}
	<form action="{router page="admin/settings/save/{$sConfigName}"}" method="post" enctype="application/x-www-form-urlencoded" id="admin_settings_save">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

		{foreach $aSettingsAll as $oParameter}
			{$sKey = $oParameter->getKey()}
			{$sInputDataName = "SettingsNum{$oParameter@iteration}[]"}

			<div class="form-field js-settings-field">
				<a name="p{$oParameter@iteration}"></a>

				{* 
					<div class="ParamNum">#{$oParameter@iteration}</div>
					<div class="DisplayKey">{$sKey}</div>
					type: <b>{$oParameter->getType()}</b>
				 *}

				<input type="hidden" name="{$sInputDataName}" value="{$sAdminSettingsFormSystemId}" />
				<input type="hidden" name="{$sInputDataName}" value="{$sKey}" />

				<label for="">{$oParameter->getName()}</label>

				<div class="form-field-holder">
					{include file="{$aTemplatePathPlugin.admin}settings/plugin_settings_one_field.tpl"}

					<small class="note">{$oParameter->getDescription()}</small>
				</div>
			</div>
		{/foreach}
		
		<button type="submit" name="submit_save_settings" class="button button-primary" id="admin_settings_submit">{$aLang.plugin.admin.save}</button>
	</form>
{else}
	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.settings.no_settings_for_this_plugin sAlertStyle='info'}
{/if}
