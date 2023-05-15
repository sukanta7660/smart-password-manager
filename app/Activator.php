<?php

namespace SmartPasswordManager;

use SmartPasswordManager\Database\Migrator;

class Activator
{
    public static function activate()
    {
        Migrator::run();
        flush_rewrite_rules();
    }

    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}