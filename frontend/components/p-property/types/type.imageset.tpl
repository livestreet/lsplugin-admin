{component_define_params params=[ 'propertyParams', 'rules' ]}

<h3 class="page-sub-header ls-mt-30">Правила валидации</h3>

{component 'admin:field.checkbox' name='validate[allowEmpty]' checked=!$rules.allowEmpty label='Обязательно к заполнению'}
{component 'admin:field.text' name='validate[size_max]' value=$rules.size_max label='Максимальный размер файла в килобайтах'}
{component 'admin:field.text' name='validate[width_max]' value=$rules.width_max label='Максимальная ширина изображения в px'}
{component 'admin:field.text' name='validate[height_max]' value=$rules.height_max label='Максимальная высота изображения в px'}

<h3 class="page-sub-header ls-mt-30">Список доступных типов, например, gif, jpg, png</h3>

{$types = $propertyParams.types}

<button onclick="return ls.admin_property.clickSelectItemNew('#property-select-items-types');" class="ls-button">Добавить элемент</button>

<div id="property-select-items-types" class="ls-mt-15 ls-mb-30 js-property-select-area">
    {if $types}
        {foreach $types as $type}
            <div class="mb-10 js-property-select-item">
                <input type="text" value="{$type}" name="param[types][]" placeholder="Тип" class="js-property-select-item-value">
                <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="ls-button">{$aLang.plugin.admin.delete}</button>
            </div>
        {/foreach}
    {else}
        <div class="mb-10 js-property-select-item">
            <input type="text" value="" name="param[types][]" placeholder="Тип" class="js-property-select-item-value">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="ls-button">{$aLang.plugin.admin.delete}</button>
        </div>
    {/if}
</div>

<h3 class="page-sub-header mt-30">Список размеров для ресайза, например, 150x150crop</h3>

{$sizes = $propertyParams.sizes}

<button onclick="return ls.admin_property.clickSelectItemNew('#property-select-items-sizes');" class="ls-button">Добавить размер</button>

<div id="property-select-items-sizes" class="ls-mt-15 ls-mb-30 js-property-select-area">
    {if $sizes}
        {foreach $sizes as $size}
            <div class="mb-10 js-property-select-item">
                <input type="text" value="{$size}" name="param[sizes][]" placeholder="Размер" class="js-property-select-item-value">
                <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="ls-button">{$aLang.plugin.admin.delete}</button>
            </div>
        {/foreach}
    {else}
        <div class="mb-10 js-property-select-item">
            <input type="text" value="" name="param[sizes][]" placeholder="Размер" class="js-property-select-item-value">
            <button onclick="return ls.admin_property.clickSelectItemRemove(this);" class="ls-button">{$aLang.plugin.admin.delete}</button>
        </div>
    {/if}
</div>