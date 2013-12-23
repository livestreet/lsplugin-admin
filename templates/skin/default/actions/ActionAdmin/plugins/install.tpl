{**
 * Инструкция по установке плагина
 *}

{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_page_title'}
	{$aLang.plugin.admin.plugins.install.title}
{/block}


{block name='layout_content_actionbar'}
	<div class="fl-r">
		<a class="button active" href="https://catalog.livestreetcms.com/addon/?order=update">Все</a>
		<a class="button " href="https://catalog.livestreetcms.com/addon/?order=update&amp;type=2">Платные</a>
		<a class="button " href="https://catalog.livestreetcms.com/addon/?order=update&amp;type=1">Бесплатные</a>

		&nbsp;&nbsp;&nbsp;

		<select onchange="ls.main.changeAddonFilterOrder(jQuery(this).val());">
			<option value="https://catalog.livestreetcms.com/addon/?order=new">Новые сверху</option>
			<option value="https://catalog.livestreetcms.com/addon/?order=review">По отзывам</option>
			<option value="https://catalog.livestreetcms.com/addon/?order=update" selected="selected">По дате обновления</option>
			<option value="https://catalog.livestreetcms.com/addon/?order=download">По количеству загрузок</option>
			<option value="https://catalog.livestreetcms.com/addon/?order=buy">По количеству покупок</option>
			<option value="https://catalog.livestreetcms.com/addon/?order=price">По цене</option>
		</select>
	</div>

	<a class="button" href="{router page='admin/plugins/list'}">&larr; {$aLang.plugin.admin.plugins.install.go_to_list}</a>
{/block}


{block name='layout_content'}
	<a href="#" class="fl-r js-catalog-toggle-tip-button" title="{$aLang.plugin.admin.plugins.install.tip_button}"><i class="icon-question-sign"></i></a>
	<div class="info js-catalog-tip-message" style="display: none;">
		{$aLang.plugin.admin.plugins.install.tip}
	</div>



{/block}