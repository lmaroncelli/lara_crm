<?php

namespace App;

use App\Fattura;
use Illuminate\Database\Eloquent\Model;

class RigaDiFatturazione extends Model
{
   protected $table = 'tblRigheFatturazione';

   protected $guarded = ['id'];


   public function fattura()
   {
       return $this->belongsTo(Fattura::class, 'fattura_id', 'id');
   }

   

}
