mention_photos = $ '#mention_photos'

mention_photos.photosetGrid
	gutter: '3px'
	highresLinks: true

	onComplete: ->
		mention_photos.find('a').magnificPopup
			type: 'image'
			gallery:
				enabled: true