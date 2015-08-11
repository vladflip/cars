class Model extends Backbone.Model
	defaults:
		id: 0
		title: ''
		url: ''
		changed: ''

class ModelsCollection extends Backbone.Collection
	model: Model

class ModelView extends Backbone.View

	initialize: ->

		@editButton = @$el.find('.edit-model')

		@editButton.click @toggleEdit

		@title = @$el.children('td:eq(1)')
		@url = @$el.children('td:eq(2)')

		@$el.append @saveButton

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
			@model.set('title', @titleInput.val())
			@model.set('url', @urlInput.val())
			@model.set('changed', true)



class Models extends Backbone.View

	collection: new ModelsCollection

	initialize: ->

		do @fillCollection

		@button = @$el.parent().find('#new-model')

		@button.click @createModel

	createModel: =>

		console.log @collection

	fillCollection: ->

		@$el.find('.model').each (i, model) =>

			m = new Model
				id: $(model).data 'id'
				title: $(model).data 'title'
				url: $(model).data 'url'

			v = new ModelView
				el: model
				model: m

			@collection.add m

	get: ->
		@collection.where changed:true

module.exports = Models