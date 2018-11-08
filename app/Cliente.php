<?php

namespace App;

use App\GruppoCliente;
use App\Localita;
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

    public function gruppo()
    {
        return $this->belongsTo(GruppoCliente::class, 'gruppo_id', 'id');
    }

    public function Localita()
    {
        return $this->belongsTo(Localita::class, 'localita_id', 'id');
    }


    public function scopeAttivo($query)
     {
         return $query->where('attivo',1);
     }



    public function categoria()
     {
        if ($this->categoria_id == 0) 
          {
          return "";
          } 
        else 
          {
          if ($this->categoria_id == 1) 
            {
            return "1 stella";
            } 
          else 
            {
            return $this->categoria_id . " stelle";

            }
          }
        return ucfirst($value);
     }


    public function stato()
      {
      if ($this->attivo) 
        {
        return "Sì";
        } 
      else 
        {
        return "No";
        }
      }


    /**
     * [commerciali scrive i nomi dei commerciali ASSOCIATI a questo cliente ]
     * @return [type] [description]
     */
    public function commerciali()
      {

      $comm = [];

      foreach ($this->associato_a_commerciali as $c) 
        {
        $comm[] = $c->name;
        }
      
      return implode(', ',$comm);

      }
      

}
