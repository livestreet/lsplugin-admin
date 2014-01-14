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
	Активность на главной странице админки:
	фильтр, аякс и реакция на кнопку "показать ещё"
	(стандартный лс жс файл для активности не годится т.к. нужно через аякс менять настройки фильтра)
 */

var ls = ls || {};

ls.admin_stream = (function($) {
	
	this.selectors = {
		/*
			активность главной страницы
		 */
		admin_index_activity_form: '#admin_index_activity_form',
		admin_index_activity_event_list: '#activity-event-list',
		admin_index_activity_last_id: '#activity-last-id',
		admin_index_activity_get_more_button: '#activity-get-more',
		admin_index_activity_dropdown_menu_trigger: '#dropdown-admin-index-stream-menu-trigger',

		/*
			для удобства (последняя запятая отсутствует)
		 */
		last_element: 'without_comma'
	};

	// ---

	return this;
	
}).call(ls.admin_stream || {}, jQuery);

// ---

jQuery(document).ready(function($) {

	/*
	 	аякс отправка формы с настройками активности
	 */
	$ (ls.admin_stream.selectors.admin_index_activity_form).ajaxForm({
		dataType: 'json',
		beforeSend: function() {
			$ (ls.admin_stream.selectors.admin_index_activity_get_more_button).show().addClass('loading');
			$ (ls.admin_stream.selectors.admin_index_activity_event_list).addClass('loading');
			/*
			 	спрятать дропдаун
			 */
			$ (ls.admin_stream.selectors.admin_index_activity_dropdown_menu_trigger).dropdown('hide');
		},
		success: function(data) {
			if (data.bStateError) {
				ls.msg.error(data.sMsgTitle, data.sMsg);
				/*
					вывести текст ошибки
				 */
				$ (ls.admin_stream.selectors.admin_index_activity_event_list).html(
					$ ('<div />', {class: 'mt-10', html: data.sMsg})
				);
			} else {
				/*
					если есть события - показать
				 */
				if (data.events_count) {
					$ (ls.admin_stream.selectors.admin_index_activity_event_list).html(data.result);
					$ (ls.admin_stream.selectors.admin_index_activity_last_id).attr('value', data.iStreamLastId);
				}

				/*
					 нужно ли спрятать кнопку "показать ещё события"
				 */
				if (!data.events_count || data.bDisableGetMoreButton) {
					$ (ls.admin_stream.selectors.admin_index_activity_get_more_button).hide();
				}
			}
		},
		complete: function(xhr) {
			$ (ls.admin_stream.selectors.admin_index_activity_get_more_button).removeClass('loading');
			$ (ls.admin_stream.selectors.admin_index_activity_event_list).removeClass('loading');
		}
	});

	/*
		аякс реакция на нажатие на кнопку "показать ещё новости"
	 */
	$ (ls.admin_stream.selectors.admin_index_activity_get_more_button).bind('click.admin', function() {
		oGetMoreButton = $ (this);
		oLastId = $ (ls.admin_stream.selectors.admin_index_activity_last_id);
		iLastId = oLastId.val();

		if (!iLastId) return;

		oGetMoreButton.addClass('loading');
		$ (ls.admin_stream.selectors.admin_index_activity_event_list).addClass('loading');

		var url = aRouter['admin'] + 'ajax-get-index-activity-more/?' + $ (ls.admin_stream.selectors.admin_index_activity_form).serialize() + '&iLastId=' + iLastId;

		ls.ajax.load(url, {}, function(data) {
			/*
				если нет ошибки и есть данные
			 */
			if (!data.bStateError && data.events_count) {
				$(ls.admin_stream.selectors.admin_index_activity_event_list).append(data.result);
				oLastId.attr('value', data.iStreamLastId);
			}

			/*
			 	нужно ли спрятать кнопку "показать ещё события"
			 */
			if (!data.events_count || data.bDisableGetMoreButton) {
				oGetMoreButton.hide();
			}

			oGetMoreButton.removeClass('loading');
			$ (ls.admin_stream.selectors.admin_index_activity_event_list).removeClass('loading');
		}.bind(this));
	});

	/*
		добавлять класс "нажатия" кнопке открывающей дропдаун
	 */
	$ (ls.admin_stream.selectors.admin_index_activity_dropdown_menu_trigger).on('dropdownbeforeshow.admin, dropdownafterhide.admin', function() {
		$ (this).toggleClass('active');
	});

});
