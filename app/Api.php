<?php namespace Uncle;

use Phalcon\Mvc\Micro;use Phalcon\Di\FactoryDefault;
use Phalcon\Config\Adapter\Ini as IniConfig;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Uncle\Libs\Router;

class Api
{
    private $app;

    public function __construct()
    {
        // initialize the PDO connection to inject in the application
        $di = new FactoryDefault();
        $di->set('db', function() {
            $db = new IniConfig(__DIR__ . '/Configs/database.ini');
            return new PdoMysql([
                'host'      => $db->default->hostname,
                'username'  => $db->default->username,
                'password'  => $db->default->password,
                'dbname'    => $db->default->schema,
                'charset'   => $db->default->charset,
            ]);
        });

        $this->app = new Micro($di);

        foreach (Router::getRoutes() as $route) {
            $this->app->mount($route);
        }

        // catch-all for requests not matched by the router
        $this->app->notFound(function () {
            $this->app->response->setStatusCode(404, 'Not Found');
            $this->app->response->sendHeaders();
        });

        // report any uncaught exceptions
        $this->app->error(function (\Exception $e = null) {
            // NOTE - exceptions are not caught, a fatal error will be issue and the application will report a fatal error
            if ($e === null) {
                $e = new \Exception();
            }
            $err_code = (int)$e->getCode();
            $err_msg = $e->getMessage();
            $this->app->response->setStatusCode(500, 'Server Error');
            $this->app->response->setHeader('Content-Type', 'application/json');
            $this->app->response->setContent(json_encode([
                'code' => ($err_code > 1 ? $err_code : 1), // in *nix tradition 0 indicates success, all errors should be > 1
                'message' => (strlen($err_msg) > 0 ? $err_msg : 'An unknown error occurred'),
            ]));
            $this->app->response->send();
        });

        // successful controller action results are json-encoded before return to the user
        $this->app->after(function () {
            $returnValue = $this->app->getReturnedValue();
            $this->app->response->setStatusCode(200, 'OK');
            $this->app->response->setHeader('Content-Type', 'application/json');
            if (!empty($returnValue)) {
                $this->app->response->setContent(json_encode($returnValue));
            }
            $this->app->response->send();
        });
    }

    /*
    public function __destruct()
    {

    }
     */

    public function execute()
    {
        $this->app->handle();
    }
}
