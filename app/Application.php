<?php

namespace SmartPasswordManager;

use SmartPasswordManager\Core\Handlers\PageHandler;

class Application
{
    private $modules = [
        \SmartPasswordManager\Modules\Folder::class,
        \SmartPasswordManager\Modules\Credentials::class,
    ];


    public function __construct($file)
    {
        (new PageHandler);
    }

    final public function boot()
    {
        foreach ($this->modules as $module) {
            (new $module($this))->register();
        }
    }
}