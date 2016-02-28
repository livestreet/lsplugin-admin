{extends 'component@email.email'}

{block 'content'}
	Мы получили ваше обращение, <a href="{$oUserFrom->getUserWebPath()}">{$oUserFrom->getDisplayName()}</a>.
	<br>
	<br>
	<b>Реакция:</b> {$sText}<br/>
{/block}