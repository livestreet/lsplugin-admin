
{*
	Форма изменения количества элементов на страницу

	Передаваемые параметры:

		$sFormActionPath - путь к екшену ({router page='admin/bans/ajax-on-page'})
		$sFormId - id формы (admin_bans_onpage)
		$iCurrentValue - текущее значение ($oConfig->GetValue('plugin.admin.bans.per_page'))

*}

<div class="OnPageSelect">
	<form action="{$sFormActionPath}" method="post" enctype="application/x-www-form-urlencoded" id="{$sFormId}">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		{$aLang.plugin.admin.on_page}
		<select name="onpage" class="width-50">
			{foreach from=range(5,100,5) item=iVal}
				<option value="{$iVal}" {if $iVal==$iCurrentValue}selected="selected"{/if}>{$iVal}</option>
			{/foreach}
		</select>
	</form>
</div>
