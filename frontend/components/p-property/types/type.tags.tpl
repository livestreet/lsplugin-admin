{component_define_params params=[ 'propertyParams', 'rules' ]}

<h3 class="page-sub-header mt-30">Правила валидации</h3>

{component 'admin:field.checkbox' name='validate[allowEmpty]' checked=!$rules.allowEmpty label='Обязательно к заполнению'}
{component 'admin:field.text' name='validate[countMin]' value=$rules.countMin label='Минимальное количество тегов'}
{component 'admin:field.text' name='validate[countMax]' value=$rules.countMax label='Максимальное количество тегов'}