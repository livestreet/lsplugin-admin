{**
 * Список категорий
 *
 * @param array $aCategoryItems Список категорий
 *
 * TODO: Вывод имени плагина
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_content_actionbar'}
	{component 'admin:button' text=$aLang.plugin.admin.add url={router page="admin/categories/{$oCategoryType->getTargetType()}/create"} mods='primary'}
{/block}

{block 'layout_page_title'}
	Категории типа &laquo;{$oCategoryType->getTitle()|escape}&raquo;
{/block}

{block 'layout_content'}
	{if $aCategoryItems}
		<table class="table">
            <thead>
				<tr>
					<th>Название</th>
					<th>URL</th>
					<th>Элементов</th>
					<th>Действие</th>
				</tr>
            </thead>
            <tbody>
				{foreach $aCategoryItems as $aCategoryItem}
					{$oCategoryItem=$aCategoryItem['entity']}
					{$iLevel=$aCategoryItem['level']}

					<tr data-id="{$oCategoryItem->getId()}">
						<td>
							<i class="fa fa-file" style="margin-left: {$iLevel*20}px;"></i>
							{if $oCategoryItem->getWebUrl()}
								<a href="{$oCategoryItem->getWebUrl()}" border="0">{$oCategoryItem->getTitle()}</a>
							{else}
								{$oCategoryItem->getTitle()}
							{/if}
						</td>
						<td>{$oCategoryItem->getUrlFull()}</td>
						<td>{$oCategoryItem->getCountTargetOfDescendants()}</td>
						<td class="ta-r">
							<a href="{$oCategoryItem->getUrlAdminUpdate()}" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
							<a href="{$oCategoryItem->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
							   class="fa fa-trash-o js-confirm-remove"
							   title="{$aLang.plugin.admin.delete}"></a>
						</td>
					</tr>
				{/foreach}
            </tbody>
		</table>
	{else}
		{component 'admin:blankslate' text='Нет категорий. Вы можете добавить новую.'}
	{/if}
{/block}