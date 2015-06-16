(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){


},{}],2:[function(require,module,exports){
require('./base');

require('./popups/index');

require('./live-search');

},{"./base":1,"./live-search":3,"./popups/index":6}],3:[function(require,module,exports){
var ConcreteView, List, ListCollection, ListModel, ListView, MakeCollection, MakeList, MakeView, SpecList, SpecView, TypeList, TypeView, makes, specs, types,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Array.prototype.have = function(i) {
  if (this.indexOf(i) === -1) {
    return false;
  } else {
    return true;
  }
};

Array.prototype.remove = function(i) {
  return this.splice(this.indexOf(i), 1);
};

Array.prototype["in"] = function(i) {
  var j, len, make;
  for (j = 0, len = this.length; j < len; j++) {
    make = this[j];
    if (make.id === i) {
      return true;
    }
  }
  return false;
};

ListModel = (function(superClass) {
  extend(ListModel, superClass);

  function ListModel() {
    return ListModel.__super__.constructor.apply(this, arguments);
  }

  ListModel.prototype.defaults = {
    id: 0,
    title: ''
  };

  return ListModel;

})(Backbone.Model);

ListCollection = (function(superClass) {
  extend(ListCollection, superClass);

  function ListCollection() {
    return ListCollection.__super__.constructor.apply(this, arguments);
  }

  ListCollection.prototype.model = ListModel;

  return ListCollection;

})(Backbone.Collection);

ListView = (function(superClass) {
  extend(ListView, superClass);

  function ListView() {
    return ListView.__super__.constructor.apply(this, arguments);
  }

  ListView.prototype.home = $('body').data('home');

  ListView.prototype.url = 'api/live-makes';

  ListView.prototype.initialize = function() {
    this["class"] = this.options["class"];
    return this.state = false;
  };

  ListView.prototype.events = {
    'click': 'changeState'
  };

  ListView.prototype.changeState = function() {
    if (!this.state) {
      return this.activate();
    } else {
      return this.deactivate();
    }
  };

  ListView.prototype.activate = function() {
    this.$el.addClass(this["class"]);
    return this.state = true;
  };

  ListView.prototype.deactivate = function() {
    this.$el.removeClass(this["class"]);
    return this.state = false;
  };

  return ListView;

})(Backbone.View);

List = (function(superClass) {
  extend(List, superClass);

  function List() {
    return List.__super__.constructor.apply(this, arguments);
  }

  List.prototype.initialize = function() {
    var self;
    self = this;
    return this.$el.children('li').each(function(i) {
      var id, title;
      id = $(this).data('id');
      title = $(this).children('span').html();
      self.collection.add(new ListModel({
        id: id,
        title: title.trim()
      }));
      return self.createViews(i, this);
    });
  };

  List.prototype.createViews = function(i, li) {
    var v;
    return v = new ListView({
      model: this.collection.at(i),
      "class": this.options["class"],
      el: $(li)
    });
  };

  return List;

})(Backbone.View);

ConcreteView = (function(superClass) {
  extend(ConcreteView, superClass);

  function ConcreteView() {
    return ConcreteView.__super__.constructor.apply(this, arguments);
  }

  ConcreteView.prototype.get = function(o, f) {
    var id, self;
    self = this;
    id = o.id;
    return $.ajax(this.home + "/" + this.url, {
      data: o
    }).done(function(d) {
      self.makes.push({
        id: id,
        makes: d
      });
      if (f) {
        return f();
      }
    });
  };

  ConcreteView.prototype.activate = function() {
    var id, self;
    self = this;
    ConcreteView.__super__.activate.apply(this, arguments);
    id = this.model.get('id');
    this.selected.push(id);
    if (this.makes["in"](id)) {
      return this.pass();
    } else {
      return this.get({
        name: this.options.name,
        id: id
      }, function() {
        return self.pass();
      });
    }
  };

  ConcreteView.prototype.deactivate = function() {
    var id;
    ConcreteView.__super__.deactivate.apply(this, arguments);
    id = this.model.get('id');
    this.selected.remove(id);
    return this.pass();
  };

  ConcreteView.prototype.pass = function() {
    var inner, j, l, len, len1, make, makes, ref, ref1;
    makes = [];
    ref = this.makes;
    for (j = 0, len = ref.length; j < len; j++) {
      make = ref[j];
      if (this.selected.have(make.id)) {
        ref1 = make.makes;
        for (l = 0, len1 = ref1.length; l < len1; l++) {
          inner = ref1[l];
          makes.push(inner);
        }
      }
    }
    return this.options.c.cache(makes, this.options.name);
  };

  ConcreteView.prototype.remove = function(id) {
    var j, len, make, ref, results;
    ref = this.makes;
    results = [];
    for (j = 0, len = ref.length; j < len; j++) {
      make = ref[j];
      if (make.id === id) {
        results.push(this.options.c.remove(make.makes));
      } else {
        results.push(void 0);
      }
    }
    return results;
  };

  return ConcreteView;

})(ListView);

TypeView = (function(superClass) {
  extend(TypeView, superClass);

  function TypeView() {
    return TypeView.__super__.constructor.apply(this, arguments);
  }

  TypeView.prototype.selected = [];

  TypeView.prototype.makes = [];

  return TypeView;

})(ConcreteView);

SpecView = (function(superClass) {
  extend(SpecView, superClass);

  function SpecView() {
    return SpecView.__super__.constructor.apply(this, arguments);
  }

  SpecView.prototype.selected = [];

  SpecView.prototype.makes = [];

  return SpecView;

})(ConcreteView);

TypeList = (function(superClass) {
  extend(TypeList, superClass);

  function TypeList() {
    return TypeList.__super__.constructor.apply(this, arguments);
  }

  TypeList.prototype.createViews = function(i, li) {
    var v;
    return v = new TypeView({
      model: this.collection.at(i),
      "class": this.options["class"],
      el: $(li),
      c: this.options.c,
      name: 'type'
    });
  };

  return TypeList;

})(List);

SpecList = (function(superClass) {
  extend(SpecList, superClass);

  function SpecList() {
    return SpecList.__super__.constructor.apply(this, arguments);
  }

  SpecList.prototype.createViews = function(i, li) {
    var v;
    return v = new SpecView({
      model: this.collection.at(i),
      "class": this.options["class"],
      el: $(li),
      c: this.options.c,
      name: 'spec'
    });
  };

  return SpecList;

})(List);

MakeCollection = (function(superClass) {
  extend(MakeCollection, superClass);

  function MakeCollection() {
    return MakeCollection.__super__.constructor.apply(this, arguments);
  }

  MakeCollection.prototype.comparator = function(model) {
    return model.get('title');
  };

  return MakeCollection;

})(ListCollection);

MakeView = (function(superClass) {
  extend(MakeView, superClass);

  function MakeView() {
    this.clean = bind(this.clean, this);
    return MakeView.__super__.constructor.apply(this, arguments);
  }

  MakeView.prototype.tagName = 'li';

  MakeView.prototype.initialize = function() {
    this.el.dataset.id = this.model.get('id');
    return this.model.on('destroy', this.clean);
  };

  MakeView.prototype.clean = function() {
    return this.remove();
  };

  MakeView.prototype.template = Handlebars.compile($('#makes-template').html());

  MakeView.prototype.render = function() {
    this.$el.html(this.template({
      title: this.model.get('title')
    }));
    return this;
  };

  return MakeView;

})(Backbone.View);

MakeList = (function(superClass) {
  extend(MakeList, superClass);

  function MakeList() {
    return MakeList.__super__.constructor.apply(this, arguments);
  }

  MakeList.prototype.initialize = function() {
    MakeList.__super__.initialize.apply(this, arguments);
    this.all = true;
    this.makes = {};
    this.defaultCollection = [];
    return this.collection.each((function(_this) {
      return function(make) {
        return _this.defaultCollection.push(new ListModel({
          id: make.get('id'),
          title: make.get('title')
        }));
      };
    })(this));
  };

  MakeList.prototype.add = function() {
    var col, k, makes, ref, uploadDefaultCollection;
    if (this.all) {
      this.resetCollection();
      this.all = false;
    }
    this.clean();
    uploadDefaultCollection = 0;
    makes = [];
    ref = this.makes;
    for (k in ref) {
      col = ref[k];
      col.each((function(_this) {
        return function(make) {
          return makes.push(make);
        };
      })(this));
    }
    this.collection.set(makes);
    if (this.collection.length === 0) {
      this.collection.add(this.defaultCollection);
    }
    return this.render();
  };

  MakeList.prototype.cache = function(makes, name) {
    var j, len, make;
    this.makes[name] = new MakeCollection;
    for (j = 0, len = makes.length; j < len; j++) {
      make = makes[j];
      this.makes[name].add(new ListModel({
        id: make.id,
        title: make.title
      }));
    }
    return this.add();
  };

  MakeList.prototype.clean = function() {
    return this.collection.each(function(make) {
      return make.trigger('destroy');
    });
  };

  MakeList.prototype.resetCollection = function() {
    this.collection.each(function(make) {
      return make.trigger('destroy');
    });
    return this.collection.reset();
  };

  MakeList.prototype.remove = function(makes) {
    var j, len, m, make;
    m = [];
    for (j = 0, len = makes.length; j < len; j++) {
      make = makes[j];
      m.push(new ListModel({
        id: make.id,
        title: make.title
      }));
    }
    this.clean();
    this.collection.remove(m);
    return this.render();
  };

  MakeList.prototype.render = function() {
    return this.collection.each((function(_this) {
      return function(make) {
        var v;
        v = new MakeView({
          model: make
        });
        return _this.$el.append(v.render().el);
      };
    })(this));
  };

  MakeList.prototype.createViews = function(i, li) {
    var v;
    return v = new MakeView({
      model: this.collection.at(i),
      "class": this.options["class"],
      el: $(li)
    });
  };

  return MakeList;

})(List);

makes = new MakeList({
  el: '#makes-list',
  collection: new MakeCollection,
  "class": 'makes--active'
});

specs = new SpecList({
  el: '#parts-list',
  collection: new ListCollection,
  "class": 'parts--active',
  c: makes
});

types = new TypeList({
  el: '#type-list',
  collection: new ListCollection,
  "class": 'type_item--active',
  c: makes
});

},{}],4:[function(require,module,exports){
var SelectView,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

SelectView = (function(superClass) {
  extend(SelectView, superClass);

  function SelectView() {
    return SelectView.__super__.constructor.apply(this, arguments);
  }

  SelectView.prototype.home = $('body').data('home');

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
    return $.ajax(this.home + "/" + this.options.url, {
      data: {
        id: id
      }
    }).done(function(d) {
      self.options.json = d;
      console.log(d);
      return self.render();
    });
  };

  SelectView.prototype.get = function() {
    return this.$el.val();
  };

  return SelectView;

})(Backbone.View);

module.exports = SelectView;

},{}],5:[function(require,module,exports){
var AddPhotos, Image, ImageCollection, ImageView, ImagesView, List, ListCollection, ListModel, ListView, SelectView, imageCollection, imagesView, make, minuses, model, pluses, type,
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
  url: 'api/get-models-by-make'
});

