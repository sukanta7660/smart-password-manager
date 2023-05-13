<?php

namespace SmartPasswordManager;

use SmartPasswordManager\Auth\Authentication;
use SmartPasswordManager\Core\Handlers\PageHandler;
use SmartPasswordManager\Core\Handlers\ShortCodeHandler;

class Application
{
    private $modules = [
        \SmartPasswordManager\Auth\Authentication::class,
        \SmartPasswordManager\Modules\Folder::class,
        \SmartPasswordManager\Modules\Credentials::class,
    ];


    public function __construct($file = null)
    {
        (new PageHandler);
        ( new ShortCodeHandler );
    }

    final public function boot()
    {
        foreach ($this->modules as $module) {
            (new $module($this))->register();
        }
    }
}