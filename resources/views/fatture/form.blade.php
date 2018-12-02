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
                        
                        @include('fatture._header_fattura')

                        {{-- righe fatturazione --}}
                        <div class="m-invoice__body m-invoice__body--centered">
                            @if ($fattura->righe()->count())
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Servizio</th>
                                                <th>Qta</th>
                                                <th>Prezzo</th>
                                                <th>T.Netto</th>
                                                <th>Al.IVA</th>
                                                <th>IVA</th>
                                                <th>Totale</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($fattura->righe as $riga)
                                            <tr>
                                                <td>{{$riga->servizio}}</td>
                                                <td>{{$riga->qta}}</td>
                                                <td>{{App\Utility::formatta_cifra($riga->prezzo, '€')}}</td>
                                                <td>{{App\Utility::formatta_cifra($riga->totale_netto, '€')}}</td>
                                                <td>{{$riga->al_iva}}</td>
                                                <td>{{App\Utility::formatta_cifra($riga->iva, '€')}}</td>
                                                <td class="m--font-danger">{{App\Utility::formatta_cifra($riga->totale, '€')}}</td>
                                                <td>
                                                  <a href="{{ route('fatture.load-riga',['rigafattura_id' => $riga->id]) }}" class="btn btn-info m-btn m-btn--icon m-btn--icon-only">
                                                    <i class="la la-edit"></i>
                                                  </a>
                                                </td>
                                                <td>
                                                  <a href="{{ route('fatture.delete-riga',['rigafattura_id' => $riga->id]) }}" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                                                    <i class="la la-trash"></i>
                                                  </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            
                            @endif
                            
                        </div>
                        
                         {{-- form aggiunta servizio / riga di fatturazione --}}
                        @include('fatture._form_add_riga_fattura')
                        

                        {{-- footer fattura --}}
                        @include('fatture._footer_fattura_'.strtolower($fattura->tipo_id))

                        

                    </div> {{--  \wrapper --}}
                </div> {{-- "m-invoice-2 --}} 

          
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


            /* aggiornamento degli ultimi numeroìi in base al tipo di fattura */
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


            /* aggiornamento della riga di fatturazione */
            $(".trigger_row").blur(function(){
                var qta = $("#qta").val();
                var prezzo = $("#prezzo").val();
                var al_iva = $("#al_iva").val();
                if(qta != '' && prezzo != '' && !isNaN(qta) && !isNaN(prezzo))
                  {
                  var totale_netto = qta*prezzo;
                  var iva = totale_netto*al_iva/100;
                  var totale = totale_netto + iva;
                  if(!isNaN(totale_netto) && !isNaN(iva) && !isNaN(totale)) 
                    {
                    $("#totale_netto").val(totale_netto);
                    $("#iva").val(iva);
                    $("#totale").val(totale);
                    }
                  }
            });


            $("#servizi").select2({placeholder:"Seleziona i servizi da fatturare"});


            $(".add_servizi").click(function(e){
                e.preventDefault();
                var servizi_ids = $("#servizi").val();

                var selText = [];
                $("#servizi option:selected").each(function () {
                   var $this = $(this);
                   if ($this.length) {
                    selText.push($this.text());
                   }
                });

                $("#prefill").html(' <textarea name="servizio" class="form-control m-input m-input--air m-input--pill" id="servizio" rows="4">' + selText.join("\n") + '</textarea> <input type="hidden" name="servizi" value="'+ servizi_ids +'">');
                $("#reset_servizi").show();
            });




        });
    

    </script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/select2.js') }}" type="text/javascript"></script>
@endsection