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

		$.ajax "#{@home}/#{@url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				email: @input.val()

		.done (response) =>
			location.reload()

new EmailChanger