<?php

class PluginArticle_Update_Change extends ModulePluginManager_EntityUpdate
{
    /**
     * Выполняется при обновлении версии
     */
    public function up()
    {
        // Меняем длину поля до 300 символов
        $this->exportSQLQuery('ALTER TABLE `prefix_article` CHANGE `title` `title` VARCHAR( 300 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;');
    }

    /**
     * Выполняется при откате версии
     */
    public function down()
    {
        // Меняем обратно до 250 символов
        $this->exportSQLQuery('ALTER TABLE `prefix_article` CHANGE `title` `title` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;');
    }
}