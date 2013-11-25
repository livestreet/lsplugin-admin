{*
	Вывод настроек
*}

{if $aSettingsAll and count($aSettingsAll) > 0}
	<form action="{router page="admin/settings/save/{$sConfigName}"}" method="post" enctype="application/x-www-form-urlencoded" id="admin_settings_save">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{foreach $aSettingsAll as $oParameter}
			{$sKey = $oParameter->getKey()}
			{$sInputDataName = "SettingsNum{$oParameter@iteration}[]"}

			{if in_array($oParameter->getType(), array('integer', 'string', 'float', 'array', 'boolean'))}
				{include file="{$aTemplatePathPlugin.admin}settings/fields/settings.field.{$oParameter->getType()}.tpl"}
			{else}
				{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="{$aLang.plugin.admin.errors.unknown_parameter_type}: <b>{$oParameter->getType()}</b>" sAlertStyle='error'}
			{/if}
		{/foreach}
		
		<button type="submit" name="submit_save_settings" class="button button-primary" id="admin_settings_submit">{$aLang.plugin.admin.save}</button>
	</form>
{else}
	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.settings.no_settings_for_this_plugin sAlertStyle='info'}
{/if}