class CompanyModel extends Backbone.Model
	defaults:
			address: ''
			description: ''
			excerpt: ''
			logo: ''
			name: ''
			phone: ''
			tags: []


class CompanyCollection extends Backbone.Collection
	model: CompanyModel


class CompanyView extends Backbone.View

	popup: $ '#company-main-popup'

	template: if $('#company-template').get 0 then Handlebars.compile $('#company-template').html()

	initialize: ->

		do @fillModel

		src = $.parseHTML @template
			logo: @model.get 'logo'
			name: @model.get 'name'
			description: @model.get 'description'
			address: @model.get 'address'
			phone: @model.get 'phone'
			tags: @model.get 'tags'

		@$el.magnificPopup
			type: 'inline'
			closeBtnInside: true
			items:
				src: '#company-main-popup'

			callbacks:
				open: =>
					@popup.append src

					@popup.find('.company-popup_close').click =>
						$.magnificPopup.instance.close()

				close: =>
					@popup.html ''


	fillModel: ->
		@model.set 'logo', @$el.children('.company-preview_logo').css('background-image')

		@model.set 'address', @$el.find('.company-preview_address').html()

		@model.set 'name', @$el.find('.company-preview_name').html()

		@model.set 'excerpt', @$el.find('.company-preview_excerpt').html()

		@model.set 'phone', @$el.children('.company-preview_data').data 'phone'

		@model.set 'description', @$el.children('.company-preview_data').data 'description'

		tags = []

		@$el.children('.company-preview_data').children('div').each (i, el) ->
			tags.push $(el).data 'tag'

		@model.set 'tags', tags




class CompanyList extends Backbone.View

	initialize: ->

		@collection = new CompanyCollection
		
		do @fillCollection

	fillCollection: ->
		@$el.children('.company-preview').each (i, el) =>
			m = new CompanyModel
			v = new CompanyView
				model: m
				el: el
			@collection.add m

companies = new CompanyList
	el: '#catalog-companies'