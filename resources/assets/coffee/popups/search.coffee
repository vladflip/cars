$('#search').magnificPopup

	type : 'inline'
	closeBtnInside: true

class SelectView extends Backbone.View

	initialize: ->
		do @$el.selectBox

	events:
		'change' : 'selected'

	selected: ->
		do @options.c.reset if @options.c
		do @options.c.store if @options.c
		do @render

	reset: ->
		# remove native options
		@$el.find('option:not(:first)').remove()

		# refresh selectbox
		do @$el.selectBox 'refresh'

		# reset on children
		do @options.c.reset if @options.c
		
	render: ->
		# compile handlebars view
		# render select element with options

	store: ->
		# get by ajax options and store in option
		@collection = new Backbone.Collection


model = new SelectView 
	el: '#search-model'

make = new SelectView 
	el: '#search-make'
	c: model

type = new SelectView 
	el: '#search-type'
	c: make



autosize $ '#search-more'