<?php

namespace App;

use App\CategoriaCliente;
use App\Contatto;
use App\GruppoCliente;
use App\Localita;
use App\TipologiaCliente;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   protected $table = 'tblClienti';

   protected $guarded = ['id'];


   /**
        * The attributes that should be mutated to dates.
        *
        * @var array
        */
       protected $dates = [
           'created_at',
           'updated_at',
           'deleted_at',
           'data_attivazione',
          'data_attivazione_IA',
          'data_disattivazione',
          'data_disattivazione_IA'
       ];


   public function visibile_a_commerciali()
    {
        return $this->belongsToMany('App\User', 'tblClienteVisibileCommerciale', 'cliente_id', 'user_id');
    }

   public function associato_a_commerciali()
    {
        return $this->belongsToMany('App\User', 'tblClienteAssociatoCommerciale', 'cliente_id', 'user_id');
    }

  public function commercialiAssociatiIds()
    {
        return $this->associato_a_commerciali->pluck('id')->toArray();
    }

  public function commercialiVisibilitaIds()
    {
        return $this->visibile_a_commerciali->pluck('id')->toArray();
    }

    public function gruppo()
    {
        return $this->belongsTo(GruppoCliente::class, 'gruppo_id', 'id');
    }

    public function localita()
    {
        return $this->belongsTo(Localita::class, 'localita_id', 'id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipologiaCliente::class, 'tipo_id', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaCliente::class, 'categoria_id', 'id');
    }

    public function contatti()
    {
        return $this->belongsToMany(Contatto::class, 'tblClienteContatto', 'cliente_id', 'contatto_id');
    }


    public function scopeAttivo($query)
     {
         return $query->where('attivo',1);
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
