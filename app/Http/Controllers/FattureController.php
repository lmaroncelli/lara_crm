<?php

namespace App\Http\Controllers;

use App\Fattura;
use App\RigaDiFatturazione;
use App\Utility;
use Illuminate\Http\Request;

class FattureController extends Controller
{


    private function _validate_riga_fatturazione(Request $request)
      {
        $validatedData = $request->validate([
               'servizio' => 'required',
               'qta' => 'required|numeric',
               'prezzo' => 'required|numeric',
               'totale_netto' => 'required|numeric',
               'al_iva' => 'required|numeric',
               'iva' => 'required|numeric',
               'totale' => 'required|numeric',
           ]);
      }


    private function _ricalcola_dati_riga(&$dati_riga)
      {
      $totale_netto = $dati_riga['qta']*$dati_riga['prezzo'];
      $iva = $totale_netto*$dati_riga['al_iva']/100;
      $totale = $totale_netto + $iva;
      
      $dati_riga['totale_netto'] = $totale_netto;
      $dati_riga['iva'] = $iva;
      $dati_riga['totale'] = $totale;

      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tipo_id = 'F')
    {
        $fattura = new Fattura;
        return view('fatture.create', compact('fattura'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
             'societa' => 'required',
             'societa_id' => 'required|integer',
             'numero' => 'required',
             'data' => 'required|date_format:"d/m/Y"'
         ]);

      $fattura = Fattura::create($request->except(['data','numero']));
      $fattura->data = Utility::getCarbonDate($request->get('data'));
      
      if ($request->get('tipo_id') == 'PF') 
        {
        $fattura->numero_prefattura = $request->get('numero');
        } 
      else 
        {
        $fattura->numero_fattura = $request->get('numero');
        }

      $fattura->save();
      return redirect('fatture/'.$fattura->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $rigafattura_id = null)
    {
    $fattura = Fattura::with([
                          'righe',
                          'scadenze',
                          'societa.RagioneSociale.localita.comune.provincia',
                          'societa.cliente.servizi_non_fatturati',
                        ])->find($id);

    if(!is_null($rigafattura_id))
      {
      $riga_fattura = RigaDiFatturazione::find($rigafattura_id);
      }
    else
      {
      $riga_fattura = null;
      }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // SE NON SONO UNA 'NC'
    // con l'id della societa voglio trovare tutti i servizi NON FATTURATI associati al cliente di questa societa //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    ///////////////////////////////////////////////////////////////////////////////////////
    // riesco a caricarle come rigediFatturazione prendendo il prezzo dai precontratti?? //
    ///////////////////////////////////////////////////////////////////////////////////////

    $servizio_prefill_arr = [];


    if(is_null($riga_fattura))
      {
      if($fattura->societa->cliente->servizi_non_fatturati->count())
        {
        foreach ($fattura->societa->cliente->servizi_non_fatturati as $servizio) 
          {
          $val =  $servizio->prodotto->nome . ': dal '. $servizio->data_inizio->format('d/m/Y'). ' al '. $servizio->data_fine->format('d/m/Y');
          if($servizio->note != '')
            {
            $val .= ' - ' .$servizio->note;
            }
          $servizio_prefill_arr[] =  $val;

          }
        }
      }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // SE NON SONO UNA 'NC'
    // con l'id della societa voglio trovare tutte le scadenze non pagate risalenti a prefatture di questa società //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $societa = $fattura->societa;

    if(!is_null($societa))
    {
    $prefatture_ids = $societa->prefatture->pluck('id')->toArray();
    }

    $prefatture_da_associare = Fattura::with('pagamento')
                                ->whereHas(
                                    'scadenze' , function($q) {
                                      $q->where('pagata',0);
                                    }
                                )
                                ->whereIn('id', $prefatture_ids)
                                ->get();


      dd($prefatture_da_associare);





    
    return view('fatture.form', compact('fattura','riga_fattura', 'servizio_prefill_arr'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    // visualizza le ultime fatture di un tipo
    public function lastFattureAjax(Request $request)
      {
        $tipo_id = $request->get('tipo_id');
        $last_fatture = Fattura::getLastNumber($tipo_id);

        echo view('fatture._numeri_fatture', compact('last_fatture'));
      }


      // aggiunge la riga alla fattura
      public function addRiga(Request $request)
        {
        
        $this->_validate_riga_fatturazione($request);

        $fattura_id = $request->get('fattura_id');

        $dati_riga = $request->all();
        
        $this->_ricalcola_dati_riga($dati_riga);

        $riga_fattura = RigaDiFatturazione::create($dati_riga);

        Fattura::find($fattura_id)->righe()->save($riga_fattura);

        return redirect('fatture/'.$fattura_id.'/edit');

        }


    // carica riga di fatturazione x modifica 
    public function loadRiga(Request $request, $rigafattura_id)
      {

      $riga_fattura = RigaDiFatturazione::find($rigafattura_id);

      $fattura_id = $riga_fattura->fattura_id;

      return redirect('fatture/'.$fattura_id.'/edit/'.$rigafattura_id);

      }


    // update riga di fatturazione
    public function updateRiga(Request $request, $rigafattura_id)
      {

      $this->_validate_riga_fatturazione($request);
      
      $riga_fattura = RigaDiFatturazione::find($rigafattura_id);
      $fattura_id = $riga_fattura->fattura_id;
     
      $dati_riga = $request->all();
      $this->_ricalcola_dati_riga($dati_riga);

      $riga_fattura->update($dati_riga);

      return redirect('fatture/'.$fattura_id.'/edit');

      }


    public function deleteRiga(Request $request, $rigafattura_id)
      {
      $riga_fattura = RigaDiFatturazione::find($rigafattura_id);
      $fattura_id = $riga_fattura->fattura_id;
      $riga_fattura->delete();
       return redirect('fatture/'.$fattura_id.'/edit');
      }


    public function addNote(Request $request)
      {
      $fattura_id = $request->get('fattura_id');

      $fattura = Fattura::find($fattura_id);
      $fattura->note = $request->get('note');

      $fattura->save();

      return redirect('fatture/'.$fattura_id.'/edit');
      }



}
