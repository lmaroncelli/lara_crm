@extends('layouts.lara_crm')

@section('content')

<div class="row">
    <div class="col-xl-12 sezioni-cliente">

        <!--begin:: Widgets/Tasks -->
        <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
         
            @include('menu_sezioni_clienti') 

            <div class="m-portlet__body">
            </div>
                 
        </div>
    </div>
</div>

@endsection


@section('js')
  
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
                 
        });
    

    </script>
@endsection