$('#sign-up').magnificPopup

	type : 'inline'
	closeBtnInside: true

$('#footer-sign-up').magnificPopup

	type : 'inline'
	closeBtnInside: true

$('#company-signup-button').magnificPopup
	
	type:'inline'
	closeBtnInside: true

$.fn.highlight = ->
	$(@).animate
		backgroundColor: '#f3df6d'
		color: '#fff'
	, 1000

form = $ '#sign-up-form'

button = $ '#sign-up-button'

check = $ '#sign-up-check'

if form

	email = form.find 'input[name="email"]'

	passw = form.find 'input[name="password"]'

	submit = ->
		if check.prop('checked') isnt true
			return

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