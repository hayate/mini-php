<?php

namespace Mini;

class Controller
{
    protected $request;

    public function __construct()
    {
        $this->request = Request::instance();
    }

    public function isPost()
    {
        return $this->request->isPost();
    }

    public function isGet()
    {
        return $this->request->isGet();
    }

    public function isHead()
    {
        return $this->request->isHead();
    }

    public function isPut()
    {
        return $this->request->isPut();
    }
}

