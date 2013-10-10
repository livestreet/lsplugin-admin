{if $aProperties}

	Свойства:<br/><br/>

	{foreach $aProperties as $oProperty}
		{include file="{$aTemplatePathPlugin.admin}/property/form.field_render.tpl" oProperty=$oProperty}
	{/foreach}
{/if}