<?php

namespace Mini;

class Request
{
    private static $instance = NULL;
    private $method;
    private $path;
    private $query;
    private $segs;

    private function __construct()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $parts = explode('?', $_SERVER['REQUEST_URI']);
        $this->path = trim(strtolower($parts[0]));
        $this->query = '';
        if (count($parts) > 1)
        {
            $this->query = $parts[1];
        }
        $this->segs = array();

        if (! empty($this->path) && $this->path != '/')
        {
            $this->segs = explode('/', trim($this->path, '/'));
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

    public function isPost()
    {
        return 'post' == $this->method;
    }

    public function isGet()
    {
        return 'get' == $this->method;
    }

    public function isHead()
    {
        return 'head' == $this->method;
    }

    public function isPut()
    {
        return 'put' == $this->method;
    }

    public function method()
    {
        return $this->method;
    }

    public function segments()
    {
        return $this->segs;
    }

    public function segment($pos)
    {
        if (isset($this->segs[$pos]))
        {
            return $this->segs[$pos];
        }
        return '';
    }
}
