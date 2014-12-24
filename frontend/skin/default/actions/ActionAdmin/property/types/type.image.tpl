<h3 class="page-sub-header mt-30">Список доступных типов, например, gif, jpg, png</h3>
{$aTypeItems = $oPropertyParams.types}
<button onclick="return ls.admin_property.clickSelectItemNew('#property-select-items-types');" class="button">Добавить элемент</button>
<div id="property-select-items-types" class="mt-15 mb-30 js-property-select-area">
{if $aTypeItems}
	{foreach $aTypeItems as $sType}
        <div class="mb-10 js-property-select-item">
            <input type="text" value="{$sType}" name="param[types][]" placeholder="Тип" class="js-property-select-item-value">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="button">{$aLang.plugin.admin.delete}</button>
        </div>
	{/foreach}
	{else}
    <div class="mb-10 js-property-select-item">
        <input type="text" value="" name="param[types][]" placeholder="Тип" class="js-property-select-item-value">
        <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="button">{$aLang.plugin.admin.delete}</button>
    </div>
{/if}
</div>

<h3 class="page-sub-header mt-30">Список размеров для ресайза, например, 150x150crop</h3>
{$aSizeItems = $oPropertyParams.sizes}
<button onclick="return ls.admin_property.clickSelectItemNew('#property-select-items-sizes');" class="button">Добавить размер</button>
<div id="property-select-items-sizes" class="mt-15 mb-30 js-property-select-area">
	{if $aSizeItems}
		{foreach $aSizeItems as $sSize}
            <div class="mb-10 js-property-select-item">
                <input type="text" value="{$sSize}" name="param[sizes][]" placeholder="Размер" class="js-property-select-item-value">
                <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="button">{$aLang.plugin.admin.delete}</button>
            </div>
		{/foreach}
	{else}
        <div class="mb-10 js-property-select-item">
            <input type="text" value="" name="param[sizes][]" placeholder="Размер" class="js-property-select-item-value">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="button">{$aLang.plugin.admin.delete}</button>
        </div>
	{/if}
</div>


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

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
	sFieldName    = 'validate[width_max]'
	sFieldClasses = 'width-150'
	sFieldValue   = $oPropertyValidateRules.width_max
	sFieldLabel   = 'Максимальная ширина изображения в px'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
	sFieldName    = 'validate[height_max]'
	sFieldClasses = 'width-150'
	sFieldValue   = $oPropertyValidateRules.height_max
	sFieldLabel   = 'Максимальная высота изображения в px'}