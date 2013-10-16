/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 * 
 * ------------------------------------------------------
 * 
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 * 
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * 
 * ------------------------------------------------------
 * 
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Serge Pustovit (PSNet) <light.feel@gmail.com>
 * 
 */

/*
	Разные небольшие скрипты для админки,
	код которых не еффективно помещать в отдельные файлы
 */

var ls = ls || {};

ls.admin_misc = (function($) {
	
	this.selectors = {
		/*
			количество элементов на страницу
		 */
		on_page_form_id: '#admin_onpage, #admin_bans_onpage, #admin_votes_onpage',
		on_page_count: '#admin_onpage select, #admin_bans_onpage select, #admin_votes_onpage select',
		/*
			редактирование рейтинга и силы
		 */
		edit_rating_form_id: '#admin_editrating',

		/*
			форма поиска по пользователям на странице пользователей
		 */
		user_search_form_id: '#admin_user_list_search_form',
		user_search_form_q: '#admin_user_list_search_form_q',
		user_search_form_field: '#admin_user_list_search_form_field',

		/*
			проверка правила для бана
		 */
		bans_user_sign: '#admin_bans_user_sign',
		bans_answer_id: '#admin_bans_checking_msg',

		/*
			табличный вывод данных графика
		 */
		graph_stats_table_data_id: '#admin_users_graph_table_stats_data',
		graph_stats_table_data_button: '#admin_users_show_graph_stats_in_table',

		/*
			переключатель периода прироста объектов на главной
		 */
		index_items_growth_period_select_id: '#admin_index_growth_period_select',
		index_items_new_block_id: '#admin_index_new_items_block',
		index_items_new_form_id: '#admin_index_growth_block_form',

		/*
			просмотр короткой статистики по проживанию пользователей на странице статистики пользователей (селект)
		 */
		users_stats_living_stats_short_view_select: '#admin_users_stats_living_stats_short_view_select',
		users_stats_living_stats_short_view_count: '#admin_users_stats_living_stats_short_view_count',
		users_stats_living_stats_short_view_percentage: '#admin_users_stats_living_stats_short_view_percentage',


		/*
			для удобства (последняя запятая отсутствует)
		 */
		last_element: 'without_comma'
	};

	// ---

	this.ShowShortViewLivingSelectData = function(iCount) {
		$ (this.selectors.users_stats_living_stats_short_view_count).text(iCount);
		$ (this.selectors.users_stats_living_stats_short_view_percentage).text((iCount*100/iTotalUsersCount).toFixed(2) + ' %');
	};
	
	// ---

	return this;
	
}).call(ls.admin_misc || {}, jQuery);

// ---

