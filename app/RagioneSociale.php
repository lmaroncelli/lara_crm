<?php

namespace App;

use App\Localita;
use App\Societa;
use Illuminate\Database\Eloquent\Model;

class RagioneSociale extends Model
{
   protected $table = 'tblRagioneSociale';

   protected $guarded = ['id'];



   public function societa()
   {
       return $this->hasMany(Societa::class, 'ragionesociale_id', 'id');
   }


   public function localita()
    {
        return $this->belongsTo(Localita::class, 'localita_id', 'id');
    }

   

}
