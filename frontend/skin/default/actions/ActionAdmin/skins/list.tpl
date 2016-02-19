{**
 * Список шаблонов
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	{$aLang.plugin.admin.skin.title}
{/block}

{block 'layout_content'}
	{component 'admin:skin' skin=$oSkinCurrent classes='ls-skin--active'}
	{component 'admin:skin' template='list' skins=$aSkins}
{/block}