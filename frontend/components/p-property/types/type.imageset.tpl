{component_define_params params=[ 'propertyParams', 'rules' ]}

<h3 class="page-sub-header ls-mt-30">Правила валидации</h3>

{$value_min = $rules.count_min}
{$value_max = $rules.count_max}

{if $propertyParams.count_max}
    {$value_max = $propertyParams.count_max}
{/if}
{if $propertyParams.count_min}
    {$value_min = $propertyParams.count_min}
{/if}

{component 'admin:field.checkbox' name='validate[allowEmpty]' checked=!$rules.allowEmpty label='Обязательно к заполнению'}
{component 'admin:field.text' name='validate[count_min]' value=$value_min label='Минимальное количество медиа'}
{component 'admin:field.text' name='validate[count_max]' value=$value_max label='Максимальное количество медиа'}

