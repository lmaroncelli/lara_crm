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

							{{-- form row --}}
            	<div class="m-portlet__body">
               		<div class="form-group m-form__group row">
               			<label class="col-lg-2 col-form-label">Full Name:</label>
               			<div class="col-lg-3">
               				<input type="email" class="form-control m-input" placeholder="Enter full name">
               				<span class="m-form__help">Please enter your full name</span>
               			</div>
               			<label class="col-lg-2 col-form-label">Contact Number:</label>
               			<div class="col-lg-3">
               				<input type="email" class="form-control m-input" placeholder="Enter contact number">
               				<span class="m-form__help">Please enter your contact number</span>
               			</div>
               		</div>
            	</div>
							{{-- \form row --}}
							
            
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