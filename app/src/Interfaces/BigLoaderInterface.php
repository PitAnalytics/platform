<?php

namespace App\Interfaces;

interface BigLoaderInterface{

    public function load($location,$file,$schema,$settings,$disposition);
    
}

?>