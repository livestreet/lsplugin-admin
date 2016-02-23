{**
 * Добавление дополнительного поля
 *
 * @param array $aPropertyType Список типов полей
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/properties/{$sPropertyTargetType}"}}
{/block}

{block 'layout_page_title'}
	Добавление поля для типа &laquo;{$aPropertyTargetParams.name}&raquo;
{/block}

{block 'layout_content'}
	{component 'admin:p-property' template='form'}
{/block}