<?php

namespace SmartPasswordManager\Database\Migrations;

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

    public static function seedData()
    {
        global $wpdb;
        $table = $wpdb->prefix . static::$tableName;

        $data = "SELECT * FROM $table";

        if (count($wpdb->get_results($data)) < 1) {
            foreach (static::dataToSeed() as $credential) {
                $wpdb->insert($table, [
                    'user_id'    => $credential['user_id'],
                    'item_type'  => $credential['item_type'],
                    'name'       => $credential['name'],
                    'username'   => $credential['username'],
                    'password'   => $credential['password'],
                    'url'        => $credential['url'],
                    'created_at' => $credential['created_at'],
                    'updated_at' => $credential['updated_at'],
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
                'item_type' => 'card',
                'name' => 'John Doe',
                'username' => 'john123',
                'password' => '1234567',
                'url' => 'https://youtu.be/gDOFDwgXrew',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => $user->ID,
                'item_type' => 'login',
                'name' => 'Mr. Bin',
                'username' => 'bin123',
                'password' => '1234567',
                'url' => 'https://youtu.be/gDOFDwgXrew',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => $user->ID,
                'item_type' => 'identity',
                'name' => 'Hello Bin',
                'username' => 'bin100',
                'password' => '1234567',
                'url' => 'https://youtu.be/gDOFDwgXrew',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];
    }

}