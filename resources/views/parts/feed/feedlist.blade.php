<div class="feedlist">

	@foreach($feeds as $feed)

		<div class="feedlist_item">
		
			<div class="feedlist_info">
				
				<div class="feedlist_header">
					<a href="">{{ $feed->header }}</a>
				</div>

				<div class="feedlist_excerpt">
					{{ 
						substr($feed->content, 0, 
							strpos($feed->content, ' ', 50)).'...'
					}}
				</div>

				<div class="feedlist_date-user">
					<div class="feedlist_date">
						{{ 
							$feed->created_at->day . '.' . 
							$feed->created_at->month . '.'.
							$feed->created_at->year
						}}
					</div>
					<div class="feedlist_user">
						<a href="">
							{{ $feed->user->name }}
						</a>
					</div>
				</div>

			</div>

			<div class="feedlist_votes">
				<div class="feedlist_likes">
					<span>{{ count($feed->likes) }}</span>
					<img src="{{ URL::to('/') }}/img/like.png" alt="">
				</div>
				<div class="feedlist_dislikes">
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