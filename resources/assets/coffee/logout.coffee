form = $ '#user-logout-form'

button = $ '#user-logout-button'

button.click ->
	form.submit()