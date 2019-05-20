<?php
namespace App\Modules;
use App\Primitives\DatabaseConnection as Connection;

class Cicle extends Connection{

    public function index(){

        $cicles = $this->database->select('Ciclos',['Id','Anualidad','Mes']);

        return $cicles;

    }
    
}

?>