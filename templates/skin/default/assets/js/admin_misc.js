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
			(можно указать несколько селекторов через запятую, если нужно несколько форм на одной странице, в противном случае можно использовать всегда #admin_onpage)
		 */
		on_page_form_id: '#admin_onpage',
		on_page_count: '#admin_onpage select',

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
		graph_table_data_id: '#admin_graph_table_data',
		graph_table_data_button: '#admin_show_graph_data_in_table',

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
		добавление скрытого поля для поиска по пользователям (поле имеет имя filter[profile_name])
	 */
	$ (ls.admin_misc.selectors.user_search_form_id).bind('submit.admin', function() {
		q = $ (ls.admin_misc.selectors.user_search_form_q);
		field = $ (ls.admin_misc.selectors.user_search_form_field);
		/*
			список разрешенных типов поиска, по которым можно искать без указания искомого значения
		 */
		aAllowedSearchTypes = ['profile_sex', 'admins_only'];
		/*
			флаг, который указывает что для данного поиска разрешено не указывать поисковый запрос
		 */
		bAllowEmptyRequest = $.inArray(field.val(), aAllowedSearchTypes) !== -1;
		/*
			запретить поиск с пустым условием
		 */
		if ($.trim(q.val()) == '' && !bAllowEmptyRequest) return false;
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
	$ (ls.admin_misc.selectors.bans_user_sign).bind('change.admin', function() {
		var sVal = $.trim ($ (this).val());
		if (sVal == '') return false;
		$ (this).addClass('loading');
		$ (ls.admin_misc.selectors.bans_answer_id).html('');
		ls.ajax.load(
			aRouter ['admin'] + 'bans/ajax-check-user-sign',
			{
				value: sVal
			},
			function(data) {
				if (data.bStateError) {
					ls.msg.notice(data.sMsg, data.sTitle);
				} else {
					$ (ls.admin_misc.selectors.bans_answer_id).html('<i class="icon-check"></i>&nbsp;' + data.sResponse);
				}
				$ (ls.admin_misc.selectors.bans_user_sign).removeClass('loading');
			}
		);
	});


	/*
		скрыть/показать данные для графика в таблице под ним
	 */
	$ (ls.admin_misc.selectors.graph_table_data_button).bind('click.admin', function() {
		$ (ls.admin_misc.selectors.graph_table_data_id).slideToggle(200);
		$ (this).toggleClass('active');
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
