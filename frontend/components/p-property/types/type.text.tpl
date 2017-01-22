{component_define_params params=[ 'propertyParams', 'rules' ]}

<h3 class="page-sub-header mt-30">Дополнительные параметры</h3>

{component 'admin:field.checkbox' name='param[use_html]' checked=$propertyParams.use_html label='Разрешить HTML теги'}

<h3 class="page-sub-header mt-30">Правила валидации</h3>

{component 'admin:field.checkbox' name='validate[allowEmpty]' checked=!$rules.allowEmpty label='Обязательно к заполнению'}
{component 'admin:field.text' name='validate[min]' value=$rules.min label='Минимальная длина'}
{component 'admin:field.text' name='validate[max]' value=$rules.max label='Максимальная длина'}