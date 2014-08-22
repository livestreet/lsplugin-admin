<li class="js-rbac-role-permission-item" data-id="{$oPermission->getId()}">
	{$oPermission->getTitle()} ({$oPermission->getCode()}) &mdash;
	<a href="#"
	   class="icon-remove js-question js-rbac-role-permission-remove" data-permission="{$oPermission->getId()}" data-role="{$oRole->getId()}"
	   title="{$aLang.plugin.admin.delete}" data-question-title="Действительно удалить?"></a>
</li>