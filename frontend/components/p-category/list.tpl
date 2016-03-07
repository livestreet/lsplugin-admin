{**
 * Список категорий
 *}

{$component = 'p-category-list'}
{component_define_params params=[ 'categories' ]}

{if $categories}
    <table class="ls-table">
        <thead>
            <tr>
                <th>Название</th>
                <th>URL</th>
                <th>Элементов</th>
                <th class="ls-table-cell-actions">Действие</th>
            </tr>
        </thead>
        <tbody>
            {foreach $categories as $categoryWrapper}
                {$category = $categoryWrapper['entity']}
                {$level = $categoryWrapper['level']}

                <tr data-id="{$category->getId()}">
                    <td>
                        <i class="fa fa-file" style="margin-left: {$level * 20}px;"></i>

                        {if $category->getWebUrl()}
                            <a href="{$category->getWebUrl()}" border="0">{$category->getTitle()}</a>
                        {else}
                            {$category->getTitle()}
                        {/if}
                    </td>
                    <td>{$category->getUrlFull()}</td>
                    <td>{$category->getCountTargetOfDescendants()}</td>
                    <td class="ls-table-cell-actions">
                        <a href="{$category->getUrlAdminUpdate()}" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
                        <a href="{$category->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-trash-o js-confirm-remove" title="{$aLang.plugin.admin.delete}"></a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text='Нет категорий. Вы можете добавить новую.'}
{/if}