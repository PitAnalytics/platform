<?php
namespace App\Modules;
use App\Primitives\DatabaseConnection as Connection;

abstract class Account extends Connection{

    public abstract function index();
    public abstract function update($request);
    
}

?>