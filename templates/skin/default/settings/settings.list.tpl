{**
 * Вывод настроек движка или плагина
 *}

{*
	todo: переделать
*}
{if ($aSections and count($aSections) > 0) or ($aSettingsAll and count($aSettingsAll) > 0)}
	<script>
		ls.registry.set('settings.admin_save_form_ajax_use', {json var=$oConfig->Get('plugin.admin.settings.admin_save_form_ajax_use')});
	</script>

	<form action="{router page="admin/settings/save/{$sConfigName}"}" method="post" enctype="application/x-www-form-urlencoded" id="admin_settings_save">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{*
			у настроек ядра есть разделы
		*}
		{if $sConfigName == $sAdminSystemConfigId}
			{include file="{$aTemplatePathPlugin.admin}settings/list/sections.tpl"}
		{else}
			{include file="{$aTemplatePathPlugin.admin}settings/list/parameters.tpl" aSettings=$aSettingsAll}
		{/if}

		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
			sFieldId='admin_settings_submit'
			sFieldName='submit_save_settings'
			sFieldStyle='primary'
			sFieldText=$aLang.plugin.admin.save
		}
	</form>
{else}
	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.settings.no_settings_for_this_plugin sAlertStyle='info'}
{/if}
