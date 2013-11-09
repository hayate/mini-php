<?php

namespace Mini;

class Error
{
    public function index($param)
    {
        if ($param instanceof Exception)
        {
            throw $param;
        }
        $request = Request::instance();

        if (is_numeric($param))
        {
            switch ($param)
            {
                case 404:
                    header('HTTP/1.0 404 Not Found');
                    // header('Content-Type: text/plain');
                    if (! $request->isHead())
                    {
                        return 'Not Found';
                    }
                    break;
            }
        }
    }
}
