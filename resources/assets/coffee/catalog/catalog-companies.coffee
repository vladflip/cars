class CompanyModel extends Backbone.Model
	defaults:
		address: ''
		about: ''
		excerpt: ''
		logo: ''
		name: ''
		phone: ''
		tags: []


class CompanyCollection extends Backbone.Collection
	model: CompanyModel


class CompanyView extends Backbone.View

	className: 'company-preview'

	popup: $ '#company-main-popup'

	popupTemplate: if $('#company-template').get 0 then Handlebars.compile $('#company-template').html()

	template: if $('#company-preview-template').get 0 then Handlebars.compile $('#company-preview-template').html()

	initialize: ->

		src = $.parseHTML @popupTemplate
			logo: @model.get 'logo'
			name: @model.get 'name'
			about: @model.get 'about'
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

	render: =>
		@$el.html @template
			logo: @model.get 'logo'
			address: @model.get 'address'
			excerpt: @model.get 'excerpt'
			name: @model.get 'name'

		@$el


	fillModel: ->
		




class CompanyList extends Backbone.View

	home: $('body').data 'home'

	data:
		spec: 0
		make: 0
		skip: 5

	showMoreBtn: $('#show-more-found-companies')

	initialize: ->

		@data.make = @$el.data 'make'

		@url = 'api/get-companies-by-make'

		if @$el.data 'spec'
			@data.spec = @$el.data 'spec'
			@url = 'api/get-companies-by-make-and-spec'

		@collection = new CompanyCollection
		
		do @fillCollection

		if @showMoreBtn
			@showMoreBtn.click @showMore

	fillCollection: ->

		@$el.children('.company-preview').each (i, el) =>

			tags = []

			$(el).children('.company-preview_data').children('div').each (i, el) ->
					tags.push $(el).data 'tag'

			m = new CompanyModel
				logo: $(el).children('.company-preview_logo').css('background-image')

				address: $(el).find('.company-preview_address').html()

				name: $(el).find('.company-preview_name').html()

				excerpt: $(el).find('.company-preview_excerpt').html()

				phone: $(el).children('.company-preview_data').data 'phone'

				about: $(el).children('.company-preview_data').data 'about'

				tags: tags

			v = new CompanyView
				model: m
				el: el
			v.fillModel()
			@collection.add m

	showMore: =>
		do @get

	get: ->
		$.ajax "#{@home}/#{@url}",
			data: @data
		.done (comps) =>
			@updateCollection comps
			@skip += 5

	updateCollection: (comps) =>
		console.log comps
		if comps.length <= 5 then @showMoreBtn.hide()

		for comp, i in comps
			if i < 5
				m = new CompanyModel
						address: comp.address
						about: comp.about
						excerpt: comp.about.excerpt()
						logo: "url(#{comp.logo})"
						name: comp.name
						phone: comp.phone
						tags: comp.tags

				@collection.add m

		do @render

	render: ->
		@$el.html ''
		@collection.each (model) =>
			v = new CompanyView
				model: model
			@$el.append v.render()



companies = new CompanyList
	el: '#catalog-companies'