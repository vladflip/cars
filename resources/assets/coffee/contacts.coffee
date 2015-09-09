Validator = require './inc/Validator'

class Contacts

	home: $('body').data('home')

	url: 'api/contacts/send'

	constructor: (@name, @email, @text) ->

		@button = $ '#contacts-submit'

		@button.click @send

	send: =>

		data = 
			name: @name
			email: @email
			text: @text

		validator = new Validator data

		if validator.fails
			return

		@button.preload 'start'

		$.ajax "#{@home}/#{@url}",
				headers:
					'X-CSRF-TOKEN' : $('body').data 'csrf'
				method: 'POST'
				data:
					name: @name.val()
					email: @email.val()
					text: @text.val()
			.done (response) =>
				@button.preload 'stop'

				$.alert 'Мы получили Ваше сообщение и ответим на него в порядке очереди'
				@button.preload 'reset'
				@name.val ''
				@email.val ''
				@text.val ''

new Contacts $('#contacts-name'), 
	$('#contacts-email'), 
	$('#contacts-text')