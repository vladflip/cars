class Request extends Backbone.Model

class RequestView extends Backbone.View

	home: $('body').data 'home'

	initialize: ->

		@body = @$el.find('.requests_body')



class RequestsCollection extends Backbone.Collection

class Requests extends Backbone.View

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



new Requests
	el: '#user-requests'