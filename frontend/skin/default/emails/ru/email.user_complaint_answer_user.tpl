{extends file='emails/email.base.tpl'}

{block name='content'}
	Мы получили ваше обращение, <a href="{$oUserFrom->getUserWebPath()}">{$oUserFrom->getDisplayName()}</a>.
	<br>
	<br>
	<b>Реакция:</b> {$sText}<br/>
{/block}