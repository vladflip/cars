class Response extends Backbone.Model

class ResponseView extends Backbone.View

	# create templates : 
	# declined
	# answered
	# own template (for loading more) or not needed cuz request template will include response

	initialize: ->

		@requestId = @options.requestId

		@text = @$el.find('.response_textarea')

		@answer = @$el.find('.response_answer')

		@decline = @$el.find('.response_decline')

		@body = @$el.find('.response_body')

		@answer.click @doAnswer

		@decline.click @doDecline

	doAnswer: =>
		if @text.val() is '' then return

		@text.hide()

		@answer.hide()

		@decline.hide()

		@body.html @text.val()


	doDecline: =>

		console.log @


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