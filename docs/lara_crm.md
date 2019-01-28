# Installazione

> composer create-project --prefer-dist laravel/laravel lara_crm


# setup

> php artisan make:auth
Authentication scaffolding generated successfully.




# gitHub

git init

git add --all .

git commit -m "first commit"

 git remote add origin https://github.com/lmaroncelli/lara_crm.git

 git push -u origin master


 To grab a complete copy of another user's repository, use git clone like this:

$ git clone https://github.com/lmaroncelli/lara_crm.git
# Clones a repository to your computer





#Composer per fare il bind di dati a delle view senza ripetere codice

1. php artisan make:provider ViewComposerProvider

    creo un provider per le view

    nel metodo register associo alla view il compser (la classe) che crea i dati ogni volta che la view viene chiamata

2.view()->composer('clienti.form','App\Http\Composers\ClientiFormComposer');


3. nella cartella App\Http\Composers (la folder Composer la creo io dove voglio e con il nome che voglio) creo la classe ClientiFormComposer 

che avrà il namespace

che deve avere il metodo compose(View $view)


<?php


namespace App\Http\Composers;


use Illuminate\Contracts\View\View;


/**
 * summary
 */
class ClientiFormComposer
{
    public function compose(View $view)
    	{

    	
    	$view->with(compact('tipi_cliente'));
    	}
}





4. in config/app.php nell'array providers aggiungo la riga

    App\Providers\ViewComposerProvider::class,

    che definisce la classe da caricare automaticamente nel SericeContainer



#Implementare la ricerca con paginazione

> https://www.youtube.com/watch?v=3PeF9UvoSsk




#FATTURAZIONE (vecchio CRM)


- per prima cosa seleziono il tipo di documento: prefattura, fattura, nota di credito, clona

PERCHE' ?

- l'unica cosa che ricavo dal tipo fattura sono le ultime fatture inserite di quel tipo

  

