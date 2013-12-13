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
 * Сущность для работы с шаблонами
 *
 */

class PluginAdmin_ModuleSkin_EntitySkin extends Entity {

	/**
	 * Включен ли этот шаблон сейчас для предпросмотра
	 *
	 * @return bool
	 */
	public function getInPreview() {
		return $this->getName() == $this->PluginAdmin_Skin_GetPreviewSkinName();
	}


	/**
	 * Включен ли сейчас этот шаблон (независимо от предпросмотра другого шаблона)
	 *
	 * @return bool
	 */
	public function getIsCurrent() {
		return $this->getName() == $this->PluginAdmin_Skin_GetOriginalSkinName();
	}


	/**
	 * Получить название шаблона как оно указано в описании, в противном случае - системное имя шаблона (имя директории)
	 *
	 * @return mixed
	 */
	public function getViewName() {
		/*
		 * если есть xml файл описания для шаблона
		 */
		if ($oInfo = $this->getInfo()) {
			/*
			 * получить запись с учетом языка сайта
			 */
			return (string) $oInfo->name->data;
		}
		/*
		 * вернуть системное имя шаблона
		 */
		return $this->getName();
	}


	/**
	 * Получить превью из шаблона или превью по-умолчанию
	 *
	 * @return string	путь к изображению превью
	 */
	public function getPreviewImage() {
		if ($sPreview = $this->getPreview()) {
			return $sPreview;
		}
		/*
		 * если нет превью - использовать превью по-умолчанию
		 */
		return Plugin::GetTemplateWebPath(__CLASS__) . 'assets/images/default_skin_preview.png';
	}

}

?>