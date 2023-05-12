<?php
namespace SmartPasswordManager\Core\Database;
use SmartPasswordManager\Core\Database\Migrations\CredentialMigrator;
use SmartPasswordManager\Core\Database\Migrations\FolderMigrator;

class Migrator
{
    public static function run()
    {
        self::migrate();
    }

    public static function migrate()
    {
        FolderMigrator::migrate();
        CredentialMigrator::migrate();
    }
}