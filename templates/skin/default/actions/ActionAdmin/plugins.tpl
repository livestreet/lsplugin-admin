{extends file="{$aTemplatePathPlugin.admin}/layout.base.tpl"}

{block name='layout_content'}
  Список плагинов
	<br /><br />

  {if $aPluginsInfo and count($aPluginsInfo)>0}
    {foreach from=$aPluginsInfo item=oPlugin}
      <div class="OnePlugin" title="{$oPlugin.property->description->data|strip_tags|escape:'html'}">
				{* todo: langs *}
        <a href="{router page='admin'}config/{$oPlugin.code}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{if $oPlugin.is_active}{$aLang.plugin.adminconfig.PluginList.Plugin_Settings}{else}{$aLang.plugin.adminconfig.PluginList.Plugin_Need_To_Be_Activated}{/if}">
          <h4 class="{if $oPlugin.is_active}enabled{else}disabled{/if}{if $sPluginName==$oPlugin.code} selected{/if}">{$oPlugin.property->name->data}</h4>
        </a>
			
        <div class="Controls">
          {if !empty($oPlugin.property->settings) and $oPlugin.is_active}
            <a class="PluginOwnSettings" href="{$oPlugin.property->settings}" rel="settings" target="_blank">собственные настройки плагина</a>
          {/if}
          
          {if $oPlugin.is_active}
            <a class="PluginToggle Active" href="{router page='admin'}plugin/toggle/?plugin={$oPlugin.code}&action=deactivate&security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.plugins_plugin_deactivate}">deactivate</a>
          {else}
            <a class="PluginToggle " href="{router page='adminconfig'}plugin/toggle/?plugin={$oPlugin.code}&action=activate&security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.plugins_plugin_activate}">activate</a>
          {/if}
        </div>
        

        <div class="PluginInfoMore">
          Folder: /plugins/{$oPlugin.code}/
          <br />
          Author: {$oPlugin.property->author->data}
          {$oPlugin.property->homepage}
          <br />
          Version: {$oPlugin.property->version}
          
        </div>
      </div>
    {/foreach}
  {else}
		no plugins
  {/if}
	

{/block}