<?php

namespace App\Dependencies;

use GuzzleHttp\HTTP\Client;
use Google\Cloud\BigQuery\BigQueryClient;

class BigQuery{

    //clase de bigquery cliente
    private $bigQueryClient;

    //constructor con clase anidada
    public function __construct($config){

        $this->bigQueryClient = new BigQueryClient($config);

    }

    //query general con arreglo como resultado
    public function query($dml){

        try{
            
            $query = $this->bigQueryClient->query($dml);
            $queryResults = $this->bigQueryClient->runQuery($query);
            $response=[];
            
            if ($queryResults->isComplete()) {

                $response['rows']=$queryResults->rows();
                $response['info']=$queryResults->info();
                $response['identity']=$queryResults->identity();

                return $response;

            }

        }

        catch(Exception $e){

            die($e);

            return [];

        }

    }



}

?>