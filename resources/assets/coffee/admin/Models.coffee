class Model extends Backbone.Model
	defaults:
		id: 0
		title: ''
		url: ''
		changed: ''
		new: 0
		type: 0

class ModelsCollection extends Backbone.Collection
	model: Model

class ModelView extends Backbone.View

	className: 'model'

	tagName: 'tr'
	
	home: $('#csrf').data 'home'

	types: do ->

		for type in $('#types').children()
			id: $(type).data 'id'
			title: $(type).data 'title'

	init: ->

		@editButton = @$el.find('.edit-model')
		@removeButton = @$el.find('.delete-model')

		@removeButton.click @removeModel

		@editButton.click @toggleEdit

		@title = @$el.children('td:eq(1)')
		@url = @$el.children('td:eq(2)')
		@type = @$el.children('td:eq(3)')

		@$el.append @saveButton

	removeModel: =>

		bootbox.confirm 'Вы точно хотите удалить эту модель?', (remove) =>

			if remove

				if not @model.get('new')
					$.ajax "#{@home}/api/admin/remove-model",
						headers:
							'X-CSRF-TOKEN' : $('#csrf').data 'csrf'
						method: 'POST'
						data:
							id: @model.get 'id'

				do @remove


	toggleEdit: =>

		if @editButton.hasClass 'activated'
			@editButton.html '<i class="fa fa-pencil"></i>'
			@editButton.toggleClass 'activated'

			do @saveChanges
			do @hideInputs
		else
			@editButton.html '<i class="fa fa-chevron-down" style="color:green"></i>'
			@editButton.toggleClass 'activated'

			do @edit

	edit: =>

		@titleInput = $("<input value='#{@model.get('title')}'>")
		@urlInput = $("<input value='#{@model.get('url')}'>")

		@title.html @titleInput
		@url.html @urlInput

		@titleInput.focus()

		do @showTypeSelect

	showTypeSelect: ->

		@select = $ '<select></select>'

		for type in @types
			if type.id is @model.get 'type_id'
				option = "<option selected value='#{type.id}'>#{type.title}</option>"
			else
				option = "<option value='#{type.id}'>#{type.title}</option>"
			@select.append option

		@type.html @select

	hideInputs: ->
		
		@title.html @model.get 'title'
		@url.html @model.get 'url'
		@type.html @model.get 'type_title'

	saveChanges: =>

		if @titleInput.val() isnt (@model.get('title') + '') or @urlInput.val() isnt (@model.get('url') + '')
			if @titleInput.val() isnt '' and @urlInput.val() isnt ''
				@model.set('title', @titleInput.val())
				@model.set('url', @urlInput.val())
				@model.set('changed', true)

		else if @titleInput.val() is '' and @urlInput.val() is ''
			return



		if parseInt(@select.val()) isnt @model.get 'type_id'
			@model.set 'changed', true
			@model.set 'type_id', parseInt @select.val()

			@model.set 'type_title', do =>
				for type in @types
					if type.id is @model.get 'type_id'
						return type.title

	render: ->

		@$el.append "<td>#{@model.get('id')}</td>"
		@$el.append '<td></td>'
		@$el.append '<td></td>'
		@$el.append '<td></td>'
		@$el.append "
			<td>
				<div class='btn btn-default btn-sm edit-model'>
					<i class='fa fa-pencil'></i>
				</div>
				<div class='btn btn-danger btn-delete btn-sm delete-model'>
					<i class='fa fa-times'></i>
				</div>
			</td>
		"



class Models extends Backbone.View

	initialize: ->

		@collection = new ModelsCollection

		do @fillCollection

		@button = @$el.parent().find('#new-model')

		@button.click @createModel

	createModel: =>

		m = new Model
			id: @collection.length + 1
			new: 1

		@collection.add m

		v = new ModelView
			model: m

		v.render()

		v.init()

		v.toggleEdit()

		@$el.prepend v.el

	fillCollection: ->

		@$el.find('.model').each (i, model) =>

			m = new Model
				id: $(model).data 'id'
				title: $(model).data 'title'
				url: $(model).data 'url'
				type_id: $(model).data 'type-id'
				type_title: $(model).data 'type-title'

			v = new ModelView
				el: model
				model: m

			v.init()

			@collection.add m

	get: ->
		@collection.where changed:true

module.exports = Models