Array.prototype.have = (i) ->
	if @indexOf(i) is -1 then return false else true

Array.prototype.remove = (i) ->
	@splice(@indexOf(i), 1)

Array.prototype.in = (i) ->
	for make in @
		if make.id is i then return true
	false

class ListModel extends Backbone.Model
	defaults:
		id: 0
		title: ''

class ListCollection extends Backbone.Collection

	model: ListModel

class ListView extends Backbone.View

	home: $('body').data 'home'

	url: 'api/live-makes'

	initialize: -> 
		@class = @options.class

		@state = false

	events: 
		'click' : 'changeState'

	changeState: ->
		unless @state then do @activate else do @deactivate

	activate: ->
		@$el.addClass @class
		@state = true

	deactivate: ->
		@$el.removeClass @class
		@state = false

class List extends Backbone.View

	initialize: ->
		self = @

		@$el.children('li').each (i) ->
			id = $(@).data('id')

			title = $(@).children('span').html()

			self.collection.add new ListModel 
				id: id
				title: title.trim()

			self.createViews i, @

	createViews: (i, li) ->
		v = new ListView 
			model: @.collection.at(i)
			class: @.options.class
			el: $(li)

class ConcreteView extends ListView

	get: (o, f) ->
		# download makes and store to makes array
		self = @
		id = o.id

		$.ajax "#{@home}/#{@url}",
			data: o
		.done (d) ->
			self.makes.push
				id : id
				makes : d
			if f then do f

	activate: ->
		self = @

		super

		id = @model.get 'id'

		@selected.push id

		if @makes.in id
			do @pass
		else
			@get
				name: @options.name
				id: id
				, ->
					do self.pass


	deactivate: ->
		super

		id = @model.get 'id'

		@selected.remove id

		do @pass

	pass: ->
		# get all makes that selected and add in collection
		# держать все мейки в коллекции и внутри одного модуля
		# добавлять и убирать с коллекции, не будет лишних
		# может быть ремув не удалять а брать все оставшиеся и давать
		makes = []
		for make in @makes
			if @selected.have make.id
				for inner in make.makes
					makes.push inner
		@options.c.cache makes, @options.name

	remove: (id) ->
		for make in @makes
			if make.id == id
				@options.c.remove make.makes


class TypeView extends ConcreteView

	selected: []

	makes: []

class SpecView extends ConcreteView

	selected: []

	makes: []


class TypeList extends List

	createViews: (i, li) ->
		v = new TypeView 
			model: @.collection.at(i)
			class: @.options.class
			el: $(li)
			c: @options.c
			name: 'type'

class SpecList extends List

	createViews: (i, li) ->
		v = new SpecView 
			model: @.collection.at(i)
			class: @.options.class
			el: $(li)
			c: @options.c
			name: 'spec'

class MakeCollection extends ListCollection

	comparator: (model) ->
		model.get 'title'

class MakeView extends Backbone.View

	tagName: 'li'

	initialize: ->
		@el.dataset.id = @model.get 'id'

		@model.on('destroy', @clean)

	clean: =>
		do @remove


	template: Handlebars.compile $('#makes-template').html()

	render: ->
		@$el.html @template
			title: @model.get 'title'
		this


class MakeList extends List

	initialize:->
		super

		@all = true

		@makes = {}

		@defaultCollection = []

		@collection.each (make) =>
			@defaultCollection.push new ListModel
				id: make.get 'id'
				title: make.get 'title'
			

	add: ->
		if @all
			do @resetCollection
			@all = false

		do @clean

		uploadDefaultCollection = 0

		makes = []

		for k, col of @makes
			col.each (make) =>
				makes.push make
		
		@collection.set makes

		if @collection.length is 0
			@collection.add @defaultCollection

		do @render

	cache: (makes, name) ->
		@makes[name] = new MakeCollection
		for make in makes
			@makes[name].add new ListModel
				id: make.id
				title: make.title

		do @add


	clean: ->
		@collection.each (make) ->
			make.trigger 'destroy'

	resetCollection: ->
		@collection.each (make) ->
			make.trigger 'destroy'
		do @collection.reset

	remove:(makes) ->
		m = []
		for make in makes
			m.push new ListModel
				id: make.id
				title: make.title
		do @clean
		@collection.remove m
		do @render


	render: ->
		# утечка памяти
		@collection.each (make) =>
			v =	new MakeView
				model: make
			@$el.append(v.render().el)

	createViews: (i, li) ->
		v = new MakeView 
			model: @collection.at(i)
			class: @options.class
			el: $(li)

makes = new MakeList
	el: '#makes-list',
	collection: new MakeCollection,
	class: 'makes--active'

specs = new SpecList
	el: '#parts-list',
	collection: new ListCollection,
	class: 'parts--active',
	c: makes

types = new TypeList
	el: '#type-list',
	collection: new ListCollection,
	class: 'type_item--active'
	c: makes