class Avatar

	home: $('body').data 'home'

	constructor: (id, input, @url) ->
		self = @

		@coords = {}

		@id = $(id)
		@input = $(input)
		@popup = $('#avatar-popup')
		@template = $.HandlebarsFactory '#avatar-template'

		@id.click =>
			@input.click()

		@input.change ->
			self.readFile @files

	readFile: (fileList) ->
		img = fileList[0]

		if img.type.search('image') is -1
			alert 'это не картинка'
			return

		r = new FileReader

		r.onloadend = =>
			src = r.result

			@src = src

			@showPopup src

		r.readAsDataURL(img)

	adjustPopup: (img) ->
		if img.naturalWidth > 780
			@popup.css 'width', '780px'
		else if img.naturalWidth > 300
			@popup.css 'width', img.naturalWidth + 'px'
		else
			@popup.css 'width', '300px'

	showErrorPopup: ->
		@popup.html('<span class="popup_error">Картинка должна быть не меньше 115px и не больше 7000px по ширине и высоте</span>')

		@input.val ''

		$.magnificPopup.open
			items:
				src: @popup

	showPopup: (src) ->

		@popup.html @template src:src

		img = @popup.find('img')

		img.load =>

			if img[0].naturalHeight < 115 or img[0].naturalHeight > 7000
				do @showErrorPopup
				return

			if img[0].naturalWidth < 115 or img[0].naturalWidth > 7000
				do @showErrorPopup
				return

			@adjustPopup img[0]
			
			imgWidth = img[0].naturalWidth
			imgHeight = img[0].naturalHeight

			img.Jcrop
				aspectRatio: 1 / 1
				minSize: [115, 115]
				boxWidth: 780
				boxHeight: $(document).height() - 300
				setSelect: [imgWidth*0.25, imgHeight*0.07, imgWidth*0.75, imgHeight*0.75]
				onSelect: (c) =>
					@coords =
						x: c.x
						y: c.y
						w: c.w
						h: c.h

			$.magnificPopup.open
				items:
					src: @popup
				closeOnBgClick: false
				callbacks:
					open: =>
						@button = @popup.find('.popup_button')
						@button.click @send
					close: =>
						@input.val ''

	updateAva: (src) ->
		@id.children('img').attr 'src', src

	send: =>
		popup = $.magnificPopup.instance.st.closeOnBgClick = true

		@button.preload 'start'

		$.ajax "#{@home}/#{@url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data:
				src: @src
				coords: @coords

		.done (response) =>

			setTimeout =>
				@updateAva response
			, 800

			@button.preload 'stop'

			setTimeout ->
				$.magnificPopup.instance.close()
			, 1000

module.exports = Avatar