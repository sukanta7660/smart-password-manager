<?php
namespace SmartPasswordManager\Database;
use SmartPasswordManager\Database\Migrations\CredentialMigrator;
use SmartPasswordManager\Database\Migrations\FolderMigrator;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class Migrator
{
    public static function run()
    {
        self::migrate();
    }

    public static function migrate()
    {
        FolderMigrator::migrate();
        FolderMigrator::seedData();
        CredentialMigrator::migrate();
        CredentialMigrator::seedData();
    }
}