<?php

namespace Mini;

class Autoloader
{
    public static $instance = NULL;

    public static function register()
    {
        if (NULL == self::$instance)
        {
            if (FALSE !== ($functions = spl_autoload_functions()))
            {
                if (function_exists('__autoload') && in_array('__autoload', $functions))
                {
                    spl_autoload_register('__autoload', FALSE);
                }
            }

            spl_autoload_register(function ($classname)
            {
                if (substr($classname, 0, 5) == 'Mini\\')
                {
                    require_once(MINIPATH . strtolower(substr($classname, 5)) . '.php');
                }
                else if (substr($classname, 0, 11) == 'Controller\\')
                {
                    require_once(APPPATH . 'controllers/' . strtolower(substr($classname, 11)) . '.php');
                }
            });
            self::$instance = new self();
        }
    }
}
