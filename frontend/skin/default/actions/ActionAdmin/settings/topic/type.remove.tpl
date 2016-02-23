{**
 * Настройки
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	Удаление типа топика: {$oTopicType->getName()}
{/block}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/settings/topic-type"}}
{/block}

{block 'layout_content'}
	{component 'admin:p-topic' template='remove' currentType=$oTopicType types=$aTypeOtherItems count=$iCountTopics}
{/block}