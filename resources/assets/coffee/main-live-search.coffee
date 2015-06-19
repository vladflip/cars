TypeList = require './inc/TypeList'

class SpecModel extends Backbone.Model
	defaults:
		id: 0
		active: false

class SpecCollection extends Backbone.Collection
	model: SpecModel

class SpecView extends Backbone.View

	initialize: ->

		@class = 'parts--active'

	events:
		'click' : 'changeState'

	changeState: =>
		if @model.get 'active' 
			do @deactivate
		else
			do @activate

		@model.trigger('pass')

	activate: =>
		@$el.addClass @class

		@model.set 'active', true

	deactivate: =>
		@$el.removeClass @class

		@model.set 'active', false

class SpecList extends Backbone.View

	initialize: ->

		@collection = new SpecCollection

		@collection.on 'pass', @pass

		do @fillCollection

	pass: =>
		ids = []
		models = @collection.where active: true
		for model in models
			ids.push model.get 'id'

		@trigger 'changed', ids

	fillCollection: ->
		@$el.children('li').each (i, li) =>
			id = $(li).data('id')
			m = new SpecModel id: id
			v = new SpecView model: m, el: li
			@collection.add m


# initializes default collection from html
# on specs or type changed stores ids in specIds and typeId
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
		@$el.css('display', 'none')

	show: =>
		@$el.css('display', 'block')

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

	url: 'api/live-makes'

	home: $('body').data 'home'

	typeId: 0

	specIds: []

	ids: []

	button: $('#show-found-orgs')

	makesElement: $('.makes.makes--live')

	initialize: ->

		@on 'error', @error

		# dependencies to listen for changes of ids
		@dep = @options.dep

		@collection = new MakeCollection

		@collection.on 'change', @updateIds

		do @setDependencies

		# fill collection from html
		do @fillCollection

	# when no makes chosed
	error: =>
		console.log 'please chose make'

	fillCollection: ->
		@$el.children('li').each (i, li) =>
			id = $(li).data 'id'
			title = $(li).children('span').html().trim()

			m = new MakeModel id: id, title: title
			v = new MakeView model: m, el: li

			@collection.add m

	# listen for changes
	setDependencies: ->
		@dep.specs.on 'changed', @specsChanged

		@dep.type.on 'changed', @typeChanged

	specsChanged: (ids) =>
		@specIds = ids

		do @getMakes

	typeChanged: (id) =>
		@typeId = id

		do @getMakes

	getMakes: ->
		self = @

		$.ajax "#{@home}/#{@url}",
			data: 
				type: @typeId
				specs: @specIds
		.done (ids) ->
			self.updateCollection ids

	hide: ->
		@makesElement.hide()
		@button.hide()

	show: ->
		@makesElement.show()
		@button.css('display', 'flex')

	updateCollection: (ids) ->
		if ids.length is 0
			do @hide
		else
			do @show

			@collection.each (model) ->

				if ids.have model.get 'id'
					model.trigger 'show'
				else
					model.trigger 'hide'

	# update make ids for companies module
	updateIds: (model) =>
		if model.get('active')
			@ids.push model.get 'id'
		else
			@ids.remove model.get 'id'

		@trigger 'changed', @ids



class CompanyModel extends Backbone.Model
	defaults:
		address: ''
		description: ''
		excerpt: ''
		logo: ''
		name: ''
		phone: ''
		tags: ''

class CompanyView extends Backbone.View

	template: Handlebars.compile $('#company-template').html()

	initialize: ->

		@more = @$el.children('.company-preview_more')

		@more.on 'click', @showPopup

	showPopup: =>
		src = @template
			logo: @model.get 'logo'
			name: @model.get 'name'
			description: @model.get 'description'
			address: @model.get 'address'
			phone: @model.get 'phone'
			excerpt: @model.get('description').excerpt()
			tags: @model.get 'tags'

		$.magnificPopup.open
			items:
				src: src
				type: 'inline'
				closeBtnInside: true


class CompanyCollection extends Backbone.Collection
	model: CompanyModel

class CompanyList extends Backbone.View

	url: 'api/get-companies-by-makes'

	home: $('body').data 'home'

	button: $('#show-found-orgs')

	template: Handlebars.compile $('#found-template').html()

	initialize: ->

		@collection = new CompanyCollection

		@ids = []

		@options.makes.on 'changed', @makesChanged

		@button.on 'click', @showMe

	showMe: =>
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

		@$el

	makesChanged: (ids) =>
		@ids = ids

		do @get

	get: ->
		$.ajax "#{@home}/#{@url}",
			data: 
				ids: @ids
		.done (comps) =>
			@updateCollection JSON.parse comps

	updateCollection: (c) ->
		do @collection.reset

		for comp in c
			m = new CompanyModel
					address: comp.address
					description: comp.description
					excerpt: comp.description.excerpt()
					logo: comp.logo
					name: comp.name
					phone: comp.phone
					tags: comp.tags

			@collection.add m


specs = new SpecList
	el: '#parts-list'

types = new TypeList
	el: '#main-type-list'

makes = new MakeList
	el: '#main-makes-list'
	dep: 
		specs: specs
		type: types

companies = new CompanyList
	makes: makes
	el: '#found'