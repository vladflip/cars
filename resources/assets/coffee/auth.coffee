form = $ '#user-auth-form'

email = form.find 'input[name="email"]'

passw = form.find 'input[name="password"]'

button = $ '#user-auth-button'

submit = ->
	pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i

	if pattern.test email.val()

		if passw.val() isnt ''
			form.submit()
		else
			passw.blink()
	else
		email.blink()

button.click submit

form.keypress (e) ->
	if e.which is 13
		submit()