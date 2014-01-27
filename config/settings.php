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
 * --- Настройки ---
 *
 */

$config = array();

/*
 * Использовать ли аякс при отправке формы с настройками
 */
$config['settings']['admin_save_form_ajax_use'] = true;

/*
 * Нужно ли выводить ключи раздела настроек на странице настроек движка или плагина
 */
$config['settings']['show_section_keys'] = false;

return $config;

?>