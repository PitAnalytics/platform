<?php

namespace App\Modules;
use App\Primitives\DatabaseConnection as Connection;

class History extends Connection{

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