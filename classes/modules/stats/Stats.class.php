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
 * Модуль для расчета статистики
 */

class PluginAdmin_ModuleStats extends Module {

	public function Init() {}

	/**
	 * Получить реальный временной интервал в зависимости от типа периода для статистики
	 *
	 * @param $sPeriod		тип периода
	 * @return array		array('from' => '...', 'to' => '...', 'format' => '...', 'interval' => '...')
	 */
	public function GetStatsGraphPeriod($sPeriod = null) {
		switch($sPeriod) {
			/*
			 * вчера
			 */
			case 'yesterday':
				$iTime = mktime(date('H'), date('i'), date('s'), date('n'), date('j') - 1, date('Y'));
				return array(
					'from' => date('Y-m-d 00:00:00', $iTime),
					'to' => date('Y-m-d 23:59:59', $iTime),
					/*
					 * Для одноденных периодов нужны интервалы по пол часа, поэтому в формате указаны часы и минуты.
					 * Убираем ненужные данные (полный 'Y-m-d H:i:00') чтобы подписи влезли, все равно имеем дело с известным интервалом
					 */
					'format' => 'H:i',
					/*
					 * интервал для периода 30 мин
					 */
					'interval' => 60*30
				);
				break;
			/*
			 * сегодня
			 */
			case 'today':
				return array(
					'from' => date('Y-m-d 00:00:00'),
					'to' => date('Y-m-d 23:59:59'),
					/*
					 * Для одноденных периодов нужны интервалы по пол часа, поэтому в формате указаны часы и минуты.
					 * Убираем ненужные данные (полный 'Y-m-d H:i:00') чтобы подписи влезли, все равно имеем дело с известным интервалом
					 */
					'format' => 'H:i',
					/*
					 * интервал для периода 30 мин
					 */
					'interval' => 60*30
				);
				break;
			/*
			 * неделя
			 */
			case 'week':
				return array(
					/*
					 * полных 7 дней назад (не включая текущий)
					 */
					'from' => date('Y-m-d', mktime(date('H'), date('i'), date('s'), date('n'), date('j') - 7, date('Y'))),
					'to' => date('Y-m-d 23:59:59', mktime(date('H'), date('i'), date('s'), date('n'), date('j') - 1, date('Y'))),
					/*
					 * Для больших периодов интервал 1 день, поэтому часы и меньшие значения не указаны в формате.
					 * Убираем ненужные данные (полный 'Y-m-d') чтобы подписи влезли, все равно имеем дело с известным интервалом
					 */
					'format' => 'm-d',
					/*
					 * интервал для периода 1 день
					 */
					'interval' => 60*60*24
				);
				break;
			/*
			 * месяц
			 */
			case 'month':
				/*
				 * используется период по-умолчанию
				 */
				//break;
			/*
			 * период по-умолчанию
			 */
			default:
				return array(
					'from' => date('Y-m-d', mktime(date('H'), date('i'), date('s'), date('n') - 1, date('j'), date('Y'))),
					'to' => date('Y-m-d 23:59:59', mktime(date('H'), date('i'), date('s'), date('n'), date('j') - 1, date('Y'))),
					/*
					 * Для больших периодов интервал 1 день, поэтому часы и меньшие значения не указаны в формате.
					 * Убираем ненужные данные (полный 'Y-m-d') чтобы подписи влезли, все равно имеем дело с известным интервалом
					 */
					'format' => 'm-d',
					/*
					 * интервал для периода 1 день
					 */
					'interval' => 60*60*24
				);
				break;
		}
	}


	/**
	 * Заполнить пустыми значениями период дат с нужным для каждого периода интервалом
	 *
	 * @param $aPeriod			период дат (от и до) и другие данные
	 * @return array			массив с нулевыми значениями на каждый промежуток интервала в периоде дат
	 */
	public function FillDatesRangeForPeriod($aPeriod) {
		/*
		 * интервал прохода по датам
		 */
		$iInterval = $aPeriod['interval'];
		/*
		 * дата начала и счетчик
		 */
		$iCurrentTime = strtotime($aPeriod['from']);
		/*
		 * дата финиша
		 */
		$iFinishTime = strtotime($aPeriod['to']);
		/*
		 * здесь хранятся даты и количество
		 */
		$aData = array();
		/*
		 * заполнить пустыми значениями интервалы в периоде
		 */
		do {
			/*
			 * добавить запись про текущую дату
			 */
			$aData[] = array(
				/*
				 * формат даты берется из периода, где был задан её формат связанный с интервалом
				 */
				'date' => date($aPeriod['format'], $iCurrentTime),
				'count' => 0
			);
			/*
			 * увеличить интервал
			 */
			$iCurrentTime += $iInterval;
		} while ($iCurrentTime <= $iFinishTime);
		return $aData;
	}


	/**
	 * Заполнить реальными данными из запроса период
	 *
	 * @param $aFilledWithZerosPeriods		"пустые" данные периода для каждой даты
	 * @param $aDataStats					полученные данные для дат
	 * @return array						объедененный массив данных
	 */
	public function MixEmptyPeriodsWithData($aFilledWithZerosPeriods, $aDataStats) {
		if (!is_array($aFilledWithZerosPeriods) or !is_array($aDataStats)) return array();
		foreach($aFilledWithZerosPeriods as &$aFilledPeriod) {
			foreach($aDataStats as $aData) {
				/*
				 * если есть реальные данные для этой даты
				 */
				if ($aFilledPeriod['date'] == $aData['date']) {
					$aFilledPeriod['count'] = $aData['count'];
				}
			}
		}
		return $aFilledWithZerosPeriods;
	}


	/**
	 * Получить данные периода при ручном выборе дат
	 *
	 * @param $sDateStart		дата начала
	 * @param $sDateFinish		дата финиша
	 * @return array
	 */
	public function SetupCustomPeriod($sDateStart, $sDateFinish) {
		$aPeriod = $this->GetStatsGraphPeriod();
		$aPeriod['from'] = $sDateStart;
		$aPeriod['to'] = $sDateFinish;
		return $aPeriod;
	}


	/**
	 * Отконвертировать описание форматирования даты из php в mysql
	 *
	 * @param $sFormat		строка форматирования как в php ("Y-m-d")
	 * @return mixed		строка для мускула ("%Y-%m-%d")
	 */
	public function BuildDateFormatFromPHPToMySQL($sFormat) {
		/*
		 * не использовать литерал \w т.к. он содержит цифры, а их экранировать не нужно!
		 */
		$sFormat = preg_replace('#([a-z])#iu', '%$1', $sFormat);
		/*
		 * хак: если формат даты содежит часы и минуты,
		 * то чтобы не округлять даты в бд к получасам (ведь действие может быть и в 55 минут) - ставим минуты в 30 как среднее
		 * и привязываем действие только к часу (т.е. каждое действие будет в Х часов 30 минут для однодневных интервалов)
		 */
		return str_replace('%i', '30', $sFormat);
	}

}

?>