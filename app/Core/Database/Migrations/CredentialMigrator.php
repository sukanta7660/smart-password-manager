<?php

namespace SmartPasswordManager\Core\Database\Migrations;

class CredentialMigrator
{
    static $tableName = 'credentials';

    public static function migrate()
    {
        global $wpdb;

        $table = $wpdb->prefix . static::$tableName;

        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table(
                `id` int NOT NULL AUTO_INCREMENT,
                `user_id` int NOT NULL,
                `folder_id` int,
                `item_type` ENUM('login', 'card', 'identity') DEFAULT 'login',
                `name` varchar(255) NOT NULL,
                `username` varchar(255),
                `password` varchar(255),
                `url` LONGTEXT,
                `notes` LONGTEXT,
                `created_at` TIMESTAMP,
                `updated_at` TIMESTAMP,
                PRIMARY KEY (`id`)
        ) $charsetCollate";

        dbDelta($sql);
    }

}