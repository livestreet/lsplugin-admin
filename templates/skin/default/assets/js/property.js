var ls = ls || {};
ls.admin_property =( function ($) {

	this.clickSelectItemNew = function() {
		var $aItems=$('.js-property-select-item');
		if ($aItems.length) {
			var $aItemNew=$($aItems[0]).clone();
			$aItemNew.find('.js-property-select-item-value').val('');
			$aItemNew.find('.js-property-select-item-sort').val('10');
			$aItemNew.find('.js-property-select-item-id').val('');
			$('#property-select-items').append($aItemNew);
		}
		return false;
	};

	this.clickSelectItemRemove = function(obj) {
		obj=$(obj);
		if ($('.js-property-select-item').length<2) {
			return false;
		}
		obj.parent().fadeOut(function(){
			$(this).remove();
		});
		return false;
	};

	return this;
}).call(ls.admin_property || {},jQuery);