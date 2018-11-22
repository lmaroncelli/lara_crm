<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClientiController extends Controller
{



    private function _getClienteEagerLoaded()
      {
      return Cliente::with([
            'localita',
            'associato_a_commerciali',
            'categoria',
            'localita.comune.provincia.regione',
            'contatti',
            'gruppo.clienti',
            ]);
      }


    /**
     * Display a listing of the resource.
     * Capacità di cercare e ordinare
     *
     * @return \Illuminate\Http\Response
     */  
    public function index(Request $request)
      {

       //dd($request->all());

        $q = $request->get('q');
        $order = $request->get('order');
        $orderby = $request->get('orderby');

        if(is_null($order))
          {
            $order='id_info';
          }

        if(is_null($orderby))
          {
            $orderby='asc';
          }

        $attivo_ia = $request->get('attivo_ia');
        $attivo = $request->get('attivo');


        $clienteEagerLoaded = $this->_getClienteEagerLoaded();
        $clienti = $clienteEagerLoaded;

        if($attivo_ia == 'on')
          {
          $clienti = $clienti->where('attivo_ia',1);
          }

        if($attivo == 'on')
          {
          $clienti = $clienti->where('attivo',1);
          }



        $clienti = $clienti->where(function ($query) use ($q) {
                        $query->where('nome','LIKE','%'.$q.'%')
                              ->orWhere('id_info','LIKE','%'.$q.'%');
                        })
                  ->orderBy($order, $orderby);
        
        
        $to_append = ['q' => $q, 'order' => $order, 'orderby' => $orderby];
       

        if($attivo_ia == 'on')
          {
          $to_append['attivo_ia'] = "on";
          }

         if($attivo == 'on')
          {
          $to_append['attivo'] = "on";
          }





        $clienti = $clienti->paginate(15)->setpath('')->appends($to_append);

      
        
        if($clienti->count())
          {
          return view('clienti.index', compact('clienti'));
          }
        else
          {
          return view('clienti.index')->withMessage('Nessun risultato trovato!');
          }

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
    public function edit(Cliente $cliente)
    {
     return view('clienti.form', compact('cliente'));   
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



    /**
     * [gestisciContattiAjax chiamata ajax quando faccio check su un contatto dal form del cliente]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function gestisciContattiAjax(Request $request)
      {
        $contatto_id = $request->get('contatto_id');
        $cliente_id = $request->get('cliente_id');
        
        $cliente = Cliente::find($cliente_id); 

        $cliente->contatti()->toggle([$contatto_id]);

        echo 'ok';

      }
    
}
