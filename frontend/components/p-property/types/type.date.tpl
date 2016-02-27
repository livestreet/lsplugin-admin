{component_define_params params=[ 'propertyParams', 'rules' ]}

<h3 class="page-sub-header mt-30">Дополнительные параметры</h3>

{component 'admin:field.checkbox' name='param[use_time]' checked=$propertyParams.use_time label='Использовать время'}
{component 'admin:field.text' name='param[format_out]' value=$propertyParams.format_out label='Формат вывода даты' note='Формат указывается по спецификации функции date(). Например: Y-m-d H:i:s'}

<h3 class="page-sub-header mt-30">Правила валидации</h3>

{component 'admin:field.checkbox' name='validate[allowEmpty]' checked=!$rules.allowEmpty label='Обязательно к заполнению'}
{component 'admin:field.checkbox' name='validate[disallowFuture]' checked=$rules.disallowFuture label='Запретить указывать дату в будущем'}
{component 'admin:field.checkbox' name='validate[disallowPast]' checked=$rules.disallowPast label='Запретить указывать дату в прошлом'}