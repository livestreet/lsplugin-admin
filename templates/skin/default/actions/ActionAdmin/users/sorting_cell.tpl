	{*

		Сортировка по полям с учетом фильтра

		Передаваемые переменные:

		$sCellClassName - имя класса тега th таблицы ('name')
		$sSortingOrder - имя поля для сортировки текущей ячейки ('u.user_login')
		$sLinkHtml - отображаемый хтмл ссылки ('имя')
		$sBaseUrl - базовый путь ссылки для сортировки ({router page='admin/users/list'})

	*}

	<th class="{$sCellClassName} {if $sOrder==$sSortingOrder}active{/if}">
		{assign var="sWayForThisOrder" value="{if $sOrder==$sSortingOrder}{$sReverseOrder}{else}{$sWay}{/if}"}

		<a href="{$sBaseUrl}{request_filter
			name=array('order', 'way')
			value=array($sSortingOrder, $sWayForThisOrder)
		}">{$sLinkHtml}</a>

		<span class="current-way">
			{if $sWay=='asc'}
				&uarr;
			{elseif $sWay=='desc'}
				&darr;
			{/if}
		</span>
	</th>
