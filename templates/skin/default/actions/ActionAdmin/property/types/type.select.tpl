{include file='forms/form.field.checkbox.tpl' 
         sFieldName    = 'validate[allowEmpty]' 
         bFieldChecked = ! $oPropertyValidateRules.allowEmpty
         sFieldLabel   = 'Обязательно к заполнению'}

{include file='forms/form.field.checkbox.tpl' 
         sFieldName    = 'validate[allowMany]' 
         bFieldChecked = $oPropertyValidateRules.allowMany
         sFieldLabel   = 'Возможен множественный выбор'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
         sFieldName    = 'validate[min]'
         sFieldClasses = 'width-150'
         sFieldValue   = $oPropertyValidateRules.min
         sFieldLabel   = 'Минимальное количество элементов для выбора'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
         sFieldName    = 'validate[max]'
         sFieldClasses = 'width-150'
         sFieldValue   = $oPropertyValidateRules.max
         sFieldLabel   = 'Максимальное количество элементов для выбора'}


<h3 class="page-sub-header mt-30">Набор элементов для выбора</h3>

{$aSelectItems = $oProperty->getSelects()}

<button onclick="return ls.admin_property.clickSelectItemNew();" class="button">Добавить элемент</button>

<div id="property-select-items" class="mt-15 mb-30">
	{if $aSelectItems}
		{foreach $aSelectItems as $oSelect}
            <div class="mb-10 js-property-select-item">
                <input type="text" value="{$oSelect->getValue()}" name="items[value][]" placeholder="Значение" class="js-property-select-item-value">
                <input type="text" value="{$oSelect->getSort()}" name="items[sort][]" placeholder="Сортировка" class="js-property-select-item-sort">
                <input type="hidden" value="{$oSelect->getId()}" name="items[id][]" class="js-property-select-item-id">
                <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="button">{$aLang.plugin.admin.delete}</button>
            </div>
		{/foreach}
	{else}
        <div class="js-property-select-item">
            <input type="text" value="" name="items[value][]" placeholder="Значение" class="js-property-select-item-value">
            <input type="text" value="" name="items[sort][]" placeholder="Сортировка" class="js-property-select-item-sort">
            <input type="hidden" value="" name="items[id][]" class="js-property-select-item-id">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="button">{$aLang.plugin.admin.delete}</button>
        </div>
	{/if}
</div>