ModelsList = require './ModelsList'

class MakeView extends Backbone.View

	template: Handlebars.compile $('#create-company-make-template').html()

	className: 'create-company_makes-models_item'

	destroy: =>
		do @remove
		do @modelslist.destroy

	postRender: =>
	# do when apended to dom

		self = @

		unless @modelslist
			@modelslist = new ModelsList
				el: @$el.children('.create-company_models')

		# -----------------

		@$el.find('.create-company_make').children('.popup_redx').click =>
			do @destroy

		# -----------------

		@select = @$el.find('.create-company_make').children('select')

		@modelslist.update @select.val()

		# -----------------

		@select.on 'change', ->
			id = $(@).val()
			self.modelslist.update id

		# -----------------

		do @select.selectBox

	render: (makes) =>

		@$el.html @template makes: makes

		@$el


# --------------------------------------------------
# | | | | | | | | | | | | | | | | | |  | | | | | | |
# --------------------------------------------------


class MakesList extends Backbone.View

	collection: []

	home: $('body').data('home')

	url: 'api/get-makes-by-type'

	makes: []

	initialize: ->

		@options.types.on 'changed', @reset

		# add first default
		do @add

		@$el.find('.popup_plus-sign:first').click @add

	add: =>

		@collection.push new MakeView

		do @render

	reset: (id) =>
		# delete all makes but 0, get makes, create new make and add to collection
		toRemove = []
		for make, i in @collection
			unless i is 0
				do make.destroy
				toRemove.push make
		for make in toRemove
			@collection.remove make

		# -----------------

		@getMakes id, (d) =>
			do @render

	getMakes: (id, callback) =>

		$.ajax "#{@home}/#{@url}",
			data:
				id: id
		.done (d) =>
			@makes = d

			callback d

	render: ->

		make = @collection.last()

		@$el.append make.render @makes

		make.modelslist = 0

		do make.postRender



module.exports = MakesList