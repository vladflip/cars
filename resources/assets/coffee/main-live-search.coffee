TypeList = require './inc/TypeList'


# initializes default collection from html
# on type changed stores id 
# then gets makes be typeid and specids and updates collection

class MakeModel extends Backbone.Model
	defaults:
		id: 0
		title: ''
		active: false

class MakeCollection extends Backbone.Collection
	model: MakeModel

class MakeView extends Backbone.View

	initialize: ->
		@class = 'makes--active'

		@model.on('hide', @hide)

		@model.on('show', @show)

	hide: =>
		@$el.hide()
		do @deactivate

	show: =>
		@$el.show()

	events: 
		'click' : 'changeState'

	changeState: =>
		unless @model.get('active') then do @activate else do @deactivate

	activate: ->
		@$el.addClass @class

		@model.set 'active', true

	deactivate: ->
		@$el.removeClass @class

		@model.set 'active', false

class MakeList extends Backbone.View

	makesIds: []

	chosenIds: []

	collection: new MakeCollection

	showButton: $ '#show-found-orgs'

	initialize: ->

		do @getMakesTypeIds

		do @fillCollection

		@collection.on 'change', @makeChosen

		@options.types.on 'changed', @updateCollection

	getMakesTypeIds: ->
		el = $ '#type-makes-ids'

		el.children().each (i, type) =>
			@makesIds.push $(type).data 'ids'

	updateCollection: (id) =>

		ids = @makesIds[id-1]

		if id isnt 0

			@collection.each (model) ->
				if ids.have model.get 'id'
					model.trigger 'show'
				else
					model.trigger 'hide'

		else
			@collection.each (model) ->
				model.trigger 'show'

		do @triggerShowButton

	triggerShowButton: ->

		model = @collection.findWhere 'active': true
		if model
			@showButton.css 'display', 'flex'
		else
			@showButton.hide()


	fillCollection: ->

		@$el.find('li').each (i, li) =>
			id = $(li).data 'id'
			title = $(li).children('span').html().trim()

			m = new MakeModel id: id, title: title
			v = new MakeView model: m, el: li

			@collection.add m

	makeChosen: (model) =>

		if model.get 'active'
			@chosenIds.push model.get 'id'
		else
			@chosenIds.remove model.get 'id'

		do @triggerShowButton



class CompanyModel extends Backbone.Model
	defaults:
		address: ''
		about: ''
		excerpt: ''
		logo: ''
		name: ''
		phone: ''
		tags: ''

class CompanyView extends Backbone.View

	template: $.HandlebarsFactory '#company-template'

	popup: $ '#company-main-popup'

	initialize: ->

		src = $.parseHTML @template
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



class CompanyCollection extends Backbone.Collection
	model: CompanyModel

class CompanyList extends Backbone.View

	url: 'api/get-companies-by-makes-and-specs'

	home: $('body').data 'home'

	button: $('#show-found-orgs')

	template: $.HandlebarsFactory  '#found-template'

	initialize: ->

		@toSkip = 0

		@active = false

		@collection = new CompanyCollection

		@ids = []

		@options.makes.on 'changed', @makesChanged

		@button.on 'click', @showMe

		@options.makes.on 'hideComps', @hideMe

	hideMe: =>
		@$el.html ''

	showMe: =>
		@active = true
		if @ids.length is 0
			@options.makes.trigger 'error'
			return

		$('html, body').animate
	        scrollTop: @$el.offset().top
	    , 500

	    do @render

	render: ->
		@$el.html @template 
			companies: @collection.toJSON()

		@$el.find('.company-preview').each (i, el) =>
			v = new CompanyView
				model: @collection.at i
				el: el

		@showMore = @$el.find('.found_more')

		unless @more then @showMore.hide()
		else
			@showMore.click @getMore

	makesChanged: (ids) =>

		@ids = ids

		do @hideMe

		@toSkip = 0

		@active = false

		do @get

	get: ->
		$.ajax "#{@home}/#{@url}",
			data: 
				type: @ids.type
				makes: @ids.makes
				spec: @ids.spec
				skip: @toSkip

		.done (comps) =>
			@fillCollection JSON.parse comps
			console.log JSON.parse(comps).length

	fillCollection: (c) ->
		do @collection.reset

		for comp, i in c
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
			else
				console.log comp
				@more = true

		if @active then do @render

	getMore: =>
		@toSkip += 5
		@more = false

		$.ajax "#{@home}/#{@url}",
			data: 
				type: @ids.type
				makes: @ids.makes
				spec: @ids.spec
				skip: @toSkip
		.done (comps) =>
			@updateCollection JSON.parse comps

	updateCollection: (c) =>
		for comp, i in c
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
			else
				console.log comp
				@more = true

		do @render



types = new TypeList
	el: '#main-type-list'

makes = new MakeList
	el: '#main-makes-list'
	types: types

companies = new CompanyList
	el: '#found'
	makes: makes