class Model extends Backbone.Model
	defaults:
		id: 0
		title: ''
		visible: true

class ModelsCollection extends Backbone.Collection
	model: Model

	# reset all models visible to true
	resetVisible: ->
		@.each (model) ->
			model.set 'visible', true

class ModelView extends Backbone.View

	template: $.HandlebarsFactory '#create-company-model-template'

	className: 'create-company_model popup_field'

	initialize: ->

		@models = new ModelsCollection @options.models

		do @render

		@$el.children('.popup_redx').click =>
			do @destroy

		@select = @$el.children('select')

		@select.change @selectChanged

	initSelectbox: =>
		do @select.selectBox

	selectChanged: (e) =>
		@trigger 'selectChanged', e.target.value, @

	# loop options
	# get value of select
	# remove all options
	# append all where visible or selected
	updateOptions: (models) ->
		selected = parseInt @select.val()

		@select.children().remove()

		models.each (model) =>
			opt = $('<option class="popup_option"></option>')
			opt.val model.get 'id'
			opt.html model.get 'title'
			
			# append only if visible or selected
			if selected is parseInt(opt.val()) or model.get('visible')
				@select.append opt

			if selected is parseInt opt.val()
				opt.attr('selected', 'selected')

		@select.selectBox('refresh')

	destroy: =>
		@trigger 'destroy', @
		do @remove

	render: ->
		@$el.html @template models: @models.toJSON()

class ModelsList extends Backbone.View

	template: $.HandlebarsFactory '#create-company-models-list-template'

	home: $('body').data('home')

	url: 'api/get-models-by-make'

	# store models, update on refresh, on add just render it with new view

	initialize: ->

		# store models objects
		@modelsCollection = new ModelsCollection

		# store modelviews
		@modelsArray = []

		@typeId = @options.typeId

		do @getModels

		do @render

		@$el.find('.popup_plus-sign').click @add

	# init ModelView
	# add to @modelsArray
	add: =>
		# if no visible models - return
		if @modelsCollection.where(visible: true).length is 0
			return

		modelview = new ModelView
			models: @modelsCollection.where visible: true

		@modelsArray.push modelview

		do @renderAddModel

		do @updateModelsCollection

		modelview.on 'destroy', @destroyMakesList

		modelview.on 'selectChanged', @updateModelsCollection

	# remove modelview from @modelsArray
	# do updateMakesCollection
	destroyMakesList: (modelview) =>
		@modelsArray.remove modelview

		do @updateModelsCollection

	# reset visible
	# loop @modelsArray
	# get selected option id
	# set visible false where id is selected option
	updateModelsCollection: =>

		@modelsCollection.resetVisible()

		for modelview in @modelsArray
			model = @modelsCollection.get modelview.select.val()
			model.set 'visible', false

		# loop after becauze @modelsCollection must be updated
		for modelview in @modelsArray
			modelview.updateOptions @modelsCollection

	# get models
	# reset @modelsCollection
	# destroy all modelviews in @modelsArray
	# empty @modelsArray
	update: (id) ->
		@typeId = id

		@modelsCollection.reset()

		for model in @modelsArray
			do model.remove

		@modelsArray = []

		do @getModels

	# add models to @modelsCollection
	getModels: ->
		$.ajax "#{@home}/#{@url}",
			data:
				id: @typeId
		.done (d) =>
			@modelsCollection.add d

	destroy: =>
		do @remove

	render: ->
		@$el.append @$el.html @template

	renderAddModel: ->
		model = @modelsArray.last()

		@$el.append model.el

		do model.initSelectbox

	get: ->
		result = []

		if @modelsArray.length is 0
			return 0
		else
			for model in @modelsArray
				result.push parseInt model.select.val()

			return result


module.exports = ModelsList