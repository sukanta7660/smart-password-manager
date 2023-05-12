<?php

namespace SmartPasswordManager;

use SmartPasswordManager\Core\Handlers\MenuHandler;

class Application
{
    private $modules = [
        \SmartPasswordManager\Modules\Folder::class,
        \SmartPasswordManager\Modules\Credentials::class,
    ];


    public function __construct($file)
    {
        (new MenuHandler);
    }

    final public function boot()
    {
        foreach ($this->modules as $module) {
            (new $module($this))->register();
        }
    }
}