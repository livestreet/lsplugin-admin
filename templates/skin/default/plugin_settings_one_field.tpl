
  {if $oSetting->getType()=='integer' or $oSetting->getType()=='string'}
    
    
    <input type="text" name="SettingsNum{$iNumOrder}[]" value="{$oSetting->getValue()|escape:'html'}" class="input-text input-width-250" />
  
    
  {elseif $oSetting->getType()=='array'}
  
  
    <textarea name="SettingsNum{$iNumOrder}[]" class="input-text input-width-250">{var_export($oSetting->getValue())|escape:'html'}</textarea>
  
  
  {elseif $oSetting->getType()=='boolean'}
  
  
    <select name="SettingsNum{$iNumOrder}[]" class="input-width-250">
      <option value="1"{if $oSetting->getValue()} selected="selected"{/if}>
        TRUE
      </option>
      <option value="0"{if !$oSetting->getValue()} selected="selected"{/if}>
        FALSE
      </option>
    </select>
  
  
  {else}
    Unknown param type: <b>{$oSetting->getType()}</b>.
  {/if}
