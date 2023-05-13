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

    public static function seedData()
    {
        global $wpdb;
        $table = $wpdb->prefix . static::$tableName;

        $data = "SELECT * FROM $table";

        if (count($wpdb->get_results($data)) < 1) {
            foreach (static::dataToSeed() as $folder) {
                $wpdb->insert($table, [
                    'user_id'    => $folder['user_id'],
                    'name'       => $folder['name'],
                    'created_at' => $folder['created_at'],
                    'updated_at' => $folder['updated_at'],
                ]);
            }
        }
    }

    public static function dataToSeed()
    {
        $user = wp_get_current_user();

        return [
            [
                'user_id' => $user->ID,
                'name' => 'Google',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => $user->ID,
                'name' => 'Facebook',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => $user->ID,
                'name' => 'Instagram',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];
    }

}