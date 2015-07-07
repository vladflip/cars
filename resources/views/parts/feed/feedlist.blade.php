<div class="feedlist">

	@foreach($feeds as $feed)

		<div class="feedlist_item">
		
			<div class="mention_info">
				
				<div class="feedlist_header">
					<a href="{{ route('mention', $feed->id) }}">
						{{ $feed->header }}</a>
				</div>

				<div class="feedlist_excerpt">
					{{-- {!! substr($feed->content, 0, 70).'...' !!} --}}
				</div>

				<div class="mention_date-user">
					<div class="mention_date">
						{{ 
							$feed->created_at->day . '.' . 
							$feed->created_at->month . '.'.
							$feed->created_at->year
						}}
					</div>
					<div class="mention_user">
						<a href="">
							{{ $feed->user->name }}
						</a>
					</div>
				</div>

			</div>

			<div class="mention_votes">
				<div class="mention_likes">
					<span>{{ count($feed->likes) }}</span>
					<img src="{{ URL::to('/') }}/img/like.png" alt="">
				</div>
				<div class="mention_dislikes">
					<span>{{ count($feed->dislikes) }}</span>
					<img src="{{ URL::to('/') }}/img/dislike.png" alt="">
				</div>
			</div>

			<div class="feedlist_img">
				<img src="{{ $feed->logo }}" alt="">
			</div>

		</div>

	@endforeach

</div>