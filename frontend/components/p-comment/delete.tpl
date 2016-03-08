{**
 * Удаление комментария
 *}

{component_define_params params=[ 'comment' ]}

{component 'admin:alert' text=$aLang.plugin.admin.comments.delete.delete_info mods='info'}

{component 'admin:p-form'
    action={router page='admin/comments/delete'}
    submit = [ name => 'submit_comment_delete', classes => 'js-confirm-remove', text => $aLang.plugin.admin.delete ]
    form = [
        [ field => 'hidden', name => 'id', value => $comment->getId() ]
    ]}