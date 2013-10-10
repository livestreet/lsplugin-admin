{$oPropertyValidateRules=$oProperty->getValidateRules()}

Правила валидации:
<br/>
Обязательно к заполнению: <input type="checkbox" value="1" name="validate[allowEmpty]" {if !$oPropertyValidateRules.allowEmpty}checked="checked" {/if}><br/>
Минимальная длина: <input type="text" value="{$oPropertyValidateRules.min}" name="validate[min]"><br/>
Максимальная длина: <input type="text" value="{$oPropertyValidateRules.max}" name="validate[max]"><br/>