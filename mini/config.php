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

    public static function instance(array $config = NULL)
    {
        if (NULL == self::$instance)
        {
            if (empty($config))
            {
                throw new Exception("Config class must be initialize with a config array.");
            }
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function __get($name)
    {
        if (in_array($name, $this->config))
        {
            return $this->config[$name];
        }
        return NULL;
    }

    public function __isset($name)
    {
        if (in_array($name, $this->config))
        {
            return NULL != $this->config[$name];
        }
        return FALSE;
    }
}
