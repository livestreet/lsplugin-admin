
		<select name="{$sInputDataName}" class="input-width-250">
			<option value="1"{if $oParameter->getValue()} selected="selected"{/if}>
				{$aLang.plugin.admin.true}
			</option>
			<option value="0"{if !$oParameter->getValue()} selected="selected"{/if}>
				{$aLang.plugin.admin.false}
			</option>
		</select>
