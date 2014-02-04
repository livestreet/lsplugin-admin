{**
 * Описание типа блока бана с выводом информации
 *
 * @param object $oBan Объект бана
 *}

{if $oBan->getBlockType() == PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID}
	{* Пользователь *}
	{$aLang.plugin.admin.bans.list.block_type.user}:
	{if $oBan->getUserId()}
		{$oBannedUser = $LS->User_GetUserById($oBan->getUserId())}
		<a href="{router page="admin/users/profile/{$oBan->getUserId()}"}">{if $oBannedUser}{$oBannedUser->getLogin()}{else}#{$oBan->getUserId()}{/if}</a>
	{/if}
{elseif $oBan->getBlockType() == PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP}
	{* IP *}
	{$aLang.plugin.admin.bans.list.block_type.ip}:
	{if $oBan->getIp()}
		<a href="{router page='admin/users/list'}{request_filter
			name=array('session_ip_last')
			value=array(convert_long2ip($oBan->getIp()))
		}">{convert_long2ip($oBan->getIp())}</a>
	{/if}
{elseif $oBan->getBlockType() == PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP_RANGE}
	{* Диапазон IP *}
	{$aLang.plugin.admin.bans.list.block_type.ip_range}:
	{if $oBan->getIpStart()}
		<a href="{router page='admin/users/list'}{request_filter
		   name=array('session_ip_last')
		   value=array(convert_long2ip($oBan->getIpStart()))
		}">{convert_long2ip($oBan->getIpStart())}</a>
	{/if}
	&mdash;
	{if $oBan->getIpFinish()}
		<a href="{router page='admin/users/list'}{request_filter
		   name=array('session_ip_last')
		   value=array(convert_long2ip($oBan->getIpFinish()))
		}">{convert_long2ip($oBan->getIpFinish())}</a>
	{/if}
{elseif $oBan->getBlockType() == PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID_AND_IP}
	{* Пользователь или IP *}
	{$aLang.plugin.admin.bans.list.block_type.user}:
	{if $oBan->getUserId()}
		{$oBannedUser = $LS->User_GetUserById($oBan->getUserId())}
		<a href="{router page="admin/users/profile/{$oBan->getUserId()}"}">{if $oBannedUser}{$oBannedUser->getLogin()}{else}#{$oBan->getUserId()}{/if}</a>
	{/if}
	{if $oBan->getIp()}
		{$aLang.plugin.admin.word_or}
		<br />
		{$aLang.plugin.admin.bans.list.block_type.ip}:
		<a href="{router page='admin/users/list'}{request_filter
			name=array('session_ip_last')
			value=array(convert_long2ip($oBan->getIp()))
		}">{convert_long2ip($oBan->getIp())}</a>
	{/if}
{/if}