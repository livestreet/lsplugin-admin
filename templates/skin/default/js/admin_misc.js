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
		$ (ls.admin_misc.selectors.user_search_form_id).prepend(
			$ ('<input />', {
				type: 'hidden',
				name: 'filter[' + field.val() + ']',
				value: q.val()
			})
		);
	});

});
