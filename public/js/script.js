(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){


},{}],2:[function(require,module,exports){
require('./base');

require('./popups/index');

},{"./base":1,"./popups/index":5}],3:[function(require,module,exports){
var SelectView,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

SelectView = (function(superClass) {
  extend(SelectView, superClass);

  function SelectView() {
    return SelectView.__super__.constructor.apply(this, arguments);
  }

  SelectView.prototype.initialize = function() {
    return this.$el.selectBox();
  };

  SelectView.prototype.events = {
    'change': 'selected'
  };

  SelectView.prototype.selected = function() {
    if (this.options.c) {
      this.options.c.reset();
    }
    if (this.options.c) {
      return this.options.c.store(this.$el.val());
    }
  };

  SelectView.prototype.reset = function() {
    this.$el.find('option:not(:first)').remove();
    this.$el.selectBox('refresh');
    if (this.options.c) {
      return this.options.c.reset();
    }
  };

  SelectView.prototype.render = function() {
    var html, options, temp;
    temp = Handlebars.compile($('#options-template').html());
    options = temp(this.options.json);
    html = $.parseHTML(options);
    this.$el.find('option:first').after(html);
    return this.$el.selectBox('refresh');
  };

  SelectView.prototype.store = function(id) {
    var self;
    self = this;
    return $.ajax(this.options.url, {
      data: {
        id: id
      }
    }).done(function(d) {
      self.options.json = d;
      console.log(d);
      return self.render();
    });
  };

  return SelectView;

})(Backbone.View);

module.exports = SelectView;

},{}],4:[function(require,module,exports){
var AddPhotos, Image, ImageCollection, ImageView, ImagesView, SelectView, imageCollection, imagesView, make, model, type,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

SelectView = require('./SelectView');

$('#feedback').magnificPopup({
  type: 'inline',
  closeBtnInside: true
});

model = new SelectView({
  el: '#feedback-model',
  url: 'api/get-models'
});

make = new SelectView({
  el: '#feedback-make',
  c: model,
  url: 'api/get-makes'
});

type = new SelectView({
  el: '#feedback-type',
  c: make
});

Image = (function(superClass) {
  extend(Image, superClass);

  function Image() {
    return Image.__super__.constructor.apply(this, arguments);
  }

  Image.prototype.defaults = {
    src: ''
  };

  return Image;

})(Backbone.Model);

ImageCollection = (function(superClass) {
  extend(ImageCollection, superClass);

  function ImageCollection() {
    return ImageCollection.__super__.constructor.apply(this, arguments);
  }

  ImageCollection.prototype.model = Image;

  return ImageCollection;

})(Backbone.Collection);

ImageView = (function(superClass) {
  extend(ImageView, superClass);

  function ImageView() {
    this.destroy = bind(this.destroy, this);
    this.clean = bind(this.clean, this);
    return ImageView.__super__.constructor.apply(this, arguments);
  }

  ImageView.prototype.className = 'feedback_photo';

  ImageView.prototype.template = Handlebars.compile($('#photos-template').html());

  ImageView.prototype.initialize = function() {
    var self;
    self = this;
    this.model.on('clean', this.clean);
    this.render();
    return this.$el.find('.feedback_redx:first').click(function() {
      return self.destroy();
    });
  };

  ImageView.prototype.clean = function() {
    return this.$el.remove();
  };

  ImageView.prototype.destroy = function() {
    this.model.destroy();
    return this.clean();
  };

  ImageView.prototype.render = function() {
    return this.$el.html(this.template({
      src: this.model.get('src')
    }));
  };

  return ImageView;

})(Backbone.View);

ImagesView = (function(superClass) {
  extend(ImagesView, superClass);

  function ImagesView() {
    this.added = bind(this.added, this);
    return ImagesView.__super__.constructor.apply(this, arguments);
  }

  ImagesView.prototype.initialize = function() {
    console.log(this.collection);
    return this.collection.on('add', this.added);
  };

  ImagesView.prototype.added = function(m) {
    this.clean();
    return this.render();
  };

  ImagesView.prototype.clean = function() {
    return this.collection.each((function(_this) {
      return function(image) {
        return image.trigger('clean');
      };
    })(this));
  };

  ImagesView.prototype.render = function() {
    return this.collection.each((function(_this) {
      return function(image) {
        var view;
        view = new ImageView({
          model: image
        });
        return _this.options.plus.before(view.el);
      };
    })(this));
  };

  return ImagesView;

})(Backbone.View);

imageCollection = new ImageCollection;

imagesView = new ImagesView({
  collection: imageCollection,
  el: '#feedback-photos',
  plus: $('#feedback-plus')
});

AddPhotos = (function() {
  function AddPhotos(input, plus) {
    var self;
    self = this;
    this.input = $(input);
    this.plus = $(plus);
    this.input.change(function() {
      return self.check(this.files);
    });
    this.plus.click(function() {
      return self.input.click();
    });
  }

  AddPhotos.prototype.check = function(files) {
    var file, i, len, results;
    results = [];
    for (i = 0, len = files.length; i < len; i++) {
      file = files[i];
      if (file.type.search('image') !== -1) {
        results.push(this.read(file));
      } else {
        results.push(void 0);
      }
    }
    return results;
  };

  AddPhotos.prototype.read = function(file) {
    var r, src;
    src = '';
    r = new FileReader();
    r.onloadend = function() {
      return imageCollection.add(new Image({
        src: r.result
      }));
    };
    return r.readAsDataURL(file);
  };

  return AddPhotos;

})();

new AddPhotos('#feedback-input', '#feedback-plus');

},{"./SelectView":3}],5:[function(require,module,exports){
require('./search');

require('./reg');

require('./feedback');

},{"./feedback":4,"./reg":6,"./search":7}],6:[function(require,module,exports){
$('#register').magnificPopup({
  type: 'inline',
  closeBtnInside: true
});

},{}],7:[function(require,module,exports){
var SelectView, make, model, type;

SelectView = require('./SelectView');

$('#search').magnificPopup({
  type: 'inline',
  closeBtnInside: true
});

model = new SelectView({
  el: '#search-model',
  url: 'api/get-models'
});

make = new SelectView({
  el: '#search-make',
  c: model,
  url: 'api/get-makes'
});

type = new SelectView({
  el: '#search-type',
  c: make
});

autosize($('#search-more'));

},{"./SelectView":3}]},{},[2]);
