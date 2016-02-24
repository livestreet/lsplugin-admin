<div class="ls-fl-r">
    {component 'admin:button' template='group' buttons=[
        [ text => 'Роли', url => {router page="admin/users/rbac/role"}, classes => "{if $sMenuSubItemSelect=='role'}active{/if}" ],
        [ text => 'Разрешения', url => {router page="admin/users/rbac/permission"}, classes => "{if $sMenuSubItemSelect=='permission'}active{/if}" ],
        [ text => 'Группы', url => {router page="admin/users/rbac/group"}, classes => "{if $sMenuSubItemSelect=='group'}active{/if}" ]
    ]}
</div>