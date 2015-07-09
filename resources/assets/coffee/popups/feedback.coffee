SelectView = require '../inc/SelectView'

$('#feedback').magnificPopup

	type : 'inline'
	closeBtnInside: true

model = new SelectView 
	el: '#feedback-model'
	url: 'api/get-models-by-make'

make = new SelectView 
	el: '#feedback-make'
	c: model
	url: 'api/get-makes-by-type'

type = new SelectView 
	el: '#feedback-type'
	c: make


class Image extends Backbone.Model
	defaults:
		src: '' 


class ImageCollection extends Backbone.Collection
	model : Image

class ImageView extends Backbone.View

	className : 'feedback_photo'

	template: $.HandlebarsFactory '#photos-template'

	initialize: ->
		self = @
		@model.on('clean', @clean)

		do @render

		@$el.find('.popup_redx:first').click ->
			do self.destroy

	clean: =>
		do @$el.remove

	destroy: =>
		do @model.destroy
		do @clean

	render: ->
		@$el.html @template src : @model.get('src')

class ImagesView extends Backbone.View

	initialize: ->
		@collection.on('add', @added)

	added: (m) =>
		do @clean
		do @render

	clean: ->
		@collection.each (image) =>
			image.trigger('clean')

	render: ->
		@collection.each (image) =>
			view = new ImageView model: image
			@options.plus.before view.el

	get: ->
		r = []
		@collection.each (image) ->
			r.push image.get 'src'

		r


imageCollection = new ImageCollection


imagesView = new ImagesView 
	collection : imageCollection
	el: '#feedback-photos'
	plus: $('#feedback-plus')


class AddPhotos

	constructor: (input, plus) ->
		self = @

		@input = $(input)
		@plus = $(plus)

		@input.change ->
			self.check @files

		@plus.click ->
			self.input.click()

	check: (files) ->
		for file, i in files
			unless file.type.search('image') is -1
				@read file

	read: (file) ->
		src = ''
		r = new FileReader

		if imageCollection.length < 10
			r.onloadend = ->
				imageCollection.add new Image src : r.result

		r.readAsDataURL(file)


new AddPhotos '#feedback-input', '#feedback-plus'

# -------------------------------------------
# ------------- Quill.js
# -------------------------------------------

quill = new Quill '#feedback-editor',
	theme: 'snow'

quill.addModule 'toolbar', container: '#feedback-editor-toolbar'

# quill.setContents [
# 	{insert: '\n'}
# 	{insert: '\n'}
# 	{insert: '\n'}
# 	{insert: '\n'}
# 	{insert: '\n'}
# ]

# -------------------------------------------
# ------------- Quill.js
# -------------------------------------------

class ListModel extends Backbone.Model
	defaults:
		text: ''

class ListCollection extends Backbone.Collection
	model: ListModel

class ListView extends Backbone.View

	template: $.HandlebarsFactory '#plus-minus-template'

	initialize: ->
		self = @

		do @render

		@model.on('clean', @clean)

		@$el.find('.popup_redx').click =>
			do @destroy

		@$el.children('input').keyup ->
			self.model.set('text', $(@).val())

	render: ->
		@$el.html @template text : @model.get 'text'

	destroy: ->
		do @model.destroy
		do @clean

	clean: =>
		do @$el.remove

class List extends Backbone.View

	initialize: ->
		@options.add.on('click', @add)

		# @collection.add new ListModel

		# do @addFirst

	add: =>
		@collection.add new ListModel

		do @clean
		do @render

	clean: ->
		@collection.each (item) ->
			item.trigger('clean')

	addFirst: ->
		v = new ListView 
			model: @collection.at(0)
			className : @options.class

		@$el.children('div:first').after(v.el)

	render: ->
		@collection.each (item) =>
			v = new ListView 
				model: item
				className : @options.class

			@$el.children('div:first').after(v.el)

	get: ->
		r = []
		@collection.each (item) ->
			r.push item.get 'text'

		r


pluses = new List
	add: $('#feedback-add-plus')
	el: '#feedback-pluses'
	class: 'feedback_plus'
	collection: new ListCollection

minuses = new List
	add: $('#feedback-add-minus')
	el: '#feedback-minuses'
	class: 'feedback_minus'
	collection: new ListCollection

$('#add-feedback').click ->

	result = {}

	if type.get()?
		result.type = parseInt type.get()
	else
		type.error()
		return

	# ===================================

	if make.get()?
		result.make = parseInt make.get()
	else
		make.error()
		return

	# ===================================

	if model.get()?
		result.model = parseInt model.get()
	else
		model.error()
		return

	# ===================================
	if imagesView.get().length isnt 0
		result.images = imagesView.get()

	# ===================================

	header = $('#feedback-header')

	if header.val() is ''
		header.blink()
	else
		result.header = header.val()

	# ===================================

	if quill.getLength() is 1
		$('#feedback-editor').blink()
	else
		result.content = quill.getHTML()

	# ===================================

	if pluses.get().length isnt 0
		result.pluses = pluses.get()

	if minuses.get().length isnt 0
		result.minuses = minuses.get()

	# ===================================

	$.ajax "#{$('body').data 'home'}/api/feedback/create",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data: result
		.done (response) =>
			console.log response

	$.magnificPopup.instance.close()