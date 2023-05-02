<?php
/**
 * Trigger this file on plugin uninstall
 * @package SmartPasswordManager
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
  die;
}

// Clear database stored data
$folders = get_post( array( 'post_type' => 'folder', 'numberposts' => -1 ) );

foreach ($folders as $folder) {
  wp_delete_post( $folder->ID, true );
}
