<?php

namespace App;

use App\Fattura;
use Illuminate\Database\Eloquent\Model;

class ScadenzaFattura extends Model
{
   protected $table = 'tblScadenzeFattura';

   protected $guarded = ['id'];



   public function fattura()
   {
       return $this->belongsTo(Fattura::class, 'fattura_id', 'id');
   }
   

}
