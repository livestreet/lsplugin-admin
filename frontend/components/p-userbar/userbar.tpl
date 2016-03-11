{**
 * Userbar
 *}

{$component = 'p-userbar'}
{component_define_params params=[ 'skin', 'mods', 'classes', 'attributes' ]}

<div id="header" class="{$component} {cmods name=$component mods=$mods} {$classes} ls-clearfix" {cattr list=$attributes}>
    <ul class="breadcrumbs">
        <li><a href="{Router::GetPath('/')}" class="link-dotted">Перейти на сайт</a></li>
    </ul>

    <div class="site-info">
        <h1 class="site-name"><a href="{Router::GetPath('admin')}">{Config::Get("view.name")}</a></h1>
    </div>

    {* Юзербар *}
    {component 'dropdown'
        text="<img src=\"{$oUserCurrent->getProfileAvatarPath(48)}\" alt=\"Avatar\" class=\"userbar-avatar\" />{$oUserCurrent->getLogin()}"
        classes='admin-userbar js-dropdown-userbar'
        menu=[
            [ 'text' => 'Мой профиль', 'url' => {router page="admin/users/profile/{$oUserCurrent->getId()}"} ],
            [ 'text' => 'Выйти', 'url' => "{router page='auth/logout'}?security_ls_key={$LIVESTREET_SECURITY_KEY}" ]
        ]}
</div>