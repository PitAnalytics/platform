<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface as Container;

abstract class Controller{

    protected $container;

    public abstract function __construct(Container $container);

}

?>