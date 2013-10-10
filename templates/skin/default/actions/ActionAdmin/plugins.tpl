{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content'}
	<h2 class="title mb-20">Список плагинов</h2>

	{if $aPluginsInfo and count($aPluginsInfo)>0}
	
		{foreach from=$aPluginsInfo item=oPlugin}
		
			<div class="OnePlugin" title="{$oPlugin.property->description->data|strip_tags|escape:'html'}">

				<a href="{router page='admin/settings/plugin'}{$oPlugin.code}/">
					<h4 class="{if $oPlugin.is_active}enabled{else}disabled{/if}">{$oPlugin.property->name->data}</h4>
				</a>
			
				<div>
					{if !empty($oPlugin.property->settings) and $oPlugin.is_active}
						<a href="{$oPlugin.property->settings}"target="_blank">собственные настройки плагина</a> -
					{/if}

					{if $oPlugin.is_active}
						<a href="{router page='admin/plugin/toggle'}?plugin={$oPlugin.code}&action=deactivate&security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.plugins_plugin_deactivate}">deactivate</a>
					{else}
						<a href="{router page='admin/plugin/toggle'}?plugin={$oPlugin.code}&action=activate&security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.plugins_plugin_activate}">activate</a>
					{/if}
				</div>
				

				<div>
					Folder: /plugins/{$oPlugin.code}/
					<br />
					Author: {$oPlugin.property->author->data}
					<br />
					{$oPlugin.property->homepage}
					<br />
					Version: {$oPlugin.property->version}
					
				</div>
			</div>
			
		{/foreach}
	{else}
		no plugins
	{/if}
	

{/block}