<?php

//mandamos llamar modulos e interfaz de esquema
namespace App\Dependencies;

class Schema{

    //ruta para esquemas
    private $path;

    //constructor con ruta a esquemas
    public function __construct($path){

        //creamos ruta general para esuqemas
        $this->path=$path;

    }

    //obtenemos esquema como array a partir de un nombre simple
    public function getSchema($schema){

        //concatenamos camino a esquemas
        $jsonFile=file_get_contents($this->path.'/'.$schema.'.json');
        $schema=json_decode($jsonFile,true);
        return $schema;

    }

}

?>