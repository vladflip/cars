Models = require './Models'

Handlebars.registerHelper 'ifCond', (v1, v2, options) ->
	if v1 is v2
		return options.fn(this)
	options.inverse(this)

class MakeView extends Backbone.View

	popup: $ '#admin-popup'

	template: Handlebars.compile $('#admin-makes-template').html()

	home: $('#csrf').data 'home'

	initialize: ->

		do @getModels

		@model.on 'change:show', @triggerShow

		@createButton = $ '#new-make'

		@editButton = @$el.find('.edit-make')

		@deleteButton = @$el.find('.delete-make')

		@deleteButton.click @removeMake

		@initPopup @editButton

		src = @template
			buttonText: 'Создать'

		@createButton.magnificPopup
			type: 'inline'
			closeBtnInside: true
			items:
				src: '#admin-popup'

			callbacks:
				open: =>
					@popup.append src

					@modelsView = new Models
						el: @popup.find('#admin-models')

					@popup.find('#admin-edit-button').click @createMake

				close: =>
					@popup.html ''

	triggerShow: =>

		if @model.get 'show'
			do @$el.show
		else
			do @$el.hide

	initPopup: (el) ->

		src = @template
			title: @model.get 'title'
			url: @model.get 'url'
			models: @models
			buttonText: 'Принять изменения'

		el.magnificPopup
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


	removeMake: =>

		bootbox.confirm 'Вы точно хотите удалить эту марку?', (remove) =>

			if remove

				$.ajax "#{@home}/api/admin/remove-make",
					headers:
						'X-CSRF-TOKEN' : $('#csrf').data 'csrf'
					method: 'POST'
					data:
						id: @model.get 'id'

				do @remove

	getModels: ->

		@models = []

		@$el.find('.model').each (i, model) =>

			@models.push
				id: $(model).data 'id'
				title: $(model).data 'title'
				url: $(model).data 'url'
				type_id: $(model).data 'type-id'
				type_title: $(model).data 'type-title'

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
				m.type = model.get 'type_id'

				modelsArray.push m

			result.models = modelsArray

		if Object.keys(result).length isnt 0

			result.id = @model.get 'id'

			$.ajax "#{@home}/api/admin/makesmodels",
				headers:
					'X-CSRF-TOKEN' : $('#csrf').data 'csrf'
				method: 'POST'
				data: result

			location.reload()

	createMake: =>

		result = {}

		models = @modelsView.get()

		title = @popup.find('.make-title').val()
		url = @popup.find('.make-url').val()

		if title isnt ''
			result.title = title
		else
			return

		if url isnt ''
			result.url = url
		else
			return

		if models.length > 0

			modelsArray = []

			for model in models
				m = {}
				m.title = model.get 'title'
				m.url = model.get 'url'
				m.new = model.get 'new'
				m.type = model.get 'type_id'

				modelsArray.push m

			result.models = modelsArray

		else
			return

		if Object.keys(result).length isnt 0

			$.ajax "#{@home}/api/admin/create-make",
				headers:
					'X-CSRF-TOKEN' : $('#csrf').data 'csrf'
				method: 'POST'
				data: result

			location.reload()

class Make extends Backbone.Model
	defaults:
		id: ''
		title: ''
		url: ''
		show: true

class MakesCollection extends Backbone.Collection
	model: Make

class Makes extends Backbone.View

	collection: new MakesCollection

	initialize: ->

		do @fillCollection

		@search = $ '#makes-search'

		@search.keyup @filter

		@count = 10

		@offset = 0

		@countSelect = $ '#makes-count'

		@countSelect.change @updateCount

		do @updateCount

	filter: =>

		search = @search.val().toLowerCase()

		console.log search

		@collection.each (model) =>

			if search is ''
				model.set 'show', true
				return

			title = model.get('title').toLowerCase()
			url = model.get('url').toLowerCase()

			if title.indexOf(search) is -1 and url.indexOf(search) is -1
				model.set 'show', false
			else
				model.set 'show', true

	fillCollection: ->

		@$el.find('.make').each (i, make) =>
			m = new Make
				id: $(make).data 'id'
				title: $(make).data 'title'
				url: $(make).data 'url'

			@collection.add m

			v = new MakeView
				el: make
				model: m

	updateCount: =>
		@count = @countSelect.val()

		@collection.each (model, i) =>

			if i >= @count
				model.set 'show', false
			else
				model.set 'show', true
			


new Makes
	el: '#admin-makes'