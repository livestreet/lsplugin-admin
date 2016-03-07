{**
 * Список свойств
 *}

{$component = 'p-property-list'}
{component_define_params params=[ 'properties' ]}

{if $properties}
    <script>
        jQuery(function($){
            ls.admin_property.initTableProperty();
        });
    </script>

    <table class="ls-table" id="property-list">{* todo: ид переименовать т.к. может использоваться глобально, добавить префикс "admin_" *}
        <thead>
            <tr>
                <th>Название</th>
                <th>Идентификатор</th>
                <th>Тип</th>
                <th class="ls-table-cell-actions">Действие</th>
            </tr>
        </thead>
        <tbody>
            {foreach $properties as $property}
                <tr data-id="{$property->getId()}">
                    <td>{$property->getTitle()}</td>
                    <td>{$property->getCode()}</td>
                    <td>{$property->getType()}</td>
                    <td class="ls-table-cell-actions">
                        <a href="{$property->getUrlAdminUpdate()}" class="fa fa-edit" title="{$aLang.plugin.admin.edit}"></a>
                        <a href="{$property->getUrlAdminRemove()}?security_ls_key={$LIVESTREET_SECURITY_KEY}" class="fa fa-trash-o js-confirm-remove" title="{$aLang.plugin.admin.delete}"></a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    {component 'admin:blankslate' text='Нет дополнительных полей'}
{/if}