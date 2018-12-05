<?php


namespace App\Http\Composers;

use Illuminate\Contracts\View\View;


/**
 * summary
 */
class FattureIndexComposer
{
    public function compose(View $view)
    	{
    	       //////////////////////////////////////////////////////////
                // campi esposti nella select di ricerca elenco clienti //
                //////////////////////////////////////////////////////////
                $campi_fattura_search = [];
                $campi_fattura_search['numero_fattura'] = 'numero fattura';
                $campi_fattura_search['data'] = 'data';
                $campi_fattura_search['pagamento'] = 'pagamento';
                $campi_fattura_search['societa'] = 'societa';
                $campi_fattura_search['cliente'] = 'cliente';
                $campi_fattura_search['note'] = 'note';
                $campi_fattura_search['0'] = 'campo in cui cercare';

                asort($campi_fattura_search);
                $view->with(compact('campi_fattura_search'));
    	}
}