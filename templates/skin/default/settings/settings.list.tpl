{**
 * Вывод настроек движка или плагина
 *}

{if $aSections and count($aSections) > 0}
	<script>
		ls.registry.set('settings.admin_save_form_ajax_use', {json var=$oConfig->Get('plugin.admin.settings.admin_save_form_ajax_use')});
	</script>

	<form action="{router page="admin/settings/save/{$sConfigName}"}" method="post" enctype="application/x-www-form-urlencoded" id="admin_settings_save">
		{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

		{*
			по всем разделам настроек
		*}
		{foreach $aSections as $oSection}
			{*
				есть ли имя раздела (плагины могут не указывать имя раздела)
			*}
			{if $oSection->getName()}
				<h2 class="page-header"><span>{$oSection->getName()}</span></h2>
			{/if}
			{*
				показывать ли ключи раздела
			*}
			{if $oConfig->Get('plugin.admin.settings.show_section_keys')}
				{include file="{$aTemplatePathPlugin.admin}settings/keys_to_show.tpl" aKeysToShow=$oSection->getAllowedKeys()}
			{/if}
			{*
				по всем параметрам раздела
			*}
			{foreach $oSection->getSettings() as $oParameter}
				{$bSettingsExist = true}

				{$sKey = $oParameter->getKey()}
				{$sInputDataName = "Settings_Sec{$oSection@iteration}_Num{$oParameter@iteration}[]"}

				{if in_array($oParameter->getType(), array('integer', 'string', 'float', 'array', 'boolean'))}
					{include file="{$aTemplatePathPlugin.admin}settings/fields/settings.field.{$oParameter->getType()}.tpl"}
				{else}
					{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="{$aLang.plugin.admin.errors.unknown_parameter_type}: <b>{$oParameter->getType()}</b>" sAlertStyle='error'}
				{/if}
			{/foreach}
		{/foreach}


		{if $bSettingsExist}
			{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.button.tpl"
				sFieldId='admin_settings_submit'
				sFieldName='submit_save_settings'
				sFieldStyle='primary'
				sFieldText=$aLang.plugin.admin.save
			}
		{else}
			{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.settings.no_settings_for_this_plugin sAlertStyle='info'}
		{/if}

	</form>
{else}
	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$aLang.plugin.admin.settings.no_settings_for_this_plugin sAlertStyle='info'}
{/if}
