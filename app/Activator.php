<?php

namespace SmartPasswordManager;

use SmartPasswordManager\Core\Database\Migrator;
use SmartPasswordManager\Core\Handlers\PageHandler;

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