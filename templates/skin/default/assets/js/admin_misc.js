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
			для удобства (последняя запятая отсутствует)
		 */
		last_element: 'without_comma'
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


});
