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
 * количество банов на страницу
 */
$config['bans']['per_page'] = 10;

/*
 * Использовать ли аякс при отправке формы с настройками
 */
$config['admin_save_form_ajax_use'] = true;

/*
 * Автоматически удалять старые записи банов если дата окончания бана уже прошла
 */
$config['auto_delete_old_ban_records'] = true;

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