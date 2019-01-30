<?php


namespace App\Http\Composers;


use App\Localita;
use Illuminate\Contracts\View\View;


/**
 * summary
 */
class SocietaFormComposer
{
    public function compose(View $view)
    	{

    
    	$localita = Localita::pluck('nome','id')->toArray(); 
  
    	$view->with(compact('localita'));
    	}
}