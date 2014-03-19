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
 * Расширение возможностей вьюера
 * 
 */

class PluginAdmin_ModuleViewer extends PluginAdmin_Inherit_ModuleViewer {

	/**
	 * Добавить директорию с плагинами для Smarty
	 * 
	 * @param $sDir		директория
	 * @return bool
	 */
	public function AddSmartyPluginsDir($sDir) {
		if (!is_dir($sDir)) {
			return false;
		}
		$this->oSmarty->addPluginsDir($sDir);
		return true;
	}


	/**
	 * Очистить списки таблиц стилей и JS загружаемых вместе с движком
	 *
	 * @param bool $bClearConfig
	 */
	public function ClearStyle($bClearConfig=false) {
		$this->aCssInclude = array(
			'append' => array(),
			'prepend' => array()
		);
		$this->aJsInclude = array(
			'append' => array(),
			'prepend' => array()
		);
		/*
		 * очистить параметры для подключаемых файлов
		 */
		$this->aFilesParams=array(
			'js' => array(),
			'css' => array()
		);

		if ($bClearConfig) {
			/*
			 * стандартные настройки жс и ксс
			 */
			$this->aFilesDefault=array(
				'js' => array(),
				'css' => array()
			);
			Config::Set('head.rules',array());
		}
	}


	/**
	 * Строит HTML код по переданному массиву файлов с добавлением гет-параметра к адресу файла для автоматического сброса кеша на стороне пользователя
	 *
	 * @param  array $aFileList    		Список файлов
	 * @return array
	 */
	protected function BuildHtmlHeadFiles($aFileList) {
		/*
		 * получить счетчик последнего сброса кеша
		 */
		$sCounter = $this->Storage_Get(PluginAdmin_ModuleTools::CACHE_LAST_RESET_COUNTER, $this);

		$aFileList['css'] = (array) $aFileList['css'];
		$aFileList['js'] = (array) $aFileList['js'];
		/*
		 * добавить гет параметр со счетчиком к адресу файла
		 */
		foreach(array('css', 'js') as $sAssetType) {
			foreach($aFileList[$sAssetType] as &$sFile) {
				$sFile .= $this->GetDelimiterForGetRequestParameterByPath($sFile) . 'v=' . $sCounter;
			}
		}
		return parent::BuildHtmlHeadFiles($aFileList);
	}


	/**
	 * Получить корректный разделитель для добавления гет параметра к строке запроса
	 *
	 * @param $sPath		существующая строка
	 * @return string		? или &amp;
	 */
	private function GetDelimiterForGetRequestParameterByPath($sPath) {
		return (strpos($sPath, '?') === false) ? '?' : '&amp;';
	}
	
}

?>