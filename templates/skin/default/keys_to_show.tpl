
{if $aKeysToShow}

	<div class="mb20">

		Ключи, которые показываются для данного раздела:
		<div>
			<b>
				{foreach from=$aKeysToShow item=sKey}
					{$sKey}{if !$sKey@last},{/if}
				{/foreach}
			</b>
		</div>
		
	</div>
	
{/if}