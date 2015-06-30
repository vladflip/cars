class ModelView extends Backbone.View

	template: Handlebars.compile $('#create-company-model-template').html()

	className: 'create-company_model popup_field'

	postRender: =>

		do @$el.children('select').selectBox

		@$el.children('.popup_redx').click =>
			do @destroy

	destroy: =>
		do @remove


	render: (models) ->
		@$el.html @template models: models

		@$el


class ModelsList extends Backbone.View

	template: Handlebars.compile $('#create-company-models-list-template').html()

	home: $('body').data('home')

	url: 'api/get-models-by-make'

	# store models, update on refresh, on add just render it with new view

	initialize: ->

		@collection = []

		@models = []

		@id = 0

		do @render

		@$el.find('.popup_plus-sign').click @add

	add: =>
		v = new ModelView

		@collection.push v

		@$el.append v.render @models

		do v.postRender

	update: (id) ->
		@id = id
	# get models, destroy all modelview
		@getModels id

		toRemove = []
		for model, i in @collection
			do model.remove
			toRemove.push model

		for model in toRemove
			@collection.remove model

	getModels: (id) ->
		$.ajax "#{@home}/#{@url}",
			data:
				id: id
		.done (d) =>
			@models = d

	destroy: =>
		do @remove

	render: ->
		@$el.append @$el.html @template



module.exports = ModelsList