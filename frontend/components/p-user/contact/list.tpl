{**
 * Список контактов
 *}

{$component = 'p-user-contact-list'}
{component_define_params params=[ 'fields' ]}

{if $fields}
    <table class="ls-table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Тип</th>
                <th>Шаблон</th>
                <th class="ls-table-cell-actions">Действие</th>
            </tr>
        </thead>

        <tbody>
        {foreach $fields as $field}
            <tr data-id="{$field->getId()}">
                <td>
                    {$field->getTitle()|escape}
                </td>
                <td>{$field->getType()|escape}</td>
                <td>{$field->getPattern()|escape}</td>
                <td class="ls-table-cell-actions">
                    <a href="{router page='admin/users/contact-fields/update'}{$field->getId()}/" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
                    <a href="{router page='admin/users/contact-fields/remove'}{$field->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-trash-o js-confirm-remove" title="{$aLang.plugin.admin.delete}"></a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text='Нет контактов'}
{/if}