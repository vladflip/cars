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

	constructor: (@el, @elInfo, @class) ->

		@span = @el.children 'span'

		@count = @el.data 'count'

		@active = @el.data 'active'

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


class Votes

	constructor: (@likes, @dislikes) ->

		@likes.click = @likesClick

		@dislikes.click = @dislikesClick

	likesClick: (e) =>
		
		unless e.active
			
			do e.toggle

			if @dislikes.active

				do @dislikes.toggle


	dislikesClick: (e) =>

		unless e.active

			do e.toggle

			if @likes.active

				do @likes.toggle

		






likes = new Counter $('#mention-likes'), $('#mention-likes-info'), 'mention_likes--active'

dislikes = new Counter $('#mention-dislikes'), $('#mention-dislikes-info'), 'mention_dislikes--active'

new Votes likes, dislikes