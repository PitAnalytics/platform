<?php

namespace App\Subsystems;

class Loader{

    private static $INSTANCE;

    /************************************/

    //camino al pool de tablas
    private $pool='/home/loader';

    //variable para uso unico
    private $available=true;

    //esquema para 
    private $files;
    private $location=['dataset'=>'MULTIVA','table'=>'BSEGAIO'];
    private $disposition=['create'=>'CREATE_NEVER','write'=>'WRITE_APPEND'];
    private $settings=['delimiter'=>'|','quote'=>'"','ignoreUnknowValues'=>true,'allowQuotedNewLines'=>false,'allowJaggedRows'=>false,'nullMarker'=>'\N'];
    private $file=['format'=>'CSV'];

    //dependencias modulares
    private $bigLoader;
    private $fileManager;
    private $history;

    public static function INSTANCIATE($bigLoader,$fileManager,$history){

        if (!self::$INSTANCE instanceof self){

            self::$INSTANCE = new self($bigLoader,$fileManager,$history);
   
        }
        
        return self::$INSTANCE;

    }

    //inyectamos dependencia de BigQuery Loader
    private function __construct($bigLoader,$fileManager,$history){

        $this->bigLoader=$bigLoader;
        $this->fileManager=$fileManager;
        $this->history=$history;

    }

    public function available(){

        return $this->available;

    }

    public function getHistory(){

        return $this->history->index();

    }

    public function load($type,$society,$date){

        $this->available=false;

        //
        $this->file['source']=$type.'-'.$society.'-'.$date;

        
        print_r(scandir($this->pool.'/'.$type));

        //
        if($this->history->exists($type,$society,$date)||!file_exists($this->pool.'/'.$type.'/'.$this->file['source'])){

            return false;

        }
        else{

            $this->schema = $this->fileManager->getSchema($type);
            print_r($this->schema);
            $this->available=true;
            return true;

        }

    }

}


?>