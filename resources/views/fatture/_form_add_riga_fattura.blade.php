<div class="m-portlet__body">
    @if (is_null($riga_fattura))
        <form action="{{ route('fatture.add-riga') }}" method="POST" accept-charset="utf-8">
        {{-- true expr --}}
    @else
        <form action="{{ route('fatture.update-riga',['rigafattura_id' => $riga_fattura->id]) }}" method="POST" accept-charset="utf-8">
    @endif
     
        {!! csrf_field() !!}
        <input type="hidden" name="fattura_id" value="{{$fattura->id}}">
        <div class="form-group m-form__group row">
            <label class="offset-lg-3 col-lg-1 col-form-label text-right" for="numero">Servizio:</label>
            <div class="col-lg-5">
                    @if (count($servizio_prefill_arr))
                        <textarea name="servizio" class="form-control m-input m-input--air m-input--pill" id="servizio" rows="4">{{trim(implode("\n", $servizio_prefill_arr))}}</textarea>
                    @else
                        @if (old('servizio') != '')
                            <textarea name="servizio" class="form-control m-input m-input--air m-input--pill" id="servizio" rows="4">{!!old('servizio') != ''!!}</textarea>
                        @else
                            <textarea name="servizio" class="form-control m-input m-input--air m-input--pill" id="servizio" rows="4">{!!optional($riga_fattura)->servizio!!}</textarea>
                        @endif
                    @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-1 col-form-label text-right" for="numero">Qta:</label>
            <div class="col-lg-1">
                <input type="text" name="qta" id="qta" value="{{ old('qta') != '' ?  old('qta') : optional($riga_fattura)->qta}}"  class="trigger_row form-control m-input m-input--air m-input--pill">
            </div>
            <label class="col-lg-1 col-form-label text-right" for="numero">Prezzo:</label>
            <div class="col-lg-1">
                <input type="text" name="prezzo" id="prezzo" value="{{ old('prezzo') != '' ?  old('prezzo') : optional($riga_fattura)->prezzo}}"  class="trigger_row form-control m-input m-input--air m-input--pill">
            </div>
            <label class="col-lg-1 col-form-label text-right" for="numero">Tot netto:</label>
            <div class="col-lg-1">
                <input type="text" name="totale_netto" id="totale_netto" value="{{ old('totale_netto') != '' ?  old('totale_netto') : optional($riga_fattura)->totale_netto}}"  class="form-control m-input m-input--air m-input--pill">
            </div>
            <label class="col-lg-1 col-form-label text-right" for="numero">Al. IVA:</label>
            <div class="col-lg-1">
                <input type="text" name="al_iva" id="al_iva" value="22"  class="form-control m-input m-input--air m-input--pill">
            </div>
            <label class="col-lg-1 col-form-label text-right" for="numero">IVA:</label>
            <div class="col-lg-1">
                <input type="text" name="iva" id="iva" value="{{ old('iva') != '' ?  old('iva') : optional($riga_fattura)->iva}}"  class="form-control m-input m-input--air m-input--pill">
            </div>
             <label class="col-lg-1 col-form-label text-right" for="numero">Totale:</label>
             <div class="col-lg-1">
                 <input type="text" name="totale" id="totale" value="{{ old('totale') != '' ?  old('totale') : optional($riga_fattura)->totale}}"  class="form-control m-input m-input--air m-input--pill">
             </div>
        </div>
        <div class="text-center">
            @if (is_null($riga_fattura))
                <button type="submit" class="btn btn-success">Inserisci</button>
                <button type="reset"  title="Annulla" class="btn btn-secondary">Annulla</button>
            @else
                <button type="submit" class="btn btn-success">Modifica</button>
                <a href="{{ route('fatture.edit',['fattura_id' => $fattura->id]) }}" title="Annulla" class="btn btn-secondary">Annulla</button>
            @endif
        </div>
    </form>
</div>