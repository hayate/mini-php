<?php

namespace Mini;

class Dispatcher
{
    private static $instance = NULL;
    private $router;
    private $controller = 'index';
    private $action = 'index';

    private function __construct()
    {
        $this->router = Router::instance();
    }

    public static function instance()
    {
        if (NULL == self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function dispatch()
    {
        try {
            if ($this->router->route())
            {
                return call_user_func_array(array($this->router->controller(TRUE),
                                                  $this->router->action()), $this->router->args());
            }

            $this->router->error(404);
            return call_user_func_array(array($this->router->controller(TRUE),
                                              $this->router->action()), $this->router->args());
        }
        catch (Exception $ex)
        {
            $this->router->error($ex);
            return call_user_func_array(array($this->router->controller(TRUE),
                                              $this->router->action()), $this->router->args());
        }
    }

    public function controller()
    {
        return $this->router->controller();
    }

    public function action()
    {
        return $this->router->action();
    }
}
