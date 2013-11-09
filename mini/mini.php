<?php

namespace Mini;

class Mini
{
    private static $instance = NULL;
    private $dispatcher;
    private $config;
    private $view;

    private function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));
        $this->config = NULL;
        $this->view = NULL;
        $this->dispatcher = Dispatcher::instance();
    }

    public static function instance()
    {
        if (NULL == self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function autoload($classname)
    {
        if (substr($classname, 0, 5) == 'Mini\\')
        {
            $filepath = MINIPATH . strtolower(substr($classname, 5)) . '.php';
        }
        else if (substr($classname, 0, 11) == 'Controller\\')
        {
            $filepath = APPPATH . 'controllers/' . strtolower(substr($classname, 11)) . '.php';
        }
        require_once $filepath;
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    public function run()
    {
        $response = $this->dispatcher->dispatch();
        if (is_array($response))
        {
            $view = new View();
            $filepath = $this->dispatcher->controller() . '/' . $this->dispatcher->action();
            $view->render($filepath, $response);
        }
        else {
            echo $response;
        }
    }
}
