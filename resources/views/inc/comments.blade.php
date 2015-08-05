<div id="comments" class="comments">
	
	<h3 class="comments_header">Комментарии</h3>

	<div class="comments_block">
		@foreach($mention->comments as $comment)

			<div class="comment">
				
				<div>
					<div class="comment_ava" 
					style="background-image:url( 
					{{ URL::to('/') }}/{{ $comment->user->ava ? $comment->user->ava : 'img/noavatar.png' }})"
					data-ava="{{ URL::to('/') }}/{{ $comment->user->ava ? $comment->user->ava : 'img/noavatar.png' }}"></div>
				</div>

				<div class="comment_right">
					<div class="comment_header">
						<div class="comment_name">{{ $comment->user->name }}</div>
						<div class="comment_date">
							{{ 
								$comment->created_at->day . '.' . 
								$comment->created_at->month . '.'.
								$comment->created_at->year
							}}
						</div>
					</div>
					<div class="comment_content">
						{{ $comment->text }}
					</div>
				</div>

			</div>

		@endforeach
	</div>

	@if(Auth::check())
		<div id="comments-send" class="comments_send"
			data-name="{{ Auth::user()->name ? Auth::user()->name : Auth::user()->email }}"
			data-ava="{{ Auth::user()->ava ? Auth::user()->ava : 'img/noavatar.png' }}">
			<textarea id="comments-textarea" placeholder="Комментарий..." class="comments_textarea"></textarea>
			<div id="comments-button" class="comments_send-button">Отправить</div>
		</div>
	@endif

	@include('templates.comment-template')

</div>