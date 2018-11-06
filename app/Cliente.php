<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   protected $table = 'tblClienti';

   protected $guarded = ['id'];


   public function visibile_a_commerciali()
    {
        return $this->belongsToMany('App\User', 'tblClienteVisibileCommerciale', 'cliente_id', 'user_id');
    }

   public function associato_a_commerciali()
    {
        return $this->belongsToMany('App\User', 'tblClienteAssociatoCommerciale', 'cliente_id', 'user_id');
    }

}
