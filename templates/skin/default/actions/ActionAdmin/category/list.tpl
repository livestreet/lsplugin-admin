{**
 * Список категорий
 *
 * @param array $aCategoryItems Список категорий
 *
 * TODO: Вывод имени плагина
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/categories/{$oCategoryType->getTargetType()}/create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>
{/block}
{* todo: add lang *}
{block name='layout_page_title'}Категории типа &laquo;{$oCategoryType->getTitle()|escape:'html'}&raquo;{/block}

{block name='layout_content'}
	{if $aCategoryItems}
		<table class="table">
            <thead>
				<tr>
					<th>Название</th>
					<th>URL</th>
					<th>Действие</th>
				</tr>
            </thead>
            <tbody>
				{foreach $aCategoryItems as $aCategoryItem}
					{$oCategoryItem=$aCategoryItem['entity']}
					{$iLevel=$aCategoryItem['level']}
					<tr data-id="{$oCategoryItem->getId()}">
						<td>
							<i class="icon-file" style="margin-left: {$iLevel*20}px;"></i>
							<a href="{$oCategoryItem->getWebUrl()}" border="0">{$oCategoryItem->getTitle()}</a>
						</td>
						<td>{$oCategoryItem->getUrlFull()}</td>
						<td class="ta-r">
							<a href="{$oCategoryItem->getUrlAdminUpdate()}" class="icon-edit" title="{$aLang.plugin.admin.edit}"></a>
							<a href="{$oCategoryItem->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}"
							   class="icon-remove js-question"
							   title="{$aLang.plugin.admin.delete}"
							   data-question-title="Действительно удалить?"></a>
						</td>
					</tr>
				{/foreach}
            </tbody>
		</table>
	{else}
		{include file="{$aTemplatePathPlugin.admin}alert.tpl" sAlertStyle='info' mAlerts='Нет категорий. Вы можете добавить новую.'}
	{/if}
{/block}