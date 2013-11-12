{if $aKeysToShow}
	<div class="mb-20">
		Ключи, которые показываются для данного раздела:
		<div>
			<strong>
				{foreach from=$aKeysToShow item=sKey}
					{$sKey}{if !$sKey@last},{/if}
				{/foreach}
			</strong>
		</div>
	</div>
{/if}