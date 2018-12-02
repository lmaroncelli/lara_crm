<?php

namespace App;

use App\Pagamento;
use App\RigaDiFatturazione;
use App\Societa;
use Illuminate\Database\Eloquent\Model;

class Fattura extends Model
{
   protected $table = 'tblFatture';

   protected $fillable = ['tipo_id','numero_fattura','numero_prefattura','data','societa_id'];

   protected $dates = [
       'created_at',
       'updated_at',
        'data',
   ];


   public function righe()
   {
       return $this->hasMany(RigaDiFatturazione::class, 'fattura_id', 'id');
   }


   public function scadenze()
   {
       return $this->hasMany(ScadenzaFattura::class, 'fattura_id', 'id');
   }


   public function societa()
   {
       return $this->belongsTo(Societa::class, 'societa_id', 'id');
   }

   public function pagamento()
   {
       return $this->belongsTo(Pagamento::class, 'pagamento_id', 'cod');
   }


   public function servizi()
   {
       return $this->hasMany(Servizio::class, 'fattura_id', 'id');
   }



   /**
      * Override parent boot and Call deleting event
      *
      * @return void
      */
      protected static function boot() 
       {
         parent::boot();

         static::deleting(function($fattura) {
            foreach ($fattura->servizi as $servizio) {
               $servizio->fattura_id = NULL;
               $servizio->rigafatturazione_id = NULL;
               $servizio->save();
            }
         });
       }



   public function getTotale()
    {
    $totale = 0;
    foreach (self::righe()->get() as $r) 
      {
      $totale += $r->totale;
      }
    return $totale;
    }


   public function scopeTipo($query, $tipo_id)
     {
        return $query->where('tipo_id', $tipo_id);
     }


  public static function getLastNumber($tipo_id = 'F', $limit = 10)
    {
    $fatture_last = self::where('tipo_id', $tipo_id)->orderBy('data','desc')->limit($limit)->get();

    return $fatture_last;
    }




}
