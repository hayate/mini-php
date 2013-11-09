<?php

namespace Mini;


class View
{
    protected $vars;
    protected $basepath;

    public function __construct()
    {
        $this->vars = array();
        $this->basepath = APPPATH . 'views/';
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->vars))
        {
            return $this->vars[$name];
        }
        return '';
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function load($template, array $vars = array(), $as_string = FALSE)
    {
        if ($as_string)
        {
            return $this->fetch($template, $vars);
        }
        $this->render($template, $vars);
    }

    public function render($template, array $args = array())
    {
        $params = array_merge($args, $this->vars);
        $params['this'] = $this;

        extract($params, EXTR_SKIP);
        ob_start();
        try {
            require($this->template($template));
        }
        catch (Exception $ex)
        {
            ob_end_clean();
            throw $ex;
        }
        ob_end_flush();
    }

    public function fetch($template, array $args = array())
    {
        $params = array_merge($args, $this->vars);
        $params['this'] = $this;

        extract($params, EXTR_SKIP);
        ob_start();
        try {
            require($this->template($template));
        }
        catch (Exception $ex)
        {
            ob_end_clean();
            throw $ex;
        }
        return ob_get_clean();
    }

    protected function template($template)
    {
        return $this->basepath . ltrim($template, '/') . '.php';
    }
}
