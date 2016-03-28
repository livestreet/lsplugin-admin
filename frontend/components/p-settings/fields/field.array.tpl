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

    {$classes = "$classes js-admin-settings-array-default"}
{/block}

{block 'field_input'}
    {component 'admin:field' template='hidden' name=$name value=$formid}
    {component 'admin:field' template='hidden' name=$name value=$key}

    {* Скрытая копия для структуры одного элемента массива *}
    <div class="js-hidden-array-item-copy" style="display: none;" data-key="{$key}">
        <div class="form-field-settings-array-value js-array-item-value">
            <input type="text" class="input-text" readonly data-name-original="{$name}">
            {component 'admin:button' type='button' icon='trash' classes='js-array-item-remove'}
        </div>
    </div>

    {* Элементы массива *}
    <div class="form-field-settings-array-values js-array-values" data-key="{$key}">
        {foreach $parameter->getValue() as $value}
            <div class="form-field-settings-array-value js-array-item-value">
                <input type="text" name="{$name}" class="input-text" readonly value="{$value|escape}">
                {component 'admin:button' type='button' icon='trash' classes='js-array-item-remove'}
            </div>
        {/foreach}
    </div>

    {* Тип ввода данных *}
    {if isset($validatorParams['enum'])}
        <input type="hidden" class="js-array-input-type" data-key="{$key}" value="enum">

        {* Перечисление разрешенных значений массива в селекте *}
        <select class="js-array-enum input-text width-250" data-key="{$key}">
            {foreach $validatorParams['enum'] as $value}
                <option value="{$value|escape}" {if in_array($value, $parameter->getValue())}disabled={/if}>{$value|escape}</option>
            {/foreach}
        </select>
    {else}
        <input type="hidden" class="js-array-input-type" data-key="{$key}" value="text-field">

        {* Поле для ввода значений массива *}
        <input type="text" class="js-array-input-text" data-key="{$key}" value="">
    {/if}

    {component 'admin:button' type='button' text={lang 'common.add'} mods='primary' classes='js-array-add-value' attributes=[ 'data-key' => $key ]}
{/block}
