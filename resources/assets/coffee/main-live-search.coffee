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

		@model.on 'deactivate', @deactivate

	events:
		'click' : 'changeState'

	changeState: =>
		if @model.get 'active' 
			do @deactivate
		else
			do @activate

		@model.trigger('pass')

	activate: =>
		if @options.list.active
			@$el.addClass @class

			@model.set 'active', true
		else
			@options.list.trigger 'error'


	deactivate: =>
		@$el.removeClass @class

		@model.set 'active', false

class SpecList extends Backbone.View

	initialize: ->

		@ids = 
			type: 0
			specs: []

		@active = false

		@collection = new SpecCollection

		@collection.on 'pass', @pass

		@on 'error', @error

		@options.types.on 'changed', @fromTypes

		do @fillCollection

	error: =>
		console.log 'choose type'

	fromTypes: (id) =>
		if id
			@active = true 
			@ids.type = id
			if @ids.specs.length isnt 0
				@trigger 'changed', @ids
		else
			@active = false
			@trigger 'changed', 0
			@ids.specs = []
			@collection.each (model) =>
				model.trigger 'deactivate'

	pass: =>
		ids = []
		models = @collection.where active: true
		for model in models
			ids.push model.get 'id'

		@ids.specs = ids

		@trigger 'changed', @ids

	fillCollection: ->
		@$el.children('li').each (i, li) =>
			id = $(li).data('id')
			m = new SpecModel id: id
			v = new SpecView model: m, el: li, list: @
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

	ids: []

	parentIds: {}

	button: $('#show-found-orgs')

	makesElement: $('.makes.makes--live')

	empty: $('.makes_empty')

	initialize: ->

		@on 'error', @error

		# dependency to listen for changes of ids
		@options.specs.on 'changed', @changed

		@collection = new MakeCollection

		@collection.on 'change', @updateIds

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

	changed: (ids) =>
		@parentIds = ids
		if ids is 0 or ids.specs.length is 0
			do @hide
			@trigger 'hideComps'
			return

		@getMakes ids

	getMakes: (ids) ->
		console.log ids, 'selected'
		self = @

		$.ajax "#{@home}/#{@url}",
			data: ids
		.done (rids) =>
			if rids.length is 0 
				do @empty.show 
				do @button.hide

				@trigger 'hideComps'
			else 
				do @empty.hide
				@button.css 'display', 'flex'
			
			self.updateCollection rids

	hide: ->
		@makesElement.hide()
		@button.hide()

	show: ->
		@makesElement.show()

	updateCollection: (ids) ->
		console.log ids, 'received'
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

		@parentIds.makes = @ids

		@trigger 'changed', @parentIds


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

	popup: $ '#company-main-popup'

	initialize: ->

		@more = @$el.children('.company-preview_more')

		src = $.parseHTML @template
			logo: @model.get 'logo'
			name: @model.get 'name'
			description: @model.get 'description'
			address: @model.get 'address'
			phone: @model.get 'phone'
			excerpt: @model.get('description').excerpt()
			tags: @model.get 'tags'

		@more.magnificPopup
			type: 'inline'
			closeBtnInside: true
			items:
				src: '#company-main-popup'

			callbacks:
				open: =>
					@popup.append src
				close: =>
					@popup.html ''

	showPopup: =>
		src = $.parseHTML @template
			logo: @model.get 'logo'
			name: @model.get 'name'
			description: @model.get 'description'
			address: @model.get 'address'
			phone: @model.get 'phone'
			excerpt: @model.get('description').excerpt()
			tags: @model.get 'tags'

		@popup.html src

		@popup.magnificPopup
			closeBtnInside: true
			type: 'inline'
			items:
				src: '#company-main-popup'
		.magnificPopup 'open'



class CompanyCollection extends Backbone.Collection
	model: CompanyModel

class CompanyList extends Backbone.View

	url: 'api/get-companies-by-makes'

	home: $('body').data 'home'

	button: $('#show-found-orgs')

	template: Handlebars.compile $('#found-template').html()

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
				specs: @ids.specs
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
						description: comp.description
						excerpt: comp.description.excerpt()
						logo: comp.logo
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
				specs: @ids.specs
				skip: @toSkip
		.done (comps) =>
			@updateCollection JSON.parse comps

	updateCollection: (c) =>
		for comp, i in c
			if i < 5
				m = new CompanyModel
						address: comp.address
						description: comp.description
						excerpt: comp.description.excerpt()
						logo: comp.logo
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

specs = new SpecList
	el: '#parts-list'
	types: types

makes = new MakeList
	el: '#main-makes-list'
	specs: specs

companies = new CompanyList
	el: '#found'
	makes: makes