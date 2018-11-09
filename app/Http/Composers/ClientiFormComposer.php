<?php


namespace App\Http\Composers;


use App\TipologiaCliente;
use Illuminate\Contracts\View\View;


/**
 * summary
 */
class ClientiFormComposer
{
    public function compose(View $view)
    	{

    	$tipi_cliente = TipologiaCliente::pluck('nome','id')->toArray(); 
    	$view->with(compact('tipi_cliente'));
    	}
}