<?php

namespace SmartPasswordManager;
use SmartPasswordManager\Traits\ApplicationContract;

class Application
{
    private $modules = [
        \SmartPasswordManager\Modules\Folder::class,
        \SmartPasswordManager\Modules\Credentials::class,
    ];


    public function __construct($file)
    {

    }

    final public function boot()
    {
        foreach ($this->modules as $module) {
            (new $module($this))->register();
        }
    }
}