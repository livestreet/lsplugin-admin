{**
 * Добавить ссылку полного удаления комментария
 *}

{component_define_params params=[ 'comment' ]}

{if $oUserCurrent and $oUserCurrent->isAdministrator()}
    {component 'comment.actions-item'
        link = [
            url => "{router page='admin/comments/delete'}?id={$comment->getId()}",
            attributes => [ target => '_blank' ]
        ]
        text = $aLang.plugin.admin.comments.full_deleting}
{/if}
