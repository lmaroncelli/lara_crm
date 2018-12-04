
@if ($fattura->scadenze->count())
<div class="m-section">
<div class="m-list-timeline">
	<div class="m-list-timeline__items">
		
		@foreach ($fattura->scadenze as $s)
		<div class="m-list-timeline__item">
			<span class="m-list-timeline__icon flaticon-interface-7"></span>
			<span class="m-list-timeline__text">{{$s->data_scadenza->format('d/m/Y')}}
				<span class="m-badge m-badge--danger m-badge--wide">{{ App\Utility::formatta_cifra($s->importo)}}	</span>
			</span>
		</div>
		@endforeach

	</div>
</div>
</div>
@endif