{$component = 'p-user-profile'}
{component_define_params params=[ 'action', 'queries' ]}

<form action="{$action}" id="js-admin-users-list-search-form-id">
    {* нужна только первая пара ключ => значение *}
    {$searchValueItems = array_values($queries)}
    {$searchFieldItems = array_keys($queries)}
    {$searchValue = array_shift($searchValueItems)}
    {$searchField = array_shift($searchFieldItems)}

    <script>
        var aAdminUsersSearchRules = {json var=Config::Get('plugin.admin.users.search_allowed_types')};
    </script>

    <span id="js-admin-users-list-search-form-q-wrapper">
        <input type="text" class="width-200" value="{$searchValue}" placeholder="{$aLang.plugin.admin.users.search}" />
    </span>

    <select class="width-200" id="js-admin-users-list-search-form-field-name">
        {foreach array_keys(Config::Get('plugin.admin.users.search_allowed_types')) as $searchIn}
            <option value="{$searchIn}" {if $searchIn == $searchField}selected="selected"{/if}>
                {$aLang.plugin.admin.users.search_allowed_in.$searchIn}
            </option>
        {/foreach}
    </select>

    {* Кнопка отключения фильтра поиска *}
    {if $searchField}
        {component 'admin:button' url="{$sFullPagePathToEvent}{request_filter name=array($searchField) value=array(null)}" icon='trash-o' mods='danger'}
    {/if}

    {component 'admin:button' text=$aLang.plugin.admin.users.search mods='primary'}
</form>