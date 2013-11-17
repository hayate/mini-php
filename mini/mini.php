<?php

namespace Mini;

class Mini
{
    private static $instance = NULL;
    private $dispatcher;
    private $view;

    private function __construct()
    {
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
