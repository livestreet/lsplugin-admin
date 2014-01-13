/**
 * Дополнительные поля
 * 
 * @module ls/plugin/admin/property
 * 
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 */

var ls = ls || {};

ls.admin_property = ( function ($) {

	this.clickSelectItemNew = function() {
		var $aItems = $('.js-property-select-item');

		if ($aItems.length) {
			var $aItemNew = $($aItems[0]).clone();
			$aItemNew.find('.js-property-select-item-value').val('');
			$aItemNew.find('.js-property-select-item-sort').val('10');
			$aItemNew.find('.js-property-select-item-id').val('');
			$('#property-select-items').append($aItemNew);
		}

		return false;
	};

	this.clickSelectItemRemove = function(obj) {
		obj = $(obj);

		if ($('.js-property-select-item').length < 2) return false;

		obj.parent().fadeOut(function(){
			$(this).remove();
		});

		return false;
	};

	this.initTableProperty = function() {
		var fixHelper = function(e, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
			});
			return ui;
		};

		$('#property-list tbody').sortable({
			helper: fixHelper,
			stop: this.stopTableTypeSort
		}).disableSelection();
	};

	this.stopTableTypeSort = function(e,ui) {
		var items=$('#property-list tbody tr');
		var data=[];
		items.each(function(k,v){
			data.push({ id: $(v).data('id'), sort: items.length-k });
		});
		console.log(data);
		if (data.length) {
			ls.ajax.load(aRouter.admin+'ajax/properties/sort-save/', { data: data }, function(result) {
				if (result.bStateError) {
					ls.msg.error(null, result.sMsg);
				} else {
					ls.msg.notice(null, result.sMsg);
				}
			});
		}
	};

	return this;
}).call(ls.admin_property || {},jQuery);