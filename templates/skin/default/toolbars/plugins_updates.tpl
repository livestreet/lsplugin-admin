
{*
	Кнопка на тулбаре количества обновлений для плагинов (только для админа)
*}

<section class="toolbar-item">
	<a href="{router page='admin/plugins/list'}updates" title="{$aLang.plugin.admin.plugins.updates_exists_button|ls_lang:"count%%`$params.iUpdatesCount`"}">
		<i class="icon-asterisk mb-10"></i>
		<div style="text-align: center;">
			{$params.iUpdatesCount}
		</div>
	</a>
</section>
