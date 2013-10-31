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

class PluginAdmin_ModuleDeletecontent_MapperDeletecontent extends Mapper {

	/**
	 * Удаление данных из БД по фильтру
	 *
	 * @param $aFilter		фильтр
	 * @return array|null
	 */
	public function DeleteUserContentByFilter($aFilter) {
		$sWhere = $this->BuildWhereQuery($aFilter[PluginAdmin_ModuleDeletecontent::FILTER_CONDITIONS]);
		$sSql = 'DELETE
			FROM
				`' . $aFilter[PluginAdmin_ModuleDeletecontent::FILTER_TABLE] . '`
			WHERE
				' . $sWhere . '
		';
		/*
		 * если тип таблиц ИнноДБ - отключить проверку внешних связей
		 */
		if (Config::Get('db.tables.engine') == 'InnoDB') {
			$sSql = $this->DisableForeignKeysChecking($sSql);
		}
		return $this->oDb->query($sSql);
	}


	/*
	 * todo: использовать данный метод и в модуле статистики (и удалить оттуда ручное экранирование значений)
	 * т.е. заменить данным методом аналогичный там и удалить один лишний
	 *
	 * + можно вообще вынести его в общий какой-то модуль чтобы не дублировать
	 */
	/**
	 * Построить условие WHERE sql-запроса
	 *
	 * @param $aConditions		массив условий
	 * @return string			часть sql-строки
	 */
	protected function BuildWhereQuery($aConditions) {
		$sSql = '1 = 1';
		foreach($aConditions as $sField => $mValue) {
			/*
			 * экранировать поле таблицы как идентификатор и значение в зависимости от типа
			 */
			$sSql .= ' AND ' . $this->oDb->escape($sField, true) . ' = ' . $this->oDb->escape($mValue);
		}
		return $sSql;
	}


	/**
	 * Отключает проверку внешних ключей для InnoDB добавляя к запросу ещё один перед основным
	 * Данное отключение действует строго на транзакцию т.е. после запроса к следующему запросу они будут включены по-умолчанию,
	 * поэтому нет надобности их включать
	 *
	 * @param $sSql		запрос к бд
	 * @return string	запрос к бд с добавленным впереди него отключением проверки связей
	 */
	protected function DisableForeignKeysChecking($sSql) {
		return 'SET foreign_key_checks = 0; ' . $sSql;
	}

}

?>