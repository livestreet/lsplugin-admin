{**
 * Настройки
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	Удаление типа топика: {$oTopicType->getName()}
{/block}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/settings/topic-type"}" class="button">&larr; Назад к списку типов</a>
{/block}

{block name='layout_content'}
	Топиков с данным типом: {if $iCountTopics}{$iCountTopics}{else}нет{/if}

	<form action="{router page="admin/settings/topic-type/remove"}{$oTopicType->getId()}/" method="post">
		<br><br>

		{if $aTypeOtherItems}
			<label><input type="radio" name="type-remove" value="replace" checked="checked"> &mdash; топики НЕ удаляются, у них меняется тип. Пользовательские поля удаляются.</label><br/>
			<div>
				Сменить тип на:
				<select name="type-replace-id">
					{foreach $aTypeOtherItems as $oTypeOther}
                        <option value="{$oTypeOther->getId()}">{$oTypeOther->getName()} - {$oTypeOther->getCode()}</option>
					{/foreach}
				</select>
			</div>
            <br/>
		{/if}

		<label><input type="radio" name="type-remove" value="remove" {if !$aTypeOtherItems}checked="checked" {/if}> &mdash; топики и пользовательские поля УДАЛЯЮТСЯ. Удаление может занять длительное время.</label>

		<div class="alert alert-info mt-15">
			Будьте аккуратны, удаление данных отменить нельзя!
		</div>

		{include "{$aTemplatePathPlugin.admin}forms/fields/form.field.hidden.security_key.tpl"}
        <button type="submit" class="button button-primary" name="submit-remove">{$aLang.common.remove}</button>
    </form>
{/block}