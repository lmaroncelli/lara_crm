<?php

namespace App;


use App\Provincia;
use Illuminate\Database\Eloquent\Model;

class Regione extends Model
{
   protected $table = 'tblProvince';

   protected $guarded = ['id'];

   public function province()
   {
       return $this->hasMany(Provincia::class, 'regione_id', 'id');
   }

}
