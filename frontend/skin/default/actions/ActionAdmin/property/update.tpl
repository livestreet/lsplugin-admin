{**
 * Редактирование дополнительного поля
 *
 * @param object $oProperty     Поле
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/properties/{$sPropertyTargetType}"}}
{/block}

{block 'layout_page_title'}
	Редактирование поля для типа &laquo;{$aPropertyTargetParams.name}&raquo;
{/block}

{block 'layout_content'}
	{component 'admin:p-property' template='form' property=$oProperty}
{/block}