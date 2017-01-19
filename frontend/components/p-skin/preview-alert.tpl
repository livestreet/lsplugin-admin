{component_define_params params=[ 'skin', 'token' ]}

{lang 'plugin.admin.skin.this_is_preview' params = [ 'name' => $skin->getViewName() ]}

<a href="{router page="admin/skins/turnoffpreview/{$skin->getName()}"}?security_ls_key={$token}">
    {$aLang.plugin.admin.skin.turn_off_preview}
</a>
