{**
 * Сортировка по полям с учетом фильтра
 *
 * @param string $sCellClassName Имя класса тега th таблицы ('name')
 * @param mixed  $mSortingOrder  Имя поля для сортировки текущей ячейки ('u.user_login') может быть массивом, если нужно чтобы выводился выпадающий список по какому полю сортировать
 * @param mixed  $mLinkHtml      Отображаемый хтмл ссылки сортировки ('имя') может быть массивом, 
 *                               если нужно чтобы выводился выпадающий список по какому полю сортировать (соответствие текстовки каждому полю из $mSortingOrder)
 * @param string $sBaseUrl       Базовый путь ссылки для сортировки ({router page='admin/users/list'})
 * @param string $sDropDownHtml  Хтмл ссылки дропдауна, нужен в том случае, если в указаном столбце несколько выводимых полей (они должны быть указаны в массиве $mSortingOrder),
 *                               то тогда при нажатии на шапку столбца будет показан выпадающий список полей, по которым можно сортировать таблицу.
 * 	                             Если поле одно, то указывать данный параметр не нужно
 *
 * Также уже должны существовать вспомогательные переменные:
 *
 * @param string $sReverseOrder  Обратная сортировка от текущей (или той, что идет по-умолчанию в случае отсутствия выбранной)
 * @param string $sOrder         Текущее имя поля для сортировки
 * @param string $sWay           Текущее направление сортировки (или та, что идет по-умолчанию в случае отсутствия выбранной)
 *}

<th class="cell-{$sCellClassName}">
	{if !is_array($mSortingOrder)}
		{$mSortingOrder = array($mSortingOrder)}
	{/if}

	{if !is_array($mLinkHtml)}
		{$mLinkHtml = array($mLinkHtml)}
	{/if}

	{* Если ссылок больше одной, то тогда их нужно выводить в выпадающем списке *}
	{if count($mSortingOrder) > 1}
		{$bDropDownMenu = true}

		{* Кнопка выпадающего списка *}
		<div class="ls-dropdown ls-dropdown--no-text js-dropdown" >
			<span class="link-dotted js-ls-dropdown-toggle">
				{* Многоточие будет подталкивать к мысли что это выпадающее меню со множеством сортировок *}
				{$sDropDownHtml}&hellip;

				{**
				 * Вывод стрелки сортировки если текущая сортировка из этого выпадающего списка сортировок,
				 * нужно для того, чтобы легко ориентироваться включена ли сортировка в таблице и в каком именно столбце
				 *}
				{if in_array($sOrder, $mSortingOrder)}
					{if $sWay == 'asc'}
						<i class="fa fa-sort-up"></i>
					{elseif $sWay == 'desc'}
						<i class="fa fa-sort-desc"></i>
					{/if}
				{/if}
			</span>

			{* Начало контейнера списка сортировок *}
			<ul class="ls-nav ls-nav--stacked ls-nav--dropdown ls-dropdown-menu js-ls-dropdown-menu  ls-clearfix" role="menu" aria-hidden="true">
	{/if}

	{* Вывод полей для сортировки *}
	{foreach $mSortingOrder as $iKey => $sSortingOrderItem}
		{* Указывает что сортировка активна по данном полю *}
		{$bSortedByCurrentField = $sOrder == $sSortingOrderItem}

		{* Направление сортировки для данного поля *}
		{$sWayForThisOrder = "{if $bSortedByCurrentField}{$sReverseOrder}{else}{$sWay}{/if}"}

		{* Чтобы ссылки в выпадающем списке были одна под одной *}
		{if $bDropDownMenu}
			<li class="ls-nav-item active"  role="menuitem">
		{/if}

		{* Ссылка смены сортировки *}
		<a href="{$sBaseUrl}{request_filter
			name=array('order_field', 'order_way')
			value=array($sSortingOrderItem, $sWayForThisOrder)
		}" class="ls-nav-item-link">{$mLinkHtml[$iKey]}

			{* Стрелка, указывающая направление сортировки *}
			{if $bSortedByCurrentField}
				{if $sWay == 'asc'}
					<i class="fa fa-sort-up"></i>
				{elseif $sWay == 'desc'}
					<i class="fa fa-sort-desc"></i>
				{/if}
			{/if}
		</a>

		{* / Чтобы ссылки в выпадающем списке были одна под одной *}
		{if $bDropDownMenu}
			</li>
		{/if}
	{/foreach}

	{* Конец контейнера списка *}
	{if $bDropDownMenu}
		</ul><div>
	{/if}
</th>