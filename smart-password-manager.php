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


use SmartPasswordManager\Activator;

if (!defined('ABSPATH')) {
  exit;
}


if(file_exists(__DIR__.'/vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

(new \SmartPasswordManager\Application(__FILE__))->boot();


register_activation_hook(__FILE__, [ Activator::class, 'activate' ]);


register_deactivation_hook(__FILE__, [Activator::class, 'deactivate']);