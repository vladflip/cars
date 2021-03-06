(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var Model, ModelView, Models, ModelsCollection,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Model = (function(superClass) {
  extend(Model, superClass);

  function Model() {
    return Model.__super__.constructor.apply(this, arguments);
  }

  Model.prototype.defaults = {
    id: 0,
    title: '',
    url: '',
    changed: '',
    "new": 0,
    type: 0
  };

  return Model;

})(Backbone.Model);

ModelsCollection = (function(superClass) {
  extend(ModelsCollection, superClass);

  function ModelsCollection() {
    return ModelsCollection.__super__.constructor.apply(this, arguments);
  }

  ModelsCollection.prototype.model = Model;

  return ModelsCollection;

})(Backbone.Collection);

ModelView = (function(superClass) {
  extend(ModelView, superClass);

  function ModelView() {
    this.saveChanges = bind(this.saveChanges, this);
    this.edit = bind(this.edit, this);
    this.toggleEdit = bind(this.toggleEdit, this);
    this.removeModel = bind(this.removeModel, this);
    return ModelView.__super__.constructor.apply(this, arguments);
  }

  ModelView.prototype.className = 'model';

  ModelView.prototype.tagName = 'tr';

  ModelView.prototype.home = $('#csrf').data('home');

  ModelView.prototype.types = (function() {
    var j, len, ref, results, type;
    ref = $('#types').children();
    results = [];
    for (j = 0, len = ref.length; j < len; j++) {
      type = ref[j];
      results.push({
        id: $(type).data('id'),
        title: $(type).data('title')
      });
    }
    return results;
  })();

  ModelView.prototype.init = function() {
    this.editButton = this.$el.find('.edit-model');
    this.removeButton = this.$el.find('.delete-model');
    this.removeButton.click(this.removeModel);
    this.editButton.click(this.toggleEdit);
    this.title = this.$el.children('td:eq(1)');
    this.url = this.$el.children('td:eq(2)');
    this.type = this.$el.children('td:eq(3)');
    return this.$el.append(this.saveButton);
  };

  ModelView.prototype.removeModel = function() {
    return bootbox.confirm('Вы точно хотите удалить эту модель?', (function(_this) {
      return function(remove) {
        if (remove) {
          if (!_this.model.get('new')) {
            $.ajax(_this.home + "/api/admin/remove-model", {
              headers: {
                'X-CSRF-TOKEN': $('#csrf').data('csrf')
              },
              method: 'POST',
              data: {
                id: _this.model.get('id')
              }
            });
          }
          return _this.remove();
        }
      };
    })(this));
  };

  ModelView.prototype.toggleEdit = function() {
    if (this.editButton.hasClass('activated')) {
      this.editButton.html('<i class="fa fa-pencil"></i>');
      this.editButton.toggleClass('activated');
      this.saveChanges();
      return this.hideInputs();
    } else {
      this.editButton.html('<i class="fa fa-chevron-down" style="color:green"></i>');
      this.editButton.toggleClass('activated');
      return this.edit();
    }
  };

  ModelView.prototype.edit = function() {
    this.titleInput = $("<input value='" + (this.model.get('title')) + "'>");
    this.urlInput = $("<input value='" + (this.model.get('url')) + "'>");
    this.title.html(this.titleInput);
    this.url.html(this.urlInput);
    this.titleInput.focus();
    return this.showTypeSelect();
  };

  ModelView.prototype.showTypeSelect = function() {
    var j, len, option, ref, type;
    this.select = $('<select></select>');
    ref = this.types;
    for (j = 0, len = ref.length; j < len; j++) {
      type = ref[j];
      if (type.id === this.model.get('type_id')) {
        option = "<option selected value='" + type.id + "'>" + type.title + "</option>";
      } else {
        option = "<option value='" + type.id + "'>" + type.title + "</option>";
      }
      this.select.append(option);
    }
    return this.type.html(this.select);
  };

  ModelView.prototype.hideInputs = function() {
    this.title.html(this.model.get('title'));
    this.url.html(this.model.get('url'));
    return this.type.html(this.model.get('type_title'));
  };

  ModelView.prototype.saveChanges = function() {
    if (this.titleInput.val() !== (this.model.get('title') + '') || this.urlInput.val() !== (this.model.get('url') + '')) {
      if (this.titleInput.val() !== '' && this.urlInput.val() !== '') {
        this.model.set('title', this.titleInput.val());
        this.model.set('url', this.urlInput.val());
        this.model.set('changed', true);
      }
    } else if (this.titleInput.val() === '' && this.urlInput.val() === '') {
      return;
    }
    if (parseInt(this.select.val()) !== this.model.get('type_id')) {
      this.model.set('changed', true);
      this.model.set('type_id', parseInt(this.select.val()));
      return this.model.set('type_title', (function(_this) {
        return function() {
          var j, len, ref, type;
          ref = _this.types;
          for (j = 0, len = ref.length; j < len; j++) {
            type = ref[j];
            if (type.id === _this.model.get('type_id')) {
              return type.title;
            }
          }
        };
      })(this)());
    }
  };

  ModelView.prototype.render = function() {
    this.$el.append("<td>" + (this.model.get('id')) + "</td>");
    this.$el.append('<td></td>');
    this.$el.append('<td></td>');
    this.$el.append('<td></td>');
    return this.$el.append("<td> <div class='btn btn-default btn-sm edit-model'> <i class='fa fa-pencil'></i> </div> <div class='btn btn-danger btn-delete btn-sm delete-model'> <i class='fa fa-times'></i> </div> </td>");
  };

  return ModelView;

})(Backbone.View);

Models = (function(superClass) {
  extend(Models, superClass);

  function Models() {
    this.createModel = bind(this.createModel, this);
    return Models.__super__.constructor.apply(this, arguments);
  }

  Models.prototype.initialize = function() {
    this.collection = new ModelsCollection;
    this.fillCollection();
    this.button = this.$el.parent().find('#new-model');
    return this.button.click(this.createModel);
  };

  Models.prototype.createModel = function() {
    var m, v;
    m = new Model({
      id: this.collection.length + 1,
      "new": 1
    });
    this.collection.add(m);
    v = new ModelView({
      model: m
    });
    v.render();
    v.init();
    v.toggleEdit();
    return this.$el.prepend(v.el);
  };

  Models.prototype.fillCollection = function() {
    return this.$el.find('.model').each((function(_this) {
      return function(i, model) {
        var m, v;
        m = new Model({
          id: $(model).data('id'),
          title: $(model).data('title'),
          url: $(model).data('url'),
          type_id: $(model).data('type-id'),
          type_title: $(model).data('type-title')
        });
        v = new ModelView({
          el: model,
          model: m
        });
        v.init();
        return _this.collection.add(m);
      };
    })(this));
  };

  Models.prototype.get = function() {
    return this.collection.where({
      changed: true
    });
  };

  return Models;

})(Backbone.View);

module.exports = Models;

},{}],2:[function(require,module,exports){
var Make, MakeView, Makes, MakesCollection, Models,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

Models = require('./Models');

Handlebars.registerHelper('ifCond', function(v1, v2, options) {
  if (v1 === v2) {
    return options.fn(this);
  }
  return options.inverse(this);
});

MakeView = (function(superClass) {
  extend(MakeView, superClass);

  function MakeView() {
    this.saveChanges = bind(this.saveChanges, this);
    this.removeMake = bind(this.removeMake, this);
    this.readFile = bind(this.readFile, this);
    this.triggerShow = bind(this.triggerShow, this);
    return MakeView.__super__.constructor.apply(this, arguments);
  }

  MakeView.prototype.popup = $('#admin-popup');

  MakeView.prototype.template = Handlebars.compile($('#admin-makes-template').html());

  MakeView.prototype.home = $('#csrf').data('home');

  MakeView.prototype.initialize = function() {
    this.getModels();
    this.model.on('change:show', this.triggerShow);
    this.editButton = this.$el.find('.edit-make');
    this.deleteButton = this.$el.find('.delete-make');
    this.deleteButton.click(this.removeMake);
    return this.initPopup(this.editButton);
  };

  MakeView.prototype.triggerShow = function() {
    if (this.model.get('show')) {
      return this.$el.show();
    } else {
      return this.$el.hide();
    }
  };

  MakeView.prototype.initPopup = function(el) {
    var src;
    src = this.template({
      title: this.model.get('title'),
      url: this.model.get('url'),
      icon: this.model.get('icon') ? this.home + "/" + (this.model.get('icon')) : this.home + "/img/noavatar.png",
      models: this.models,
      buttonText: 'Принять изменения'
    });
    return el.magnificPopup({
      type: 'inline',
      closeBtnInside: true,
      items: {
        src: '#admin-popup'
      },
      callbacks: {
        open: (function(_this) {
          return function() {
            var input, self;
            self = _this;
            _this.popup.append(src);
            input = _this.popup.find('#make-icon-input');
            _this.modelsView = new Models({
              el: _this.popup.find('#admin-models')
            });
            _this.popup.find('#admin-edit-button').click(_this.saveChanges);
            _this.popup.find('.make-icon').click(function() {
              return input.click();
            });
            _this.popup.find('#make-icon-input').change(function() {
              return self.readFile(this.files);
            });
            return _this.popup.find('.make-soviet').val(_this.model.get('soviet'));
          };
        })(this),
        close: (function(_this) {
          return function() {
            return _this.popup.html('');
          };
        })(this)
      }
    });
  };

  MakeView.prototype.readFile = function(fileList) {
    var img, r;
    img = fileList[0];
    if (img.type.search('image') === -1) {
      alert('это не картинка');
      return;
    }
    r = new FileReader;
    r.onloadend = (function(_this) {
      return function() {
        var src;
        src = r.result;
        return _this.popup.find('.make-icon').css('background-image', "url(" + src + ")");
      };
    })(this);
    return r.readAsDataURL(img);
  };

  MakeView.prototype.removeMake = function() {
    return bootbox.confirm('Вы точно хотите удалить эту марку?', (function(_this) {
      return function(remove) {
        if (remove) {
          $.ajax(_this.home + "/api/admin/remove-make", {
            headers: {
              'X-CSRF-TOKEN': $('#csrf').data('csrf')
            },
            method: 'POST',
            data: {
              id: _this.model.get('id')
            }
          });
          return _this.remove();
        }
      };
    })(this));
  };

  MakeView.prototype.getModels = function() {
    this.models = [];
    return this.$el.find('.model').each((function(_this) {
      return function(i, model) {
        return _this.models.push({
          id: $(model).data('id'),
          title: $(model).data('title'),
          url: $(model).data('url'),
          type_id: $(model).data('type-id'),
          type_title: $(model).data('type-title')
        });
      };
    })(this));
  };

  MakeView.prototype.saveChanges = function() {
    var icon, j, len, m, model, models, modelsArray, result, soviet, title, url;
    result = {};
    models = this.modelsView.get();
    title = this.popup.find('.make-title').val();
    url = this.popup.find('.make-url').val();
    soviet = parseInt(this.popup.find('.make-soviet').val());
    icon = this.popup.find('.make-icon').css('background-image');
    icon = icon.substring(4, icon.length - 1);
    if (title !== this.model.get('title')) {
      result.title = title;
    }
    if (url !== this.model.get('url')) {
      result.url = url;
    }
    if (soviet !== parseInt(this.model.get('soviet'))) {
      result.soviet = soviet;
    }
    if (icon !== this.model.get('icon') && icon.search('noavatar') === -1) {
      result.icon = icon;
    }
    if (models.length > 0) {
      modelsArray = [];
      for (j = 0, len = models.length; j < len; j++) {
        model = models[j];
        m = {};
        m.id = model.get('id');
        m.title = model.get('title');
        m.url = model.get('url');
        m.type = model.get('type_id');
        modelsArray.push(m);
      }
      result.models = modelsArray;
    }
    if (Object.keys(result).length !== 0) {
      result.id = this.model.get('id');
      $.ajax(this.home + "/api/admin/makesmodels", {
        headers: {
          'X-CSRF-TOKEN': $('#csrf').data('csrf')
        },
        method: 'POST',
        data: result
      });
      return location.reload();
    }
  };

  return MakeView;

})(Backbone.View);

Make = (function(superClass) {
  extend(Make, superClass);

  function Make() {
    return Make.__super__.constructor.apply(this, arguments);
  }

  Make.prototype.defaults = {
    id: '',
    title: '',
    url: '',
    show: true,
    soviet: 1,
    icon: ''
  };

  return Make;

})(Backbone.Model);

MakesCollection = (function(superClass) {
  extend(MakesCollection, superClass);

  function MakesCollection() {
    return MakesCollection.__super__.constructor.apply(this, arguments);
  }

  MakesCollection.prototype.model = Make;

  return MakesCollection;

})(Backbone.Collection);

Makes = (function(superClass) {
  extend(Makes, superClass);

  function Makes() {
    this.createMake = bind(this.createMake, this);
    return Makes.__super__.constructor.apply(this, arguments);
  }

  Makes.prototype.home = $('#csrf').data('home');

  Makes.prototype.popup = $('#admin-popup');

  Makes.prototype.template = Handlebars.compile($('#admin-makes-template').html());

  Makes.prototype.collection = new MakesCollection;

  Makes.prototype.initialize = function() {
    var src;
    this.createButton = $('#new-make');
    this.fillCollection();
    src = this.template({
      buttonText: 'Создать'
    });
    this.createButton.magnificPopup({
      type: 'inline',
      closeBtnInside: true,
      items: {
        src: '#admin-popup'
      },
      callbacks: {
        open: (function(_this) {
          return function() {
            _this.popup.append(src);
            _this.modelsView = new Models({
              el: _this.popup.find('#admin-models')
            });
            return _this.popup.find('#admin-edit-button').click(_this.createMake);
          };
        })(this),
        close: (function(_this) {
          return function() {
            return _this.popup.html('');
          };
        })(this)
      }
    });
    return this.$el.DataTable({
      language: {
        'search': 'Поиск: ',
        'infoEmpty': 'Записи с 0 по 0 из 0',
        'infoFiltered': '- отфильтровано из _MAX_ записей',
        'info': 'Записи с _START_ по _END_ из _TOTAL_',
        'emptyTable': 'нет записей',
        'paginate': {
          'first': 'Первая',
          'previous': '&larr;',
          'next': '&rarr;',
          'last': 'Последняя'
        },
        'zeroRecords': 'Не найдено подходящих записей.',
        'lengthMenu': 'Отображать _MENU_ записей'
      }
    });
  };

  Makes.prototype.createMake = function() {
    var j, len, m, model, models, modelsArray, result, title, url;
    result = {};
    models = this.modelsView.get();
    title = this.popup.find('.make-title').val();
    url = this.popup.find('.make-url').val();
    if (title !== '') {
      result.title = title;
    } else {
      return;
    }
    if (url !== '') {
      result.url = url;
    } else {
      return;
    }
    if (models.length > 0) {
      modelsArray = [];
      for (j = 0, len = models.length; j < len; j++) {
        model = models[j];
        m = {};
        m.title = model.get('title');
        m.url = model.get('url');
        m["new"] = model.get('new');
        m.type = model.get('type_id');
        modelsArray.push(m);
      }
      result.models = modelsArray;
    } else {
      return;
    }
    if (Object.keys(result).length !== 0) {
      $.ajax(this.home + "/api/admin/create-make", {
        headers: {
          'X-CSRF-TOKEN': $('#csrf').data('csrf')
        },
        method: 'POST',
        data: result
      });
      return location.reload();
    }
  };

  Makes.prototype.fillCollection = function() {
    return this.$el.find('.make').each((function(_this) {
      return function(i, make) {
        var m, v;
        m = new Make({
          id: $(make).data('id'),
          title: $(make).data('title'),
          url: $(make).data('url'),
          soviet: $(make).data('soviet'),
          icon: $(make).data('icon')
        });
        _this.collection.add(m);
        return v = new MakeView({
          el: make,
          model: m
        });
      };
    })(this));
  };

  return Makes;

})(Backbone.View);

new Makes({
  el: '#admin-makes'
});

},{"./Models":1}]},{},[2]);
