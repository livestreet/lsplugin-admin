
{*
	Вывод дополнительных полей для ввода данных на странице создания нового объекта
*}

{if $aProperties}
	<h3 class="page-sub-header mt-30">Дополнительные поля</h3>

	{foreach $aProperties as $oProperty}
		{include file="{$aTemplatePathPlugin.admin}property/form.field_render.tpl" oProperty=$oProperty}
	{/foreach}
{/if}
