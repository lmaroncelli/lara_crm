@extends('layouts.lara_crm')

@section('content')

<div class="row">
    <div class="col-xl-12">

        <!--begin:: Widgets/Tasks -->
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Elenco clienti
                        </h3>
                    </div>
                </div>
            </div>
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
                                          <td>{{$cliente->categoria()}}</td>
                                          <td>{{$cliente->stato()}}</td>
                                          <td>{{$cliente->commerciali()}}</td>
                                      </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{ $clienti->links() }}
            
        </div>


        <!--end:: Widgets/Tasks -->
    </div>
   
</div>
@endsection
