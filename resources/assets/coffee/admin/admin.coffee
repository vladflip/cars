Models = require './Models'

Handlebars.registerHelper 'ifCond', (v1, v2, options) ->
	if v1 is v2
		return options.fn(this)
	options.inverse(this)

class MakeView extends Backbone.View

	popup: $ '#admin-popup'

	template: Handlebars.compile $('#admin-makes-template').html()

	home: $('#csrf').data 'home'

	initialize: ->

		do @getModels

		@model.on 'change:show', @triggerShow

		@editButton = @$el.find('.edit-make')

		@deleteButton = @$el.find('.delete-make')

		@deleteButton.click @removeMake

		@initPopup @editButton

	triggerShow: =>

		if @model.get 'show'
			do @$el.show
		else
			do @$el.hide

	initPopup: (el) ->

		src = @template
			title: @model.get 'title'
			url: @model.get 'url'
			icon: if @model.get('icon') then "#{@home}/#{@model.get('icon')}" else "#{@home}/img/noavatar.png"
			models: @models
			buttonText: 'Принять изменения'

		el.magnificPopup
			type: 'inline'
			closeBtnInside: true
			items:
				src: '#admin-popup'

			callbacks:
				open: =>
					self = @

					@popup.append src

					input = @popup.find('#make-icon-input')

					@modelsView = new Models
						el: @popup.find('#admin-models')

					@popup.find('#admin-edit-button').click @saveChanges

					@popup.find('.make-icon').click =>
						input.click()

					@popup.find('#make-icon-input').change ->
						self.readFile @files

					@popup.find('.make-soviet').val(@model.get('soviet'))

				close: =>
					@popup.html ''

	readFile: (fileList) =>
		img = fileList[0]

		if img.type.search('image') is -1
			alert 'это не картинка'
			return

		r = new FileReader

		r.onloadend = =>
			src = r.result
			
			@popup.find('.make-icon').css('background-image', "url(#{src})")

		r.readAsDataURL(img)


	removeMake: =>

		bootbox.confirm 'Вы точно хотите удалить эту марку?', (remove) =>

			if remove

				$.ajax "#{@home}/api/admin/remove-make",
					headers:
						'X-CSRF-TOKEN' : $('#csrf').data 'csrf'
					method: 'POST'
					data:
						id: @model.get 'id'

				do @remove

	getModels: ->

		@models = []

		@$el.find('.model').each (i, model) =>

			@models.push
				id: $(model).data 'id'
				title: $(model).data 'title'
				url: $(model).data 'url'
				type_id: $(model).data 'type-id'
				type_title: $(model).data 'type-title'

	saveChanges: =>

		result = {}

		models = @modelsView.get()

		title = @popup.find('.make-title').val()
		url = @popup.find('.make-url').val()
		soviet = parseInt @popup.find('.make-soviet').val()
		icon = @popup.find('.make-icon').css('background-image')
		icon = icon.substring(4, icon.length - 1)

		if title isnt @model.get 'title'
			result.title = title

		if url isnt @model.get 'url'
			result.url = url

		if soviet isnt parseInt @model.get 'soviet'
			result.soviet = soviet

		if icon isnt @model.get('icon') and icon.search('noavatar') is -1
			result.icon = icon

		if models.length > 0

			modelsArray = []

			for model in models
				m = {}
				m.id = model.get 'id'
				m.title = model.get 'title'
				m.url = model.get 'url'
				m.type = model.get 'type_id'

				modelsArray.push m

			result.models = modelsArray

		if Object.keys(result).length isnt 0

			result.id = @model.get 'id'

			$.ajax "#{@home}/api/admin/makesmodels",
				headers:
					'X-CSRF-TOKEN' : $('#csrf').data 'csrf'
				method: 'POST'
				data: result

			location.reload()


class Make extends Backbone.Model
	defaults:
		id: ''
		title: ''
		url: ''
		show: true
		soviet: 1
		icon: ''

class MakesCollection extends Backbone.Collection
	model: Make

class Makes extends Backbone.View

	home: $('#csrf').data 'home'

	popup: $ '#admin-popup'

	template: Handlebars.compile $('#admin-makes-template').html()

	collection: new MakesCollection

	initialize: ->

		@createButton = $ '#new-make'

		do @fillCollection

		src = @template
			buttonText: 'Создать'

		@createButton.magnificPopup
			type: 'inline'
			closeBtnInside: true
			items:
				src: '#admin-popup'

			callbacks:
				open: =>
					@popup.append src

					@modelsView = new Models
						el: @popup.find('#admin-models')

					@popup.find('#admin-edit-button').click @createMake

				close: =>
					@popup.html ''

		@$el.DataTable
			language:
				'search': 'Поиск: '
				'infoEmpty': 'Записи с 0 по 0 из 0'
				'infoFiltered': '- отфильтровано из _MAX_ записей'
				'info': 'Записи с _START_ по _END_ из _TOTAL_'
				'emptyTable': 'нет записей'
				'paginate': 
					'first': 'Первая'
					'previous': '&larr;'
					'next': '&rarr;'
					'last': 'Последняя'
				'zeroRecords': 'Не найдено подходящих записей.'
				'lengthMenu': 'Отображать _MENU_ записей'


	createMake: =>

		result = {}

		models = @modelsView.get()

		title = @popup.find('.make-title').val()
		url = @popup.find('.make-url').val()

		if title isnt ''
			result.title = title
		else
			return

		if url isnt ''
			result.url = url
		else
			return


		if models.length > 0

			modelsArray = []

			for model in models
				m = {}
				m.title = model.get 'title'
				m.url = model.get 'url'
				m.new = model.get 'new'
				m.type = model.get 'type_id'

				modelsArray.push m

			result.models = modelsArray

		else
			return

		if Object.keys(result).length isnt 0

			$.ajax "#{@home}/api/admin/create-make",
				headers:
					'X-CSRF-TOKEN' : $('#csrf').data 'csrf'
				method: 'POST'
				data: result

			location.reload()

	fillCollection: ->

		@$el.find('.make').each (i, make) =>
			m = new Make
				id: $(make).data 'id'
				title: $(make).data 'title'
				url: $(make).data 'url'
				soviet: $(make).data 'soviet'
				icon: $(make).data 'icon'

			@collection.add m

			v = new MakeView
				el: make
				model: m

new Makes
	el: '#admin-makes'