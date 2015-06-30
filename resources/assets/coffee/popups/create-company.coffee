SelectView = require '../inc/SelectView'
MakesList = require '../create-company/MakesList'

$('#create-company-button').magnificPopup

	type: 'inline'
	closeBtnInside: true


specs = $('#create-company-spec')

do specs.selectBox


autosize $ '#create-company-about'


class AddLogo

	constructor: (btn, input, container) ->

		self = @

		@btn = $(btn)

		@input = $(input)

		@container = $(container)

		@input.change ->
			self.check @files

		@btn.click ->
			self.input.click()

	check: (files) =>
		file = files[0]
		if file.type.search('image') is -1
			do @error
		else
			@read file

	error: ->
		alert 'это не картинка'

	append: (src) ->
		@container.html ''
		img = new Image
		img.src = src
		console.log img
		@container.html img

	read: (file) ->
		src = ''
		r = new FileReader

		r.onloadend = =>
			src = r.result

			@append src

		r.readAsDataURL(file)


new AddLogo '#create-company-logo-btn', 
			'#create-company-logo',
			'#create-company-logo-html'


class SelectType extends Backbone.View

	initialize: ->
		self = @

		do @$el.selectBox

		@$el.change ->
			
			self.trigger 'changed', $(@).val()


types = new SelectType 
	el: '#create-company-type'

makes = new MakesList 
	el: '#create-company-makes-list'
	types: types


# class ModelView extends Backbone.View

# 	template: Handlebars.compile $('#create-company-model-template').html()

# 	className: 'create-company_model'

# 	render: (models) ->
# 		@$el.html @template models: models

# 		@$el




# class ModelsList extends Backbone.View

# 	template: Handlebars.compile $('#create-company-models-list-template').html()

# 	home: $('body').data('home')

# 	url: 'api/get-models-by-make'

# 	className: 'create-company_models-list_item popup_field popup_field--models'

# 	# store models, update on refresh, on add just render it with new view
# 	models: []

# 	collection: []

# 	initialize: ->

# 		do @render

# 		do @getModels

# 		@options.make.on 'removeModels', @removeModels

# 		# when type changed update ids, delete models
# 		@options.make.on 'refresh', @refresh


# 		@plus = @$el.find '.popup_plus-sign'
# 		@plus.on 'click', @add

# 	# get make view and bind it to model view, when make view removed it removes binded model view
# 	add: =>
# 		modelview = new ModelView
# 			list: @

# 		@collection.push modelview

# 		do @renderModels

# 	removeModels: =>
# 		do @remove

# 	getModels: ->
# 		id = @options.make.id

# 		console.log id

# 		$.ajax "#{@home}/#{@url}",
# 			data:
# 				id: id
# 		.done (d) =>
# 			@models = d

# 			console.log @models

# 	# take make id, get models by make, delete models
# 	refresh: =>
# 		id = @options.make.id

# 		# ----------------

# 		$.ajax "#{@home}/#{@url}",
# 			data:
# 				id: id
# 		.done (d) =>
# 			@models = d

# 		# -----------------

# 		for model in @collection
# 			do model.remove


# 	update: ->
# 		@collection = []
# 		@container.html ''

# 		do @updateFirst

# 	renderModels: ->
# 		container = @$el.children('.create-company_models-list')

# 		model = @collection.last()

# 		el = model.render @models

# 		el.children('.popup_redx').on 'click', =>
# 			do el.remove

# 		container.append el

# 		do el.children('select').selectBox



# 	render: ->
# 		$('.create-company_models').append @$el.html @template


# class MakeView extends Backbone.View

# 	template: Handlebars.compile $('#create-company-make-template').html()

# 	className: 'create-company_make'

# 	initialize:(prop) ->
# 		# default init, create models list, init first model

# 		@id = 0

# 		new ModelsList
# 			make: @


# 	render: (makes) =>
# 		self = @

# 		@$el.html @template makes: makes

# 		@$el.children('.popup_redx').click =>
# 			do @remove

# 			@trigger 'removeModels'

# 		@id = @$el.children('select').val()

# 		@$el.children('select').on 'change', ->
# 			self.id = $(@).val()
# 			self.trigger 'refresh'

# 		@$el

# class MakesList extends Backbone.View

# 	home: $('body').data('home')

# 	url: 'api/get-makes-by-type'

# 	makes: []

# 	template: Handlebars.compile $('#create-company-make-template').html()

# 	collection: []

# 	initialize: ->

# 		@options.types.on 'changed', @get

# 		@plus = @$el.parent().find('.popup_plus-sign')

# 		@plus.click @add

# 		do @createFirstMake

# 	createFirstMake: ->
# 		el = @$el.children '.create-company_make'
# 		v = new MakeView
# 			el: el
# 		@collection.push v
# 		do el.children('select').selectBox

# 	update: ->
# 		toRemove = []
# 		for make, i in @collection
# 			unless i is 0
# 				do make.remove
# 				toRemove.push make
# 		for make in toRemove
# 			make.trigger 'removeModels'
# 			@collection.remove make

# 	# when updated render first makes
# 	renderFirst: ->
# 		el = @collection[0].render @makes
# 		do el.children('select').selectBox
# 		@collection[0].trigger 'refresh'

# 	get: (id) =>

# 		do @update

# 		$.ajax "#{@home}/#{@url}",
# 			data:
# 				id: id
# 		.done (d) =>
# 			@makes = d

# 			do @renderFirst

# 	add: =>
# 		v = new MakeView

# 		@collection.push v

# 		v.on 'remove', @removed

# 		do @render

# 	removed: (v) =>
# 		@collection.remove v

# 	render: ->
# 		make = @collection.last()

# 		el = make.render @makes

# 		@$el.append el

# 	# selectbox works only when rendered already in dom
# 		do el.children('select').selectBox




# models = new ModelsList
# 	el: '#create-company-models-list'
# 	makes: makes