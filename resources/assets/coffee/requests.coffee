class Response extends Backbone.Model

class ResponseView extends Backbone.View

	url: 'api/response/create'

	home: $('body').data 'home'

	# create templates : 
	# canceled
	# answered
	# own template (for loading more) or not needed cuz request template will include response

	initialize: ->

		@requestId = @options.requestId

		@text = @$el.find('.response_textarea')

		@answer = @$el.find('.response_answer')

		@cancel = @$el.find('.response_cancel')

		@body = @$el.find('.response_body')

		@answer.click @doAnswer

		@cancel.click @doCancel

	doAnswer: =>

		if @text.val() is '' then return

		@text.hide()

		@answer.hide()

		@cancel.hide()

		@body.html @text.val()

		do @sendResponse

	doCancel: =>

		@text.hide()

		@answer.hide()

		@cancel.hide()

		@body.html 'Отклонено.'

	sendResponse: ->
		
		$.ajax "#{@home}/#{@url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				request: @requestId
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
			requestId: @model.get 'id'


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