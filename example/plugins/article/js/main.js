var ls = ls || {};
ls.plugin = ls.plugin || {};

ls.plugin.article =( function ($) {

	this.initTagsSearch = function() {
		/**
		 * Поиск по тегам
		 */
		$('.js-article-tag-search-form').submit(function(){
			var val=$(this).find('.js-tag-search').val();
			if (val) {
				window.location = aRouter['article']+'tag/'+encodeURIComponent(val)+'/';
			}
			return false;
		});
	};

	$(function(){
		this.initTagsSearch();
	}.bind(this));

	return this;
}).call(ls.plugin.article || {},jQuery);