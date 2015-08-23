TypeList = require '../inc/TypeList'

class MakeModel extends Backbone.Model
	defaults:
		id: 0

class MakeCollection extends Backbone.Collection
	model: MakeModel
	active: true

class MakeView extends Backbone.View

	initialize: ->

		@model.on('hide', @hide)

		@model.on('show', @show)

	hide: =>
		@$el.css('display', 'none')

	show: =>
		@$el.css('display', 'block')



class MakeList extends Backbone.View

	home: $('body').data 'home'

	active: 0

	empty: $ '.makes_empty'

	initialize: ->

		if @$el.length is 0 then return

		self = @

		@deps = {}

		@collection = new MakeCollection

		@options.types.on 'changed', @changed

		do @fillCollection

		for li, i in @options.types.$el.children()
			i = i+1
			do (i) ->
				setTimeout ->
					self.get i
				, 1000

	fillCollection: ->
		@$el.find('li').each (i, li) =>
			m = new MakeModel
				id: $(li).data 'id'
			@collection.add m

			v = new MakeView
				model: m
				el: li

	changed: (id) =>
		if id is 0
			do @reset
			@active = 0
		# when 0 just change active then @shoeIfActive do its best
		else if @deps[id] is undefined
			@active = id
		else
			@updateCollection id

	updateCollection: (id) ->
		if @deps[id].length is 0
			do @empty.show
		else
			do @empty.hide
		@collection.each (model) =>

			if @deps[id].have model.get 'id'
				model.trigger 'show'
			else
				model.trigger 'hide'

	# show all
	reset: ->
		do @empty.hide
		@collection.each (model) ->
			model.trigger 'show'

	showIfActive: (id) =>
		if @active isnt 0 and @active is id
			@changed @active

class MainMakes extends MakeList

	url: 'api/get-makes-by-type-has-comps'

	get: (i) ->
		$.ajax "#{@home}/#{@url}",
			data:
				id: i
		.done (makes) =>
			@deps[i] = []
			for make in makes
				@deps[i].push make.id
			# console.log makes

			@showIfActive i


class SpecMakes extends MakeList

	url: 'api/live-makes'

	get: (i) ->
		$.ajax "#{@home}/#{@url}",
			data:
				type: i
				spec: @$el.data 'current'
		.done (ids) =>
			@deps[i] = ids
		
			@showIfActive i



types = new TypeList
	el: '#catalog-types'

setTimeout ->
	do types.click
, 400

makes = new MainMakes
	el: '#catalog-makes'
	types: types

specmakes = new SpecMakes
	el: '#catalog-specmakes'
	types: types