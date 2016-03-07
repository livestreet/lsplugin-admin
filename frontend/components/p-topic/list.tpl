{**
 * Список типов топика
 *}

{$component = 'p-property-list'}
{component_define_params params=[ 'types' ]}

{if $types}
    <script>
        jQuery(function($){
            ls.admin_topic.initTableType();
        });
    </script>

    <table class="ls-table" id="type-list">{* todo: ид переименовать т.к. может использоваться глобально, добавить префикс "admin_" *}
        <thead>
            <tr>
                <th>Название</th>
                <th>Идентификатор</th>
                <th>Состояние</th>
                <th class="ls-table-cell-actions">Действие</th>
            </tr>
        </thead>
        <tbody>
            {foreach $types as $type}
                <tr data-type-id="{$type->getId()}">
                    <td>{$type->getName()}</td>
                    <td>{$type->getCode()}</td>
                    <td>{$type->getStateText()}</td>
                    <td class="ls-table-cell-actions">
                        <a href="{router page="admin/settings/topic-type/update"}{$type->getId()}/" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
                        <a href="{router page="admin/properties"}{$type->getPropertyTargetType()}/" class="fa fa-th-list" title="Настройка дополнительных полей"></a>
                        {if $type->getAllowRemove()}
                            <a href="{router page="admin/settings/topic-type/remove"}{$type->getId()}/" class="fa fa-trash-o" title="{$aLang.plugin.admin.delete}"></a>
                        {/if}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text={lang 'common.empty'}}
{/if}