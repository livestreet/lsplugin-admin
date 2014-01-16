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
	Обработка поля для поиска по пользователям
 */

var ls = ls || {};

ls.admin_users_search = (function($) {
	
	this.selectors = {
		/*
			форма поиска по пользователям на странице пользователей
		 */
		form_id: 					'#js-admin-users-list-search-form-id',
		search_query_wrapper: 		'#js-admin-users-list-search-form-q-wrapper',
		search_query: 				'#js-admin-users-list-search-form-q-wrapper > *',
		field_name: 				'#js-admin-users-list-search-form-field-name',
		class_for_element: 			'width-200',

		/*
			для удобства (последняя запятая отсутствует)
		 */
		last_element: 'without_comma'
	};


	/**
	 * Триггер смены имени поля (в селекте) для поиска, подставляющий нужные типы полей (инпут или селект) и разрешенных значений в них (для селекта)
	 *
	 * @param oField				объект селекта
	 * @constructor
	 */
	this.ChangeFieldNameTrigger = function(oField) {
		var sCurrentField = $ (oField).val();
		var aRulesForField = aAdminUsersSearchRules[sCurrentField];
		var aRestrictedValues = aRulesForField['restricted_values'];
		/*
			получить текущее значение
		 */
		var sCurrentValue = $ (this.selectors.search_query).val();
		/*
		 	если задан ограниченный набор возможных значений - показать селект
		 */
		if (aRestrictedValues) {
			var oElement = $ ('<select />', {
				class: this.selectors.class_for_element
			});
			/*
			 	добавить все значения к селекту
			 */
			aRestrictedValues.map(function(sValue, i) {
				oElement.append(
					$ ('<option />', {
						value: sValue,
						html: ls.lang.get('plugin.admin.users.restricted_values')[sCurrentField][sValue]
					}).attr(
						'selected',
						sValue == sCurrentValue
					)
				);
			});

		} else {
			/*
			 	нужно поле ввода для значений
			 */
			var oElement = $ ('<input />', {
				class: this.selectors.class_for_element,
				type: 'text',
				value: sCurrentValue
			}).attr(
				'placeholder',
				ls.lang.get('plugin.admin.users.search')
			);
		}
		$ (this.selectors.search_query_wrapper).html(oElement);
	};


	/**
	 * Хендлер отправки формы поиска по пользователям
	 *
	 * @param oForm					объект формы
	 * @returns {boolean}
	 * @constructor
	 */
	this.SubmitFormHandler = function(oForm) {
		var oSearchQuery = $ (this.selectors.search_query);
		var sSearchValue = oSearchQuery.val();
		var oFieldName = $ (this.selectors.field_name);
		var sCurrentField = oFieldName.val();
		var aRulesForField = aAdminUsersSearchRules[sCurrentField];
		/*
		 	флаг, который указывает что для данного типа поиска разрешено не указывать поисковый запрос
		 */
		var bAllowEmptySearch = aRulesForField['allow_empty_search'];
		/*
		 	запретить поиск с пустым условием
		 */
		if ($.trim(sSearchValue) === '' && !bAllowEmptySearch) return false;
		$ (oForm).prepend(
			$ ('<input />', {
				type: 'hidden',
				name: 'filter[' + sCurrentField + ']',
				value: sSearchValue
			})
		);
		return true;
	};

	// ---

	return this;
	
}).call(ls.admin_users_search || {}, jQuery);

// ---

jQuery(document).ready(function($) {

	/*
		если есть правила для поиска по пользователям
	 */
	if (typeof(aAdminUsersSearchRules) == 'object') {
		/*
		 	добавление скрытого поля для поиска по пользователям (поле имеет имя filter[profile_name])
		 */
		$ (ls.admin_users_search.selectors.form_id).bind('submit.admin', function() {
			return ls.admin_users_search.SubmitFormHandler(this);
		});

		/*
		 	изменение типа элемента для ввода для разных типов данных
		 */
		$ (ls.admin_users_search.selectors.field_name).change(function() {
			ls.admin_users_search.ChangeFieldNameTrigger(this);
		});

		/*
		 	сразу выставить нужный тип поля если был поиск по нему
		 */
		ls.admin_users_search.ChangeFieldNameTrigger(ls.admin_users_search.selectors.field_name);
	}

});
