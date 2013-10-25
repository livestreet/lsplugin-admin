{$oPropertyValidateRules=$oProperty->getValidateRules()}
{$oPropertyParams=$oProperty->getParams()}

Правила валидации:
<br/>
Обязательно к заполнению: <input type="checkbox" value="1" name="validate[allowEmpty]" {if !$oPropertyValidateRules.allowEmpty}checked="checked" {/if}><br/>
Возможен множественный выбор: <input type="checkbox" value="1" name="validate[allowMany]" {if $oPropertyValidateRules.allowMany}checked="checked" {/if}><br/>
Минимальное количество элементов для выбора: <input type="text" value="{$oPropertyValidateRules.min}" name="validate[min]"><br/>
Максимальное количество элементов для выбора: <input type="text" value="{$oPropertyValidateRules.max}" name="validate[max]"><br/>
<br/>


{$aSelectItems=$oProperty->getSelects()}
Набор элементов для выбора:
<br/>
<button onclick="return ls.admin_property.clickSelectItemNew();">Добавить элемент</button>
<div id="property-select-items">
	{if $aSelectItems}
		{foreach $aSelectItems as $oSelect}
            <div class="js-property-select-item">
                <input type="text" value="{$oSelect->getValue()}" name="items[value][]" class="js-property-select-item-value">
                <input type="text" value="{$oSelect->getSort()}" name="items[sort][]" placeholder="Сортировка" class="js-property-select-item-sort">
                <input type="hidden" value="{$oSelect->getId()}" name="items[id][]" class="js-property-select-item-id">
                <button onclick="return ls.admin_property.clickSelectItemRemove(this);">Удалить</button>
            </div>
		{/foreach}
	{else}
        <div class="js-property-select-item">
            <input type="text" value="" name="items[value][]" class="js-property-select-item-value">
            <input type="text" value="" name="items[sort][]" placeholder="Сортировка" class="js-property-select-item-sort">
            <input type="hidden" value="" name="items[id][]" class="js-property-select-item-id">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);">Удалить</button>
        </div>
	{/if}
</div>