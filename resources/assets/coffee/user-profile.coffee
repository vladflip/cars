Avatar = require './inc/Avatar'

$('#profile-pen').magnificPopup

	type: 'inline'
	closeBtnInside: true

class FieldModel extends Backbone.Model
	defaults:
		value      : ''
		newvalue   : ''
		name       : ''
		title      : ''
		state      : 'same'
		elToRefresh: ''

class FieldCollection extends Backbone.Collection
	model: FieldModel

class FieldView extends Backbone.View

	className: 'popup_field'

	template: $.HandlebarsFactory '#popup-field-template'

	initialize: ->

		do @render

		@model.on 'error', @error
		@model.on 'update', @update

		if @model.get('name') is 'about'
			@input = @$el.children 'textarea'
		else
			@input = @$el.children 'input'

		if @input.val() is ''
			@model.set 'state', 'empty'

		@input.keyup @updateModel

	updateModel: =>
		@model.set 'newvalue', @input.val()

		if @model.get('value') is @model.get('newvalue')
			@model.set 'state', 'same'
		else if @model.get('newvalue') is ''
			@model.set 'state', 'empty'
		else
			@model.set 'state', 'ready'

	# update when changes saved, value = newvalue, state = same, update dom
	update: =>
		el = @model.get 'elToRefresh'

		if @model.get('newvalue') isnt ''
			@model.set 'value', @model.get 'newvalue'

		@model.set 'state', 'same'

		el.html @model.get 'value'

	error: =>
		@$el.children('input, textarea').blink()

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

	url  : 'api/user/edit'
	
	home : $('body').data 'home'
	
	button: $ '#edit-profile-button'

	initialize: ->

		do @render

		@button.click @saveChanges

	saveChanges: =>
		pass = true
		data = {}

		@collection.each (field) ->
			if field.get('state') is 'empty'
				field.trigger 'error'
				pass = false
			else if field.get('newvalue') isnt ''
				data[field.get('name')] = field.get('newvalue')

		if pass then @post data

	updateModels: ->
		@collection.each (model) ->
			model.trigger 'update'

	post: (data) ->
		$.ajax "#{@home}/#{@url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data: data
		.done (response) =>
			console.log response
			# loading icon
			do @updateModels
			$.magnificPopup.instance.close()



	# init views and append to popup content
	render: ->
		@collection.each (field) =>
			v = new FieldView
				model: field

			@button.before v.el


new Avatar '#user-logo', '#user-logo-file'


collection = new FieldCollection

collection.add new FieldModel
	name: 'name' 
	value: $.trim( $('#edit-profile-name').children('span:first').html() )
	title: 'Имя'
	elToRefresh: $('#edit-profile-name').children('span:first')

collection.add new FieldModel
	name: 'address'
	value: $.trim($('#edit-profile-address').html())
	title: 'Адрес'
	elToRefresh: $('#edit-profile-address')

collection.add new FieldModel
	name: 'phone'
	value: $.trim($('#edit-profile-phone').html())
	title: 'Телефон'
	elToRefresh: $('#edit-profile-phone')

collection.add new FieldModel
	name: 'about'
	value: $.trim($('#edit-profile-about').html())
	title: 'О себе'
	elToRefresh: $('#edit-profile-about')


new FieldSet
	collection: collection