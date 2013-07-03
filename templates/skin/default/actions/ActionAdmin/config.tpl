{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
  Настройки плагина "{$sPlugin}"
	<br /><br />


	{include file="{$aTemplatePathPlugin.admin}plugin_settings.tpl"}



{/block}