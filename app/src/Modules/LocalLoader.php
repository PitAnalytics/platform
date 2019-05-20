<?php
//
namespace App\Modules;
//
use GuzzleHttp\HTTP\Client;
use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\Core\ExponentialBackoff;
//
use App\Interfaces\BigLoaderInterface;
//
class LocalLoader implements BigLoaderInterface{

    //clase de bigquery cliente
    private $bigQueryClient;

    //constructor privado
    public function __construct($projectId){

        try {
            
            $this->bigQueryClient = new BigQueryClient(['projectId'=>$projectId]);

        }

        catch(Exception $e){

            die($e);

        }

    }

    //cargamos el archivo de la tabla a migrar
    public function load($location,$file,$schema,$settings,$disposition){

        //tabla y dataset
        $dataset = $this->bigQueryClient->dataset($location['dataset']);
        $table = $dataset->table($location['table']);

        //creamos el trabajo de carga
        $loadJobConfig = $table->load(fopen($file['source'], 'r'))->sourceFormat($file['format']);

        //delimitador de campos entre columnas
        $loadJobConfig->fieldDelimiter($settings['delimiter']);
        $loadJobConfig->ignoreUnknownValues($settings['ignoreUnknowValues']);
        $loadJobConfig->quote($settings['quote']);
        $loadJobConfig->allowQuotedNewlines($settings['allowQuotedNewLines']);
        $loadJobConfig->allowJaggedRows($settings['allowJaggedRows']);
        $loadJobConfig->nullMarker($settings['nullMarker']);

        //creacion
        $loadJobConfig->writeDisposition($disposition['write']);
        $loadJobConfig->createDisposition($disposition['create']);


        //esquema siempre en minusculas
        $loadJobConfig->schema($schema);

        //trabajo de carga iniciado
        $job = $table->runJob($loadJobConfig);

        // poll the job until it is complete
        $backoff = new ExponentialBackoff(10);
        $backoff->execute(function () use ($job) {

            $job->reload();

            if (!$job->isComplete()) {

                throw new Exception('Job has not yet completed', 500);

            }

        });

        if (isset($job->info()['status']['errorResult'])) {

            $error = $job->info()['status']['errorResult']['message'];
            printf('Error running job: %s'.$error);

            return false;

        }

        else {

            return true;

        }

    }

    public function getType(){

        return $this->type;

    }

}

?>