{extends file="{$aTemplatePathPlugin.admin}layout.base.tpl"}

{block name='layout_content'}

<form method="post" action="">
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}">

	Настройка поля:<br/>
	<br/>

	Тип: {$oProperty->getTypeTitle()}<br/>
	{*
	<select name="property[type]">
		<option value="int">Целое число</option>
		<option value="float">Дробное число</option>
		<option value="varchar">Строка</option>
		<option value="text">Текст</option>
		<option value="checkbox">Чекбокс</option>
		<option value="select">Селект</option>
		<option value="tags">Теги</option>
		<option value="video_link">Ссылка на видео</option>
	</select>
	*}

	Название: <input name="property[title]" value="{$oProperty->getTitle()}"><br/>
	Код: <input name="property[code]" value="{$oProperty->getCode()}"><br/>
	Сортировка: <input name="property[sort]" value="{$oProperty->getSort()}"><br/>

	<br/>
	{include file="{$aTemplatePathPlugin.admin}actions/ActionAdmin/property/type.{$oProperty->getType()}.tpl"}

    <br/><br/>
	<button type="submit" name="property_update_submit" value="1">Сохранить</button>

</form>

{/block}