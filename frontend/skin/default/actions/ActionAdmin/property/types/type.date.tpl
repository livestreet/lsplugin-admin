<h3 class="page-sub-header mt-30">Дополнительные параметры</h3>

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		sFieldName    = 'param[use_time]'
		bFieldChecked = $oPropertyParams.use_time
		sFieldLabel   = 'Использовать время'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.text.tpl"
		sFieldName    = 'param[format_out]'
		sFieldClasses = 'width-150'
		sFieldValue   = $oPropertyParams.format_out
		sFieldNote    = 'Формат указывается по спецификации функции date(). Например: Y-m-d H:i:s'
		sFieldLabel   = 'Формат вывода даты'}



<h3 class="page-sub-header mt-30">Правила валидации</h3>

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		 sFieldName    = 'validate[allowEmpty]' 
		 bFieldChecked = ! $oPropertyValidateRules.allowEmpty
		 sFieldLabel   = 'Обязательно к заполнению'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		sFieldName    = 'validate[disallowFuture]'
		bFieldChecked = $oPropertyValidateRules.disallowFuture
		sFieldLabel   = 'Запретить указывать дату в будущем'}

{include file="{$aTemplatePathPlugin.admin}forms/fields/form.field.checkbox.tpl"
		sFieldName    = 'validate[disallowPast]'
		bFieldChecked = $oPropertyValidateRules.disallowPast
		sFieldLabel   = 'Запретить указывать дату в прошлом'}