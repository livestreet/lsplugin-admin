{$component = 'p-user-form'}
{component_define_params params=[ 'user' ]}

<form action="{router page='admin/users/profile'}{$user->getId()}" method="post">
    {component 'admin:field.hidden.security-key'}

    {component 'admin:field.text'
        name  = 'login'
        value = $user->getLogin()
        label = $aLang.plugin.admin.users.profile.info.login}

    {component 'admin:field.text'
        name  = 'profile_name'
        value = $user->getProfileName()
        label = $aLang.plugin.admin.users.profile.info.profile_name}

    {component 'admin:field.text'
        name  = 'mail'
        value = $user->getMail()
        label = $aLang.plugin.admin.users.profile.info.mail}

    {component 'admin:field.select'
        name='profile_sex'
        selectedValue=$user->getProfileSex()
        label=$aLang.plugin.admin.users.profile.info.sex
        items=[
            [ 'value' => 'man',   'text' => $aLang.plugin.admin.users.sex.man ],
            [ 'value' => 'woman', 'text' => $aLang.plugin.admin.users.sex.woman ],
            [ 'value' => 'other', 'text' => $aLang.plugin.admin.users.sex.other ]
        ]}

    {component 'admin:field.text'
        name  = 'profile_rating'
        value = $user->getRating()
        label = 'Рейтинг'}

    {component 'admin:field.date'
        name  = 'profile_birthday'
        inputAttributes = [ 'data-lsdate-format' => 'DD.MM.YYYY' ]
        inputClasses = 'js-field-date-default'
        value = ($user->getProfileBirthday()) ? {date_format date=$user->getProfileBirthday() format='d.m.Y'} : ''
        label = $aLang.plugin.admin.users.profile.info.birthday}

    {* Местоположение *}
    {component 'admin:field.geo'
        classes   = 'js-field-geo-default'
        name      = 'geo'
        label     = {lang name='plugin.admin.users.profile.info.living'}
        countries = $aGeoCountries
        regions   = $aGeoRegions
        cities    = $aGeoCities
        place     = $oGeoTarget}

    {component 'admin:field.text'
        name='password'
        label=$aLang.plugin.admin.users.profile_edit.password}

    {component 'admin:field.textarea'
        name  = 'profile_about'
        rows  = 4
        value = $user->getProfileAbout()|strip_tags
        label = $aLang.plugin.admin.users.profile_edit.about_user}

    {component 'admin:button' text=$aLang.common.save name='submit_edit' mods='primary'}
</form>