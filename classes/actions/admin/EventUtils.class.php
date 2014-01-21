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
 * Разные утилиты
 *
 */

class PluginAdmin_ActionAdmin_EventUtils extends Event {

	/*
	 *
	 * --- Проверка и восстановление ---
	 *
	 */

	/**
	 * Показать список действий для утилит раздела проверки и восстановления
	 */
	public function EventCheckAndRepair() {
		$this->SetTemplateAction('utils/check_n_repair');

		/*
		 * если нужно выполнить действие
		 */
		if ($sActionType = $this->GetParam(1)) {
			$this->Security_ValidateSendForm();
			$this->ProcessCheckAndRepairAction($sActionType);
		}
	}


	/**
	 * Выполнить нужное действие для утилит раздела проверки и восстановления
	 *
	 * @param $sActionType	тип действия
	 * @return bool
	 */
	protected function ProcessCheckAndRepairAction($sActionType) {
		set_time_limit(0);
		switch ($sActionType) {
			case 'repaircomments':
				/*
				 * Очистить таблицу комментариев и все связанные с ней данные от поврежденных записей комментариев
				 */
				$this->PluginAdmin_Deletecontent_PerformRepairCommentsStructure();
				$this->Message_AddNotice($this->Lang('notices.utils.check_n_repair.tables.checking_comments_done'), '', true);
				break;
			case 'cleanstream':
				/*
				 * Очистка активности (стрима) от ссылок на записи, которых больше нет
				 */
				$this->PluginAdmin_Deletecontent_PerformCleanStreamEventsRecords();
				$this->Message_AddNotice($this->Lang('notices.utils.check_n_repair.tables.checking_stream_done'), '', true);
				break;
			case 'cleanvotings':
				/*
				 * Удалить все голосования, указывающие на несуществующие объекты
				 */
				$this->PluginAdmin_Deletecontent_CleanVotingsTableTargetingObjectsNotExists();
				$this->Message_AddNotice($this->Lang('notices.utils.check_n_repair.tables.checking_votings_done'), '', true);
				break;
			case 'cleanfavourites':
				/*
				 * Очистить записи избранного и тегов для избранного, указывающие на несуществующие объекты
				 */
				$this->PluginAdmin_Deletecontent_CleanFavouritesAndItsTagsTargetingObjectsNotExists();
				$this->Message_AddNotice($this->Lang('notices.utils.check_n_repair.tables.checking_favourites_done'), '', true);
				break;
			case 'checkencoding':
				/*
				 * Проверить корректность кодировки файлов
				 */
				if ($this->PluginAdmin_Tools_CheckFilesOfPluginsAndEngineHaveCorrectEncoding()) {
					$this->Message_AddNotice($this->Lang('notices.utils.check_n_repair.files.checking_encoding_done'), '', true);
				}
				break;
			default:
				$this->Message_AddError($this->Lang('errors.utils.unknown_check_n_repair_action'), $this->Lang_Get('error'), true);
		}
		$this->RedirectToReferer();
	}


	/*
	 *
	 * --- Сброс и очистка ---
	 *
	 */

	/**
	 * Показать список действий для утилит раздела сброса и очистки
	 */
	public function EventResetAndClear() {
		$this->SetTemplateAction('utils/reset_n_clear');

		/*
		 * если нужно выполнить действие
		 */
		if ($sActionType = $this->GetParam(1)) {
			$this->Security_ValidateSendForm();
			$this->ProcessResetAndClearAction($sActionType);
		}
	}


	/**
	 * Выполнить нужное действие для утилит раздела сброса и очистки
	 *
	 * @param $sActionType	тип действия
	 * @return bool
	 */
	protected function ProcessResetAndClearAction($sActionType) {
		set_time_limit(0);
		switch ($sActionType) {
			case 'resetallbansstats':
				/*
				 * Сбросить статистику срабатываний банов
				 */
				$this->PluginAdmin_Users_DeleteAllBansStats();
				$this->Message_AddNotice($this->Lang('notices.utils.reset_n_clear.datareset.bans_stats_cleared'), '', true);
				break;
			default:
				$this->Message_AddError($this->Lang('errors.utils.unknown_reset_n_clear_action'), $this->Lang_Get('error'), true);
		}
		$this->RedirectToReferer();
	}


}

?>