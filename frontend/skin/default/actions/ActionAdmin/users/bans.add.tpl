{**
 * Добавление бана
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
    {$layoutBackUrl = {router page='admin/users/bans'}}
{/block}

{block 'layout_page_title'}
	{$aLang.plugin.admin.bans.add.title}
{/block}

{block 'layout_content'}
	{component 'admin:p-user' template='ban-form'}
{/block}