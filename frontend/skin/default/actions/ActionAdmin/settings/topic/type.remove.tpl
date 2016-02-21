{**
 * Настройки
 *}

{extends "{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block 'layout_page_title'}
	Удаление типа топика: {$oTopicType->getName()}
{/block}

{block 'layout_options' append}
	{$layoutBackUrl = {router page="admin/settings/topic-type"}}
{/block}

{block 'layout_content'}
	<p>Топиков с данным типом: <strong>{if $iCountTopics}{$iCountTopics}{else}нет{/if}</strong></p>

	<form action="{router page="admin/settings/topic-type/remove"}{$oTopicType->getId()}/" method="post" enctype="application/x-www-form-urlencoded">
		{component 'admin:field' template='hidden.security-key'}

		{if $aTypeOtherItems}
			{component 'admin:field' template='radio' name='type-remove' value='replace' checked=true label='Топики НЕ удаляются, у них меняется тип. Пользовательские поля удаляются'}

			{$items = []}

			{foreach $aTypeOtherItems as $oTypeOther}
				{$items[] = [
					'text' => "{$oTypeOther->getName()} - {$oTypeOther->getCode()}",
					'value' => $oTypeOther->getId()
				]}
			{/foreach}

			{component 'admin:field' template='select' name='type-replace-id' label='Сменить тип на' items=$items}
		{/if}

		{component 'admin:field' template='radio' name='type-remove' value='remove' checked=!$aTypeOtherItems label='Топики и пользовательские поля УДАЛЯЮТСЯ. Удаление может занять длительное время'}

		{component 'admin:alert' text='Будьте аккуратны, удаление данных отменить нельзя!' mods='info'}

		{component 'admin:button' name='submit-remove' classes='js-confirm-remove' text=$aLang.common.remove mods='primary'}
    </form>
{/block}