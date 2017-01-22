{component_define_params params=[ 'propertyParams', 'rules' ]}

<h3 class="page-sub-header ls-mt-30">Дополнительные параметры</h3>

{component 'admin:field.checkbox' name='param[access_only_auth]' checked=$propertyParams.access_only_auth label='Доступ к файлу только для авторизованных пользователей'}


<h3 class="page-sub-header ls-mt-30">Список доступных типов, например, doc, zip и т.д.</h3>

{$types = $propertyParams.types}

<button onclick="return ls.admin_property.clickSelectItemNew();" class="ls-button">Добавить элемент</button>

<div id="property-select-items" class="ls-mt-15 ls-mb-30">
    {if $types}
        {foreach $types as $type}
            <div class="mb-10 js-property-select-item">
                <input type="text" value="{$type}" name="param[types][]" placeholder="Тип" class="js-property-select-item-value">
                <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="ls-button">{$aLang.plugin.admin.delete}</button>
            </div>
        {/foreach}
    {else}
        <div class="js-property-select-item">
            <input type="text" value="" name="param[types][]" placeholder="Тип" class="js-property-select-item-value">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="ls-button">{$aLang.plugin.admin.delete}</button>
        </div>
    {/if}
</div>


<h3 class="page-sub-header ls-mt-30">Правила валидации</h3>

{component 'admin:field.checkbox' name='validate[allowEmpty]' checked=!$rules.allowEmpty label='Обязательно к заполнению'}
{component 'admin:field.text' name='validate[size_max]' value=$rules.size_max label='Максимальный размер файла в килобайтах'}