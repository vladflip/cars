mention_photos = $ '#mention_photos'

mention_photos.photosetGrid
	gutter: '3px'
	highresLinks: true

	onComplete: ->
		mention_photos.find('a').magnificPopup
			type: 'image'
			closeBtnInside: false
			gallery:
				enabled: true

class Counter

	home: $('body').data 'home'

	id: $('.mention_rate:first').data 'id'

	url: 'api/feedback/vote'

	constructor: (@el, @elInfo, @class) ->

		@span = @el.children 'span'

		@count = @el.data 'count'

		@active = @el.data 'active'

		if @active
			@el.addClass @class

		@el.click @pass

	pass: =>
		@click @

	updateInfo: ->
		@elInfo.html @count

	toggle: =>
		if @active
			do @minus
			@active = 0
			@el.removeClass @class
		else
			do @plus
			@active = 1
			@el.addClass @class

		do @updateInfo

	plus: =>
		@span.html ++@count

	minus: =>
		@span.html --@count

	send: (type) =>
		$.ajax "#{@home}/#{@url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				id: @id
				type: type

		.done (response) =>
			console.log response
		.error ->
			console.log 'error'
			


class Votes

	constructor: (@likes, @dislikes) ->

		@likes.click = @likesClick

		@dislikes.click = @dislikesClick

	likesClick: (e) =>
				
		do e.toggle

		if @dislikes.active

			do @dislikes.toggle

		e.send 'likes'


	dislikesClick: (e) =>

		do e.toggle

		if @likes.active

			do @likes.toggle

		e.send 'dislikes'

		






likes = new Counter $('#mention-likes'), 
	$('#mention-likes-info'), 
	'mention_likes--active'

dislikes = new Counter $('#mention-dislikes'),
	$('#mention-dislikes-info'),
	'mention_dislikes--active'

new Votes likes, dislikes