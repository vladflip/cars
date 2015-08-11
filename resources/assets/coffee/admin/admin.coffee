Models = require './Models'

require './create.coffee'

class Make extends Backbone.Model
	defaults:
		id: ''
		title: ''
		url: ''

class MakeView extends Backbone.View

	popup: $ '#admin-popup'

	template: Handlebars.compile $('#admin-makes-template').html()

	home: $('#csrf').data 'home'

	initialize: ->

		do @getModels

		src = @template
			title: @model.get 'title'
			url: @model.get 'url'
			models: @models

		@$el.magnificPopup
			type: 'inline'
			closeBtnInside: true
			items:
				src: '#admin-popup'

			callbacks:
				open: =>
					@popup.append src

					@modelsView = new Models
						el: @popup.find('#admin-models')

					@popup.find('#admin-edit-button').click @saveChanges

				close: =>
					@popup.html ''

	getModels: ->

		@models = []

		@$el.find('.model').each (i, model) =>

			@models.push
				id: $(model).data 'id'
				title: $(model).data 'title'
				url: $(model).data 'url'

	saveChanges: =>

		result = {}

		models = @modelsView.get()

		title = @popup.find('.make-title').val()
		url = @popup.find('.make-url').val()

		if title isnt @model.get 'title'
			result.title = title

		if url isnt @model.get 'url'
			result.url = url

		if models.length > 0

			modelsArray = []

			for model in models
				m = {}
				m.id = model.get 'id'
				m.title = model.get 'title'
				m.url = model.get 'url'
				m.new = model.get 'new'

				modelsArray.push m

			result.models = modelsArray

		if result.length isnt 0

			result.id = @model.get 'id'

			$.ajax "#{@home}/api/admin/makesmodels",
				headers:
					'X-CSRF-TOKEN' : $('#csrf').data 'csrf'
				method: 'POST'
				data: result

			console.log result


		# location.reload()


		

class MakesCollection extends Backbone.Collection
	model: Make

class Makes extends Backbone.View

	initialize: ->

		do @fillCollectiion

	fillCollectiion: ->

		@$el.find('.make').each (i, make) =>
			m = new Make
				id: $(make).data 'id'
				title: $(make).data 'title'
				url: $(make).data 'url'

			v = new MakeView
				el: make
				model: m

new Makes
	el: '#admin-makes'