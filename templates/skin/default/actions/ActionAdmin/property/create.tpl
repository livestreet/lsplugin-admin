{extends file="{$aTemplatePathPlugin.admin}layout.base.tpl"}

{block name='layout_content'}

<form method="post" action="">
    <input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}">

	Создание поля:<br/>
	<br/>

	Тип:
	<select name="property[type]">
        <option value="int" {if $_aRequest.property.type=='int'}selected="selected"{/if}>Целое число</option>
        <option value="float" {if $_aRequest.property.type=='float'}selected="selected"{/if}>Дробное число</option>
        <option value="varchar" {if $_aRequest.property.type=='varchar'}selected="selected"{/if}>Строка</option>
        <option value="text" {if $_aRequest.property.type=='text'}selected="selected"{/if}>Текст</option>
        <option value="checkbox" {if $_aRequest.property.type=='checkbox'}selected="selected"{/if}>Чекбокс</option>
		{*
		<option value="select">Селект</option>
		*}
		<option value="tags" {if $_aRequest.property.type=='tags'}selected="selected"{/if}>Теги</option>
		<option value="video_link" {if $_aRequest.property.type=='video_link'}selected="selected"{/if}>Ссылка на видео</option>
	</select>
	<br/>
	Название: <input name="property[title]" value="{if $_aRequest.property.title}{$_aRequest.property.title}{/if}"><br/>
	Код: <input name="property[code]" value="{if $_aRequest.property.code}{$_aRequest.property.code}{/if}"><br/>

    <br/><br/>
	<button type="submit" name="property_create_submit" value="1">Добавить</button>

</form>

{/block}