<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClientiFatturazioniController extends Controller
{
	public function index($cliente_id)
		{
		$cliente = Cliente::find($cliente_id);

		return view('clienti-fatturazioni.index', compact('cliente'));
		}
}
