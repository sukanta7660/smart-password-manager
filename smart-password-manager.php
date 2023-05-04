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

  function __construct() {
    add_action('init', array($this, 'custom_post_type'));
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
            110
        );

      add_submenu_page(
          'smart_password_manager',
          'Folders',
          'Folder',
          'manage_options',
          'smart_password_manager#/folders'
      );

      add_submenu_page(
          'smart_password_manager',
          'Credential',
          'Credential',
          'manage_options',
          'smart_password_manager#/credentials'
      );

      remove_submenu_page( 'smart_password_manager', 'smart_password_manager' );

  }

  public function plugin_index() :void
  {
      require_once plugin_dir_path(__FILE__) . 'pages/index.php';

      wp_enqueue_style('customStyle', plugins_url('/public/css/custom.css', __FILE__ ));
      wp_enqueue_script('mainScript', plugins_url('/public/js/main.js', __FILE__ ));
  }

  public function credential_index() :void
  {
      require_once plugin_dir_path(__FILE__) . 'pages/credential/index.php';

      wp_enqueue_style('customStyle', plugins_url('/public/css/custom.css', __FILE__ ));
      wp_enqueue_script('mainScript', plugins_url('/public/js/main.js', __FILE__ ));
  }

  function activate(): void
  {
    // tables Create
    $this->createTables();

    flush_rewrite_rules();
  }

  function deactivate(): void
  {
    flush_rewrite_rules();
  }

  function custom_post_type(): void
  {
    register_post_type('folder', ['public' => true, 'label' => 'Folders']);
  }

  function createTables(): void
  {
      global $wpdb;
      $folderTableName = $wpdb->prefix . 'folders';
      $credentialTableName = $wpdb->prefix . 'credentials';
      $charsetCollate = $wpdb->get_charset_collate();

      $folderTable = "CREATE TABLE IF NOT EXISTS $folderTableName(
                `id` int NOT NULL AUTO_INCREMENT,
                `user_id` int NOT NULL,
                `name` varchar(255),
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
                url varchar(255),
                notes LONGTEXT,
                PRIMARY KEY (`id`)
        ) $charsetCollate";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

      try {

          dbDelta( $folderTable );
          dbDelta( $credentialTable );
          error_log('Tables are created');

      } catch (Exception $exception) {
          error_log('Something Went Wrong');
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
