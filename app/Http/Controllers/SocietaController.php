<?php

namespace App\Http\Controllers;

use App\Societa;
use Illuminate\Http\Request;

class SocietaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
      {

      // campo libero
      $qf = $request->get('qf');
      $field = $request->get('field');

      $orderby = $request->get('orderby');
      $order = $request->get('order');

      $societa = Societa::with(['ragioneSociale','cliente']); 


      $join_rag_soc = 0;

       //////////////////////////////////////
       // Ricerca campo libero del cliente //
       //////////////////////////////////////

      // se ho inserito un valore da cercare ed ho selzionato un campo
      if( !is_null($qf) && $field != '0' )
        {
        if (in_array($field, ['nome','localita','indirizzo','cap','piva','cf'])) 
          {

          if($field == 'localita')
            {
            $societa = $societa
                    ->select('tblSocieta.*')
                    ->join('tblRagioneSociale', 'tblSocieta.ragionesociale_id', '=', 'tblRagioneSociale.id')
                    ->join('tblLocalita', 'tblRagioneSociale.localita_id', '=', 'tblLocalita.id')
                    ->where('tblLocalita.nome','LIKE','%'.$qf.'%');
                
            }
          else
            {
            $societa = $societa
                      ->select('tblSocieta.*')
                      ->join('tblRagioneSociale', 'tblSocieta.ragionesociale_id', '=', 'tblRagioneSociale.id')
                      ->where('tblRagioneSociale.'.$field,'LIKE','%'.$qf.'%');
            }

          $join_rag_soc = 1;
          }
        }







       if(is_null($order))
        {
          $order='asc';
        }

      if(is_null($orderby))
        {
          $orderby='id';
        }
      
      $to_append = ['order' => $order, 'orderby' => $orderby];






      if ($orderby == 'nome_rag') 
        {
        if(!$join_rag_soc)
        {
        $societa = $societa
                ->select('tblSocieta.*')
                ->join('tblRagioneSociale', 'tblSocieta.ragionesociale_id', '=', 'tblRagioneSociale.id');
        }

        $societa = $societa
                ->orderBy('tblRagioneSociale.nome', $order);
        }

      if ($orderby == 'nome_cliente' || $orderby == 'id_info')
          {
          $societa = $societa
                    ->join('tblClienti', 'tblSocieta.cliente_id', '=', 'tblClienti.id');
          

          if($orderby == 'nome_cliente') 
            {
            $societa = $societa
                    ->orderBy('tblClienti.nome', $order);
            }
          else
            {
            $societa = $societa
                    ->orderBy('tblClienti.id_info', $order);
            }
          }

      
      $societa = $societa
                  ->paginate(15)->setpath('')->appends($to_append);

      //dd($societa);
       return view('societa.index', compact('societa'));

      }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
}
