<?php

namespace Mini;

class Router
{
    private static $instance = NULL;
    private $request;
    private $basepath;
    private $controllers;
    private $controller;
    private $action;
    private $args;

    private function __construct()
    {
        $this->request = Request::instance();
        $this->controllers = array();
        $this->basepath = APPPATH . 'controllers/';
        $this->controller = array('name' => NULL, 'object' => NULL);
        $this->action = NULL;
        $this->args = array();

        foreach (scandir($this->basepath) as $controller)
        {
            if (substr($controller, -4) == '.php')
            {
                $this->controllers[] = strtolower(substr($controller, 0, -4));
            }
        }
    }

    public static function instance()
    {
        if (NULL == self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function route()
    {
        $this->args = $this->request->segments();
        if (count($this->args) > 0)
        {
            if (in_array($this->args[0], $this->controllers))
            {
                $controller = array_shift($this->args);
                $classname = 'Controller\\'.ucfirst($controller);
                $this->controller['object'] = new $classname();
                $this->controller['name'] = $controller;
                if (count($this->args) > 0)
                {
                    if (method_exists($this->controller['object'], $this->args[0]))
                    {
                        $this->action = array_shift($this->args);
                        return TRUE;
                    }
                }
                if (method_exists($this->controller['object'], 'index'))
                {
                    $this->action = 'index';
                    return TRUE;
                }
            }
            if (in_array('index', $this->controllers))
            {
                $classname = 'Controller\\Index';
                $this->controller['object'] = new $classname();
                $this->controller['name'] = 'index';
                if (method_exists($this->controller['object'], $this->args[0]))
                {
                    $this->action = array_shift($this->args);
                    return TRUE;
                }
            }
        }
        else if (in_array('index', $this->controllers))
        {
            $classname = 'Controller\\Index';
            $this->controller['object'] = new $classname();
            $this->controller['name'] = 'index';
            if (method_exists($this->controller['object'], 'index'))
            {
                $this->action = 'index';
                return TRUE;
            }
        }
        $this->controller = array('name' => NULL, 'object' => NULL);
        $this->action = NULL;
        return FALSE;
    }

    public function error($param)
    {
        if (in_array('error', $this->controllers))
        {
            $classname = 'Controller\\Error';
            $this->controller['object'] = new $classname();
            $this->controller['name'] = 'error';
            if (! method_exists($this->controller['object'], 'index'))
            {
                $classname = 'Mini\\Error';
                $this->controller['object'] = new $classname();
            }
        }
        else {
            $classname = 'Mini\\Error';
            $this->controller['object'] = new $classname();
            $this->controller['name'] = 'error';
        }
        $this->action = 'index';
        $this->args = array($param);
        return TRUE;
    }

    public function controller($as_object = FALSE)
    {
        if ($as_object)
        {
            return $this->controller['object'];
        }
        return $this->controller['name'];
    }

    public function action()
    {
        return $this->action;
    }

    public function args()
    {
        return $this->args;
    }
}
