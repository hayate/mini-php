<?php

namespace Mini;

class Config
{
    private static $instance = NULL;
    private $config = NULL;

    private function __construct(array $config)
    {
        $this->config = $config;
    }

    public static function instance()
    {
        if (NULL == self::$instance)
        {
            throw new \Exception('Set a configuration array via Config::set before retrieving a Config instance.');
        }
        return self::$instance;
    }

    public static function set(array $config)
    {
        if (NULL == self::$instance)
        {
            self::$instance == new self($config);
        }
    }

    public function __get($name)
    {
        if (isset($this->config[$name]))
        {
            return $this->config[$name];
        }
        return NULL;
    }

    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    public function __toString()
    {
        return print_r($this->config, TRUE);
    }
}
