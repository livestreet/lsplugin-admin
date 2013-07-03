
  {if $aSettingsAll and count($aSettingsAll)>0}
  
    <form action="{router page='admin'}saveconfig/{$sPlugin}/" method="post" enctype="application/x-www-form-urlencoded">
      <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
      
      {foreach from=$aSettingsAll item=oSetting name=ConfigSettingForCycle}
      
        {assign var="iNumOrder" value=$smarty.foreach.ConfigSettingForCycle.iteration}
        <a name="p{$iNumOrder}"></a>
        
        <div class="OneParameterContainer mb20">
          <div class="ParamNum">#{$iNumOrder}</div>

				  {assign var="sKey" value="{$oSetting->getKey()}"}
				  <div class="DisplayKey">{$sKey}</div>

				  <input type="hidden" name="SettingsNum{$iNumOrder}[]" value="{$sFormSettingsId}" />
				  <input type="hidden" name="SettingsNum{$iNumOrder}[]" value="{$sKey}" />

          
          <div class="CommentBefore">
            {$oSetting->getName()|nl2br}
          </div>
          <div class="OneField">
            {include file="{$aTemplatePathPlugin.admin}plugin_settings_one_field.tpl"}
          </div>
          <div class="CommentAfter">
            {$oSetting->getDescription()|nl2br}
          </div>
					
					<input type="hidden" name="SettingsNum{$iNumOrder}[]" value="{$oSetting->getType()}" />
					
        </div>
      {/foreach}
			
      <input type="submit" value="ok" name="submit_save_settings" class="button button-primary" />
    </form>

  {else}
    no settings for this plugin or author not declated them
  {/if}
