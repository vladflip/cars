class Comment extends Backbone.Model
	defaults:	
		name: ''
		date: ''
		content: ''


class CommentsCollection extends Backbone.Collection
	model: Comment

class CommentView extends Backbone.View

	template: $.HandlebarsFactory '#comment-template'

	className: 'comment'

	initialize: ->

		do @render


	render: ->

		@$el.html @template
			name: @model.get 'name'
			ava: @model.get 'ava'
			date: @model.get 'date'
			content: @model.get 'content'

class Comments extends Backbone.View

	collection: new CommentsCollection

	home: $('body').data('home')

	initialize: ->

		do @fillCollection

		do @setAuthDefaults

		@id = @$el.data 'feedback'

		@button = $ '#comments-button'
		@textarea = $ '#comments-textarea'

		@button.click @addComment

		@textarea.click =>
			@button.css('display', 'flex')
		@textarea.blur =>
			if @textarea.val() is ''
				@button.hide()

	fillCollection: ->

		@$el.find('.comment').each (i, comment) =>
			m = new Comment
				name: $.trim $(comment).find('.comment_name').html()
				date: $.trim $(comment).find('.comment_date').html()
				content: $.trim $(comment).find('.comment_content').html()
				ava: $(comment).find('.comment_ava').data 'ava'

			@collection.add m

			v = new CommentView
				el: comment
				model: m

	setAuthDefaults: ->

		@name = $('#comments-send').data 'name'
		@ava = @home + '/' + $('#comments-send').data 'ava'

	addComment: =>

		if @textarea.val() is ''
			@textarea.blink()
			return

		d = new Date

		date = d.getDate() + '.' + (d.getMonth() + 1) + '.' + d.getFullYear()

		m = new Comment
			name: @name
			ava: @ava
			content: @textarea.val()
			date: date

		@collection.add m

		do @renderCollection

		@send m

	renderCollection: ->
		comments = $ '.comments_block'
		comments.html ''

		@collection.each (comment) ->

			v = new CommentView
				model: comment
			
			comments.append v.el

		@textarea.val('')
		@textarea.blur()

	send: (comment) ->

		$.ajax "#{@home}/api/comments/create",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				comment: comment.get 'content'
				feedback: @id
		.done (r) ->
			console.log r



new Comments
	el: '#comments'