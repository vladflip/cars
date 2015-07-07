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
					<span>{{ count($mention->likes) }}</span>
					<img src="{{ URL::to('/') }}/img/like.png" alt="">
				</div>
				<div class="mention_dislikes">
					<span>{{ count($mention->dislikes) }}</span>
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

		{{-- photos --}}

		<div class="mention_rate">
			<span>Отзыв был полезен?</span>

			<div class="mention_likes mention_likes--active">
				<span>{{ count($mention->likes) }}</span>
				<img src="{{ URL::to('/') }}/img/like.png" alt="">
			</div>
			<div class="mention_dislikes mention_dislikes--active">
				<span>{{ count($mention->dislikes) }}</span>
				<img src="{{ URL::to('/') }}/img/dislike.png" alt="">
			</div>

		</div>

	</div>

@stop