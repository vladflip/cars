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

		@$el.click @edit


		@title = @$el.children('td:eq(1)')
		@url = @$el.children('td:eq(2)')

		@saveButton = $('<td width="40px" style="display:none"><div class="popup_save"><span class="fa fa-chevron-down"></span></div></td>')

		@$el.append @saveButton

		@saveButton.click @saveChanges


	edit: =>

		@titleInput = $("<input value='#{@model.get('title')}'>")
		@urlInput = $("<input value='#{@model.get('url')}'>")

		@title.html @titleInput
		@url.html @urlInput

		@titleInput.focus()

		@saveButton.show()

		@titleInput.click ->
			return false

		@urlInput.click ->
			return false

		document.onclick = =>
			do @hideInputs

			document.onclick = false

		return false

	hideInputs: ->
		
		@title.html @model.get 'title'
		@url.html @model.get 'url'

		@saveButton.hide()

	saveChanges: =>

		if @titleInput.val() isnt (@model.get('title') + '') or @urlInput.val() isnt (@model.get('url') + '')
			@model.set('title', @titleInput.val())
			@model.set('url', @urlInput.val())
			@model.set('changed', true)

		do @hideInputs

		return false



class Models extends Backbone.View

	collection: new ModelsCollection

	initialize: ->

		do @fillCollection

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