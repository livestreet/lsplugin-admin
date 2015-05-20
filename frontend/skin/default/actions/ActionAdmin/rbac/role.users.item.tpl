<li class="js-rbac-role-user-item" data-id="{$oUser->getId()}">
	{$sLogin=$oUser->getLogin()}
	{$sDisplayName=$oUser->getDisplayName()}
	<a href="{router page='admin/users/profile'}{$oUser->getId()}/">{$sDisplayName|escape:'html'} {if $sLogin!=$sDisplayName}({$sLogin}){/if}</a> &mdash;
	<a href="#"
	   class="ls-icon-remove js-question js-rbac-role-user-remove" data-user="{$oUser->getId()}" data-role="{$oRole->getId()}"
	   title="{$aLang.plugin.admin.delete}"
	   data-question-title="Действительно удалить?"></a>
</li>