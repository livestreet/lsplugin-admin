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
				<a href="{router page='admin/settings/plugin'}{$oPlugin->getCode()}/">{$oPlugin->getXml()->name->data}</a>
			{else}
				{$oPlugin->getXml()->name->data}
			{/if}
		</h4>

		{*
			информация
		*}
		<div class="mb-15">
			<i class="icon-folder-open"></i> /plugins/{$oPlugin->getCode()}/
			<br />
			<i class="icon-user"></i> {$oPlugin->getXml()->author->data}
			{if !empty($oPlugin->getXml()->homepage)}
				<br />
				<i class="icon-home"></i> {$oPlugin->getXml()->homepage}
			{/if}
		</div>


		{*
			описание
		*}
		<p>{$oPlugin->getXml()->description->data|strip_tags|escape:'html'}</p>
	</td>

	{*
		версия
	*}
	<td>
		<h4 class="plugin-list-item-title">{$oPlugin->getXml()->version}</h4>
	</td>


	{*
		управление
	*}
	<td class="ta-r">
		{if $oPlugin->getActive()}
			<a href="{router page='admin/plugins/toggle'}?plugin={$oPlugin->getCode()}&action=deactivate&security_ls_key={$LIVESTREET_SECURITY_KEY}"
			   title="{$aLang.plugins_plugin_deactivate}"
			   class="button">{$aLang.plugins_plugin_deactivate}</a>
		{else}
			<a href="{router page='admin/plugins/toggle'}?plugin={$oPlugin->getCode()}&action=activate&security_ls_key={$LIVESTREET_SECURITY_KEY}"
			   title="{$aLang.plugins_plugin_activate}"
			   class="button button-primary">{$aLang.plugins_plugin_activate}</a>
		{/if}

		{if ! empty($oPlugin->getXml()->settings) and $oPlugin->getActive()}
			<br />
			<a href="{$oPlugin->getXml()->settings}" class="button" target="_blank">{$aLang.plugin.admin.plugins.settings}</a>
		{/if}
	</td>
</tr>
