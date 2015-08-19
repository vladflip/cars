form = $ '#user-auth'

email = form.find 'input[name="email"]'

passw = form.find 'input[name="password"]'

button = $ '#user-auth-button'

home = $('body').data 'home'

submit = ->
	pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i

	if pattern.test email.val()

		if passw.val() isnt ''

			$.ajax "#{home}/api/user/auth",
				headers:
					'X-CSRF-TOKEN' : $('body').data 'csrf'
				method: 'POST'
				data:
					email: email.val()
					password: passw.val()
			.done (r) ->
				
				if r is 'mismatch'
					$.alert 'Логин пользователя или пароль не совпадают.'
				else
					location.href = r

		else
			passw.blink()
	else
		email.blink()

button.click submit

form.keypress (e) ->
	if e.which is 13
		submit()