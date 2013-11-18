{**
 * Данные о последнем входе пользователя в админку
 *}

{if $aLastVisitData.date}
	{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts="{$aLang.plugin.admin.hello.last_visit} {date_format date=$aLastVisitData.date format="j F Y в H:i"}."}
{/if}
