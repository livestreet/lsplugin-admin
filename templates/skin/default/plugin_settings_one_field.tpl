
  {if $oParameter->getType()=='integer' or $oParameter->getType()=='string'}
    
    
    <input type="text" name="{$sInputDataName}" value="{$oParameter->getValue()|escape:'html'}" class="input-text input-width-250" />
  
    
  {elseif $oParameter->getType()=='array'}
  
  
    <textarea name="{$sInputDataName}" class="input-text input-width-250">{var_export($oParameter->getValue())|escape:'html'}</textarea>
  
  
  {elseif $oParameter->getType()=='boolean'}
  
  
    <select name="{$sInputDataName}" class="input-width-250">
      <option value="1"{if $oParameter->getValue()} selected="selected"{/if}>
        {$aLang.plugin.admin.true}
      </option>
      <option value="0"{if !$oParameter->getValue()} selected="selected"{/if}>
        {$aLang.plugin.admin.false}
      </option>
    </select>
  
  
  {else}
    Unknown param type: <b>{$oParameter->getType()}</b>.
  {/if}

	type: <b>{$oParameter->getType()}</b>
