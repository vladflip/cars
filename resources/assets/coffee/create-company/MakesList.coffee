ModelsList = require './ModelsList'

class MakeView extends Backbone.View

	template: Handlebars.compile $('#create-company-make-template').html()

	className: 'create-company_make'

	initialize: ->
		# default init, create models list

		@modelslist = new ModelsList

	destroy: =>
		do @remove
		do @modelslist.destroy

	postRender: =>
	# do when apended to dom

		do @$el.children('select').selectBox

	render: (makes) =>
		self = @

		@$el.html @template makes: makes

		# -----------------

		@$el.children('.popup_redx').click =>
			do @destroy

		# -----------------

		id = @$el.children('select').val()

		@modelslist.update id

		# -----------------

		@$el.children('select').on 'change', ->
			id = $(@).val()
			self.modelslist.update id

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

		@$el.parent().find('.popup_plus-sign').click @add

	add: =>
		v = new MakeView

		@collection.push v

		do @render

	reset: (id) =>
		# delete makes all but 0, get makes and reset options in 0 make
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

		do make.postRender



module.exports = MakesList