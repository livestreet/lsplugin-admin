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
 * --- Пользователи ---
 *
 */

$config = array();

/*
 * количество пользователей на страницу
 */
$config['users']['per_page'] = 10;

/*
 * Разрешенные имена полей для поиска по пользователям
 *
 * Параметры:
 *
 * "search_as_part_of_string"	разрешает искать по данному полю как по части строки запроса
 * 								(при изменении необходимы правки в маппере модуля юзеров плагина - изменить присваивание на LIKE)
 * "restricted_values"			список всех возможных значений для этого поля (текстовки задаются в языковом файле в массиве plugin.admin.users.restricted_values),
 * 								которые будут показаны в селекте, если не указано - будет простой инпут
 * "allow_empty_search"			разрешить ли поиск с пустым значением для этого поля (по-умолчанию запрещено)
 */
$config['users']['search_allowed_types'] = array(
    'id'              => array('search_as_part_of_string' => false),
    'mail'            => array('search_as_part_of_string' => true),
    'password'        => array('search_as_part_of_string' => false),
    'ip_register'     => array('search_as_part_of_string' => true),
    'activate'        => array('search_as_part_of_string' => false, 'restricted_values' => array('1', '0')),
    'activate_key'    => array('search_as_part_of_string' => false),
    'profile_sex'     => array(
        'search_as_part_of_string' => false,
        'restricted_values'        => array('man', 'woman', 'other')
    ),
    'login'           => array('search_as_part_of_string' => true),
    'profile_name'    => array('search_as_part_of_string' => true, 'allow_empty_search' => true),
    'session_ip_last' => array('search_as_part_of_string' => true),
);

/*
 *
 * --- Сортировка ---
 *
 */

/*
 * Корректные значения (поля) для сортировок пользователей
 */
$config['users']['correct_sorting_order'] = array(
    'u.user_id',
    'u.user_login',
    'u.user_mail',
    'u.user_date_register',
    'u.user_ip_register',
    'u.user_rating',
    'u.user_profile_name',
    'u.user_profile_birthday',
    's.session_ip_create',
    's.session_ip_last',
    's.session_date_create',
    's.session_date_last',
);

/*
 * Сортировка пользователей по-умолчанию (если указанная сортировка некорректна или не разрешена)
 */
$config['users']['default_sorting_order'] = 'u.user_id';

/*
 *
 * --- Статистика ---
 *
 */

/*
 * Минимальный корректный возраст пользователя (минимальная разница между текущей датой и указанным в профиле днем рождения пользователя),
 * чтобы учитывать такую запись в показе статистики пользователей в графике возрастного распределения.
 *
 * Считается что пользователь, которому исполнилось 7 (значение по-умолчанию) и больше лет - это верно указанная дата рождения в профиле пользователя.
 * Другие количества лет (меньше данного значения т.е. 0 - 6 лет или минусовые) не будут учитываться и будут отброшены как некорректные
 * в формировании графика возрастного распределения на странице статистики пользователей
 */
$config['users']['min_user_age_difference_to_show_users_age_stats'] = 7;        // лет

/*
 * максимальное количество элементов при показе статистики проживаний пользователей
 * все остальные элементы будут спрятаны в селект
 */
$config['users']['max_items_in_living_users_stats'] = 20;

/*
 *
 * --- Управление пользователями ---
 *
 */

/*
 * id пользователей, которых нельзя удалять из сайта
 * значение по-умолчанию - 1 (это автоматически создаваемый при установке движка пользователь "admin")
 */
$config['users']['block_deleting_user_ids'] = array(1);

/*
 * id пользователей, у которых нельзя удалять/добавлять права администратора
 * значение по-умолчанию - 1 (это автоматически создаваемый при установке движка пользователь "admin")
 */
$config['users']['block_managing_admin_rights_user_ids'] = array(1);

/*
 *
 * --- Жалобы на пользователей ---
 *
 */

/*
 * количество на страницу
 */
$config['users']['complaints']['per_page'] = 20;

/*
 * Корректные значения (поля) для сортировок жалоб на пользователей
 */
$config['users']['complaints']['correct_sorting_order'] = array(
    'c.id',
    'c.target_user_id',
    'c.user_id',
    'c.type',
    'c.date_add',
    'c.state',
);

/*
 * Сортировка жалоб на пользователей по-умолчанию (если указанная сортировка некорректна или не разрешена)
 */
$config['users']['complaints']['default_sorting_order'] = 'c.date_add';

return $config;

?>