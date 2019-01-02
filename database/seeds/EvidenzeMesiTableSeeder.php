<?php

use Illuminate\Database\Seeder;

class EvidenzeMesiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	$tblEVEvidenzeMesi  =  DB::connection('old')
        	                ->table('ev_evidenze_mese')
        	                ->select(DB::raw('id, id_tipo_evidenza as tipoevidenza_id'))
        	                ->get();

        	$tblEVEvidenzeMesi = collect($tblEVEvidenzeMesi)->map(function($x){ return (array) $x; })->toArray(); 

        	DB::connection('mysql')->table('tblEVEvidenzeMesi')->truncate();
        	
        	foreach ($tblEVEvidenzeMesi as $evidenza) 
        		{
                DB::connection('mysql')->table('tblEVEvidenzeMesi')->insert($evidenza);
        		}
    }
}
