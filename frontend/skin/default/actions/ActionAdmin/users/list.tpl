{**
 * Список пользователей
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	<form action="{$sFullPagePathToEvent}" method="get" enctype="application/x-www-form-urlencoded" id="js-admin-users-list-search-form-id">
		{*
			нужна только первая пара ключ => значение
		*}
		{$sSearchValueItems=array_values($aSearchRulesWithOriginalQueries)}
		{$sSearchFieldItems=array_keys($aSearchRulesWithOriginalQueries)}
		{$sSearchValue = array_shift($sSearchValueItems)}
		{$sSearchField = array_shift($sSearchFieldItems)}

		<script>
			var aAdminUsersSearchRules = {json var=Config::Get('plugin.admin.users.search_allowed_types')};
		</script>

		<span id="js-admin-users-list-search-form-q-wrapper">
			<input type="text" class="width-200" value="{$sSearchValue}" placeholder="{$aLang.plugin.admin.users.search}" />
		</span>

		<select class="width-200" id="js-admin-users-list-search-form-field-name">
			{foreach array_keys(Config::Get('plugin.admin.users.search_allowed_types')) as $sSearchIn}
				<option value="{$sSearchIn}" {if $sSearchIn == $sSearchField}selected="selected"{/if}>
					{$aLang.plugin.admin.users.search_allowed_in.$sSearchIn}
				</option>
			{/foreach}
		</select>

		{**
		 * Кнопка отключения фильтра поиска
		 *}
		{if $sSearchField}
			<a href="{$sFullPagePathToEvent}{request_filter
				name=array($sSearchField)
				value=array(null)
			}" class="button button-icon"><i class="fa fa-trash-o"></i></a>
		{/if}

		<button type="submit" class="button button-primary">{$aLang.plugin.admin.users.search}</button>
	</form>
{/block}

{block 'layout_page_title'}
	{$aLang.plugin.admin.users.title} <span>({$iUsersTotalCount})</span>
{/block}

{block 'layout_content'}
	{component 'admin:p-user' template='list' users=$aUsers pagination=$aPaging}
{/block}