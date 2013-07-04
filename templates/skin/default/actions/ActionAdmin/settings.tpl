{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
  <h2 class="Title mb20">
    Настройки плагина "{$sConfigName}"
  </h2>


	{include file="{$aTemplatePathPlugin.admin}plugin_settings.tpl"}



{/block}