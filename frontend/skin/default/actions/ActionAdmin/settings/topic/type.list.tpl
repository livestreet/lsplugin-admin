{**
 * Настройки для типов топиков
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}


{block name='layout_page_title'}
	Настройка типов топиков
{/block}

{block name='layout_content_actionbar'}
	<a href="{router page="admin/settings/topic-type/create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>
{/block}

{block name='layout_content'}
	<script>
		jQuery(function($){
            ls.admin_topic.initTableType();
		});
	</script>
	<table class="table" id="type-list">{* todo: ид переименовать т.к. может использоваться глобально, добавить префикс "admin_" *}
        <thead>
			<tr>
				<th>Название</th>
				<th>Идентификатор</th>
				<th>Состояние</th>
				<th>Действие</th>
			</tr>
        </thead>
		<tbody>
			{foreach $aTopicTypeItems as $oTopicTypeItem}
				<tr data-type-id="{$oTopicTypeItem->getId()}">
					<td>{$oTopicTypeItem->getName()}</td>
					<td>{$oTopicTypeItem->getCode()}</td>
					<td>{$oTopicTypeItem->getStateText()}</td>
					<td>
						<a href="{router page="admin/settings/topic-type/update"}{$oTopicTypeItem->getId()}/" class="ls-icon-edit" title="{$aLang.plugin.admin.edit}"></a>
						<a href="{router page="admin/properties"}{$oTopicTypeItem->getPropertyTargetType()}/" class="ls-icon-th-list" title="Настройка дополнительных полей"></a>
						{if $oTopicTypeItem->getAllowRemove()}
							<a href="{router page="admin/settings/topic-type/remove"}{$oTopicTypeItem->getId()}/" class="ls-icon-remove" title="{$aLang.plugin.admin.delete}"></a>
						{/if}
					</td>
				</tr>
			{/foreach}
        </tbody>
	</table>
{/block}