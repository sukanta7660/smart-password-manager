<?php
namespace SmartPasswordManager\Modules;
use SmartPasswordManager\Modules\Concern\Module;

class Folder implements Module
{
    static $folderTableName = 'folders';
    static $userTableName = 'users';

    public function register()
    {
        add_action( 'wp_ajax_get_folder', [$this, 'fetch']);
        add_action( 'wp_ajax_create_folder', [$this, 'store']);
        add_action( 'wp_ajax_update_folder', [$this, 'update']);
        add_action( 'wp_ajax_delete_folder', [$this, 'destroy']);
    }

    public function fetch()
    {
        global $wpdb;

        $table = $wpdb->prefix . static::$folderTableName;
        $userTable = $wpdb->prefix . static::$userTableName;

        $user = wp_get_current_user();

        $folders = $wpdb->get_results (
            "SELECT * FROM $table, wp_users WHERE $userTable.ID = $table.user_id AND $table.user_id = $user->ID"
        );
        return wp_send_json($folders);
    }

    public function store()
    {
        global $wpdb;
        $table = $wpdb->prefix . static::$folderTableName;
        $user = wp_get_current_user();
        $name = sanitize_text_field($_POST['name']);

        $wpdb->insert($table, [
            'user_id'    => $user->ID,
            'name'       => $name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function update()
    {
        global $wpdb;
        $table = $wpdb->prefix . static::$folderTableName;
        $name = sanitize_text_field($_POST['name']);

        $wpdb->update($table, [
            'name'       => $name,
            'updated_at' => date('Y-m-d H:i:s'),
        ],
            ['id' => $_POST['id']]
        );
    }

    public function destroy()
    {
        global $wpdb;
        $table = $wpdb->prefix . static::$folderTableName;
        $id = $_POST['id'];

        $wpdb->delete($table, [
            'id' => $id
        ]);
    }
}