{**
 * Строковый тип
 *}

{extends 'component@admin:field.text'}

{block 'field_options' append}
    {component_define_params params=[ 'parameter', 'key', 'formid' ]}

    {$label = $parameter->getName()}
    {$note = $parameter->getDescription()}

    {$validatorData = $parameter->getValidator()}
    {$validatorParams = $validatorData['params']}
{/block}

{block 'field_input'}
    {component 'admin:field' template='hidden' name=$name value=$formid}
    {component 'admin:field' template='hidden' name=$name value=$key}

    {* Скрытая копия для структуры одного элемента массива *}
    <div class="js-hidden-array-item-copy" style="display: none;" data-key="{$sKey}">
        <div class="form-field-settings-array-value js-array-item-value">
            <input type="text" class="input-text width-100" readonly="readonly" value="" data-name-original="{$sInputDataName}" />
            <button type="button" class="button button-primary form-field-settings-array-remove js-remove-previous">x</button>
        </div>
    </div>

    {* Элементы массива *}
    <div class="form-field-settings-array-values js-array-values" data-key="{$sKey}">
        {foreach $parameter->getValue() as $value}
            <div class="form-field-settings-array-value js-array-item-value">
                <input type="text" name="{$sInputDataName}" class="input-text width-100" readonly="readonly" value="{$value|escape}" />
                <button type="button" class="button button-primary form-field-settings-array-remove js-remove-previous">x</button>
            </div>
        {/foreach}
    </div>

    {* Тип ввода данных *}
    {if isset($validatorParams['enum'])}
        <input type="hidden" class="js-array-input-type" data-key="{$sKey}" value="enum" />

        {* Перечисление разрешенных значений массива в селекте *}
        <select class="js-array-enum input-text width-250" data-key="{$sKey}">
            {foreach $validatorParams['enum'] as $value}
                <option value="{$value|escape}" {if in_array($value, $parameter->getValue())}disabled="disabled"{/if}>{$value|escape}</option>
            {/foreach}
        </select>
    {else}
        <input type="hidden" class="js-array-input-type" data-key="{$sKey}" value="text-field" />

        {* Поле для ввода значений массива *}
        <input type="text" class="js-array-input-text input-text width-250" data-key="{$sKey}" value="" />
    {/if}

    <button type="button" class="js-array-add-value button button-primary" data-key="{$sKey}">+</button>
{/block}
