class Avatar

	constructor: (id, input) ->
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

		$.magnificPopup.open
			items:
				src: @popup

	showPopup: (src) ->

		@popup.html @template src:src

		img = @popup.find('img')

		if 115 > img[0].naturalHeight > 7000 or 115 > img[0].naturalWidth > 7000
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
				console.log c.x, c.y, c.x2, c.y2, c.w, c.h

		$.magnificPopup.open
			items:
				src: @popup
			closeBtnInside: false
			callbacks:
				open: =>
					console.log @popup.find '.popup_button'
				close: =>
					console.log @input.val ''

module.exports = Avatar