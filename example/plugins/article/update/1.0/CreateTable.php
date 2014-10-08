<?php

class PluginArticle_Update_CreateTable extends ModulePluginManager_EntityUpdate
{
    /**
     * Выполняется при обновлении версии
     */
    public function up()
    {
        if (!$this->isTableExists('prefix_article')) {
            /**
             * При активации выполняем SQL дамп
             */
            $this->exportSQL(Plugin::GetPath(__CLASS__) . '/dump.sql');
        }
    }

    /**
     * Выполняется при откате версии
     */
    public function down()
    {
        $this->exportSQLQuery('DROP TABLE prefix_article;');
    }
}