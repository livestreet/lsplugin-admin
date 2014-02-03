var ls = ls || {};
ls.plugin = ls.plugin || {};
ls.plugin.article = ls.plugin.article || {};

ls.plugin.article.admin =( function ($) {

	this.ajaxSubmitSimple = function(url,form) {
		form='#'+form;
		ls.ajax.submit(url,form,function(res){
			if (res.sUrlRedirect) {
				window.location.href=res.sUrlRedirect;
			}
			if (res.bReloadPage) {
				window.location.reload();
			}
		}.bind(this),{ validate: false });
	};

	this.createArticle = function(form) {
		this.ajaxSubmitSimple(ls.registry.get('sAdminUrl')+'ajax/article-create/',form);
	};

	this.updateArticle = function(form) {
		this.ajaxSubmitSimple(ls.registry.get('sAdminUrl')+'ajax/article-update/',form);
	};

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