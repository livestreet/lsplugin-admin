<?php
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
 *
 * --- Базовые настройки ---
 *
 */

$config = array();

/*
 * количество событий по-умолчанию для ленты последней активности главной страницы админки
 */
$config['dashboard']['stream']['count_default'] = 5;

/*
 * список значений количества элементов на страницу в выпадающем списке
 */
$config['pagination']['values_for_select_elements_on_page'] = array(10, 30, 100);        // range(5, 100, 5)

/*
 * макс. количество точек на графике (фильтрует подписи по оси х)
 */
$config['stats']['max_points_on_graph'] = 10;

/*
 * роутер
 */
$config['$root$']['router']['page']['admin'] = 'PluginAdmin_ActionAdmin';

/*
 * таблицы
 */
$config['$root$']['db']['table']['users_ban'] = '___db.table.prefix___admin_users_ban';

return $config;

?>