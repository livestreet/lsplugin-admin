{include file='header.tpl'}


<div class="topic">
    Список юзеров
</div>


<table class="table table-users">
    <thead>
    <tr>
        <th class="cell-name cell-tab">
            <div class="cell-tab-inner {if $sUsersOrder=='user_login'}active{/if}"><a href="{$sUsersRootPage}?order=user_login&order_way={if $sUsersOrder=='user_login'}{$sUsersOrderWayNext}{else}{$sUsersOrderWay}{/if}" {if $sUsersOrder=='user_login'}class="{$sUsersOrderWay}"{/if}><span>{$aLang.user}</span></a></div>
        </th>
        <th class="cell-skill cell-tab">
            <div class="cell-tab-inner {if $sUsersOrder=='user_skill'}active{/if}"><a href="{$sUsersRootPage}?order=user_skill&order_way={if $sUsersOrder=='user_skill'}{$sUsersOrderWayNext}{else}{$sUsersOrderWay}{/if}" {if $sUsersOrder=='user_skill'}class="{$sUsersOrderWay}"{/if}><span>{$aLang.user_skill}</span></a></div>
        </th>
        <th class="cell-rating cell-tab">
            <div class="cell-tab-inner {if $sUsersOrder=='user_rating'}active{/if}"><a href="{$sUsersRootPage}?order=user_rating&order_way={if $sUsersOrder=='user_rating'}{$sUsersOrderWayNext}{else}{$sUsersOrderWay}{/if}" {if $sUsersOrder=='user_rating'}class="{$sUsersOrderWay}"{/if}><span>{$aLang.user_rating}</span></a></div>
        </th>
    </tr>
    </thead>

    <tbody>
	{foreach from=$aUsers item=oUserItem}
		{assign var="oSession" value=$oUserItem->getSession()}
		<tr>
			<td class="cell-name">
				<a href="{$oUserItem->getUserWebPath()}"><img src="{$oUserItem->getProfileAvatarPath(48)}" alt="avatar" class="avatar" /></a>
				<div class="name {if !$oUserItem->getProfileName()}no-realname{/if}">
					<p class="username word-wrap"><a href="{$oUserItem->getUserWebPath()}">{$oUserItem->getLogin()}</a></p>
					{if $oUserItem->getProfileName()}<p class="realname">{$oUserItem->getProfileName()}</p>{/if}
				</div>
			</td>
			<td class="cell-skill">{$oUserItem->getSkill()}</td>
			<td class="cell-rating {if $oUserItem->getRating() < 0}negative{/if}"><strong>{$oUserItem->getRating()}</strong></td>
		</tr>
	{/foreach}
    </tbody>
</table>

{include file='paging.tpl' aPaging=$aPaging}


{include file='footer.tpl'}