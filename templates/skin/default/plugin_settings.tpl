
  {if $aSettingsAll and count($aSettingsAll)>0}
  
    <form action="{router page='admin'}settings/save/{$sConfigName}/" method="post" enctype="application/x-www-form-urlencoded">
      <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
      
      {foreach from=$aSettingsAll item=oParameter name=ConfigSettingForCycle}
        {assign var="iNumOrder" value=$smarty.foreach.ConfigSettingForCycle.iteration}
        <a name="p{$iNumOrder}"></a>
        
        <div class="OneParameterContainer mb20">
          <div class="ParamNum">#{$iNumOrder}</div>

				  {assign var="sKey" value="{$oParameter->getKey()}"}
					{assign var="sInputDataName" value="SettingsNum{$iNumOrder}[]"}
				  <div class="DisplayKey">{$sKey}</div>

				  <input type="hidden" name="{$sInputDataName}" value="{$sAdminSettingsFormSystemId}" />
				  <input type="hidden" name="{$sInputDataName}" value="{$sKey}" />
          
          <div>
            {$oParameter->getName()|nl2br}
          </div>
					
          <div>
            {include file="{$aTemplatePathPlugin.admin}plugin_settings_one_field.tpl"}
          </div>
					
          <div>
            {$oParameter->getDescription()|nl2br}
          </div>
        </div>
      {/foreach}
			
      <input type="submit" value="ok" name="submit_save_settings" class="button button-primary" />
    </form>

  {else}
    no settings for this plugin or author not declared them
  {/if}
