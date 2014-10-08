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
 * --- Голоса ---
 *
 */

$config = array();

/*
 * количество голосов пользователя на страницу
 */
$config['votes']['per_page'] = 10;

/*
 *
 * --- Сортировка ---
 *
 */

/*
 * Корректные значения (поля) для сортировки голосов пользователя
 */
$config['votes']['correct_sorting_order'] = array(
    'target_id',
    'target_type',
    'vote_direction',
    'vote_value',
    'vote_date',
    'vote_ip'
);

/*
 * Сортировка для вывода голосов по-умолчанию
 */
$config['votes']['default_sorting_order'] = 'vote_date';

return $config;

?>