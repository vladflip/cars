class TypeModel extends Backbone.Model
	defaults:
		id: 0

class TypesCollection extends Backbone.Collection
	model: TypeModel

class TypeView extends Backbone.View

	initialize: ->

		# css class for active element
		@class = 'type_item--active'

		@model.on('deactivate', @deactivate)

		@state = false

	events:
		'click': 'changeState'

	changeState: =>
		if @state 
			do @deactivate

			@model.trigger('pass')
		else
			do @activate

	activate: =>
		@model.trigger('activate', @model)

		@$el.addClass @class

		@state = true

	deactivate: =>
		@$el.removeClass @class

		@state = false


class TypeList extends Backbone.View

	initialize: ->

		# active type id
		@activeId = 0

		# initialize hardcocded collection
		# anyway TypesCollection will be in the same file
		@collection = new TypesCollection

		# on change model active deactivate other models
		@collection.on 'activate', @deactivate

		@collection.on 'pass', @pass
	
		do @fillCollection

	# fill typescollection with li's in type's @el
	fillCollection: ->
		@$el.children('li').each (i, li) =>

			id = $(li).data('id')
			m = new TypeModel id: id
			v = new TypeView model: m, el: li
			@collection.add m

	deactivate:(model) =>
		@activeId = model.get 'id'

		@collection.each (m) =>
			if m isnt model
				m.trigger('deactivate')

		# trigger event for lower dependencies
		@trigger 'changed', @activeId

	pass: =>
		@activeId = 0

		@trigger 'changed', @activeId


module.exports = TypeList