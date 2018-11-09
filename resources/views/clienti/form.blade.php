@extends('layouts.lara_crm')

@section('content')

<div class="m-content">
<div class="row">
    <div class="col-xl-12">

        <!--begin:: Widgets/Tasks -->
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Form cliente
                        </h3>
                    </div>
                </div>
            </div>

	          @if ($cliente->exists)
	          	
	          	<form action="{{ route('clienti.destroy', $cliente->id) }}" method="POST" id="record_delete">
	          		{{ method_field('DELETE') }}
	          	  {!! csrf_field() !!}
	          	  <input type="hidden" name="id" value="{{$cliente->id}}">
	          	</form>

	          	<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" role="form" action="{{ route('clienti.update', $cliente->id) }}" method="POST">
	          	{{ method_field('PUT') }}
	          @else
	          	<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" role="form" action="{{ route('clienti.store') }}" method="POST" enctype="multipart/form-data">
	          @endif
	          	{!! csrf_field() !!}

            	<div class="m-portlet__body">
									
									{{-- Attivo-AttivoIA --}}
               		<div class="form-group m-form__group row">
               			<label class="col-lg-2 col-form-label" for="attivo">Stato:</label>
               			<div class="col-lg-3">
               					<select class="form-control m-input" id="attivo" name="attivo">
               							<option value="1" @if ( $cliente->attivo == 1 || old('attivo') == 1 ) selected="selected" @endif>Attivo</option>
               							<option value="0" @if ( $cliente->attivo == 0 || (old('attivo') !== null && old('attivo') == 0) ) selected="selected" @endif>NON Attivo</option>
               					</select>
               					<span class="m-form__help">
               						@if ($cliente->attivo)
               						<span class="m-badge m-badge--success m-badge--wide data_attivazione">{{$cliente->data_attivazione->format('d/m/Y')}}</span>
               						@else
               						<span class="m-badge m-badge--danger m-badge--wide data_attivazione">{{$cliente->data_disattivazione->format('d/m/Y')}}</span>
               						@endif
               					</span>
               			</div>
               			<label class="col-lg-2 col-form-label" for="attivo_IA">Infoalberghi:</label>
               			<div class="col-lg-3">
               					<select class="form-control m-input" id="attivo_IA" name="attivo_IA">
               							<option value="1" @if ( $cliente->attivo_IA == 1 || old('attivo_IA') == 1 ) selected="selected" @endif>Attivo</option>
               							<option value="0" @if ( $cliente->attivo_IA == 0 || (old('attivo_IA') !== null && old('attivo_IA') == 0) ) selected="selected" @endif>NON Attivo</option>
               					</select>
               					<span class="m-form__help">
               						@if ($cliente->attivo_IA)
               						<span class="m-badge m-badge--success m-badge--wide data_attivazione">{{$cliente->data_attivazione_IA->format('d/m/Y')}}</span>
               						@else
               						<span class="m-badge m-badge--danger m-badge--wide data_attivazione">{{$cliente->data_disattivazione_IA->format('d/m/Y')}}</span>
               						@endif
               					</span>
               			</div>
               		</div>
									{{-- \Attivo-AttivoIA --}}


									{{-- Nome-Tipo --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="nome">Nome:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="nome" id="nome" value="{{ old('nome') != '' ?  old('nome') : $cliente->nome}}"  class="form-control m-input" placeholder="Nome">
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="tipo_id">Tipo:</label>
	             			<div class="col-lg-3">
	             					<select class="form-control m-input" id="tipo_id" name="tipo_id">
	             						@foreach ($tipi_cliente as $tipo_id => $tipo)
	             							<option value="{{$tipo_id}}" @if ($cliente->tipo_id == $tipo_id || old('tipo_id') == $tipo_id ) selected="selected" @endif>{{$tipo}}</option>
	             						@endforeach
	             					</select>
	             			</div>
	             		</div>
									{{-- \Nome-Tipo --}}

									{{-- Indirizzo-Categoria --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="indirizzo">Indirizzo:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="indirizzo" id="indirizzo" value="{{ old('indirizzo') != '' ?  old('indirizzo') : $cliente->indirizzo}}"  class="form-control m-input" placeholder="Nome">
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="categoria_id">Categoria:</label>
	             			<div class="col-lg-3">
	             					<select class="form-control m-input" id="categoria_id" name="categoria_id">
	             						<option value="6">Altro</option>
	             						@foreach ($cataegorie_cliente as $categoria_id => $categoria)
	             							<option value="{{$categoria_id}}" @if ($cliente->categoria_id == $categoria_id || old('categoria_id') == $categoria_id ) selected="selected" @endif>{{$categoria}}</option>
	             						@endforeach
	             					</select>
	             			</div>
	             		</div>
									{{-- \Indirizzo-Categoria --}}


									{{-- Città-CAP --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="localita_id">Località:</label>
	             			<div class="col-lg-3">
	             					<select class="form-control m-input" id="localita_id" name="localita_id">
	             						<option value="6">Altro</option>
	             						@foreach ($localita_cliente as $localita_id => $localita)
	             							<option value="{{$localita_id}}" @if ($cliente->localita_id == $localita_id || old('localita_id') == $localita_id ) selected="selected" @endif>{{$localita}}</option>
	             						@endforeach
	             					</select>
	             			</div>
	             			<label class="col-lg-2 col-form-label" id="luogo">{{$cliente->localita->comune->nome}} ({{$cliente->localita->comune->provincia->sigla}}) - {{$cliente->localita->comune->provincia->regione->nome}}</label>
	             			<label class="col-lg-2 col-form-label" for="cap">CAP:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="cap" id="cap" value="{{ old('cap') != '' ?  old('cap') : $cliente->cap}}"  class="form-control m-input" placeholder="CAP">
	             			</div>
	             		</div>
									{{-- \Città-CAP --}}



            	</div> {{-- m-portlet__body --}}
						
            
            	<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            		<div class="m-form__actions m-form__actions--solid">
            			<div class="row">
            				<div class="col-lg-2"></div>
            				<div class="col-lg-10">
            					<button type="reset" class="btn btn-success">
            						@if ($cliente->exists)
            							Modifica
            						@else
            							Crea
            						@endif
            					</button>
            					<a href="{{ url('clienti') }}" title="Annulla" class="btn btn-secondary">Annulla</a>
            				</div>
            			</div>
            		</div>
            	</div>

            </form>
     
        </div> {{-- m-portlet --}}
    </div>{{-- col --}}
   
</div>{{-- row --}}
</div>{{-- content --}}



@endsection