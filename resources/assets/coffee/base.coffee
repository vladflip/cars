Array.prototype.have = (i) ->
	if @indexOf(i) is -1 then return false else true

Array.prototype.remove = (i) ->
	@splice(@indexOf(i), 1)

Array.prototype.in = (i) ->
	for a in @
		if a.id is i then return true
	false

Array.prototype.last = ->
	@[@length - 1]

String.prototype.excerpt = ->
	i = @.indexOf '.'
	@slice 0, i+1

$.fn.blink = ->
	@stop(true).animate
		backgroundColor: '#f3df6d'
		color          : 'white'
	, 300, ->
		$(@).stop(true).animate
			backgroundColor: 'white'
			color: '#222'
		, 300

$('.sticky').stick_in_parent
	offset_top: 25