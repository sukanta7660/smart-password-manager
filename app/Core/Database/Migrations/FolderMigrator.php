<?php

namespace SmartPasswordManager\Core\Database\Migrations;

class FolderMigrator
{

    static $tableName = 'folders';

    public static function migrate()
    {
        global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();

        $table = $wpdb->prefix . static::$tableName;

        $sql = "CREATE TABLE IF NOT EXISTS $table(
                `id` int NOT NULL AUTO_INCREMENT,
                `user_id` int NOT NULL,
                `name` varchar(255),
                `created_at` TIMESTAMP,
                `updated_at` TIMESTAMP,
                PRIMARY KEY (`id`)
        ) $charsetCollate";

        dbDelta($sql);
    }

}