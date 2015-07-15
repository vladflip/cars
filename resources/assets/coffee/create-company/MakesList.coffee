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

	selectChanged: (e) =>
		@trigger 'selectChanged', e.target.value, @

	# trigger destroy for Makes to updateMakesCollection
	# remove element from dom
	destroy: =>
		@trigger 'destroy', @
		do @remove


	# loop options
	# if not selected and visible false -> delete
	# if not exists append (problem with sort)
	# update selectbox

	# get value of select
	# delete all
	# append all where visible
	updateOptions: (makes) ->
		selected = parseInt @select.val()

		@select.children().remove()

		makes.each (make) =>
			opt = $('<option class="popup_option"></option>')
			opt.val make.get 'id'
			opt.html make.get 'title'
			
			# append only if not visible and not selected
			unless selected isnt parseInt(opt.val()) and not make.get('visible')
				@select.append opt

			if selected is parseInt opt.val()
				opt.attr('selected', 'selected')

		@select.selectBox('refresh')

	initSelectbox: ->
		do @select.selectBox

	render: ->

		@$el.html @template makes: @makes.toJSON()




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

	# update options remove newly selected (first) make 		---todo---
	updateMakesCollection: =>

		@makesCollection.resetVisible()

		for makeslist in @makesListArray
			model = @makesCollection.get makeslist.select.val()
			model.set 'visible', false

		# loop after becauze @makesCollection must be updated
		for makeslist in @makesListArray
			makeslist.updateOptions @makesCollection


	# remove newly selected make to all but current ---todo---
	# add unselected make to all					---todo---
	# do updateMakesCollection						---todo---
	updateOptions:(id, makeslist) =>
		console.log @, id, makeslist

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


# TODO
# append empty makeslist
# allow to add when all makeslist have selected make



# reset makes when new type selected

# trigger options on select changed from makeslist
# update options when makeslist removed
# update options remove newly selected (first) make

# check if exists visible true makes, if no such then on add.click return false






# class MakesList extends Backbone.View

# 	template: $.HandlebarsFactory '#create-company-make-template'

# 	className: 'create-company_makes-models_item'

# 	destroy: =>
# 		do @remove
# 		do @modelslist.destroy

# 	postRender: =>
# 	# do when apended to dom

# 		self = @

# 		unless @modelslist
# 			@modelslist = new ModelsList
# 				el: @$el.children('.create-company_models')

# 		# -----------------

# 		@$el.find('.create-company_make').children('.popup_redx').click =>
# 			do @destroy

# 		# -----------------

# 		@select = @$el.find('.create-company_make').children('select')

# 		@modelslist.update @select.val()

# 		# -----------------

# 		@select.on 'change', ->
# 			id = $(@).val()
# 			self.modelslist.update id

# 		# -----------------

# 		do @select.selectBox

# 	updateOptions: ->


# 	render: (makes) =>

# 		@$el.html @template makes: makes

# 		@$el


# # --------------------------------------------------
# # | | | | | | | | | | | | | | | | | |  | | | | | | |
# # --------------------------------------------------

# class MakesObjectsCollection extends Backbone.Collection



# class Makes extends Backbone.View

# 	collection: []

# 	home: $('body').data('home')

# 	url: 'api/get-makes-by-type'

# 	makes: []

# 	active: false

# 	initialize: ->

# 		@options.types.on 'changed', @reset

# 		# add first default
# 		# do @add

# 		@$el.find('.popup_plus-sign:first').click @add

# 	add: =>
# 		# if type isnt choosed return
# 		if not @active 
# 			@options.types.error()

# 			return

# 		@collection.push new MakesList
# 			makes: @makes

# 		do @render

# 		@makes.splice(0, 1)

# 		for makeslist in @collection
# 			makeslist.updateOptions()

# 	reset: (id) =>
# 		@active = true

# 		# delete all makes but 0, get makes, create new make and add to collection
# 		toRemove = []
# 		for make, i in @collection
# 			unless i is 0
# 				do make.destroy
# 				toRemove.push make
# 		for make in toRemove
# 			@collection.remove make

# 		# -----------------

# 		@getMakes id, (d) =>
# 			do @render

# 			@makes.remove({id:1})

# 	getMakes: (id, callback) =>

# 		$.ajax "#{@home}/#{@url}",
# 			data:
# 				id: id
# 		.done (d) =>
# 			@makes = d

# 			callback d

# 	render: ->

# 		make = @collection.last()

# 		@$el.append make.render @makes

# 		make.modelslist = 0

# 		do make.postRender



module.exports = Makes