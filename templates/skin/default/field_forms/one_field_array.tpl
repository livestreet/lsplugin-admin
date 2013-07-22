
		{if $oParameter->getNeedToShowSpecialArrayForm()}
		
			{assign var="aValidatorData" value=$oParameter->getValidator()}
			{assign var="aValidatorParams" value=$aValidatorData['params']}
			
			<div class="js-hidden-array-item-copy" style="display: none;">
				<div class="js-array-item-value">
					<input type="text" class="input-text input-width-50" readonly="readonly" value="" data-name-original="{$sInputDataName}" />
					<span class="js-remove-previous">X</span>
				</div>
			</div>
			
			<div class="js-array-values" data-key="{$sKey}">
				{foreach from=$oParameter->getValue() item=mValue}
					<div class="js-array-item-value">
						<input type="text" name="{$sInputDataName}" class="input-text input-width-50" readonly="readonly" value="{$mValue}" />
						<span class="js-remove-previous">X</span>
					</div>
				{/foreach}
			</div>
			
			
			{if isset($aValidatorParams['enum'])}
			
				<input type="hidden" class="js-array-input-type" data-key="{$sKey}" value="enum" />
			
				{* Перечисление разрешенных значений массива *}
				{assign var="aItemsToShow" value=$aValidatorParams['enum']}
				
				<select class="js-array-enum input-text input-width-250" data-key="{$sKey}">
					{foreach from=$aItemsToShow item=sValue}
						<option value="{$sValue}" {if in_array($sValue, $oParameter->getValue())}disabled="disabled"{/if}>{$sValue}</option>
					{/foreach}
				</select>
			
			{else}
				
				<input type="hidden" class="js-array-input-type" data-key="{$sKey}" value="text-field" />
				
				{* Поле для ввода значений массива *}
				
				<input type="text" class="js-array-input-text input-text input-width-250" data-key="{$sKey}" value="" />
				
			{/if}
			
			<button class="js-array-add-value button button-primary" data-key="{$sKey}">+</button>
		
		{else}
		
			{* Простой вывод значений массива как есть в виде php array *}
			
			{*
			<textarea name="{$sInputDataName}" class="input-text input-width-250">{var_export($oParameter->getValue())|escape:'html'}</textarea>
			*}
			Простой вывод значений массива как есть в виде php array - на данный момент не доступно.
		
		{/if}
