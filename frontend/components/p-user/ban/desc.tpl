{**
 * Описание типа блока бана с выводом информации
 *
 * @param object $ban Объект бана
 *}

{$component = 'p-user-ban-desc'}
{component_define_params params=[ 'ban' ]}

{if $ban->getBlockType() == PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID}
    {* Пользователь *}
    {$aLang.plugin.admin.bans.list.block_type.user}:

    {if $ban->getUserId()}
        {$bannedUser = $LS->User_GetUserById($ban->getUserId())}

        <a href="{router page="admin/users/profile/{$ban->getUserId()}"}">{if $bannedUser}{$bannedUser->getLogin()}{else}#{$ban->getUserId()}{/if}</a>
    {/if}
{elseif $ban->getBlockType() == PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP}
    {* IP *}
    {$aLang.plugin.admin.bans.list.block_type.ip}:

    {if $ban->getIp()}
        <a href="{router page='admin/users/list'}{request_filter
            name=array('session_ip_last')
            value=array(convert_long2ip($ban->getIp()))
        }">{convert_long2ip($ban->getIp())}</a>
    {/if}
{elseif $ban->getBlockType() == PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_IP_RANGE}
    {* Диапазон IP *}
    {$aLang.plugin.admin.bans.list.block_type.ip_range}:

    {if $ban->getIpStart()}
        <a href="{router page='admin/users/list'}{request_filter
           name=array('session_ip_last')
           value=array(convert_long2ip($ban->getIpStart()))
        }">{convert_long2ip($ban->getIpStart())}</a>
    {/if}

    &mdash;

    {if $ban->getIpFinish()}
        <a href="{router page='admin/users/list'}{request_filter
           name=array('session_ip_last')
           value=array(convert_long2ip($ban->getIpFinish()))
        }">{convert_long2ip($ban->getIpFinish())}</a>
    {/if}
{elseif $ban->getBlockType() == PluginAdmin_ModuleUsers::BAN_BLOCK_TYPE_USER_ID_AND_IP}
    {* Пользователь или IP *}
    {$aLang.plugin.admin.bans.list.block_type.user}:

    {if $ban->getUserId()}
        {$bannedUser = $LS->User_GetUserById($ban->getUserId())}
        <a href="{router page="admin/users/profile/{$ban->getUserId()}"}">{if $bannedUser}{$bannedUser->getLogin()}{else}#{$ban->getUserId()}{/if}</a>
    {/if}

    {if $ban->getIp()}
        {$aLang.plugin.admin.word_or}
        <br />
        {$aLang.plugin.admin.bans.list.block_type.ip}:
        <a href="{router page='admin/users/list'}{request_filter
            name=array('session_ip_last')
            value=array(convert_long2ip($ban->getIp()))
        }">{convert_long2ip($ban->getIp())}</a>
    {/if}
{/if}