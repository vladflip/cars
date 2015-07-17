Avatar = require './inc/Avatar'
FieldSet = require './inc/FieldSet'

$('#profile-company-pen').magnificPopup

	type: 'inline'
	closeBtnInside: true

$('#profile-user-pen').magnificPopup

	type: 'inline'
	closeBtnInside: true

userAvatar = new Avatar '#user-ava', '#user-ava-file', 'api/user/avatar'


companyAvatar = new Avatar '#company-ava', '#company-ava-file', 'api/company/avatar'


# collection = new FieldCollection

# collection.add new FieldModel
# 	name: 'name' 
# 	value: $.trim( $('#edit-profile-name').children('span:first').html() )
# 	title: 'Имя'
# 	elToRefresh: $('#edit-profile-name').children('span:first')

# collection.add new FieldModel
# 	name: 'address'
# 	value: $.trim($('#edit-profile-address').html())
# 	title: 'Адрес'
# 	elToRefresh: $('#edit-profile-address')

# collection.add new FieldModel
# 	name: 'phone'
# 	value: $.trim($('#edit-profile-phone').html())
# 	title: 'Телефон'
# 	elToRefresh: $('#edit-profile-phone')

# collection.add new FieldModel
# 	name: 'about'
# 	value: $.trim($('#edit-profile-about').html())
# 	title: 'О себе'
# 	elToRefresh: $('#edit-profile-about')

userProfileCollection = [

	{
		name: 'name' 
		value: $.trim( $('#profile-user-name').children('span:first').html() )
		title: 'Имя'
		elToRefresh: $('#profile-user-name').children('span:first')
	}

]

companyProfileCollection = [

	{
		name: 'name' 
		value: $.trim( $('#profile-company-name').children('span:first').html() )
		title: 'Имя'
		elToRefresh: $('#profile-company-name').children('span:first')
	},

	{
		name: 'address'
		value: $.trim($('#profile-company-address').html())
		title: 'Адрес'
		elToRefresh: $('#profile-company-address')
	},

	{
		name: 'phone'
		value: $.trim($('#profile-company-phone').html())
		title: 'Телефон'
		elToRefresh: $('#profile-company-phone')
	},

	{
		name: 'about'
		value: $.trim($('#profile-company-about').html())
		title: 'О Компании'
		elToRefresh: $('#profile-company-about')
	}

]


user = new FieldSet
	collection: userProfileCollection
	button: $ '#edit-user-profile-button'
	url: 'api/user/edit'

company = new FieldSet
	collection: companyProfileCollection
	button: $ '#edit-company-profile-button'
	url: 'api/company/edit'

class ProfileToggler

	class      : 'profile--hidden'
	
	activeClass: 'profile-info_toogler--active'
	
	state      : 'company'

	companyBtn: $('#profile-show-company')

	userBtn: $('#profile-show-user')

	constructor: (obj) ->

		@companyBtn.click @showCompany

		@userBtn.click @showUser

		@userFields = obj.user

		@companyFields = obj.company

	showCompany: =>
		if @state is 'company'
			return

		do @changeState

		@state = 'company'

	showUser: =>
		if @state is 'user'
			return

		do @changeState


		@state = 'user'

	toggleButtons: ->
		if @state is 'company'
			@companyBtn.removeClass @activeClass
			@userBtn.addClass @activeClass
		else
			@userBtn.removeClass @activeClass
			@companyBtn.addClass @activeClass

	changeState: ->
		do @toggleButtons

		if @state is 'company'
			@hideFields @companyFields
			@showFields @userFields
		else
			@hideFields @userFields
			@showFields @companyFields


	hideFields: (fields) ->
		for k, field of fields
			field.addClass 'profile--hidden'

	showFields: (fields) ->
		for k, field of fields
			field.removeClass 'profile--hidden'


new ProfileToggler
	user:
		ava: $ '#user-ava'
		info: $ '#profile-user-info'

	company:
		ava: $ '#company-ava'
		info: $ '#profile-company-info'
		tags: $ '#profile-company-tags'