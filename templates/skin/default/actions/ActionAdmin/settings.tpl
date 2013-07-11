{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
  <h2 class="Title mb20">
    {if $sConfigName==$sAdminSystemConfigId}
      {$aLang.plugin.admin.settings.titles.main_config}
    {else}
      {$aLang.plugin.admin.settings.titles.plugin_config} "{$sConfigName}"
    {/if}
  </h2>
  
  
	{include file="{$aTemplatePathPlugin.admin}plugin_settings.tpl"}
	
	
{/block}