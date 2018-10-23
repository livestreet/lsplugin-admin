{**
 * Список категорий
 *}

{$component = 'p-menu-list'}
{component_define_params params=[ 'items' ]}

{if $items}
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
            {foreach $items as $itemWrapper}
                {$item = $itemWrapper['entity']}
                {$level = $itemWrapper['level']}

                <tr data-id="{$item->getId()}">
                    <td>
                        <i class="fa fa-file" style="margin-left: {$level * 20}px;"></i>

                        {if $item->getUrl()}
                            <a href="{$item->getUrl()}" border="0">{$item->getTitle()}</a>
                        {else}
                            {$item->getTitle()}
                        {/if}
                    </td>
                    <td>{$item->getUrl()}</td>
                    <td>{$item->getCountTargetOfDescendants()}</td>
                    <td class="ls-table-cell-actions">
                        <a href="{$item->getUrlAdminUpdate()}" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
                        <a href="{$item->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-trash-o js-confirm-remove" title="{$aLang.plugin.admin.delete}"></a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text='Нет пунктов. Вы можете добавить.'}
{/if}