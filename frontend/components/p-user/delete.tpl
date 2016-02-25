{**
 * Delete user
 *}

{$component = 'p-user-delete'}
{component_define_params params=[ 'user' ]}

{component 'admin:alert' text=$aLang.plugin.admin.users.deleteuser.delete_user_info mods='info'}

{component 'admin:p-form'
    action={router page='admin/users/deleteuser'}
    submit = [ name => 'submit_delete_user_contents', classes => 'js-confirm-remove', text => $aLang.plugin.admin.delete ]
    form = [
        [ field => 'hidden', name => 'user_id', value => $user->getId() ],
        [ field => 'checkbox', name => 'delete_user', checked => true, label => $aLang.plugin.admin.users.deleteuser.delete_user_itself ]
    ]}