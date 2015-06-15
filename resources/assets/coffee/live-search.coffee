class ListModel extends Backbone.Model
	defaults:
		id: 0

class ListCollection extends Backbone.Collection
	model: ListModel

class ListView extends Backbone.View

	initialize: -> 
		@class = @options.class

	state: false

	events: 
		'click' : 'changeState'

	changeState: ->
		unless @state then do @active else do @deactivate

	active: ->
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

			self.collection.add new ListModel id: id

			v = new ListView 
				model: self.collection.at(i)
				class: self.options.class
				el: $(@)



types = new List
	el: '#type-list',
	collection: new ListCollection,
	class: 'type_item--active'

specs = new List
	el: '#parts-list',
	collection: new ListCollection,
	class: 'parts--active'

makes = new List
	el: '#makes-list',
	collection: new ListCollection,
	class: 'makes--active'