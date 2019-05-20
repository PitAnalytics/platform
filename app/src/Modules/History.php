<?php

namespace App\Modules;

class History {

    private static $INSTANCE;
    private $database;

    public function __construct($database){

        $this->database=$database;

    }

    public function index(){

        $table = $this->database->select(
            'Uploads',
            ['id','type','society','date']
        );

        return $table;

    }

    public function exists($type,$society,$date){

        return false;

    }
    
}


?>