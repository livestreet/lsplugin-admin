{*

	Сортировка по полям с учетом фильтра

	Передаваемые переменные:

		$sCellClassName - имя класса тега th таблицы ('name')
		$mSortingOrder - имя поля для сортировки текущей ячейки ('u.user_login'),
			может быть массивом, если нужно чтобы выводился выпадающий список по какому полю сортировать
		$mLinkHtml - отображаемый хтмл ссылки сортировки ('имя')
			может быть массивом, если нужно чтобы выводился выпадающий список по какому полю сортировать (соответствие текстовки каждому полю из $mSortingOrder)
		$sBaseUrl - базовый путь ссылки для сортировки ({router page='admin/users/list'})
		$sDropDownHtml - хтмл ссылки дропдауна, нужен в том случае, если в указаном столбце несколько выводимых полей (они должны быть указаны в массиве $mSortingOrder),
			то тогда при нажатии на шапку столбца будет показан выпадающий список полей, по которым можно сортировать таблицу.
			Если поле одно, то указывать данный параметр не нужно

	Также уже должны существовать вспомогательные переменные:

		$sReverseOrder - обратная сортировка от текущей (или той, что идет по-умолчанию в случае отсутствия выбранной)
		$sOrder - текущее имя поля для сортировки
		$sWay - текущее направление сортировки (или та, что идет по-умолчанию в случае отсутствия выбранной)

*}

<th class="cell-{$sCellClassName}">

	{if !is_array($mSortingOrder)}
		{assign var=mSortingOrder value=array($mSortingOrder)}
	{/if}

	{if !is_array($mLinkHtml)}
		{assign var=mLinkHtml value=array($mLinkHtml)}
	{/if}

	{*
		если ссылок больше одной, то тогда их нужно выводить в выпадающем списке
	*}
	{if count($mSortingOrder) > 1}
		{assign var=bDropDownMenu value=true}
		{*
			кнопка выпадающего списка
		*}
		<a href="#" class="link-dotted js-dropdown-left-bottom" data-dropdown-target="dropdown-sorting-table-menu-{$sCellClassName}">
			{*
				многоточие будет подталкивать к мысли что это выпадающее меню со множеством сортировок
			*}
			{$sDropDownHtml}&hellip;
			{*
				вывод стрелки сортировки если текущая сортировка из этого выпадающего списка сортировок,
				нужно для того, чтобы легко ориентироваться включена ли сортировка в таблице и в каком именно столбце
			*}
			{if in_array($sOrder, $mSortingOrder)}
				{if $sWay == 'asc'}
					<i class="icon-sort-asc"></i>
				{elseif $sWay == 'desc'}
					<i class="icon-sort-desc"></i>
				{/if}
			{/if}
		</a>
		{*
			начало контейнера списка сортировок
		*}
		<div class="dropdown-menu p15" id="dropdown-sorting-table-menu-{$sCellClassName}">
	{/if}

	{*
		вывод полей для сортировки
	*}
	{foreach from=$mSortingOrder item=sSortingOrderItem key=iKey}
		{*
			указывает что сортировка активна по данном полю
		*}
		{assign var=bSortedByCurrentField value=$sOrder == $sSortingOrderItem}
		{*
			направление сортировки для данного поля
		*}
		{assign var=sWayForThisOrder value="{if $bSortedByCurrentField}{$sReverseOrder}{else}{$sWay}{/if}"}
		{*
			чтобы ссылки в выпадающем списке были одна под одной
		*}
		{if $bDropDownMenu}
			<div class="{if !$sSortingOrderItem@last}mb-10{/if}">
		{/if}
		{*
			ссылка смены сортировки
		*}
		<a href="{$sBaseUrl}{request_filter
			name=array('order_field', 'order_way')
			value=array($sSortingOrderItem, $sWayForThisOrder)
		}" class="link-dotted">{$mLinkHtml[$iKey]}</a>
		{*
			стрелка, указывающая направление сортировки
		*}
		{if $bSortedByCurrentField}
			{if $sWay == 'asc'}
				<i class="icon-sort-asc"></i>
			{elseif $sWay == 'desc'}
				<i class="icon-sort-desc"></i>
			{/if}
		{/if}
		{*
			/чтобы ссылки в выпадающем списке были одна под одной
		*}
		{if $bDropDownMenu}
			</div>
		{/if}
	{/foreach}

	{*
		конец контейнера списка
	*}
	{if $bDropDownMenu}
		</div>
	{/if}

</th>
