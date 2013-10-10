{$oPropertyValidateRules=$oProperty->getValidateRules()}

Правила валидации:
<br/>
Обязательно к заполнению: <input type="checkbox" value="1" name="validate[allowEmpty]" {if !$oPropertyValidateRules.allowEmpty}checked="checked" {/if}>