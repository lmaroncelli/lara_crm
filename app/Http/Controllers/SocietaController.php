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

       $orderby = $request->get('orderby');
       $order = $request->get('order');


       if(is_null($order))
        {
          $order='asc';
        }

      if(is_null($orderby))
        {
          $orderby='id';
        }
      
      $to_append = ['order' => $order, 'orderby' => $orderby];



      $societa = Societa::with(['ragioneSociale','cliente']); 



      if ($orderby == 'nome_rag') 
        {
        $societa = $societa
                    ->join('tblRagioneSociale', 'tblSocieta.ragionesociale_id', '=', 'tblRagioneSociale.id')
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
