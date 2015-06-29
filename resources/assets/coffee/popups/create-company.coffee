SelectView = require '../inc/SelectView'

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


class ModelView extends Backbone.View

	template: Handlebars.compile $('#create-company-model-template').html()

	className: 'create-company_model'

	render: (models) ->
		@$el.html @template models: models

		@$el


class ModelsList extends Backbone.View

	template: Handlebars.compile $('#create-company-model-template').html()

	home: $('body').data('home')

	url: 'api/get-models-by-make'

	className: '.create-company_models-list'

	# store models, update on refresh, on add just render it with new view
	models: []

	collection: []

	initialize: ->

		console.log @options.v

		# when new make added
		@options.makes.on 'add', @add

		@options.makes.on 'remove', @remove


		# when type changed delete added models
		@options.makes.on 'refresh', @refresh

	# get make view and bind it to model view, when make view removed it removes binded model view
	add:(v) =>
		modelview = new ModelView
			make: v

		@collection.push modelview

		do @render

	remove:(v) =>
		console.log v

	# take make id, get models by make, update default model view and delete added
	refresh:(id) =>

		$.ajax "#{@home}/#{@url}",
			data:
				id: id
		.done (d) =>
			@models = d

	update: ->
		@collection = []
		@container.html ''

		do @updateFirst

	updateFirst: ->
		@first.html @template models: @models

		do @first.children('select').selectBox

	# render: ->
	# 	for model in @collection
	# 		el = model.render @makes

	# 		@container.append el

	# 		do el.children('select').selectBox


class MakeView extends Backbone.View

	template: Handlebars.compile $('#create-company-make-template').html()

	className: 'create-company_make'

	initialize:(prop) ->
		if prop.first
			do @initFirst
		else
			do @init

	# default init, create models list, init first model
	init: ->

	# first init, get first model and list
	initFirst: ->
		new ModelsList
			v: @


	render: (makes) ->
		@$el.html @template makes: makes

		@$el.children('.popup_redx').click =>
			do @remove

			@trigger 'remove', @

		@$el

class MakesList extends Backbone.View

	home: $('body').data('home')

	url: 'api/get-makes-by-type'

	makes: []

	template: Handlebars.compile $('#create-company-make-template').html()

	collection: []

	initialize: ->

		@options.types.on 'changed', @get

		@plus = @$el.parent().find('.popup_plus-sign')

		@plus.click @add

		do @createFirstMake

	createFirstMake: ->
		el = @$el.children '.create-company_make'
		v = new MakeView
			el: el
			first: true
		@collection.push v
		do el.children('select').selectBox

	update: ->
		toRemove = []
		for make, i in @collection
			unless i is 0
				do make.remove
				toRemove.push make
		for make in toRemove
			@collection.remove make

	# when updated render first makes
	renderFirst: ->
		el = @collection[0].render @makes
		do el.children('select').selectBox

	get: (id) =>

		do @update

		$.ajax "#{@home}/#{@url}",
			data:
				id: id
		.done (d) =>
			@makes = d

			do @renderFirst

	add: =>
		v = new MakeView

		@collection.push v

		v.on 'remove', @removed

		do @render

	removed: (v) =>
		@collection.remove v

	render: ->
		make = @collection.last()

		el = make.render @makes

		@$el.append el

	# selectbox works only when rendered already in dom
		do el.children('select').selectBox



types = new SelectType 
	el: '#create-company-type'

makes = new MakesList 
	el: '#create-company-makes-list'
	types: types

# models = new ModelsList
# 	el: '#create-company-models-list'
# 	makes: makes