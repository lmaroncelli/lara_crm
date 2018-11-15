@extends('layouts.lara_crm')

@section('content')

<div class="row">
    <div class="col-xl-12">

        <!--begin:: Widgets/Tasks -->
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text" style="width: 200px;">
                            Elenco clienti &nbsp;&nbsp; @if (isset($clienti)) <span class="m-badge m-badge--success m-badge--wide">{{$clienti->total()}}@endif</span>
                        </h3>
                    </div>
                </div>
            </div>
                <form action="{{ url('cerca-clienti') }}" method="get" id="searchForm" accept-charset="utf-8">
                <div class="row">
                    <div class="col-lg-6" style="padding-left: 40px; padding-top: 20px">
                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                            <input type="text" name="q" value="{{\Request::get('q')}}" class="form-control m-input m-input--pill m-input--air" placeholder="Cerca per nome o ID">
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class="la la-user"></i>
                                </span>
                            </span>
                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                <span>
                                    <i class="la la-search"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding-top: 20px">
                        <span class="label">Solo attivi</span>
                        <input data-switch="true" type="checkbox" name="attivo" @if ( \Request::get('attivo') ) checked="checked" @endif  data-on-color="success" data-off-color="danger" data-on-text="Sì" data-off-text="No">
                        <span class="label">Solo attivi IA</span>
                        <input data-switch="true" type="checkbox" name="attivo_ia" @if ( \Request::get('attivo_ia') ) checked="checked" @endif data-on-color="success" data-off-color="danger" data-on-text="Sì" data-off-text="No">
                    </div>
                </div>
                </form>

            @if (isset($clienti))
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table table-striped m-table m-table--head-bg-success">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Località</th>
                                        <th>Categoria</th>
                                        <th>Stato</th>
                                        <th>Commerciale</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clienti as $cliente)
                                      <tr>
                                          <th scope="row">{{$cliente->id_info}}</th>
                                          <td> <a href="{{ route('clienti.edit',['id' => $cliente->id]) }}" title="Modifica cliente">{{$cliente->nome}}</a></td>
                                          <td>{{optional($cliente->localita)->nome}}</td>
                                          <td>{{optional($cliente->categoria)->categoria}}</td>
                                          <td>{{$cliente->stato()}}</td>
                                          <td>{{$cliente->commerciali()}}</td>
                                      </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $clienti->links() }}
            </div>
            @else
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="m-section">
                            <div class="m-section__content">
                                {!! $message !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>


        <!--end:: Widgets/Tasks -->
    </div>
   
</div>
@endsection


@section('js')
    <script src="{{ asset('js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
            $(".la-search").click(function(){
                $("#searchForm").submit();
            });


          
        });
    

    </script>
@endsection