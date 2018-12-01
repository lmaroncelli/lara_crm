<?php

namespace App;

use App\Cliente;
use App\Prodotto;
use Illuminate\Database\Eloquent\Model;

class Servizio extends Model
{
   protected $table = 'tblServizi';

   protected $guarded = ['id'];

   protected $dates = [
       'created_at',
       'updated_at',
        'data_inizio',
        'data_fine'
   ];


   public function prodotto()
   {
       return $this->belongsTo(Prodotto::class, 'prodotto_id', 'id');
   }


   public function cliente()
   {
       return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
   }

   

}
