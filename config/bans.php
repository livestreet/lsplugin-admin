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
 * --- Баны ---
 *
 */

$config = array();

/*
 * Количество банов на страницу
 */
$config['bans']['per_page'] = 10;

/*
 * Собирать статистку по срабатываниям банов
 */
$config['bans']['gather_bans_running_stats'] = true;

/*
 * Список методов из модуля ACL для которых не нужно подсчитывать количество срабатываний бана типа "только чтение"
 * (может уменьшить нагрузку)
 */
$config['bans']['acl_exclude_methods_from_gather_stats'] = array(
    /*
     * эти методы по нескольку раз запускаются на странице для вывода ссылок "редактировать" и "удалить" для каждого топика
     */
    'IsAllowEditTopic',
    'IsAllowDeleteTopic',
);

/*
 * id пользователей, которых нельзя банить
 * значение по-умолчанию - 1 (это автоматически создаваемый при установке движка пользователь "admin")
 */
$config['bans']['block_ban_user_ids'] = array(1);

/*
 *
 * --- Сортировка ---
 *
 */

/*
 * Корректные значения (поля) для сортировки банов
 */
$config['bans']['correct_sorting_order'] = array(
    'restriction_type',
    'block_type',
    'user_id',
    'ip',
    'ip_start',
    'ip_finish',
    'time_type',
    'date_start',
    'date_finish',
    'add_date',
    'edit_date',
    'reason_for_user',
    'comment'
);

/*
 * Сортировка для вывода банов по-умолчанию
 */
$config['bans']['default_sorting_order'] = 'edit_date';

return $config;

?>