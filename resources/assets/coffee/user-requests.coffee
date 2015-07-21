class Request extends Backbone.Model

class RequestView extends Backbone.View

	home: $('body').data 'home'

	initialize: ->

		@cancelButton = @$el.find('.response_cancel')

		@body = @$el.find('.requests_body')

		@cancelButton.click @cancel

	cancel: =>

		$.ajax "#{@home}/api/request/cancel",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				id: @model.get 'id'

		@body.removeClass 'requests_body--yellow'
		@body.addClass 'requests_body--grey'

		@cancelButton.hide()



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