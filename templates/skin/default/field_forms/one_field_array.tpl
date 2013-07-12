
		{if $oParameter->getNeedToShowSpecialArrayForm()}
		
			{assign var="aValidatorData" value=$oParameter->getValidator()}
			{assign var="aValidatorParams" value=$aValidatorData['params']}
			
			{if isset($aValidatorParams['enum'])}
			
				{* Перечисление разрешенных значений массива *}
				{assign var="aItemsToShow" value=$aValidatorParams['enum']}
			
			{elseif isset($aValidatorParams['range'])}
				
				{* Границы от и до разрешенных значений массива *}
				{assign var="aItemsToShow" value=range($aValidatorParams['range']['min'],$aValidatorParams['range']['max'])}
				
			{/if}
			
			<select name="{$sInputDataName}" class="input-text input-width-250" multiple>
				{foreach from=$aItemsToShow item=sValue}
					<option value="{$sValue}" {if in_array($sValue, $oParameter->getValue())}selected="selected"{/if}>{$sValue}</option>
				{/foreach}
			</select>
			<div>
				{$aLang.plugin.admin.settings.param_type.array.multiple_select_tip}
			</div>
		
		{else}
		
			{* Простой вывод значений массива как есть в виде php array *}
		
			<textarea name="{$sInputDataName}" class="input-text input-width-250">{var_export($oParameter->getValue())|escape:'html'}</textarea>
		
		{/if}
