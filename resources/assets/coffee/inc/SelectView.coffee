class SelectView extends Backbone.View

	home: $('body').data('home')

	initialize: ->
		do @$el.selectBox

	events:
		'change' : 'selected'

	selected: ->
		do @options.c.reset if @options.c
		@options.c.store @$el.val() if @options.c

	reset: ->
		# remove native options
		@$el.find('option:not(:first)').remove()

		# refresh selectbox
		@$el.selectBox 'refresh'

		# reset on children
		do @options.c.reset if @options.c
		
	render: ->
		temp = Handlebars.compile $('#options-template').html()

		options = temp @options.json

		html = $.parseHTML(options)

		@$el.find('option:first').after(html)

		@$el.selectBox 'refresh'

	store: (id) ->
		self = @
		$.ajax "#{@home}/#{@options.url}",
			data:
				id: id
		.done (d) ->
			self.options.json = d

			console.log d

			do self.render

	get: ->
		@$el.val()

module.exports = SelectView