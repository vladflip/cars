class Make extends Backbone.Model
	defaults:
		id: ''
		title: ''
		url: ''

class MakeView extends Backbone.View

	popup: $ '#admin-popup'

	template: Handlebars.compile $('#admin-makes-template').html()

	initialize: ->

		src = @template
			title: @model.get 'title'
			url: @model.get 'url'
			models: @model.get 'models'

		@$el.magnificPopup
			type: 'inline'
			closeBtnInside: true
			items:
				src: '#admin-popup'

			callbacks:
				open: =>
					@popup.append src

					# @popup.find('.company-popup_close').click =>
					# 	$.magnificPopup.instance.close()

				close: =>
					@popup.html ''

		

class MakesCollection extends Backbone.Collection
	model: Make

class Makes extends Backbone.View

	initialize: ->

		do @fillCollectiion

	fillCollectiion: ->

		@$el.find('.make').each (i, make) =>
			m = new Make
				id: $(make).data 'id'
				title: $(make).data 'title'
				url: $(make).data 'url'
				models: @getModels make

			v = new MakeView
				el: make
				model: m

	getModels: (make) ->

		models = []

		$(make).find('.model').each (i, model) =>

			models.push
				id: $(model).data 'id'
				title: $(model).data 'title'
				url: $(model).data 'url'

		models

new Makes
	el: '#admin-makes'