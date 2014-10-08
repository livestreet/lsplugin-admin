<?php
/**
 * Таблица БД
 */
$config['$root$']['db']['table']['article_main_article'] = '___db.table.prefix___article';
/**
 * Роутинг
 */
$config['$root$']['router']['page']['article'] = 'PluginArticle_ActionArticle';
/**
 * Тип для дополнительных полей
 */
$config['property_target_type'] = 'article';
/**
 * Код дополнительного поля для тегов статьи
 */
$config['property_tags_code'] = 'tags';

/**
 * Количество статей на одну страницу
 */
$config['per_page'] = 10;
/**
 * Произвольный строковый параметр 1
 */
$config['param_string_1'] = 'Социальные сети';
/**
 * Произвольный строковый параметр 2
 */
$config['param_string_2'] = 'LiveStreet CMS';

return $config;