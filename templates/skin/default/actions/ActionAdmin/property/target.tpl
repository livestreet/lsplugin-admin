{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_content'}

	Список полей/свойств:<br/>
	<br/>
	<a href="{router page="admin/properties/{$sPropertyTargetType}/create"}">Добавить свойство</a>
	<table class="table">
	{foreach $aPropertyItems as $oPropertyItem}
		<tr>
			<td>{$oPropertyItem->getTitle()}</td>
			<td>{$oPropertyItem->getCode()}</td>
			<td>{$oPropertyItem->getType()}</td>
			<td><a href="{$oPropertyItem->getUrlAdminUpdate()}">Управление</a></td>
		</tr>
	{/foreach}
	</table>

{/block}