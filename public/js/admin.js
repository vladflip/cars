(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var Make, MakeView, Makes, MakesCollection,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

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
    return MakeView.__super__.constructor.apply(this, arguments);
  }

  MakeView.prototype.popup = $('#admin-popup');

  MakeView.prototype.template = Handlebars.compile($('#admin-makes-template').html());

  MakeView.prototype.initialize = function() {
    var src;
    src = this.template({
      title: this.model.get('title'),
      url: this.model.get('url'),
      models: this.model.get('models')
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
            return _this.popup.append(src);
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
          url: $(make).data('url'),
          models: _this.getModels(make)
        });
        return v = new MakeView({
          el: make,
          model: m
        });
      };
    })(this));
  };

  Makes.prototype.getModels = function(make) {
    var models;
    models = [];
    $(make).find('.model').each((function(_this) {
      return function(i, model) {
        return models.push({
          id: $(model).data('id'),
          title: $(model).data('title'),
          url: $(model).data('url')
        });
      };
    })(this));
    return models;
  };

  return Makes;

})(Backbone.View);

new Makes({
  el: '#admin-makes'
});

},{}]},{},[1]);
