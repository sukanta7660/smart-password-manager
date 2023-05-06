<?php
/*
 * Plugin Name:       Smart Password Manager
 * Plugin URI:        #
 * Description:       A WordPress plugin to manage credentials.
 * Version:           1.0.0
 * Author:            Sukanta Purkayastha
 * Author URI:        https://devsukanta.me/
 * License:           GPL v2 or later
 * Text Domain:       password-vault
 */

/*
Smart Password Manager is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Smart Password Manager is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Smart Password Manager. If not, write to the free software.

Copyright 2019 Smart Password Manager LLC. All rights reserved.
*/

if (!defined('ABSPATH')) {
  exit;
}

class SmartPasswordManager {

    public string $plugin;

  function __construct() {
      $this->plugin = plugin_basename(__FILE__);
      add_action( 'wp_ajax_get_folder', [$this, 'getFolderLists']);
      add_action( 'wp_ajax_create_folder', [$this, 'createFolder']);
      add_action( 'wp_ajax_delete_folder', [$this, 'deleteFolder']);
      add_action( 'wp_ajax_get_credential', [$this, 'getCredentialLists']);
  }

  public function getFolderLists()
  {
    global $wpdb;
    $folderTableName = 'wp_folders';
    $userTableName = 'wp_users';
    $folders = $wpdb->get_results ( "SELECT * FROM $folderTableName, wp_users WHERE $userTableName.ID = $folderTableName.user_id ");
    return wp_send_json($folders);
  }

    public function createFolder()
    {
        global $wpdb;
        $folderTableName = 'wp_folders';
        $user = wp_get_current_user();
        $name = $_POST['name'];

        $wpdb->insert($folderTableName, [
            'user_id'   => $user->ID,
           'name'       => $name,
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

  public function deleteFolder()
  {
      global $wpdb;
      $folderTableName = 'wp_folders';
      $id = $_POST['id'];
      $wpdb->get_results ( "DELETE FROM $folderTableName WHERE `id` = $id");
  }

  public function getCredentialLists()
    {
        global $wpdb;
        $credentialTableName = 'wp_credentials';
        $userTableName = 'wp_users';
        $credentials = $wpdb->get_results ( "SELECT * FROM $credentialTableName, $userTableName WHERE $userTableName.ID = $credentialTableName.user_id ");
        return wp_send_json($credentials);
    }

  function register(): void
  {
      add_action('admin_enqueue_scripts', array( $this, 'enqueue' ));

      add_action('admin_menu', array( $this, 'addAdminPages' ));

  }

  public function addAdminPages(): void
  {
        add_menu_page(
            'Smart Password Manager',
            'SPM',
            'manage_options',
            'smart_password_manager',
            array( $this, 'plugin_index' ),
            'dashicons-vault',
            10
        );

      add_submenu_page(
          'smart_password_manager',
          'Folders',
          'Folder',
          'manage_options',
          'smart_password_manager#/folders',
          array( $this, 'plugin_index' ),
      );

      add_submenu_page(
          'smart_password_manager',
          'Credential',
          'Credential',
          'manage_options',
          'smart_password_manager#/credentials',
          array( $this, 'plugin_index' ),
      );

  }

  public function plugin_index() :void
  {
      require_once plugin_dir_path(__FILE__) . 'pages/index.php';

      wp_enqueue_style('customStyle', plugins_url('/public/css/custom.css', __FILE__ ));
      wp_enqueue_script('mainScript', plugins_url('/public/js/main.js', __FILE__ ));
      wp_localize_script( 'mainScript', 'ajax_object', ['ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ] );
  }

  function activate(): void
  {
    // tables Create
    $this->createTables();

    // insert data
    $this->insertData();

    flush_rewrite_rules();
  }

  function deactivate(): void
  {
    flush_rewrite_rules();
  }

  function createTables(): void
  {
      global $wpdb;
      $folderTableName = $wpdb->prefix . 'folders';
      $credentialTableName = $wpdb->prefix . 'credentials';
      $charsetCollate = $wpdb->get_charset_collate();

      $user = wp_get_current_user();

      $folderTable = "CREATE TABLE IF NOT EXISTS $folderTableName(
                `id` int NOT NULL AUTO_INCREMENT,
                `user_id` int NOT NULL,
                `name` varchar(255),
                `created_at` TIMESTAMP,
                `updated_at` TIMESTAMP,
                PRIMARY KEY (`id`)
        ) $charsetCollate";

      $credentialTable = "CREATE TABLE IF NOT EXISTS $credentialTableName(
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

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

      try {

          /*----- creating tables -----*/
          dbDelta( $folderTable );
          dbDelta( $credentialTable );
          /*-----/ creating tables -----*/

      } catch (Exception $exception) {
          error_log('Something Went Wrong');
      }
  }

  function insertData(): void
  {
      global $wpdb;
      $folderTableName = $wpdb->prefix . 'folders';
      $credentialTableName = $wpdb->prefix . 'credentials';

      $user = wp_get_current_user();

      /*----- Folder data -----*/
      $folderData = "INSERT INTO $folderTableName(`user_id`, `name`, `created_at`, `updated_at`) 
                                VALUES ($user->ID, 'Google', NOW(), NOW()),
                                ($user->ID, 'Facebook', NOW(), NOW()),
                                ($user->ID, 'Instagram', NOW(), NOW()),
                                ($user->ID, 'Discord', NOW(), NOW())
                                ";
      /*-----/ Folder data -----*/

      /*----- Credential data -----*/
      $credentialData = "INSERT INTO $credentialTableName(`user_id`, `item_type`, `name`, `username`, `password`, `url`, `created_at`, `updated_at`) 
                                VALUES ($user->ID, 'card', 'Sukanta Purkayastha', 'sukanta344', '12345678', 'https://youtu.be/gDOFDwgXrew', NOW(), NOW()),
                                ($user->ID, 'login', 'Sukanta', 'sukanta7660', '12345678', 'https://youtu.be/gDOFDwgXrew', NOW(), NOW()),
                                ($user->ID, 'login', 'Sukanta Showrav', 'sukanta7660', '12345678', 'https://youtu.be/gDOFDwgXrew', NOW(), NOW())
                                ";
      /*-----/ Credential data -----*/

      // execute
      $folderDataExists = "SELECT * FROM $folderTableName";
      $credentialDataExists = "SELECT * FROM $credentialTableName";

      if (count($wpdb->get_results($folderDataExists)) < 1) {
          $wpdb->get_results($folderData);
      }

      if (count($wpdb->get_results($credentialDataExists)) < 1) {
          $wpdb->get_results($credentialData);
      }
  }

  function enqueue(): void
  {
      wp_enqueue_style('myPluginStyle', plugins_url('/assets/css/style.css', __FILE__));
  }

}

  if ( class_exists('SmartPasswordManager') ) {
    $smartPasswordManager = new SmartPasswordManager();
    $smartPasswordManager->register();
  }

  // Activation
  register_activation_hook(__FILE__, array( $smartPasswordManager, 'activate'));

  // Deactivation
  register_deactivation_hook(__FILE__, array( $smartPasswordManager, 'deactivate'));
