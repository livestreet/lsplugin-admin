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
	Сохранение настроек плагинов и движка через аякс
 */

var ls = ls || {};

ls.admin_settings_save = (function($) {

	/*
		Классы тегов
	 */
	this.styleClass = {
		Error: 'parsley-error',
		ErrorMsgContainer: 'parsley-errors-list filled'
	};


	/*
	 	Селекторы
	 */
	this.selectors = {
		FormId: '#admin_settings_save',
		SubmitButtonId: '#admin_settings_submit',
		OneParameterContainer: '.js-settings-field',
		OneParameterErrorWrapper: '.' + this.styleClass.ErrorMsgContainer
	};


	/**
	 * Показать ошибки для каждого поля на форме (под самим полем) и выделить такие поля вызуально
	 *
	 * @param aParamErrors	массив соответствий ключей и их ошибок
	 * @constructor
	 */
	this.ShowErrors = function(aParamErrors) {
		var oThat = this;
		$ (aParamErrors).each(function(i, o) {
			var oWrapper = oThat.GetOneParameterContainer(o.key);
			oWrapper.addClass(oThat.styleClass.Error);
			oWrapper.append(
				$ ('<div />', {
					class: oThat.styleClass.ErrorMsgContainer,
					html: o.msg
				})
			);
		});
		/*
			прокрутить страницу к полю с первой ошибкой
		 */
		this.ScrollToContainer(this.GetOneParameterContainer(aParamErrors[0].key));
	};


	/**
	 * Прокрутка страницы к нужному её элементу так, чтобы он оказался в центре страницы
	 *
	 * @param oContainer	элемент
	 * @constructor
	 */
	this.ScrollToContainer = function(oContainer) {
		var iOffset = - parseInt(($ (window).height() - $ (oContainer).height()) / 2);
		iOffset = iOffset ? iOffset : -230;

		var iTargetOffset = $(oContainer).offset().top + iOffset;
		$ ('html, body').animate({
			'scrollTop': iTargetOffset
		}, 500);
	};


	/**
	 * Убрать все сообщения об ошибках для каждого поля на странице
	 *
	 * @constructor
	 */
	this.RemoveAllErrorMessages = function() {
		$ (this.selectors.FormId + ' ' + this.selectors.OneParameterContainer).removeClass(this.styleClass.Error);
		$ (this.selectors.FormId + ' ' + this.selectors.OneParameterErrorWrapper).remove();
	};


	/**
	 * Получить блок настроек поля по его ключу
	 *
	 * @param sKey			ключ поля (конфига)
	 * @returns {*|jQuery}	элемент div
	 * @constructor
	 */
	this.GetOneParameterContainer = function(sKey) {
		/*
			получить родительский див скрытого поля (type="hidden") со значением ключа
		 */
		return $ (this.selectors.FormId + ' input[value="' + sKey + '"]').closest(this.selectors.OneParameterContainer);
	};
	
	// ---

	return this;
	
}).call(ls.admin_settings_save || {}, jQuery);

// ---

jQuery(document).ready(function($) {

	/*
		нужно ли использовать аякс для сохранения настроек
	 */
	if (ls.registry.get('settings.admin_save_form_ajax_use')) {

		/*
			установить слушатель сабмита формы для обработки её через аякс
		 */
		$ (ls.admin_settings_save.selectors.FormId).ajaxForm({
			dataType: 'json',
			beforeSend: function() {
				ls.admin_settings_save.RemoveAllErrorMessages();
				/*
					визуальное оформление
				 */
				$ (ls.admin_settings_save.selectors.FormId).addClass('loading');
				$ (ls.admin_settings_save.selectors.SubmitButtonId).attr('disabled', 'disabled');
			},
			success: function(data) {
				/*
					если системная ошибка
				 */
				if (data.bStateError) {
					ls.msg.error(data.sMsgTitle, data.sMsg);
				} else {
					/*
						если есть ошибки значений в полях (валидация по правилам схемы)
					 */
					if (data.aParamErrors && data.aParamErrors.length > 0) {
						ls.admin_settings_save.ShowErrors(data.aParamErrors);
						ls.msg.error('', ls.lang.get('plugin.admin.errors.some_fields_are_incorrect'));
						return ;
					}
					ls.msg.notice(data.sMsgTitle, data.sMsg);
				}
			},
			complete: function(xhr) {
				/*
				 	визуальное оформление
				 */
				$ (ls.admin_settings_save.selectors.FormId).removeClass('loading');
				$ (ls.admin_settings_save.selectors.SubmitButtonId).removeAttr('disabled');
			}
		});
		
	}

});
