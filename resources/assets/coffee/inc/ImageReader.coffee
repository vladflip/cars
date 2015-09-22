class ImageReader

	constructor: (input) ->
		self = @

		_.extend @, Backbone.Events

		@input = $(input)

		@filesResults = []

		@input.change ->
			self.check @files

	check: (files) =>
		promises = []

		for file, i in files
			unless file.type.search('image') is -1
				promises.push @read file

		Promise.all promises
		.then (arrayOfImagesSrc) =>
			@trigger 'read', arrayOfImagesSrc


	read: (file) ->
		new Promise (resolve, reject) ->
			src = ''
			r = new FileReader

			r.onloadend = =>
				resolve r.result

			r.readAsDataURL(file)


module.exports = ImageReader