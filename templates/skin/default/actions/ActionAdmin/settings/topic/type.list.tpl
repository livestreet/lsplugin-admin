{**
 * Настройки
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	Настройка типов топиков
{/block}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/settings/topic-type/create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>
{/block}

{block name='layout_content'}
	<table class="table">
		<tr>
			<th>Название</th>
			<th>Идентификатор</th>
			<th>Состояние</th>
			<th>Действие</th>
		</tr>
		{foreach $aTopicTypeItems as $oTopicTypeItem}
            <tr>
                <td>{$oTopicTypeItem->getName()}</td>
                <td>{$oTopicTypeItem->getCode()}</td>
                <td>{$oTopicTypeItem->getStateText()}</td>
                <td>

                </td>
            </tr>
		{/foreach}
	</table>
{/block}