make = new SelectView({
  el: '#feedback-make',
  c: model,
  url: 'api/get-makes-by-type'
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

  ImagesView.prototype.get = function() {
    var r;
    r = [];
    this.collection.each(function(image) {
      return r.push(image.toJSON());
    });
    return r;
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

autosize($('#feedback-textarea'));

ListModel = (function(superClass) {
  extend(ListModel, superClass);

  function ListModel() {
    return ListModel.__super__.constructor.apply(this, arguments);
  }

  ListModel.prototype.defaults = {
    text: ''
  };

  return ListModel;

})(Backbone.Model);

ListCollection = (function(superClass) {
  extend(ListCollection, superClass);

  function ListCollection() {
    return ListCollection.__super__.constructor.apply(this, arguments);
  }

  ListCollection.prototype.model = ListModel;

  return ListCollection;

})(Backbone.Collection);

ListView = (function(superClass) {
  extend(ListView, superClass);

  function ListView() {
    this.clean = bind(this.clean, this);
    return ListView.__super__.constructor.apply(this, arguments);
  }

  ListView.prototype.template = Handlebars.compile($('#plus-minus-template').html());

  ListView.prototype.initialize = function() {
    var self;
    self = this;
    this.render();
    this.model.on('clean', this.clean);
    this.$el.find('.feedback_redx').click((function(_this) {
      return function() {
        return _this.destroy();
      };
    })(this));
    return this.$el.children('input').keyup(function() {
      return self.model.set('text', $(this).val());
    });
  };

  ListView.prototype.render = function() {
    return this.$el.html(this.template({
      text: this.model.get('text')
    }));
  };

  ListView.prototype.destroy = function() {
    this.model.destroy();
    return this.clean();
  };

  ListView.prototype.clean = function() {
    return this.$el.remove();
  };

  return ListView;

})(Backbone.View);

List = (function(superClass) {
  extend(List, superClass);

  function List() {
    this.add = bind(this.add, this);
    return List.__super__.constructor.apply(this, arguments);
  }

  List.prototype.initialize = function() {
    this.options.add.on('click', this.add);
    this.collection.add(new ListModel);
    return this.addFirst();
  };

  List.prototype.add = function() {
    this.collection.add(new ListModel);
    this.clean();
    return this.render();
  };

  List.prototype.clean = function() {
    return this.collection.each(function(item) {
      return item.trigger('clean');
    });
  };

  List.prototype.addFirst = function() {
    var v;
    v = new ListView({
      model: this.collection.at(0),
      className: this.options["class"]
    });
    return this.$el.children('div:first').after(v.el);
  };

  List.prototype.render = function() {
    return this.collection.each((function(_this) {
      return function(item) {
        var v;
        v = new ListView({
          model: item,
          className: _this.options["class"]
        });
        return _this.$el.children('div:first').after(v.el);
      };
    })(this));
  };

  List.prototype.get = function() {
    var r;
    r = [];
    this.collection.each(function(item) {
      return r.push(item.toJSON());
    });
    return r;
  };

  return List;

})(Backbone.View);

pluses = new List({
  add: $('#feedback-add-plus'),
  el: '#feedback-pluses',
  "class": 'feedback_plus',
  collection: new ListCollection
});

minuses = new List({
  add: $('#feedback-add-minus'),
  el: '#feedback-minuses',
  "class": 'feedback_minus',
  collection: new ListCollection
});

$('#add-feedback').click(function() {
  var concs;
  concs = {
    pluses: pluses.get(),
    minuses: minuses.get(),
    images: imagesView.get(),
    type: type.get(),
    make: make.get(),
    model: model.get(),
    header: $('#feedback-header').val(),
    text: $('#feedback-textarea').val()
  };
  return console.log(concs);
});

},{"./SelectView":4}],6:[function(require,module,exports){
require('./search');

require('./reg');

require('./feedback');

},{"./feedback":5,"./reg":7,"./search":8}],7:[function(require,module,exports){
$('#register').magnificPopup({
  type: 'inline',
  closeBtnInside: true
});

},{}],8:[function(require,module,exports){
var SelectView, make, model, type;

SelectView = require('./SelectView');

$('#search').magnificPopup({
  type: 'inline',
  closeBtnInside: true
});

model = new SelectView({
  el: '#search-model',
  url: 'api/get-models-by-make'
});

make = new SelectView({
  el: '#search-make',
  c: model,
  url: 'api/get-makes-by-type'
});

type = new SelectView({
  el: '#search-type',
  c: make
});

autosize($('#search-more'));

},{"./SelectView":4}]},{},[2]);
