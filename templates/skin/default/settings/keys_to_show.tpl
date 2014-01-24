{*
	Вывод списка ключей для раздела
*}

{*
	Указаны ли для раздела его ключи (если не указаны, то раздел "заберет" все ключи)
*}
{if $aKeysToShow}
	<div class="mb-20">
		{* todo: add lang *}
		{$sText = 'Ключи, которые показываются для данного раздела: <strong>'}

		{foreach from=$aKeysToShow item=sKey}
			{$sText = $sText|cat:"{$sKey}{if !$sKey@last}, {/if}"}
		{/foreach}

		{$sText = $sText|cat:"</strong>"}

		{include file="{$aTemplatePathPlugin.admin}alert.tpl" mAlerts=$sText sAlertStyle='info'}
	</div>
{/if}
