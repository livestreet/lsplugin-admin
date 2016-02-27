{component_define_params params=[ 'propertyParams', 'rules' ]}

<h3 class="page-sub-header mt-30">Дополнительные параметры</h3>

{component 'admin:field.text' name='param[default]' value=$propertyParams.default label='Дефолтное значение'}

<h3 class="page-sub-header mt-30">Правила валидации</h3>

{component 'admin:field.checkbox' name='validate[allowEmpty]' checked=!$rules.allowEmpty label='Обязательно к заполнению'}
{component 'admin:field.text' name='validate[min]' value=$rules.min label='Минимальное значение'}
{component 'admin:field.text' name='validate[max]' value=$rules.max label='Максимальное значение'}