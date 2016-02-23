{**
 * Настройки
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{if $oTopicType}
    	Редактирование типа топика: {$oTopicType->getName()}
	{else}
		Создание нового типа топика
	{/if}
{/block}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/settings/topic-type"}}
{/block}

{block 'layout_content'}
	{component 'admin:p-topic' template='form' type=$oTopicType}
{/block}