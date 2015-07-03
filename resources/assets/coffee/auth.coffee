form = $ '#user-auth-form'

email = form.find 'input[name="email"]'

passw = form.find 'input[name="password"]'

button = $ '#user-auth-button'

button.click ->
	pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i

	if pattern.test email.val()
		console.log 'fuck'
		if passw.val() isnt ''
			form.submit()