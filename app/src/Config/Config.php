<?php

namespace App\Config;

class Config{

    private $config;

    public function __construct($path){

        $jsonConfig=file_get_contents($path);
        $this->config=json_decode($jsonConfig,true);

    }

    public function database(){

        return $this->config['database'];

    }

    public function app(){

        return $this->config['app'];

    }

    public function pool(){

        

    }
    
}

?>