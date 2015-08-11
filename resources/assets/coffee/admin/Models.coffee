class Model extends Backbone.Model
	defaults:
		id: 0
		title: ''
		url: ''
		changed: ''
		new: 0

class ModelsCollection extends Backbone.Collection
	model: Model

class ModelView extends Backbone.View

	className: 'model'

	tagName: 'tr'

	init: ->

		@editButton = @$el.find('.edit-model')

		@editButton.click @toggleEdit

		@title = @$el.children('td:eq(1)')
		@url = @$el.children('td:eq(2)')

		@$el.append @saveButton

		# remove without asking if model is new


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

	hideInputs: ->
		
		@title.html @model.get 'title'
		@url.html @model.get 'url'

	saveChanges: =>

		if @titleInput.val() isnt (@model.get('title') + '') or @urlInput.val() isnt (@model.get('url') + '')
			if @titleInput.val() isnt '' and @urlInput.val() isnt ''
				@model.set('title', @titleInput.val())
				@model.set('url', @urlInput.val())
				@model.set('changed', true)

	render: ->

		@$el.append "<td>#{@model.get('id')}</td>"
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

		@$el.prepend v.el

	fillCollection: ->

		@$el.find('.model').each (i, model) =>

			m = new Model
				id: $(model).data 'id'
				title: $(model).data 'title'
				url: $(model).data 'url'

			v = new ModelView
				el: model
				model: m

			v.init()

			@collection.add m

	get: ->
		@collection.where changed:true

module.exports = Models