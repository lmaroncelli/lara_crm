<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\RagioneSociale;
use App\Societa;
use Illuminate\Http\Request;

class ClientiFatturazioniController extends Controller
{
	public function index($cliente_id)
		{
		$cliente = Cliente::with(['societa.ragioneSociale'])->find($cliente_id);

		////////////////////////////////////////////////////////////
		// definire gli id delle società del cliente da escludere //
		// e passarli alla funzione getListForSelectModal()				//
		////////////////////////////////////////////////////////////
		
		$societa_ids =  $cliente->societa->pluck('id')->toArray();		

		$ragioneSociale = RagioneSociale::getListForSelectModal($societa_ids);

		return view('clienti-fatturazioni.index', compact('cliente','ragioneSociale'));
		}


	public function associaSocietaAjax(Request $request)
		{
		$cliente_id = $request->get('cliente_id');
		$societa_id = $request->get('societa_id');

		$societa = Societa::find($societa_id);

		$societa->cliente_id = $cliente_id;
		
		$societa->save();

		echo "ok";


		}


	public function edit($societa_id)
		{
		$societa = Societa::with(['ragioneSociale', 'cliente'])->find($societa_id);
		}
}
