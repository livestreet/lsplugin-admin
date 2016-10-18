{**
 * Userbar
 *}

{$component = 'p-userbar'}
{component_define_params params=[ 'skin', 'mods', 'classes', 'attributes' ]}

<div id="header" class="{$component} {cmods name=$component mods=$mods} {$classes} ls-clearfix" {cattr list=$attributes}>
    <div class="{$component}-logo">
        <div class="{$component}-logo-home">
            <a href="{Router::GetPath('/')}">Перейти на сайт</a>
        </div>

        <h1 class="{$component}-logo-name">
            <a href="{Router::GetPath('admin')}">{Config::Get("view.name")}</a>
        </h1>
    </div>

    {* Юзербар *}
    {component 'admin:dropdown'
        text="<img src=\"{$oUserCurrent->getProfileAvatarPath(48)}\" alt=\"Avatar\" class=\"userbar-avatar\" />{$oUserCurrent->getLogin()}"
        classes='admin-userbar js-dropdown-userbar'
        menu=[
            [ 'text' => 'Мой профиль', 'url' => {router page="admin/users/profile/{$oUserCurrent->getId()}"} ],
            [ 'text' => 'Выйти', 'url' => "{router page='auth/logout'}?security_ls_key={$LIVESTREET_SECURITY_KEY}" ]
        ]}
</div>