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
 *	Разные утилиты
 */

class PluginAdmin_ActionAdmin_EventUtils extends Event {

	/*
	 *
	 * --- Проверка таблиц ---
	 *
	 */

	/**
	 * Показать список действий очистки таблиц от поврежденных связей
	 *
	 * @return mixed
	 */
	public function EventCheckTables() {
		$this->SetTemplateAction('utils/tables');

		/*
		 * если нужно выполнить действие
		 */
		if ($sActionType = $this->GetParam(1)) {
			$this->Security_ValidateSendForm();
			$this->ProcessTablesAction($sActionType);
		}
	}


	/**
	 * Выполнить нужное действие очистки с таблицами
	 *
	 * @param $sActionType	тип действия
	 * @return bool
	 */
	protected function ProcessTablesAction($sActionType) {
		switch ($sActionType) {
			case 'repaircomments':
				/*
				 * Очистить таблицу комментариев и все связанные с ней от поврежденных записей комментариев
				 */
				$this->PluginAdmin_Deletecontent_PerformRepairCommentsStructure();
				break;
			case 'cleanstream':
				/*
				 * Очистка активности (стрима) от ссылок на записи, которых больше нет
				 */
				$this->PluginAdmin_Deletecontent_PerformCleanStreamEventsRecords();
				break;
			default:
				$this->Message_AddError($this->Lang('errors.utils.unknown_tables_clean_action'));
				return false;
		}
		$this->Message_AddNotice('Ok', '', true);
		$this->RedirectToReferer();
	}


	/*
	 *
	 * --- Проверка файлов ---
	 *
	 */

	/**
	 * Показать список действий проверки файлов
	 *
	 * @return mixed
	 */
	public function EventCheckFiles() {
		$this->SetTemplateAction('utils/files');

		/*
		 * если нужно выполнить действие
		 */
		if ($sActionType = $this->GetParam(1)) {
			$this->Security_ValidateSendForm();
			$this->ProcessFilesAction($sActionType);
		}
	}


	/**
	 * Выполнить нужное действие проверки файлов
	 *
	 * @param $sActionType	тип действия
	 * @return bool
	 */
	protected function ProcessFilesAction($sActionType) {
		switch ($sActionType) {
			case 'checkencoding':
				/*
				 * проверить кодировку файлов
				 */
				if ($this->PluginAdmin_Tools_CheckFilesOfPluginsAndEngineHaveCorrectEncoding()) {
					$this->Message_AddNotice('Ok', '', true);
				}
				break;
			default:
				$this->Message_AddError($this->Lang('errors.utils.unknown_files_action'));
				return false;
		}
		$this->RedirectToReferer();
	}


}

?>