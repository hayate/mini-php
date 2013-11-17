<?php

namespace Mini;

class Log
{
    private static $instance = NULL;
    private $filepath;
    private $level;

    private function __construct()
    {
        $config = Config::instance();
        $this->level = isset($config->logging['level']) ? $config->logging['level'] : 0;
        if (isset($config->logging['path']) && is_writable($config->logging['path']))
        {
            $path = rtrim($config->logging['path'], '/\\');
        }
        else {
            $path = '/tmp';
        }
        $filename = 'log-'.gmdate('Y-m-d').'.log';
        $this->filepath = "{$path}/{$filename}";
    }

    public static function instance()
    {
        if (self::$instance == NULL)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function info($msg)
    {
        if ($this->level > 0 && $this->level <= 3)
        {
            $this->write(__FUNCTION__, $msg);
        }
    }

    public function debug($msg)
    {
        if ($this->level > 0 && $this->level <= 2)
        {
            $this->write(__FUNCTION__, $msg);
        }
    }

    public function error($msg)
    {
        if ($this->level > 0 && $this->level <= 3)
        {
            $this->write(__FUNCTION__, $msg);
        }
    }

    public function exception($ex)
    {
        $msg = sprintf("%s\n%s", $ex->getMessage(), $ex->getTraceAsString());
        $this->write(__FUNCTION__, $msg);
    }

    private function write($type, $msg)
    {
        $message = sprintf('%s [%s]: %s', gmdate('Y/m/d H:i:s'), $type, $msg);
        $fp = fopen($this->filepath, 'a');
        fwrite($fp, $message);
        fclose($fp);
    }
}
