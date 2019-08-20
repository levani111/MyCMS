<?php

namespace Engine;

use Engine\Helper\Common;

class Cms
{
    /**
     * var $di
     */
    private $di;

    public $router;

    /**
     * Cms Constructor.
     * @param $di
     */
    public function __construct($di)
    {
        $this -> di = $di;
        $this -> router = $this -> di -> get('router');
    }



    /**
     * Run CMS
     */
    public function run()
    {
        $this -> router -> add('home', '/', 'HomeController:index');
        $this -> router -> add('product', '/user/12', 'ProductController:index');

        $routerDispatch = $this -> router -> dispatch(Common::getMethod(), Common::getPathUrl());
        print_r($routerDispatch);
    }
}