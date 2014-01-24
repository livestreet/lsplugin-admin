{*
	Вывод разделов и их настроек
*}

{*
	по всем разделам настроек
*}
{foreach $aSections as $oSection}
	<h2 class="page-header">Раздел "<span>{$oSection->getSectionName()}</span>"</h2>								{* todo: lang *}
	{*
		по всем параметрам раздела
	*}
	{include file="{$aTemplatePathPlugin.admin}settings/list/parameters.tpl" aSettings=$oSection->getSettings()}
{/foreach}