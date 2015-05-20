{**
 * Типы контактов пользователей
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content_actionbar'}
    <a href="{router page="admin/users/contact-fields/create"}" class="button button-primary">{$aLang.plugin.admin.add}</a>
{/block}

{block name='layout_page_title'}
	{$aLang.plugin.admin.users.contact_fields.title}
{/block}


{block name='layout_content'}

    {if $aUserFields}
        <table class="table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Тип</th>
                <th>Шаблон</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody>
            {foreach $aUserFields as $oFieldItem}
                <tr data-id="{$oFieldItem->getId()}">
                    <td>
                        {$oFieldItem->getTitle()|escape}
                    </td>
                    <td>{$oFieldItem->getType()|escape}</td>
                    <td>{$oFieldItem->getPattern()|escape}</td>
                    <td class="ta-r">
                        <a href="{router page='admin/users/contact-fields/update'}{$oFieldItem->getId()}/" class="ls-icon-edit" title="{$aLang.plugin.admin.edit}"></a>
                        <a href="{router page='admin/users/contact-fields/remove'}{$oFieldItem->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}"
                           class="ls-icon-remove js-question"
                           title="{$aLang.plugin.admin.delete}"
                           data-question-title="Действительно удалить?"></a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {else}
        {include file="{$aTemplatePathPlugin.admin}alert.tpl" sAlertStyle='info' mAlerts='Нет контактов. Вы можете добавить новые.'}
    {/if}

{/block}