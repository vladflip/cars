@extends('pages.feed')

@section('content')

	{!! Breadcrumbs::render('feed', $bread) !!}

	<div class="mention">
		
		<div class="mention_head">

			<h3 class="mention_header">
				{{ $mention->header }}
			</h3>

			<div class="mention_votes">
				<div class="mention_likes">
					<span id="mention-likes-info">{{ count($mention->likes) }}</span>
					<img src="{{ URL::to('/') }}/img/like.png" alt="">
				</div>
				<div class="mention_dislikes">
					<span id="mention-dislikes-info">{{ count($mention->dislikes) }}</span>
					<img src="{{ URL::to('/') }}/img/dislike.png" alt="">
				</div>
			</div>

		</div>

		<div class="mention_date-user">
			<div class="mention_date">
				{{ 
					$mention->created_at->day . '.' . 
					$mention->created_at->month . '.'.
					$mention->created_at->year
				}}
			</div>
			<div class="mention_user">
				<a href="">
					{{ $mention->user->name }}
				</a>
			</div>
		</div>

		<div class="mention_content">
			{!! $mention->content !!}
		</div>

		<div id="mention_photos" class="mention_photos" data-layout="{{ $option }}">
			
			@foreach($mention->photos as $photo)

				<img src="{{ URL::to('/') . '/' . $photo->src }}" alt="">

			@endforeach

		</div>
		
		<div class="mention_pluses-minuses">

			<div class="mention_pluses">

				<h4>Плюсы</h4>

				@foreach($mention->pluses as $plus)
	
					<div class="mention_plus">
						<span class="mention_plus-sign">+</span>
						{{ $plus->text }}
					</div>

				@endforeach

			</div>

			<div class="mention_minuses">

				<h4>Минусы</h4>
				
				@foreach($mention->minuses as $minus)

					<div class="mention_minus">
						<span class="mention_minus-sign">-</span>
						{{ $minus->text }}
					</div>

				@endforeach

			</div>

		</div>

		@if( Auth::check() )

			<div class="mention_rate" data-id="{{ $mention->id }}">
				<span>Отзыв был полезен?</span>

				<div id="mention-likes" class="mention_likes"

				 data-count="{{ (int)count($mention->likes) }}"
				 data-active="{{ (int)$mention->likes->contains(Auth::id()) }}"
				>
					<span>{{ count($mention->likes) }}</span>
					<img src="{{ URL::to('/') }}/img/like.png" alt="">
				</div>
				<div id="mention-dislikes" class="mention_dislikes"

				 data-count="{{ (int)count($mention->dislikes) }}"
				 data-active="{{ (int)$mention->dislikes->contains(Auth::id()) }}"
				>
					<span>{{ count($mention->dislikes) }}</span>
					<img src="{{ URL::to('/') }}/img/dislike.png" alt="">
				</div>
			</div>
			
		@endif

	</div>
	
	<hr>

	@include('inc.comments')

@stop