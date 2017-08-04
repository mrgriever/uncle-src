<?php namespace Uncle\Models;

use Phalcon\Mvc\Model as PhalconModel;
use Phalcon\Config\Adapter\Ini as IniConfig;

class BaseModel extends PhalconModel
{
    protected static $config;

    public function initialize()
    {
        self::$config = new IniConfig(__DIR__ . '/../Configs/application.ini');
    }
}
