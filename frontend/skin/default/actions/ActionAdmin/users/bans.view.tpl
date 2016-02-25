{**
 * Информация о бане
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_options' append}
    {$layoutBackUrl = {router page='admin/users/bans'}}
{/block}

{block 'layout_content_actionbar'}
    <div class="ls-fl-r">
        {component 'admin:button' icon='edit' url={router page="admin/users/bans/edit/{$oBan->getId()}"} text={lang 'common.edit'}}
        {component 'admin:button' icon='trash' url="{router page='admin/users/bans/delete'}{$oBan->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" text={lang 'common.remove'} classes='js-confirm-remove'}
    </div>
{/block}

{block 'layout_page_title'}
	{$aLang.plugin.admin.bans.view.title} <span>#{$oBan->getId()}</span>
{/block}

{block 'layout_content'}
	{component 'admin:p-user' template='ban-view' ban=$oBan stats=$aBansStats}
{/block}