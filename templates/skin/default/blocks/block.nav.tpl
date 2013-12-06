{**
 * Блок с главным меню
 *
 * @styles blocks.css
 *}

{extends file="{$aTemplatePathPlugin.admin}blocks/block.aside.base.tpl"}

{block name='block_type'}nav{/block}
{block name='block_class'}js-nav-main{/block}

{block name='block_content'}
	{include file="{$aTemplatePathPlugin.admin}navs/nav.main.tpl"}
{/block}