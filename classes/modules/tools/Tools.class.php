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

/**
 *
 *	Разные методы
 *
*/

class PluginAdmin_ModuleTools extends Module {

	public function Init() {}


	/**
	 * Возвращает путь к плагинам админки для смарти
	 *
	 * @return string
	 */
	public function GetSmartyPluginsPath() {
		return Plugin::GetPath(__CLASS__) . 'include/smarty/';
	}


	/**
	 * Вернуть путь к шаблону админки для плагина
	 *
	 * @param $sName			имя плагина
	 * @return bool|string
	 */
	public function GetPluginTemplatePath($sName) {
		$sNamePlugin = Engine::GetPluginName($sName);
		$sNamePlugin = $sNamePlugin ? $sNamePlugin : $sName;
		$sNamePlugin = func_underscore($sNamePlugin);

		$sPath = Plugin::GetPath($sNamePlugin);
		$aSkins = array('admin_default', 'default', Config::Get('view.skin'));
		foreach($aSkins as $sSkin) {
			$sTpl = $sPath . 'templates/skin/' . $sSkin . '/';
			if (is_dir($sTpl)) {
				return $sTpl;
			}
		}
		return false;
	}


	/**
	 * Вернуть веб-путь к шаблону админки для плагина
	 *
	 * @param $sName			имя плагина
	 * @return bool|string
	 */
	public function GetPluginTemplateWebPath($sName) {
		if ($sPath = $this->GetPluginTemplatePath($sName)) {
			return str_replace(Config::Get('path.root.server'), Config::Get('path.root.web'), $sPath);
		}
		return false;
	}


	/**
	 * Выполнить проверку конфигов и языковых файлов плагинов и системы на utf-8 w/o BOM
	 */
	public function CheckLangsAndConfigsOfPluginsAndEngineToBeInCorrectEncoding() {
		/*
		 * проверить файлы движка
		 */
		$aFilesMasksToCheck = array(
			/*
			 *
			 * --- проверка файлов фреймворка ---
			 *
			 */
			/*
			 * все конфиги: конфиг, жевикс, загрузчик
			 */
			Config::Get('path.framework.server') . 'config/*.php',
			/*
			 * все css файлы
			 */
			Config::Get('path.framework.server') . 'frontend/framework/*.css',
			/*
			 * все js файлы (папку vendor не будем проверять)
			 */
			Config::Get('path.framework.server') . 'frontend/framework/js/core/*.js',
			Config::Get('path.framework.server') . 'frontend/framework/js/ui/*.js',
			/*
			 * языковые файлы
			 */
			Config::Get('path.framework.server') . 'frontend/i18n/*.php',
			/*
			 * шаблоны
			 */
			Config::Get('path.framework.server') . 'frontend/templates/*.tpl',
			Config::Get('path.framework.server') . 'frontend/templates/*.js',
			Config::Get('path.framework.server') . 'frontend/templates/*.css',

			/*
			 *
			 * --- проверка файлов приложения ---
			 *
			 */
			/*
			 * все конфиги: конфиг, жевикс
			 */
			Config::Get('path.application.server') . 'config/*.php',
			/*
			 * все js файлы
			 */
			Config::Get('path.application.server') . 'frontend/common/js/*.js',
			/*
			 * языковые файлы
			 */
			Config::Get('path.application.server') . 'frontend/i18n/*.php',
			/*
			 * шаблоны
			 */
			Config::Get('path.application.server') . 'frontend/skin/*.tpl',
			Config::Get('path.application.server') . 'frontend/skin/*.js',
			Config::Get('path.application.server') . 'frontend/skin/*.css',
			/*
			 * проверить файлы крона
			 */
			Config::Get('path.application.server') . 'utilities/cron/*.php',
		);
		$this->CheckFilesEncodingByArray($aFilesMasksToCheck);

		/*
		 * todo: конфиги и языковые файлы плагинов
		 */
	}


	/**
	 * Проверить файлы из переданного массива на корректность кодировки
	 *
	 * @param $aFilesMasksToCheck	массив файлов для проверки
	 */
	protected function CheckFilesEncodingByArray($aFilesMasksToCheck) {
		foreach ($aFilesMasksToCheck as $sFileMask) {
			$aFilesMasksToCheck = glob($sFileMask);
			foreach ($aFilesMasksToCheck as $sFile) {
				/*
				 * можно ли прочитать этот файл
				 */
				if (!is_readable($sFile)) {
					$this->Message_AddError($this->Lang_Get('plugin.admin.errors.encoding_check.unreadable_file', array('file' => $sFile)), $this->Lang_Get('error'));
					continue;
				}
				/*
				 * получить первые 50 байт, этого достаточно для проверки
				 */
				if (($sText = @file_get_contents($sFile, false, null, 0, 50)) === false) {
					$this->Message_AddError($this->Lang_Get('plugin.admin.errors.encoding_check.file_cant_be_read', array('file' => $sFile)), $this->Lang_Get('error'));
					continue;
				}
				/*
				 * проверить на некорректную кодировку файлов
				 */
				if ($this->CheckTextEncodingForUTF8BOM($sText)) {
					$this->Message_AddError($this->Lang_Get('plugin.admin.errors.encoding_check.utf8_bom_encoding_detected', array('file' => $sFile)), $this->Lang_Get('error'));
					continue;
				}
			}
		}
	}


	/**
	 * Проверить является ли кодировкой текста utf-8 BOM, которую нельзя использовать в файлах движка
	 *
	 * @param $sText	текст для проверка
	 * @return bool
	 */
	protected function CheckTextEncodingForUTF8BOM($sText) {
		/*
		 * utf-8 BOM отличается от простой utf-8 без сигнатуры первыми тремя символами
		 */
		return substr($sText, 0, 3) === pack('CCC', 0xEF, 0xBB, 0xBF);
	}

}

?>