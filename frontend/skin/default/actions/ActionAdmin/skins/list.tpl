{**
 * Список шаблонов
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.skin.title}
{/block}

{block 'layout_content'}
	{component 'admin:p-skin' skin=$oSkinCurrent classes='ls-skin--active'}
	{component 'admin:p-skin' template='list' skins=$aSkins}
{/block}