class Response extends Backbone.Model

class ResponseView extends Backbone.View

	url: 'api/response/create'

	home: $('body').data 'home'

	initialize: ->

		@roomId = @options.roomId

		@text = @$el.find('.response_textarea')

		@answer = @$el.find('.response_answer')

		@body = @$el.find('.response_body')

		@photos = @$el.find('#feedback-input')

		@answer.click @doAnswer

	doAnswer: =>

		console.log @photos

		if @text.val() is '' then return

		@text.hide()

		@answer.hide()

		@body.html @text.val()

		# do @sendResponse

	sendResponse: ->
		
		$.ajax "#{@home}/#{@url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				room: @roomId
				response: @text.val()

		.done (response) =>
			console.log response


class Request extends Backbone.Model
	defaults:
		id: 0

class RequestView extends Backbone.View

	initialize: ->
		
		new ResponseView
			el: @$el.children('.response')
			roomId: @model.get 'id'


class RequestsCollection extends Backbone.Collection
	model: Request

class RequestsList extends Backbone.View

	initialize: ->

		@collection = new RequestsCollection
		
		do @initRequests

	initRequests: ->

		@$el.children('.requests_item').each (i, request) =>
			model = new Request
				id: $(request).data 'id'

			@collection.add model

			v = new RequestView
				el: request
				model: model





new RequestsList
	el: '#company-requests'