SelectView = require '../inc/SelectView'

$('#create-company-button').magnificPopup

	type: 'inline'
	closeBtnInside: true


specs = $('#create-company-spec')

do specs.selectBox


autosize $ '#create-company-about'


class AddLogo

	constructor: (btn, input, container) ->

		self = @

		@btn = $(btn)

		@input = $(input)

		@container = $(container)

		@input.change ->
			self.check @files

		@btn.click ->
			self.input.click()

	check: (files) =>
		file = files[0]
		if file.type.search('image') is -1
			do @error
		else
			@read file

	error: ->
		alert 'это не картинка'

	append: (src) ->
		@container.html ''
		img = new Image
		img.src = src
		console.log img
		@container.html img

	read: (file) ->
		src = ''
		r = new FileReader

		r.onloadend = =>
			src = r.result

			@append src

		r.readAsDataURL(file)


new AddLogo '#create-company-logo-btn', 
			'#create-company-logo',
			'#create-company-logo-html'


class SelectType extends Backbone.View

	initialize: ->
		self = @

		do @$el.selectBox

		@$el.change ->
			
			self.trigger 'changed', $(@).val()



class MakeView extends Backbone.View

	template: Handlebars.compile $('#create-company-make-template').html()

	className: 'create-company_make'

	render: (makes) ->
		@$el.html @template makes: makes

		@$el.children('.popup_redx').click =>
			do @remove

			@trigger 'remove', @

		@$el

class MakesList extends Backbone.View

	home: $('body').data('home')

	url: 'api/get-makes-by-type'

	makes: []

	template: Handlebars.compile $('#create-company-make-template').html()

	collection: []

	container: $ '.create-company_added'

	initialize: ->
		@options.types.on 'changed', @get

		@first = @$el.children('.create-company_make')

		do @first.children('select').selectBox

		@plus = @$el.parent().find('.popup_plus-sign')

		@plus.click @add

	update: ->
		@collection = []
		@container.html ''

		do @updateFirst

	updateFirst: ->
		@first.html @template makes: @makes

		do @first.children('select').selectBox

	get: (id) =>
		$.ajax "#{@home}/#{@url}",
			data:
				id: id
		.done (d) =>
			@makes = d

			do @update

	add: =>
		v = new MakeView

		@collection.push v

		v.on 'remove', @removed

		do @render

	removed: (v) =>
		@collection.remove v

	render: ->
		for make in @collection
			el = make.render @makes

			@container.append el

			do el.children('select').selectBox






types = new SelectType 
	el: '#create-company-type'

makes = new MakesList 
	el: '#create-company-makes-list'
	types: types