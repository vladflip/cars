ModelsList = require './ModelsList'


class MakeModel extends Backbone.Model
	defaults:
		id: 0
		title: ''
		visible: true

class MakesCollection extends Backbone.Collection
	model: MakeModel

	# reset all models visible to true
	resetVisible: ->
		@.each (model) ->
			model.set 'visible', true

class MakesList extends Backbone.View

	template: $.HandlebarsFactory '#create-company-make-template'

	className: 'create-company_makes-models_item'

	initialize: ->
		@makes = new MakesCollection @options.makes

		do @render

		@$el.find('.create-company_make').children('.popup_redx').click =>
			do @destroy

		@select = @$el.find('.create-company_make').children('select')

		@select.change @selectChanged

		@modelslist = new ModelsList
			el: @$el.children('.create-company_models')
			typeId: parseInt @select.val()

	selectChanged: (e) =>
		@modelslist.update parseInt e.target.value

		@trigger 'selectChanged', e.target.value, @

	# trigger destroy for Makes to updateMakesCollection
	# remove element from dom
	destroy: =>
		@trigger 'destroy', @
		do @remove


	# loop options
	# get value of select
	# remove all options
	# append all where visible or selected
	updateOptions: (makes) ->
		selected = parseInt @select.val()

		@select.children().remove()

		makes.each (make) =>
			opt = $('<option class="popup_option"></option>')
			opt.val make.get 'id'
			opt.html make.get 'title'
			
			# append only if visible or selected
			if selected is parseInt(opt.val()) or make.get('visible')
				@select.append opt

			if selected is parseInt opt.val()
				opt.attr('selected', 'selected')

		@select.selectBox('refresh')

	initSelectbox: ->
		do @select.selectBox

	render: ->

		@$el.html @template makes: @makes.toJSON()


# # --------------------------------------------------
# # | | | | | | | | | | | | | | | | | |  | | | | | | |
# # --------------------------------------------------


# main, holds all makes lists
class Makes extends Backbone.View

	home: $('body').data('home')

	url: 'api/get-makes-by-type'

	makesCollection: new MakesCollection

	makesListArray: []

	active: false

	initialize: ->

		@options.types.on 'changed', @typeUpdated

		@$el.find('.popup_plus-sign:first').click @add

	add: =>
		# if type isnt choosed make error
		if not @active
			@options.types.error()
			return

		# if no more visible - return
		if @makesCollection.where(visible: true).length is 0
			return

		# add makeslist to makesListArray and pass it makes where visible true
		makeslist = new MakesList
			makes:  @makesCollection.where visible: true
		@makesListArray.push makeslist

		makeslist.on 'destroy', @destroyMakesList

		makeslist.on 'selectChanged', @updateMakesCollection

		do @renderAddMakesList

		do @updateMakesCollection


	# remove makeslist from makesListArray
	# do updateMakesCollection
	destroyMakesList: (makeslist) =>
		@makesListArray.remove makeslist

		do @updateMakesCollection


	# loop makesListArray
	# get selected ids
	# visible false in makesCollection where ids
	updateMakesCollection: =>

		@makesCollection.resetVisible()

		for makeslist in @makesListArray
			model = @makesCollection.get makeslist.select.val()
			model.set 'visible', false

		# loop after becauze @makesCollection must be updated
		for makeslist in @makesListArray
			makeslist.updateOptions @makesCollection

	# getMakes
	typeUpdated: (id) =>

		do @reset

		@getMakes id

	# reset makesCollection
	# loop makesListArray call remove
	reset: ->
		@makesCollection.reset()

		for makeslist in @makesListArray
			makeslist.remove()

		@makesListArray = []


	getMakes: (id) =>

		$.ajax "#{@home}/#{@url}",
			data:
				id: id
		.done (makes) =>

			@makesCollection.add makes

			@active = true

			do @add

	renderAddMakesList: ->

		makeslist = @makesListArray.last()

		@$el.append makeslist.el

		makeslist.initSelectbox()


module.exports = Makes