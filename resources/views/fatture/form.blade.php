@extends('layouts.lara_crm')

@section('content')

<div class="m-content">
<div class="row">
    <div class="col-xl-12">
        
        <div class="m-portlet">
            <div class="m-portlet__body m-portlet__body--no-padding">
                
                <div class="m-invoice-2">
                    <div class="m-invoice__wrapper">
                        {{-- intestazione fattura --}}
                        <div class="m-invoice__head" style="background-image: url(../../assets/app/media/img//logos/bg-6.jpg);">
                            <div class="m-invoice__container m-invoice__container--centered">
                                <div class="m-invoice__logo">
                                    <a href="#">
                                        <h1>{{ App\Utility::getNomeTipoFattura($fattura->tipo_id) }}</h1>
                                    </a>
                                    <a href="#">
                                        <img src="../../assets/app/media/img//logos/logo_client_color.png">
                                    </a>
                                </div>
                                <span class="m-invoice__desc">
                                    <span>Info ALberghi srl</span>
                                    <span>Via Gambalunga, 81/A</span>
                                </span>
                                <div class="m-invoice__items">
                                    <div class="m-invoice__item">
                                        <span class="m-invoice__subtitle">DATA</span>
                                        <span class="m-invoice__text">Dec 12, 2017</span>
                                    </div>
                                    <div class="m-invoice__item">
                                        <span class="m-invoice__subtitle">INVOICE NO.</span>
                                        <span class="m-invoice__text">GS 000014</span>
                                    </div>
                                    <div class="m-invoice__item">
                                        <span class="m-invoice__subtitle">{{ App\Utility::getNomeTipoFattura($fattura->tipo_id) }} per </span>
                                        <span class="m-invoice__text">{{optional(optional($fattura->societa)->ragioneSociale)->nome}}
                                            <br>{{optional(optional($fattura->societa)->ragioneSociale)->indirizzo}} - {{optional(optional($fattura->societa)->ragioneSociale)->cap}} - {{optional(optional(optional($fattura->societa)->ragioneSociale)->localita)->nome}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- body fattura --}}
                        <div class="m-invoice__body m-invoice__body--centered">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>DESCRIPTION</th>
                                            <th>HOURS</th>
                                            <th>RATE</th>
                                            <th>AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Creative Design</td>
                                            <td>80</td>
                                            <td>$40.00</td>
                                            <td class="m--font-danger">$3200.00</td>
                                        </tr>
                                        <tr>
                                            <td>Front-End Development</td>
                                            <td>120</td>
                                            <td>$40.00</td>
                                            <td class="m--font-danger">$4800.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- footer fattura --}}
                        <div class="m-invoice__footer">
                            <div class="m-invoice__table  m-invoice__table--centered table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>BANK</th>
                                            <th>ACC.NO.</th>
                                            <th>DUE DATE</th>
                                            <th>TOTAL AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>BARCLAYS UK</td>
                                            <td>12345678909</td>
                                            <td>Jan 07, 2018</td>
                                            <td class="m--font-danger">20,600.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> {{--  \wrapper --}}
                </div> {{-- "m-invoice-2 --}} 

                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" role="form" action="{{ route('fatture.store') }}" method="POST" enctype="multipart/form-data">            
                    {!! csrf_field() !!}
                    <input type="hidden" name="societa_id" id="societa_id" value="{{old('societa_id')}}">
             
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-success">
                                        @if ($fattura->exists)
                                            Modifica
                                        @else
                                            Crea
                                        @endif
                                    </button>
                                    <button type="reset"  title="Annulla" class="btn btn-secondary">Annulla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> {{-- m-portlet__body --}}
        </div>{{-- m-portlet --}}
    
    </div>{{-- col --}}       
</div>{{-- row --}}
</div>{{-- content --}}

{{-- MODAL elenco societa --}}
<div class="modal fade" id="m_modal_contatti" tabindex="-1" role="dialog" aria-labelledby="societa" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="societa">Elenco Società</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="m-scrollable m-scrollable--track m-scroller ps ps--active-y" data-scrollable="true" style="height: 400px; overflow: hidden;">
                <table class="table table-striped m-table m-table--head-bg-success">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cliente</th>
                    <th>ID</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ragioneSociale as $r)
                    @foreach ($r->societa as $s)
                      <tr>
                          <td><a href="#" data-id="{{$s->id}}" data-nome="{{$r->nome}}"  class="societa_fattura" title="Fattura a questa società">{{$r->nome}}</a></td>
                          <td>{{optional($s->cliente)->nome}}</td>
                          <td>{{optional($s->cliente)->id_info}}</td>
                          <td>{{$r->note}}</td>
                      </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        </div>
            </div>
        </div>
    </div>
</div>
{{-- \MODAL elenco contatti --}}

@endsection

@section('js')
    <script type="text/javascript" charset="utf-8">
        
    
        jQuery(document).ready(function(){

            $('#m_datepicker_3').datepicker({
                format: 'dd/mm/yyyy',
                clearBtn:true,
                todayBtn:'linked',
            });
         
            $(".societa_fattura").click(function(e){
                e.preventDefault();
                $("#societa_id").val($(this).data("id"));
                $("#societa").val($(this).data("nome"));
                alert('Società '+$(this).data("nome")+ ' associata correttamente!\nPuoi chiudere il popup!')
            });


            $("#tipo_id").change(function(){
                jQuery.ajax({
                        url: '<?=url("last-fatture-ajax") ?>',
                        type: "post",
                        async: false,
                        data : { 
                               'tipo_id': this.value, 
                               '_token': jQuery('input[name=_token]').val()
                               },
                        success: function(data) {
                         $("#wrapper_last_numeri").html(data);
                       }
                 });
            });




        });
    

    </script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
@endsection