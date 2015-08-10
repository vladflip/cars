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
    changed: ''
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
    return ModelView.__super__.constructor.apply(this, arguments);
  }

  ModelView.prototype.initialize = function() {
    this.$el.click(this.edit);
    this.title = this.$el.children('td:eq(1)');
    this.url = this.$el.children('td:eq(2)');
    this.saveButton = $('<td width="40px" style="display:none"><div class="popup_save"><span class="fa fa-chevron-down"></span></div></td>');
    this.$el.append(this.saveButton);
    return this.saveButton.click(this.saveChanges);
  };

  ModelView.prototype.edit = function() {
    this.titleInput = $("<input value='" + (this.model.get('title')) + "'>");
    this.urlInput = $("<input value='" + (this.model.get('url')) + "'>");
    this.title.html(this.titleInput);
    this.url.html(this.urlInput);
    this.titleInput.focus();
    this.saveButton.show();
    this.titleInput.click(function() {
      return false;
    });
    this.urlInput.click(function() {
      return false;
    });
    document.onclick = (function(_this) {
      return function() {
        _this.hideInputs();
        return document.onclick = false;
      };
    })(this);
    return false;
  };

  ModelView.prototype.hideInputs = function() {
    this.title.html(this.model.get('title'));
    this.url.html(this.model.get('url'));
    return this.saveButton.hide();
  };

  ModelView.prototype.saveChanges = function() {
    if (this.titleInput.val() !== (this.model.get('title') + '') || this.urlInput.val() !== (this.model.get('url') + '')) {
      this.model.set('title', this.titleInput.val());
      this.model.set('url', this.urlInput.val());
      this.model.set('changed', true);
    }
    this.hideInputs();
    return false;
  };

  return ModelView;

})(Backbone.View);

Models = (function(superClass) {
  extend(Models, superClass);

  function Models() {
    return Models.__super__.constructor.apply(this, arguments);
  }

  Models.prototype.collection = new ModelsCollection;

  Models.prototype.initialize = function() {
    return this.fillCollection();
  };

  Models.prototype.fillCollection = function() {
    return this.$el.find('.model').each((function(_this) {
      return function(i, model) {
        var m, v;
        m = new Model({
          id: $(model).data('id'),
          title: $(model).data('title'),
          url: $(model).data('url')
        });
        v = new ModelView({
          el: model,
          model: m
        });
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
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Models = require('./Models');

require('./create.coffee');

Make = (function(superClass) {
  extend(Make, superClass);

  function Make() {
    return Make.__super__.constructor.apply(this, arguments);
  }

  Make.prototype.defaults = {
    id: '',
    title: '',
    url: ''
  };

  return Make;

})(Backbone.Model);

MakeView = (function(superClass) {
  extend(MakeView, superClass);

  function MakeView() {
    this.saveChanges = bind(this.saveChanges, this);
    return MakeView.__super__.constructor.apply(this, arguments);
  }

  MakeView.prototype.popup = $('#admin-popup');

  MakeView.prototype.template = Handlebars.compile($('#admin-makes-template').html());

  MakeView.prototype.home = $('#csrf').data('home');

  MakeView.prototype.initialize = function() {
    var src;
    this.getModels();
    src = this.template({
      title: this.model.get('title'),
      url: this.model.get('url'),
      models: this.models
    });
    return this.$el.magnificPopup({
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
            return _this.popup.find('#admin-edit-button').click(_this.saveChanges);
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

  MakeView.prototype.getModels = function() {
    this.models = [];
    return this.$el.find('.model').each((function(_this) {
      return function(i, model) {
        return _this.models.push({
          id: $(model).data('id'),
          title: $(model).data('title'),
          url: $(model).data('url')
        });
      };
    })(this));
  };

  MakeView.prototype.saveChanges = function() {
    var j, len, m, model, models, modelsArray, result, title, url;
    result = {};
    models = this.modelsView.get();
    title = this.popup.find('.make-title').val();
    url = this.popup.find('.make-url').val();
    if (title !== this.model.get('title')) {
      result.title = title;
    }
    if (url !== this.model.get('url')) {
      result.url = url;
    }
    if (models.length > 0) {
      modelsArray = [];
      for (j = 0, len = models.length; j < len; j++) {
        model = models[j];
        m = {};
        m.id = model.get('id');
        m.title = model.get('title');
        m.url = model.get('url');
        modelsArray.push(m);
      }
      result.models = modelsArray;
    }
    if (result.length !== 0) {
      result.id = this.model.get('id');
      $.ajax(this.home + "/api/admin/makesmodels", {
        headers: {
          'X-CSRF-TOKEN': $('#csrf').data('csrf')
        },
        method: 'POST',
        data: result
      });
    }
    return location.reload();
  };

  return MakeView;

})(Backbone.View);

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
    return Makes.__super__.constructor.apply(this, arguments);
  }

  Makes.prototype.initialize = function() {
    return this.fillCollectiion();
  };

  Makes.prototype.fillCollectiion = function() {
    return this.$el.find('.make').each((function(_this) {
      return function(i, make) {
        var m, v;
        m = new Make({
          id: $(make).data('id'),
          title: $(make).data('title'),
          url: $(make).data('url')
        });
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

},{"./Models":1,"./create.coffee":3}],3:[function(require,module,exports){
var Models;

Models = require('./Models');

console.log(Models);

},{"./Models":1}]},{},[2]);
