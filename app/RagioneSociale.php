<?php

namespace App;

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

   

}
