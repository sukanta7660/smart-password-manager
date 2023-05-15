<?php
namespace SmartPasswordManager\Modules;

use SmartPasswordManager\Modules\Concern\Module;

class Credentials implements Module
{

    static $credentialTableName = 'credentials';
    static $userTableName = 'users';

    public function register()
    {
        add_action( 'wp_ajax_check_master_password', [$this, 'checkMasterPassword']);
        add_action( 'wp_ajax_get_credential', [$this, 'fetch']);
        add_action( 'wp_ajax_create_credential', [$this, 'store']);
        add_action( 'wp_ajax_update_credential', [$this, 'update']);
        add_action( 'wp_ajax_delete_credential', [$this, 'destroy']);
        add_action( 'wp_ajax_move_credential', [$this, 'moveCredentialToFolder']);
    }

    public function fetch()
    {
        global $wpdb;

        $table = $wpdb->prefix . static::$credentialTableName;
        $userTable = $wpdb->prefix . static::$userTableName;

        $user = wp_get_current_user();

        $credentials = $wpdb->get_results (
            "SELECT * FROM $table, $userTable WHERE $userTable.ID = $table.user_id AND $table.user_id = $user->ID"
        );
        return wp_send_json($credentials);
    }

    public function store()
    {
        global $wpdb;
        $table = $wpdb->prefix . static::$credentialTableName;
        $user = wp_get_current_user();

        $wpdb->insert($table, [
            'user_id'    => $user->ID,
            'item_type'  => sanitize_text_field($_POST['item_type']),
            'folder_id'  => absint($_POST['folder_id']) ?? null,
            'name'       => sanitize_text_field($_POST['name']),
            'username'   => sanitize_text_field($_POST['username']) ?? null,
            'password'   => sanitize_text_field($_POST['password']) ?? null,
            'url'        => sanitize_url($_POST['url']) ?? null,
            'notes'      => sanitize_text_field($_POST['notes']) ?? null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function update()
    {
        global $wpdb;
        $table = $wpdb->prefix . static::$credentialTableName;

        $wpdb->update($table, [
            'item_type'  => sanitize_text_field($_POST['item_type']),
            'folder_id'  => absint($_POST['folder_id']) ?? null,
            'name'       => sanitize_text_field($_POST['name']),
            'username'   => sanitize_text_field($_POST['username']) ?? null,
            'password'   => sanitize_text_field($_POST['password']) ?? null,
            'url'        => sanitize_url($_POST['url']) ?? null,
            'notes'      => sanitize_text_field($_POST['notes']) ?? null,
            'updated_at' => date('Y-m-d H:i:s'),
        ],
            ['id' => $_POST['id']]
        );
    }

    public function destroy()
    {
        global $wpdb;

        $table = $wpdb->prefix . static::$credentialTableName;

        $id = $_POST['id'];

        $wpdb->delete($table, [
            'id' => $id
        ]);
    }

    public function checkMasterPassword()
    {
        $user = wp_get_current_user();
        $passwordInput = $_POST['password'];
        $isMatched = wp_check_password($passwordInput, $user->user_pass, $user->ID);
        return wp_send_json($isMatched);
    }

    public function moveCredentialToFolder()
    {
        global $wpdb;
        $table = $wpdb->prefix . static::$credentialTableName;

        $folder = $_POST['folder_id'] === "" ? null : $_POST['folder_id'];
        $items = rest_sanitize_array($_POST['items']);

        foreach ($items as $item) {
            $wpdb->update($table, [
                'folder_id'  => $folder,
                'updated_at' => date('Y-m-d H:i:s'),
            ],
                ['id' => (int) $item]
            );
        }
    }
}