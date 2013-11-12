{**
 * Boolean
 *}

{*<input type="checkbox" name="{$sInputDataName}" value="1" {if $oParameter->getValue()}checked{/if}>*}

<select name="{$sInputDataName}" class="width-250">
	<option value="1"{if $oParameter->getValue()} selected="selected"{/if}>
		{$aLang.plugin.admin.true}
	</option>
	
	<option value="0"{if !$oParameter->getValue()} selected="selected"{/if}>
		{$aLang.plugin.admin.false}
	</option>
</select>