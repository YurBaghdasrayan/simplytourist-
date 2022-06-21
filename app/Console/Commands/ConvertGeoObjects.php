<?php

namespace App\Console\Commands;

use App\Models\GeoObject;
use App\Models\Languages;
use Carbon\Language;
use Illuminate\Console\Command;

class ConvertGeoObjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geojson:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert data from imported';

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
        $cords=GeoObject::whereNull('coordinates')->get();
        foreach ($cords as $cord){
//            Country to country_iso
//            if($cord->countries){
//                $iso=false;
//                echo $cord->countries."\n";
//                $iso=Languages::getCountryIso($cord->countries);
//                if($iso){
//                    $cord->update(['country_iso'=>strtolower($iso)]);
//                }
//            }
////            Country to coordinates
            if($cord->countries){
                if($cord->longitude){
                    echo $cord->countries." ".$cord->latitude.",".$cord->longitude."\n";
                    $cord->update(['coordinates'=>$cord->latitude.','.$cord->longitude]);
                }
            }
        }
    }
}
