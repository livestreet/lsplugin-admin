{**
 * Целые числа
 *}

{extends 'component@admin:p-settings.field-string'}

{block 'field_options' append}
    {if $parameter->getNeedToShowSpecialIntegerForm()}
        {$validatorData = $parameter->getValidator()}
        {$validatorParams = $validatorData['params']}
        {$type = 'number'}

        {$inputAttributes = [
            'min' => $validatorParams['min'],
            'max' => $validatorParams['max']
        ]}
    {/if}
{/block}