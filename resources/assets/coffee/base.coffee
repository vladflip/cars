Array.prototype.have = (i) ->
	if @indexOf(i) is -1 then return false else true

Array.prototype.remove = (i) ->
	@splice(@indexOf(i), 1)

Array.prototype.in = (i) ->
	for a in @
		if a.id is i then return true
	false

String.prototype.excerpt = ->
	i = @.indexOf '.'
	@slice 0, i+1