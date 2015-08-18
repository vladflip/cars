$('#profile-settings').magnificPopup

	type : 'inline'
	closeBtnInside: true

class EmailChanger

	input: $('#settings-email')

	button: $('#settings-email-button')

	home: $('body').data 'home'

	url: 'api/settings/email'

	constructor: ->

		@email = @input.val()

		@button.click @change

	change: =>

		pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i

		if @input.val() is @email
			do @input.blink
		else
			if pattern.test @input.val()
				do @send
			else
				do @input.blink

	send: ->

		@button.preload 'start'

		$.ajax "#{@home}/#{@url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				email: @input.val()

		.done (response) =>
			@button.preload 'stop'
			@email = @input.val()
			setTimeout =>
				@button.preload('reset')
			, 1500

new EmailChanger

class PasswordChanger

	home: $('body').data 'home'

	url: 'api/settings/password'

	current: $('#settings-current-password')

	new: $('#settings-new-password')

	newRepeat: $('#settings-new-repeat')

	button: $('#settings-change-password')

	constructor: ->

		@button.click @change

	change: =>

		if @current.val() is ''
			do @current.blink
			return
		if @new.val() is ''
			do @new.blink
			return
		if @newRepeat.val() is '' or @new.val() isnt @newRepeat.val()
			do @newRepeat.blink
			return

		do @send

	send: ->

		@button.preload 'start'

		$.ajax "#{@home}/#{@url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				current: @current.val()
				new: @new.val()
				newRepeat: @newRepeat.val()

		.done (response) =>
			console.log response
			if response is 'wrong'
				@button.preload 'reset'
				do @current.blink
			if response is 'ok'
				@button.preload 'stop'
				@current.val ''
				@new.val ''
				@newRepeat.val ''
				setTimeout =>
					@button.preload('reset')
				, 1500


new PasswordChanger