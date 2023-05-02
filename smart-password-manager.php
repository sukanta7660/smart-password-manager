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

  function activate(): void
  {
    // generate Custom post type
    $this->custom_post_type();

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

}

if ( class_exists('SmartPasswordManager') ) {

  $smartPasswordManager = new SmartPasswordManager();

}

// Activation
register_activation_hook(__FILE__, array( $smartPasswordManager, 'deactivate'));

// Deactivation
register_deactivation_hook(__FILE__, array( $smartPasswordManager, 'activate'));
