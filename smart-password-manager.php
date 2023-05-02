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
Password Vault is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Password Vault is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Password Vault. If not, write to the free software.

Copyright 2019 Password Vault LLC. All rights reserved.
*/

if (!defined('ABSPATH')) {
  exit;
}

class SmartPasswordManager {

  // methods

}

if ( !class_exists('SmartPasswordManager') ) {

  $passwordVault = new SmartPasswordManager();

}
