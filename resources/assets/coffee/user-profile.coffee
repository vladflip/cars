$('#profile-pen').magnificPopup

	type: 'inline'
	closeBtnInside: true

class FieldModel extends Backbone.Model
	defaults:
		value  : ''
		name   : ''
		title  : ''
		default: ''

class FieldCollection extends Backbone.Collection
	model: FieldModel

class FieldView extends Backbone.View

	className: 'popup_field'

	template: if $('#popup-field-template').get 0 then Handlebars.compile $('#popup-field-template').html()

	initialize: ->

		do @render

	render: ->
		if @model.get('value')

			@$el.html @template
				label: @model.get 'title'
				value: @model.get 'value'
				input: if @model.get('name') is 'about' then false else true

		else

			@$el.html @template
				label: @model.get 'title'
				input: if @model.get('name') is 'about' then false else true

		@$el

class FieldSet extends Backbone.View

	url  : 'api/edit-profile'
	
	home : $('body').data 'home'
	
	button: $ '#edit-profile-button'

	initialize: ->

		do @render

	# init views and append to popup content
	render: ->
		@collection.each (field) =>
			v = new FieldView
				model: field

			@button.before v.el




collection = new FieldCollection

collection.add new FieldModel
	name: 'name' 
	value: $.trim( $('#edit-profile-name').children('span:first').html() )
	title: 'Имя'

collection.add new FieldModel
	name: 'address'
	value: $.trim($('#edit-profile-address').html())
	title: 'Адрес'

collection.add new FieldModel
	name: 'phone'
	value: $.trim($('#edit-profile-phone').html())
	title: 'Телефон'

collection.add new FieldModel
	name: 'about'
	value: $.trim($('#edit-profile-about').html())
	title: 'О себе'


new FieldSet
	collection: collection