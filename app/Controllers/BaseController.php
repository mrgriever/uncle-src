<?php namespace Uncle\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Config\Adapter\Ini as IniConfig;

class BaseController extends Controller
{
    protected static $config;

    public function onConstruct()
    {
        self::$config = new IniConfig(__DIR__ . '/../Configs/application.ini');
    }
}
