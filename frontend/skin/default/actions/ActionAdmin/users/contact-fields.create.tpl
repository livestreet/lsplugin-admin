{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
    {$layoutBackUrl = {router page="admin/users/contact-fields"}}
{/block}

{block 'layout_page_title'}
	{if $oField}
		Редактирование контакта
	{else}
		Создание нового контакта
	{/if}
{/block}

{block 'layout_content'}
    {component 'admin:p-user' template='contact-form' field=$oField types=$aUserFieldTypes}
{/block}