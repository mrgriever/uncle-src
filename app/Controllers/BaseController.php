<?php namespace Uncle\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Config\Adapter\Ini as IniConfig;

class BaseController extends Controller
{
    protected $config;

    public function onConstruct()
    {
        $this->config = new IniConfig(__DIR__ . '/../Configs/application.ini');
    }
}
