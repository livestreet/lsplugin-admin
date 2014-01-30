{**
 * Настройки
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<div class="fl-l">
		<a href="{router page='admin/settings/config'}main" class="button">Основные</a>
		<a href="{router page='admin/settings/config'}blog" class="button">Блоги</a>
		<a href="{router page='admin/settings/config'}user" class="button">Пользователи</a>
		<a href="{router page='admin/settings/config'}system" class="button">Системные</a>
	</div>
{/block}

{block name='layout_page_title'}
	{if $sConfigName}
		{if $sConfigName==$sAdminSystemConfigId}
			{$aLang.plugin.admin.settings.titles.main_config} &mdash; {$sGroupName}
		{else}
			{$aLang.plugin.admin.settings.titles.plugin_config} "<span title="{$sConfigName}">{$oPlugin->getName()}</span>"
		{/if}
	{/if}
{/block}

{block name='layout_content'}
	{include file="{$aTemplatePathPlugin.admin}settings/settings.list.tpl"}
{/block}