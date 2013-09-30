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

class PluginAdmin_ModuleStats_MapperStats extends Mapper {


	/**
	 * Возвращает прирост пользователей за последний день (на сколько больше зарегистрировалось сегодня чем вчера)
	 *
	 * @return int
	 */
	public function TodaysUserGrowth() {
		$sql = "SELECT
			(
				SELECT COUNT(*) as now_items
				FROM
					`" . Config::Get('db.table.user') . "`
				WHERE
					`user_activate` = 1
					AND
					`user_date_register` BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL 1 DAY
			) - (
				SELECT COUNT(*) as prev_items
				FROM
					`" . Config::Get('db.table.user') . "`
				WHERE
					`user_activate` = 1
					AND
					`user_date_register` BETWEEN CURRENT_DATE - INTERVAL 1 DAY AND CURRENT_DATE
			) as items_growth
		";
		return (int) $this->oDb->selectCell($sql);
	}


	public function TodaysTopicGrowth() {
		$sql = "SELECT
			(
				SELECT COUNT(*) as now_items
				FROM
					`" . Config::Get('db.table.topic') . "`
				WHERE
					`topic_publish` = 1
					AND
					`topic_date_add` BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL 1 DAY
			) - (
				SELECT COUNT(*) as prev_items
				FROM
					`" . Config::Get('db.table.topic') . "`
				WHERE
					`topic_publish` = 1
					AND
					`topic_date_add` BETWEEN CURRENT_DATE - INTERVAL 1 DAY AND CURRENT_DATE
			) as items_growth
		";
		return (int) $this->oDb->selectCell($sql);
	}


	public function TodaysCommentGrowth() {
		$sql = "SELECT
			(
				SELECT COUNT(*) as now_items
				FROM
					`" . Config::Get('db.table.comment') . "`
				WHERE
					`comment_publish` = 1
					AND
					`comment_date` BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL 1 DAY
			) - (
				SELECT COUNT(*) as prev_items
				FROM
					`" . Config::Get('db.table.comment') . "`
				WHERE
					`comment_publish` = 1
					AND
					`comment_date` BETWEEN CURRENT_DATE - INTERVAL 1 DAY AND CURRENT_DATE
			) as items_growth
		";
		return (int) $this->oDb->selectCell($sql);
	}


	public function TodaysBlogGrowth() {
		$sql = "SELECT
			(
				SELECT COUNT(*) as now_items
				FROM
					`" . Config::Get('db.table.blog') . "`
				WHERE
					`blog_date_add` BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL 1 DAY
			) - (
				SELECT COUNT(*) as prev_items
				FROM
					`" . Config::Get('db.table.blog') . "`
				WHERE
					`blog_date_add` BETWEEN CURRENT_DATE - INTERVAL 1 DAY AND CURRENT_DATE
			) as items_growth
		";
		return (int) $this->oDb->selectCell($sql);
	}


}

?>