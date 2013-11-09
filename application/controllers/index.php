<?php

namespace Controller;


class Index extends \Mini\Controller
{
    public function index()
    {
        return array('name' => __METHOD__);
    }
}
