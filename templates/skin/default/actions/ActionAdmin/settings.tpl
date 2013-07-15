{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}

  {if $sConfigName}
    <h2 class="Title mb20">
      {if $sConfigName==$sAdminSystemConfigId}
        {$aLang.plugin.admin.settings.titles.main_config}
      {else}
        {$aLang.plugin.admin.settings.titles.plugin_config} "{$sConfigName}"
      {/if}
    </h2>
  {/if}
  
  {include file="{$aTemplatePathPlugin.admin}keys_to_show.tpl"}
  
  
	{include file="{$aTemplatePathPlugin.admin}plugin_settings.tpl"}
	
	
{/block}