class Validator

	# make it more clever, must differ selects and inputs how to check val
	# also pass predefined value of val to check with [select, val]
	# may be make it static function
	# focus on element if its input after blink
	# в валидатор нужно передавать елементы а из коллектора возвращать value
	# make it just like laravel validator, just pass val and pass val to check

	constructor: (@elements) ->

		@fails = false

		do @check

	check: ->

		for name, element of @elements
			if element.val() is ''
				element.blink()
				@fails = true
				return



module.exports = Validator