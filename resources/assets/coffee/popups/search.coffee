SelectView = require '../inc/SelectView'

$('#search').magnificPopup

	type : 'inline'
	closeBtnInside: true

model = new SelectView 
	el: '#search-model'
	url: 'api/get-models-by-make'

make = new SelectView 
	el: '#search-make'
	c: model
	url: 'api/get-makes-by-type'

type = new SelectView 
	el: '#search-type'
	c: make

more = $ '#search-more'

year = $ '#search-year'

autosize more

isNew = $ '#search-new'

isOld = $ '#search-old'

isNewLabel = $('#search-new + label')

isOldLabel = $('#search-old + label')

button = $ '#search-button'

button.click ->

	result = {}

	if isNew.is(':checked') or isOld.is(':checked')
		if isNew.is(':checked') and isOld.is(':checked')
			result.new = 1
			result.old = 1
		else if isNew.is(':checked')
			result.new = 1
			result.old = 0
		else if isOld.is(':checked')
			result.new = 0
			result.old = 1
	else
		isNewLabel.blink()
		isOldLabel.blink()
		return

	
	if type.get()?
		result.type = parseInt type.get()
	else
		type.error()
		return

	if make.get()?
		result.make = parseInt make.get()
	else
		make.error()
		return

	if model.get()?
		result.model = parseInt model.get()
	else
		model.error()
		return

	if year.val() isnt ''
		result.year = year.val()
	else
		year.blink()
		return

	if more.val() isnt ''
		result.more = more.val()
	else
		more.blink()
		return

	$(@).preload 'start'

	$.ajax "#{$('body').data('home')}/api/request/create",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data: result
		.done (response) =>
			console.log response
			$(@).preload('stop')

			setTimeout ->
				$.magnificPopup.instance.close()
				location.reload()
			, 1000