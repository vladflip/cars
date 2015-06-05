<div class="makes {{ isset($live) ? 'makes--live' : '' }}">
					
	<div class="makes_header">
		<div class="row-image">
			{{ isset($header) ? $header : 'Выберите производителя' }}
		</div>
		<hr>
	</div>

	{{-- <div class="makes_count">45 компанйи</div> --}}

	<ul>

		@if(isset($count))

			@for($i=0; $i<$count; $i++)

				<li><span>Lexus</span></li>
				<li><span>Honda</span></li>
				<li><span class="active">Jeep</span></li>
				<li><span>Audi</span></li>
				<li><span>Jaguar</span></li>
				<li><span>Daewoo</span></li>
				<li><span>Porsche</span></li>
				<li><span>Ford</span></li>
				<li><span>Bentley</span></li>
				<li><span>Subaru</span></li>
				<li><span>Chevrolet</span></li>
				<li><span>Dodge</span></li>
				
			@endfor

		@else
			<li><span>Lexus</span></li>
			<li><span>Honda</span></li>
			<li><span class="active">Jeep</span></li>
			<li><span>Audi</span></li>
			<li><span>Jaguar</span></li>
			<li><span>Daewoo</span></li>
			<li><span>Porsche</span></li>
			<li><span>Ford</span></li>
			<li><span>Bentley</span></li>
			<li><span>Subaru</span></li>
			<li><span>Chevrolet</span></li>
			<li><span>Dodge</span></li>
			<li><span>Lexus</span></li>
			<li><span>Honda</span></li>
			<li><span class="active">Jeep</span></li>
			<li><span>Audi</span></li>
			<li><span>Jaguar</span></li>
			<li><span>Daewoo</span></li>
			<li><span>Porsche</span></li>
			<li><span>Ford</span></li>
			<li><span>Bentley</span></li>
			<li><span>Subaru</span></li>
			<li><span>Chevrolet</span></li>
			<li><span>Dodge</span></li>
		@endif


	</ul>

</div>