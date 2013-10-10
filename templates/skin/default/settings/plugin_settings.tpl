{if $aSettingsAll and count($aSettingsAll) > 0}
	<form action="{router page="admin/settings/save/{$sConfigName}"}" method="post" enctype="application/x-www-form-urlencoded" id="admin_save">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

		{foreach $aSettingsAll as $oParameter}
			{$sKey = $oParameter->getKey()}
			{$sInputDataName = "SettingsNum{$oParameter@iteration}[]"}

			<a name="p{$oParameter@iteration}"></a>

			<div class="OneParameterContainer mb-20">
				<div class="ParamNum">#{$oParameter@iteration}</div>
				<div class="DisplayKey">{$sKey}</div>

				<input type="hidden" name="{$sInputDataName}" value="{$sAdminSettingsFormSystemId}" />
				<input type="hidden" name="{$sInputDataName}" value="{$sKey}" />

				<div>
					{$oParameter->getName()}
				</div>

				<div>
					{include file="{$aTemplatePathPlugin.admin}settings/plugin_settings_one_field.tpl"}
				</div>

				<div>
					{$oParameter->getDescription()}
				</div>
			</div>
		{/foreach}
		
		<button type="submit" name="submit_save_settings" class="button button-primary">{$aLang.plugin.admin.save}</button>
	</form>
{else}
	{$aLang.plugin.admin.settings.no_settings_for_this_plugin}
{/if}