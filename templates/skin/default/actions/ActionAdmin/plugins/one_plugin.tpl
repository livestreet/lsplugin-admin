{*
	Вывод одного плагина в списке
*}

<tr class="plugin-list-item {if $oPlugin->getActive()}active{/if}">
	<td>
		<img src="{$oPlugin->getLogo()}" alt="logo" />
	</td>

	<td>
		{*
			заголовок
		*}
		<h4 class="plugin-list-item-title mb-15">
			{*
				редактировать настройки можно только активированного плагина
			*}
			{if $oPlugin->getActive()}
				<a href="{$oPlugin->getConfigSettingsPageUrl()}">{$oPlugin->getName()}</a>
			{else}
				{$oPlugin->getName()}
			{/if}
		</h4>

		{*
			вывод информации об обновлении
		*}
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/plugins/one_plugin_update_info.tpl"}

		{*
			информация
		*}
		<div class="mb-15">
			<i class="icon-folder-open"></i> /plugins/{$oPlugin->getCode()}/
			<br />
			<i class="icon-user"></i> {$oPlugin->getAuthor()}
			{if $oPlugin->getHomepage()}
				<br />
				<i class="icon-home"></i> {$oPlugin->getHomepage()}
			{/if}
		</div>


		{*
			описание
		*}
		<p>{$oPlugin->getDescription()|strip_tags|escape:'html'}</p>
	</td>

	{*
		версия
	*}
	<td>
		<h4 class="plugin-list-item-title">{$oPlugin->getVersion()}</h4>
	</td>


	{*
		управление
	*}
	<td class="ta-r">
		{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/plugins/controls.tpl"}

		{if $oPlugin->getOwnSettingsPageUrl() and $oPlugin->getActive()}
			<br />
			<a href="{$oPlugin->getOwnSettingsPageUrl()}" class="button" target="_blank">{$aLang.plugin.admin.plugins.list.settings}</a>
		{/if}
	</td>
</tr>
