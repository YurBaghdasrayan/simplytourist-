<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeoJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geojson:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import geojson data from import.json in storage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * GeoJSON to MySQL importer
         *
         * @todo Don't rely on a database connection to MySQL for escaping
         *
         * @usage php import.php --table district_shapes --keys state_code,district --dir /home/tmp/districts --insert
         */


        define('DB_HOST', env('DB_HOST'));
        define('DB_USER', env('DB_USERNAME'));
        define('DB_PASS', env('DB_PASSWORD'));
        define('DB_NAME', env('DB_DATABASE'));
        define('DB_TABLE', 'geo_objects');
        define('DB_COLUMNS', ['continent','countries','regions','latitude','longitude','name']);
        define('IMPORT_PATH', storage_path('import'));
        define('DO_INSERT','insert');

        /**
         * @param $mysqli
         * @param $json
         */
        function createInsert($mysqli, $json) {
            // Make sure we have a MySQL Connection
            if ($mysqli) {
                $data = array();

                foreach(DB_COLUMNS as $keyName){
                    $value = (isset($json['properties'][$keyName])) ? $json['properties'][$keyName] : '';
                    if (is_array(($value))) {
                        $value = json_encode($value,true);
                    }
                    $data[] = $mysqli->real_escape_string($value);
                }
                $columns = '`' . implode('`,`', DB_COLUMNS) . '`';
                $values = '"' . implode('","', $data) . '"';
                //$values .= ", ST_GeomFromGeoJSON('".$mysqli->real_escape_string(json_encode($json))."')";

                $query = "INSERT INTO `" . DB_TABLE . "` ({$columns}) VALUES ({$values}); \r\n";
                // Fix some Data Type Issues
                $query = str_replace('""', 'null', $query);
                $query = preg_replace('/"(\d+)"/i', '$1', $query);

                if(DO_INSERT){
                    if ($mysqli->query($query)) {
                        $message = array();
                        foreach(DB_COLUMNS as $keyName){
                            $message[] = " for key '{$keyName}'";
                        }

                        echo "✓ Added entry " . join(', ', $message) . PHP_EOL;
                    } else {
                        printf("× %s\n", $mysqli->error);
                    }
                } else {
                    echo $query;
                }
            } else {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
        }

        // Must create a connection to MySQL so real_escape_string works
        // @todo don't rely on MySQL connection
        $mysqli = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        foreach (glob(IMPORT_PATH . "/*.geojson") as $filePath) {

            $geojson = file_get_contents($filePath);
            $json = json_decode($geojson, true);

            // Check if GeoJSON is Feature or FeatureCollection
            if ($json['type'] === 'FeatureCollection') {
                foreach($json['features'] as $feature){
                    createInsert($mysqli, $feature);
                }
            } else if ($json['type'] === 'Feature') {
                createInsert($mysqli, $json);
            } else {
                exit('Invalid GeoJSON');
            }
        }

        /* Close Connection */
        $mysqli->close();
    }
}
