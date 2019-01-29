@extends('layouts.lara_crm')

@section('content')

<div class="row">
    <div class="col-xl-12 sezioni-cliente">


			<!--begin::Portlet-->
			<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet"">
			
        @include('menu_sezioni_clienti') 


			<div class="m-portlet__body">

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

									

            		</form>

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

     
        </div> {{-- m-portlet --}}

		</div>{{-- col --}}
</div>{{-- row --}}




@endsection


@section('js')
	<script type="text/javascript" charset="utf-8">

		jQuery(document).ready(function(){

		});
	</script>

@endsection