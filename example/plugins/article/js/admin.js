var ls = ls || {};
ls.plugin = ls.plugin || {};
ls.plugin.article = ls.plugin.article || {};

ls.plugin.article.admin =( function ($) {

	this.removeArticle = function(id) {
		ls.ajax.load(ls.registry.get('sAdminUrl')+'ajax/article-remove/',{ id: id },function(res){
			if (res.bStateError) {
				ls.msg.error(null, res.sMsg);
			} else {
				if (res.sMsg) {
					ls.msg.notice(null, res.sMsg);
				}
				$('#article-item-'+id).remove();
			}
			if (res.sUrlRedirect) {
				window.location.href=res.sUrlRedirect;
			}
			if (res.bReloadPage) {
				window.location.reload();
			}
		}.bind(this));
	};

	return this;
}).call(ls.plugin.article.admin || {},jQuery);

jQuery(function($){
	// Иниц-ия формы создания статьи
	$('#form-article-create').lsContent({
		urls: {
			add: ls.registry.get('sAdminUrl')+'ajax/article-create/',
			edit: ls.registry.get('sAdminUrl')+'ajax/article-update/'
		}
	});
});