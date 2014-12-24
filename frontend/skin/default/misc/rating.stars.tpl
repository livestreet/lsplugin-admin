{**
 * Рейтинг звездочками
 *
 * @param integer $iRating Рейтинг от 0 до 100
 * @param boolean $bNoTitle Отображать подсказку или нет
 *}

<ul class="stars" {if ! $bNoTitle}title="Средняя оценка: {$iRating / 20}"{/if}>{* todo: add langs *}
	<li class="star {if $iRating >= 20}star-full{elseif $iRating >= 10}star-half{/if}"></li>
	<li class="star {if $iRating >= 40}star-full{elseif $iRating >= 30}star-half{/if}"></li>
	<li class="star {if $iRating >= 60}star-full{elseif $iRating >= 50}star-half{/if}"></li>
	<li class="star {if $iRating >= 80}star-full{elseif $iRating >= 70}star-half{/if}"></li>
	<li class="star {if $iRating >= 100}star-full{elseif $iRating >= 90}star-half{/if}"></li>
</ul>