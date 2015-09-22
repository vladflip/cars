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

class Thumbnails extends Backbone.View

	collection : new ImageCollection

	initialize: ->
		@collection.on('add', @added)

		@plus = @options.plus

		@reader = @options.reader

		@reader.on 'read', @fillCollection

		@plus.click =>
			@reader.input.click()

	fillCollection: (res) =>
		for src, i in res
			if i is 10 then break

			@collection.add src: src

	added: (m) =>
		do @clean
		do @render

	clean: ->
		@collection.each (image) =>
			image.trigger('clean')

	render: ->
		@collection.each (image) =>
			view = new ImageView model: image
			@plus.before view.el

	get: ->
		r = []
		@collection.each (image) ->
			r.push image.get 'src'

		r

module.exports = Thumbnails