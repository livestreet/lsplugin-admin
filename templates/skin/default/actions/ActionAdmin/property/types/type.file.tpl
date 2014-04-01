<h3 class="page-sub-header mt-30">Правила валидации</h3>

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
         sFieldName    = 'validate[allowEmpty]' 
         bFieldChecked = ! $oPropertyValidateRules.allowEmpty
         sFieldLabel   = 'Обязательно к заполнению'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
         sFieldName    = 'validate[size_max]'
         sFieldClasses = 'width-150'
         sFieldValue   = $oPropertyValidateRules.size_max
         sFieldLabel   = 'Максимальный размер файла в килобайтах'}


<h3 class="page-sub-header mt-30">Список доступных типов, например, doc, zip и т.д.</h3>

{$aTypeItems = $oPropertyParams.types}

<button onclick="return ls.admin_property.clickSelectItemNew();" class="button">Добавить элемент</button>

<div id="property-select-items" class="mt-15 mb-30">
	{if $aTypeItems}
		{foreach $aTypeItems as $sType}
            <div class="mb-10 js-property-select-item">
                <input type="text" value="{$sType}" name="param[types][]" placeholder="Тип" class="js-property-select-item-value">
                <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="button">{$aLang.plugin.admin.delete}</button>
            </div>
		{/foreach}
	{else}
        <div class="js-property-select-item">
            <input type="text" value="" name="param[types][]" placeholder="Тип" class="js-property-select-item-value">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="button">{$aLang.plugin.admin.delete}</button>
        </div>
	{/if}
</div>