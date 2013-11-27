
{*
	Форма изменения количества элементов на страницу

	Передаваемые параметры:

		$sFormActionPath - путь к екшену ({router page='admin/bans/ajax-on-page'})
		$iCurrentValue - текущее значение ($oConfig->GetValue('plugin.admin.bans.per_page'))
		$sFormId - id формы (не обязательно, по-умолчанию "admin_onpage")

*}

{*
	Если ид не указан - использовать по-умолчанию
*}
{if !$sFormId}
	{assign var=sFormId value="admin_onpage"}
{/if}

<form action="{$sFormActionPath}" class="per-page" method="post" enctype="application/x-www-form-urlencoded" id="{$sFormId}">
	{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}

	{$aLang.plugin.admin.on_page}
	<select name="onpage" class="width-75">
		{foreach from=$oConfig->GetValue('plugin.admin.values_for_select_elements_on_page') item=iVal}
			<option value="{$iVal}" {if $iVal==$iCurrentValue}selected="selected"{/if}>{$iVal}</option>
		{/foreach}
	</select>
</form>