jQuery(document).ready(function($) {

	/*
		изменение количества элементов на страницу
		обработка формы через аякс
	 */
	$ (ls.admin_misc.selectors.on_page_form_id).ajaxForm({
		dataType: 'json',
		beforeSend: function() {},
		success: function(data) {
			if (data.bStateError) {
				ls.msg.error(data.sMsgTitle, data.sMsg);
			} else {
				ls.msg.notice('Ok');
			}
		},
		complete: function(xhr) {
			window.location.reload(true);
		}
	});
	/*
		послать запрос при изменении количества элементов в селекте
	 */
	$ (document).on ('change.admin', ls.admin_misc.selectors.on_page_count, function () {
		$ (ls.admin_misc.selectors.on_page_form_id).submit();
	});


	/*
		редактирование рейтинга и силы пользователя
	 */
	$ (ls.admin_misc.selectors.edit_rating_form_id).ajaxForm({
		dataType: 'json',
		beforeSend: function() {},
		success: function(data) {
			if (data.bStateError) {
				ls.msg.error(data.sMsgTitle, data.sMsg);
			} else {
				ls.msg.notice('Ok');
			}
		},
		complete: function(xhr) {}
	});


	/*
		добавление скрытого поля для поиска по пользователям (поле имеет имя filter[profile_name])
	 */
	$ (ls.admin_misc.selectors.user_search_form_id).bind('submit.admin', function() {
		q = $ (ls.admin_misc.selectors.user_search_form_q);
		field = $ (ls.admin_misc.selectors.user_search_form_field);
		/*
			запретить поиск с пустым условием
		 */
		if ($.trim(q.val()) == '') return false;
		$ (ls.admin_misc.selectors.user_search_form_id).prepend(
			$ ('<input />', {
				type: 'hidden',
				name: 'filter[' + field.val() + ']',
				value: q.val()
			})
		);
	});


	/*
		проверка данных поля для бана
	 */
	$ (ls.admin_misc.selectors.bans_user_sign).bind('blur.admin', function() {
		sVal = $.trim ($ (this).val());
		if (sVal == '') return false;
		$ (ls.admin_misc.selectors.bans_answer_id).html('').addClass('loading');			// todo: прикрутить крутилку (класс "loading")
		ls.ajax(
			aRouter ['admin'] + 'bans/ajax-check-user-sign',
			{
				value: sVal
			},
			function(data) {
				if (data.bStateError) {
					ls.msg.notice(data.sMsg, data.sTitle);
				} else {
					$ (ls.admin_misc.selectors.bans_answer_id).html('<i class="icon-check"></i>&nbsp;' + data.sResponse).removeClass('loading');
				}
			}
		);
	});


	/*
		скрытие/показ данных таблицы статистики для графика
	 */
	$ (ls.admin_misc.selectors.graph_stats_table_data_button).bind('click.admin', function(){
		$ (ls.admin_misc.selectors.graph_stats_table_data_id).slideToggle(200);
		return false;
	});


	/*
	 	изменение периода в блоке прироста объектов на главной
	 */
	$ (ls.admin_misc.selectors.index_items_growth_period_select_id).bind('change.admin', function(){
		$ (this).closest('form').submit();
	});

	/*
		отслеживание отправки формы при изменении периода отображения новых элементов на главной странице админки
	 */
	$ (ls.admin_misc.selectors.index_items_new_form_id).ajaxForm({
		url: aRouter ['admin'] + 'ajax-get-new-items-block',
		dataType: 'json',
		beforeSend: function() {
			$ (ls.admin_misc.selectors.index_items_new_block_id).addClass('loading');
		},
		success: function(data) {
			if (data.bStateError) {
				ls.msg.error(data.sMsgTitle,data.sMsg);
			} else {
				$ (ls.admin_misc.selectors.index_items_new_block_id).html(data.sText);
			}
		},
		complete: function(xhr) {
			$ (ls.admin_misc.selectors.index_items_new_block_id).removeClass('loading');
		}
	});


	/*
		смена элемента в селекте проживания на странице статистики пользователей
	 */
	$ (ls.admin_misc.selectors.users_stats_living_stats_short_view_select).bind('change.admin', function() {
		ls.admin_misc.ShowShortViewLivingSelectData($ (this).val());
	});
	/*
		инит текущим значением селекта проживания для отображения короткого вида
	 */
	if ($ (ls.admin_misc.selectors.users_stats_living_stats_short_view_select).length == 1) {
		ls.admin_misc.ShowShortViewLivingSelectData($ (ls.admin_misc.selectors.users_stats_living_stats_short_view_select).val());
	};





	/*
		аякс обработка нажатия на кнопки статистики пользователей по странам и городам
	 */
/*	$ (document).on ('click.admin', '#admin_users_stats_living .js-ajax-load', function() {
		sHref = $ (this).attr('href').replace(PATH_ROOT, '');
		console.log(sHref);

		return false;
	});*/


	/*
	 	todo: activity
	 */
	$ ('#admin_index_activity').ajaxForm({
		dataType: 'json',
		beforeSend: function() {
			//$ (ls.admin_misc.selectors.index_items_new_block_id).addClass('loading');
		},
		success: function(data) {
			if (data.bStateError) {
				ls.msg.error(data.sMsgTitle,data.sMsg);
			} else {
				//$ (ls.admin_misc.selectors.index_items_new_block_id).html(data.sText);
				if (data.events_count) {
					//$('#activity-event-list').append(data.result);
					$('#activity-event-list').html(data.result);
					$('#activity-last-id').attr('value', data.iStreamLastId);
				}

				$oGetMoreButton = $ ('#activity-get-more');

				if ( ! data.events_count) {
					$oGetMoreButton.hide();
				}

				$oGetMoreButton.removeClass('loading');

				//this.isBusy = false;
			}
		},
		complete: function(xhr) {
			//$ (ls.admin_misc.selectors.index_items_new_block_id).removeClass('loading');
		}
	});
	$ ('#activity-get-more').bind('click.admin', function() {
		//if (this.isBusy) return;

		$oGetMoreButton = $(this);
		$oLastId = $('#activity-last-id');
		iLastId = $oLastId.val();

		if ( ! iLastId ) return;

		$oGetMoreButton.addClass('loading');
		//this.isBusy = true;

/*		var params = {
			'iLastId':   iLastId
		};*/

/*		var params = $.extend({}, {
			'iLastId': iLastId
		}, $('#admin_index_activity').serialize().split('='));*/

		var url = aRouter['admin'] + 'ajax-get-index-activity-more/?' + $('#admin_index_activity').serialize() + '&iLastId=' + iLastId;

		ls.ajax.load(url, {}, function(data) {
			if ( ! data.bStateError && data.events_count ) {
				$('#activity-event-list').append(data.result);
				$oLastId.attr('value', data.iStreamLastId);
			}

			if ( ! data.events_count) {
				$oGetMoreButton.hide();
			}

			$oGetMoreButton.removeClass('loading');

			//this.isBusy = false;
		}.bind(this));
	});

});
