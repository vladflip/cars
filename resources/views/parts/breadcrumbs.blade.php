<ul class="breadcrumb">
	
	@foreach($breadcrumbs as $breadcrumb)

		@if($breadcrumb->last)

			<li class="breadcrumb--current breadcrumb_item">
				{{ $breadcrumb->title }}
			</li>

		@else

			<li class="breadcrumb--parent breadcrumb_item">
				<a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
			</li>
			<span class="breadcrumb_separator">/</span>

		@endif

	@endforeach

</ul>