{$oPropertyValidateRules=$oProperty->getValidateRules()}

Правила валидации:
<br/>
Обязательно к заполнению: <input type="checkbox" value="1" name="validate[allowEmpty]" {if !$oPropertyValidateRules.allowEmpty}checked="checked" {/if}><br/>
Максимальное количество тегов: <input type="text" value="{if $oPropertyValidateRules.count}{$oPropertyValidateRules.count}{/if}" name="validate[count]">