{component_define_params params=[ 'propertyParams', 'rules' ]}

<h3 class="page-sub-header mt-30">Дополнительные параметры</h3>

{component 'admin:field.text' name='param[default_value]' value=$propertyParams.default_value label='Значение атрибута value'}
{component 'admin:field.checkbox' name='param[default]' checked=$propertyParams.default label='Дефолтное значение'}