{**
 * Форма изменения количества элементов на страницу
 *
 * @param $url    Путь к екшену ({router page='admin/bans/ajax-on-page'})
 * @param $value  Текущее значение (Config::Get('plugin.admin.bans.per_page'))
 * @param $formId id формы (не обязательно, по-умолчанию "admin_onpage")
 *}

{$component = 'pagination-eop'}
{component_define_params params=[ 'url', 'value', 'formId' ]}

{* Если ид не указан - использовать по-умолчанию *}
{$formId = $formId|default:'admin_onpage'}

<form action="{$url}" class="{$component}" method="post" id="{$formId}">
	{component 'admin:field.hidden.security-key'}

	{$aLang.plugin.admin.on_page}

	<select name="onpage" class="{$component}-select">
		{foreach Config::Get('plugin.admin.pagination.values_for_select_elements_on_page') as $item}
			<option value="{$item}" {if $item == $value}selected="selected"{/if}>{$item}</option>
		{/foreach}
	</select>
</form>
