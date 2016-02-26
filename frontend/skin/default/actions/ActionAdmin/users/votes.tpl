{**
 * Голоса пользователя
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
    {$layoutBackUrl = {router page="admin/users/profile/{$oUser->getId()}"}}
{/block}

{block 'layout_page_title'}
    {$aLang.plugin.admin.users.votes.title} <span>{$aLang.plugin.admin.users.votes.votes_type.$sVotingTargetType}</span>
{/block}

{block 'layout_content_actionbar'}
    <div class="ls-fl-r">
        {component 'admin:button' template='group' buttons=[
            [
                text => $aLang.plugin.admin.users.votes.voting_list.all,
                url => "{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sVotingTargetType}",
                classes => "{if $sVotingDirection == ''}active{/if}"
            ],
            [
                text => $aLang.plugin.admin.users.votes.voting_list.plus,
                url => "{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sVotingTargetType}&filter[dir]=plus",
                classes => "{if $sVotingDirection == 'plus'}active{/if}"
            ],
            [
                text => $aLang.plugin.admin.users.votes.voting_list.minus,
                url => "{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sVotingTargetType}&filter[dir]=minus",
                classes => "{if $sVotingDirection == 'minus'}active{/if}"
            ],
            [
                text => $aLang.plugin.admin.users.votes.voting_list.abstain,
                url => "{router page="admin/users/votes/{$oUser->getId()}"}?filter[type]={$sVotingTargetType}&filter[dir]=abstain",
                classes => "{if $sVotingDirection == 'abstain'}active{/if}"
            ]
        ]}
    </div>
{/block}

{block 'layout_content'}
    {component 'admin:p-user' template='vote-list' votes=$aVotingList pagination=$aPaging}
{/block}