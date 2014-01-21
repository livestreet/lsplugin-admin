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
 *	Базовые настройки, которые не меняются через интерфейс
 */

/*
 * количество пользователей на страницу
 */
$config['user']['per_page'] = 10;

/*
 * количество голосов пользователя на страницу
 */
$config['votes']['per_page'] = 10;

/*
 * Использовать ли аякс при отправке формы с настройками
 */
$config['admin_save_form_ajax_use'] = true;

/*
 * данные для главной страницы админки
 */
$config['dashboard'] = array(
	/*
	 * лента последней активности на сайте
	 */
	'stream' => array(
		/*
		 * количество событий по-умолчанию
		 */
		'count_default' => 5
	)
);

/*
 * Минимальная разница между текущей датой и указанным в профиле днем рождения пользователя,
 * чтобы учитывать такую запись в показе статистики пользователей в графике возрастного распределения.
 * Считается что пользователь, которому исполнилось 7 (значение по-умолчанию) и больше лет - это верно указанная дата рождения в профиле пользователя.
 * Другие количества лет (меньше данного значения т.е. 0 - 6 лет или минусовые) не будут учитываться и будут отброшены как некорректные
 * в формировании графика возрастного распределения на странице статистики пользователей
 */
$config['min_years_diff_between_current_date_and_users_birthday_to_show_users_age_stats'] = 7;		// лет

/*
 * список значений количества элементов на страницу в выпадающем списке
 */
$config['values_for_select_elements_on_page'] = array(10, 30, 100);		// range(5, 100, 5)

/*
 * макс. количество точек на графике (фильтрует подписи по оси х)
 */
$config['max_points_on_graph'] = 10;

/*
 * максимальное количество элементов при показе статистики проживаний пользователей
 * все остальные элементы будут спрятаны в селект
 */
$config['max_items_in_living_users_stats'] = 20;

/*
 * id пользователей, которых нельзя удалять из сайта
 * значение по-умолчанию - 1 (это автоматически создаваемый при установке движка пользователь "admin")
 */
$config['block_deleting_user_ids'] = array(1);

/*
 * id пользователей, у которых нельзя удалять/добавлять права администратора
 * значение по-умолчанию - 1 (это автоматически создаваемый при установке движка пользователь "admin")
 */
$config['block_managing_admin_rights_user_ids'] = array(1);

/*
 * роутер
 */
$config['$root$']['router']['page']['admin'] = 'PluginAdmin_ActionAdmin';
$config['$root$']['router']['page']['tickets'] = 'PluginAdmin_ActionTickets';

/*
 * таблицы
 */
$config['$root$']['db']['table']['users_ban'] = '___db.table.prefix___admin_users_ban';

return $config;

?>