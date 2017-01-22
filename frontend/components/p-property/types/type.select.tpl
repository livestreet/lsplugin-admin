{component_define_params params=[ 'property', 'propertyParams', 'rules' ]}

<h3 class="page-sub-header mt-30">Правила валидации</h3>

{component 'admin:field.checkbox' name='validate[allowEmpty]' checked=!$rules.allowEmpty label='Обязательно к заполнению'}
{component 'admin:field.checkbox' name='validate[allowMany]' checked=$rules.allowMany label='Возможен множественный выбор'}
{component 'admin:field.text' name='validate[min]' value=$rules.min label='Минимальное количество элементов для выбора'}
{component 'admin:field.text' name='validate[max]' value=$rules.max label='Максимальное количество элементов для выбора'}

<h3 class="page-sub-header mt-30">Набор элементов для выбора</h3>

{$items = $property->getSelects()}

<button onclick="return ls.admin_property.clickSelectItemNew();" class="ls-button">Добавить элемент</button>

<div id="property-select-items" class="ls-mt-15 ls-mb-30 js-property-select-area">
    {if $items}
        {foreach $items as $item}
            <div class="mb-10 js-property-select-item">
                <input type="text" value="{$item->getValue()}" name="items[value][]" placeholder="Значение" class="js-property-select-item-value">
                <input type="text" value="{$item->getSort()}" name="items[sort][]" placeholder="Сортировка" class="js-property-select-item-sort">
                <input type="hidden" value="{$item->getId()}" name="items[id][]" class="js-property-select-item-id">
                <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="ls-button">{$aLang.plugin.admin.delete}</button>
            </div>
        {/foreach}
    {else}
        <div class="mb-10 js-property-select-item">
            <input type="text" value="" name="items[value][]" placeholder="Значение" class="js-property-select-item-value">
            <input type="text" value="" name="items[sort][]" placeholder="Сортировка" class="js-property-select-item-sort">
            <input type="hidden" value="" name="items[id][]" class="js-property-select-item-id">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="ls-button">{$aLang.plugin.admin.delete}</button>
        </div>
    {/if}
</div>