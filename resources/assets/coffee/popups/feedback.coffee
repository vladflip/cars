SelectView = require '../inc/SelectView'
ImageReader = require '../inc/ImageReader'
Thumbnails = require '../inc/Thumbnails'

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


thumbnails = new Thumbnails 
	el: $('#feedback-photos')
	plus: $('#feedback-plus')
	reader: new ImageReader '#feedback-input'

# -------------------------------------------
# ------------- Quill.js
# -------------------------------------------
if $('#feedback-editor').length isnt 0
	quill = new Quill '#feedback-editor',
		theme: 'snow'

	quill.addModule 'toolbar', container: '#feedback-editor-toolbar'

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

		@model.on 'error', @error

		@$el.find('.popup_redx').click =>
			do @destroy

		@$el.children('input').keyup ->
			self.model.set('text', $(@).val())

	error: =>
		@$el.children('input').blink()

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

			@$el.append(v.el)

	get: ->
		r = []
		@collection.each (model) ->
			r.push model
		r

	getText: ->
		r = []
		@collection.each (model) ->
			r.push model.get 'text'
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
	if thumbnails.get().length isnt 0
		result.images = thumbnails.get()

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
		for plus in pluses.get()
			if plus.get('text').length is 0
				plus.trigger 'error'
				return false

		result.pluses = pluses.getText()

	if minuses.get().length isnt 0
		for minus in minuses.get()
			if minus.get('text').length is 0
				minus.trigger 'error'
				return false
				
		result.minuses = minuses.getText()

	# ===================================

	$(@).preload('start')

	$.ajax "#{$('body').data 'home'}/api/feedback/create",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data: result
		.done (response) =>
			console.log response

			$(@).preload('stop')

			setTimeout ->
				$.magnificPopup.instance.close()
				$.alert 'Ваш отзыв об авто добавлен и будет доступен на сайте после проверки.', true
			, 1000
			setTimeout =>
				$(@).preload('reset')
			, 1500