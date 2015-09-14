<li class="js-rbac-role-permission-item" data-id="{$oPermission->getId()}">
	{$oPermission->getTitleLang()} ({$oPermission->getCode()}) &mdash;
	<a href="#"
	   class="fa fa-trash-o js-question js-rbac-role-permission-remove" data-permission="{$oPermission->getId()}" data-role="{$oRole->getId()}"
	   title="{$aLang.plugin.admin.delete}" data-question-title="Действительно удалить?"></a>
</li>