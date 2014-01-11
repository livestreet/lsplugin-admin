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
 * Расширение возможностей модуля для гео-локации
 *
 */

class PluginAdmin_ModuleGeo_MapperGeo extends PluginAdmin_Inherits_ModuleGeo_MapperGeo {


	/**
	 * Получить страны по массиву переданных имен
	 *
	 * @param $aFilter		фильтр
	 * @return mixed
	 */
	public function GetCountriesByArrayFilter($aFilter) {
		$sSql = 'SELECT *
			FROM
				?#
			WHERE
				1 = 1
				{ AND id IN (?a) }
				{ AND name_ru IN (?a) }
				{ AND name_en IN (?a) }
				{ AND code IN (?a) }
			ORDER BY
				FIELD
				(
					{id, ?a}
					{name_ru, ?a}
					{name_en, ?a}
					{code, ?a}
				)
			LIMIT
				?d, ?d
		';
		if ($aData = $this->oDb->select($sSql,
			Config::Get('db.table.geo_country'),
			/*
			 * поле для поиска
			 */
			isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
			isset($aFilter['name_ru']) ? $aFilter['name_ru'] : DBSIMPLE_SKIP,
			isset($aFilter['name_en']) ? $aFilter['name_en'] : DBSIMPLE_SKIP,
			isset($aFilter['code']) ? $aFilter['code'] : DBSIMPLE_SKIP,
			/*
			 * сортировка по значениям поля поиска
			 */
			isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
			isset($aFilter['name_ru']) ? $aFilter['name_ru'] : DBSIMPLE_SKIP,
			isset($aFilter['name_en']) ? $aFilter['name_en'] : DBSIMPLE_SKIP,
			isset($aFilter['code']) ? $aFilter['code'] : DBSIMPLE_SKIP,
			/*
			 * страница
			 */
			($aFilter['page'] - 1) * $aFilter['per_page'],
			$aFilter['per_page']
		)) {
			return Engine::getInstance()->PluginAdmin_Tools_GetArrayOfEntitiesByAssocArray($aData, 'ModuleGeo_EntityCountry');
		}
		return array();
	}


	/**
	 * Получить города по массиву переданных имен
	 *
	 * @param $aFilter		фильтр
	 * @return mixed
	 */
	public function GetCitiesByArrayFilter($aFilter) {
		$sSql = 'SELECT *
			FROM
				?#
			WHERE
				1 = 1
				{ AND id IN (?a) }
				{ AND name_ru IN (?a) }
				{ AND name_en IN (?a) }
				{ AND country_id IN (?a) }
				{ AND region_id IN (?a) }
			ORDER BY
				FIELD
				(
					{id, ?a}
					{name_ru, ?a}
					{name_en, ?a}
					{country_id, ?a}
					{region_id, ?a}
				)
			LIMIT
				?d, ?d
		';
		if ($aData = $this->oDb->select($sSql,
			Config::Get('db.table.geo_city'),
			/*
			 * поле для поиска
			 */
			isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
			isset($aFilter['name_ru']) ? $aFilter['name_ru'] : DBSIMPLE_SKIP,
			isset($aFilter['name_en']) ? $aFilter['name_en'] : DBSIMPLE_SKIP,
			isset($aFilter['country_id']) ? $aFilter['country_id'] : DBSIMPLE_SKIP,
			isset($aFilter['region_id']) ? $aFilter['region_id'] : DBSIMPLE_SKIP,
			/*
			 * сортировка по значениям поля поиска
			 */
			isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
			isset($aFilter['name_ru']) ? $aFilter['name_ru'] : DBSIMPLE_SKIP,
			isset($aFilter['name_en']) ? $aFilter['name_en'] : DBSIMPLE_SKIP,
			isset($aFilter['country_id']) ? $aFilter['country_id'] : DBSIMPLE_SKIP,
			isset($aFilter['region_id']) ? $aFilter['region_id'] : DBSIMPLE_SKIP,
			/*
			 * страница
			 */
			($aFilter['page'] - 1) * $aFilter['per_page'],
			$aFilter['per_page']
		)) {
			return Engine::getInstance()->PluginAdmin_Tools_GetArrayOfEntitiesByAssocArray($aData, 'ModuleGeo_EntityCity');
		}
		return array();
	}


}

?>