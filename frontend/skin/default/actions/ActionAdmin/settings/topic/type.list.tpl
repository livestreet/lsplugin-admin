{**
 * Настройки для типов топиков
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	Настройка типов топиков
{/block}

{block 'layout_content_actionbar'}
	{component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/settings/topic-type/create"} mods='primary'}
{/block}

{block 'layout_content'}
	{component 'admin:p-topic' template='list' types=$aTopicTypeItems}
{/block}