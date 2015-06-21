(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
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
  var a, j, len;
  for (j = 0, len = this.length; j < len; j++) {
    a = this[j];
    if (a.id === i) {
      return true;
    }
  }
  return false;
};

String.prototype.excerpt = function() {
  var i;
  i = this.indexOf('.');
  return this.slice(0, i + 1);
};

},{}],2:[function(require,module,exports){
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

},{}],3:[function(require,module,exports){
var TypeList, TypeModel, TypeView, TypesCollection,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

TypeModel = (function(superClass) {
  extend(TypeModel, superClass);

  function TypeModel() {
    return TypeModel.__super__.constructor.apply(this, arguments);
  }

  TypeModel.prototype.defaults = {
    id: 0
  };

  return TypeModel;

})(Backbone.Model);

TypesCollection = (function(superClass) {
  extend(TypesCollection, superClass);

  function TypesCollection() {
    return TypesCollection.__super__.constructor.apply(this, arguments);
  }

  TypesCollection.prototype.model = TypeModel;

  return TypesCollection;

})(Backbone.Collection);

TypeView = (function(superClass) {
  extend(TypeView, superClass);

  function TypeView() {
    this.deactivate = bind(this.deactivate, this);
    this.activate = bind(this.activate, this);
    this.changeState = bind(this.changeState, this);
    return TypeView.__super__.constructor.apply(this, arguments);
  }

  TypeView.prototype.initialize = function() {
    this["class"] = 'type_item--active';
    this.model.on('deactivate', this.deactivate);
    return this.state = false;
  };

  TypeView.prototype.events = {
    'click': 'changeState'
  };

  TypeView.prototype.changeState = function() {
    if (this.state) {
      this.deactivate();
      return this.model.trigger('pass');
    } else {
      return this.activate();
    }
  };

  TypeView.prototype.activate = function() {
    this.model.trigger('activate', this.model);
    this.$el.addClass(this["class"]);
    return this.state = true;
  };

  TypeView.prototype.deactivate = function() {
    this.$el.removeClass(this["class"]);
    return this.state = false;
  };

  return TypeView;

})(Backbone.View);

TypeList = (function(superClass) {
  extend(TypeList, superClass);

  function TypeList() {
    this.pass = bind(this.pass, this);
    this.deactivate = bind(this.deactivate, this);
    return TypeList.__super__.constructor.apply(this, arguments);
  }

  TypeList.prototype.initialize = function() {
    this.activeId = 0;
    this.collection = new TypesCollection;
    this.collection.on('activate', this.deactivate);
    this.collection.on('pass', this.pass);
    return this.fillCollection();
  };

  TypeList.prototype.fillCollection = function() {
    return this.$el.children('li').each((function(_this) {
      return function(i, li) {
        var id, m, v;
        id = $(li).data('id');
        m = new TypeModel({
          id: id
        });
        v = new TypeView({
          model: m,
          el: li
        });
        return _this.collection.add(m);
      };
    })(this));
  };

  TypeList.prototype.deactivate = function(model) {
    this.activeId = model.get('id');
    this.collection.each((function(_this) {
      return function(m) {
        if (m !== model) {
          return m.trigger('deactivate');
        }
      };
    })(this));
    return this.trigger('changed', this.activeId);
  };

  TypeList.prototype.pass = function() {
    this.activeId = 0;
    return this.trigger('changed', this.activeId);
  };

  return TypeList;

})(Backbone.View);

module.exports = TypeList;

},{}],4:[function(require,module,exports){
require('./base');

require('./popups/index');

require('./main-live-search');

},{"./base":1,"./main-live-search":5,"./popups/index":7}],5:[function(require,module,exports){
var CompanyCollection, CompanyList, CompanyModel, CompanyView, MakeCollection, MakeList, MakeModel, MakeView, SpecCollection, SpecList, SpecModel, SpecView, TypeList, companies, makes, specs, types,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

TypeList = require('./inc/TypeList');

SpecModel = (function(superClass) {
  extend(SpecModel, superClass);

  function SpecModel() {
    return SpecModel.__super__.constructor.apply(this, arguments);
  }

  SpecModel.prototype.defaults = {
    id: 0,
    active: false
  };

  return SpecModel;

})(Backbone.Model);

SpecCollection = (function(superClass) {
  extend(SpecCollection, superClass);

  function SpecCollection() {
    return SpecCollection.__super__.constructor.apply(this, arguments);
  }

  SpecCollection.prototype.model = SpecModel;

  return SpecCollection;

})(Backbone.Collection);

SpecView = (function(superClass) {
  extend(SpecView, superClass);

  function SpecView() {
    this.deactivate = bind(this.deactivate, this);
    this.activate = bind(this.activate, this);
    this.changeState = bind(this.changeState, this);
    return SpecView.__super__.constructor.apply(this, arguments);
  }

  SpecView.prototype.initialize = function() {
    this["class"] = 'parts--active';
    return this.model.on('deactivate', this.deactivate);
  };

  SpecView.prototype.events = {
    'click': 'changeState'
  };

  SpecView.prototype.changeState = function() {
    if (this.model.get('active')) {
      this.deactivate();
    } else {
      this.activate();
    }
    return this.model.trigger('pass');
  };

  SpecView.prototype.activate = function() {
    if (this.options.list.active) {
      this.$el.addClass(this["class"]);
      return this.model.set('active', true);
    } else {
      return this.options.list.trigger('error');
    }
  };

  SpecView.prototype.deactivate = function() {
    this.$el.removeClass(this["class"]);
    return this.model.set('active', false);
  };

  return SpecView;

})(Backbone.View);

SpecList = (function(superClass) {
  extend(SpecList, superClass);

  function SpecList() {
    this.pass = bind(this.pass, this);
    this.fromTypes = bind(this.fromTypes, this);
    this.error = bind(this.error, this);
    return SpecList.__super__.constructor.apply(this, arguments);
  }

  SpecList.prototype.initialize = function() {
    this.ids = {
      type: 0,
      specs: []
    };
    this.active = false;
    this.collection = new SpecCollection;
    this.collection.on('pass', this.pass);
    this.on('error', this.error);
    this.options.types.on('changed', this.fromTypes);
    return this.fillCollection();
  };

  SpecList.prototype.error = function() {
    return console.log('choose type');
  };

  SpecList.prototype.fromTypes = function(id) {
    if (id) {
      this.active = true;
      this.ids.type = id;
      if (this.ids.specs.length !== 0) {
        return this.trigger('changed', this.ids);
      }
    } else {
      this.active = false;
      this.trigger('changed', 0);
      this.ids.specs = [];
      return this.collection.each((function(_this) {
        return function(model) {
          return model.trigger('deactivate');
        };
      })(this));
    }
  };

  SpecList.prototype.pass = function() {
    var ids, j, len, model, models;
    ids = [];
    models = this.collection.where({
      active: true
    });
    for (j = 0, len = models.length; j < len; j++) {
      model = models[j];
      ids.push(model.get('id'));
    }
    this.ids.specs = ids;
    return this.trigger('changed', this.ids);
  };

  SpecList.prototype.fillCollection = function() {
    return this.$el.children('li').each((function(_this) {
      return function(i, li) {
        var id, m, v;
        id = $(li).data('id');
        m = new SpecModel({
          id: id
        });
        v = new SpecView({
          model: m,
          el: li,
          list: _this
        });
        return _this.collection.add(m);
      };
    })(this));
  };

  return SpecList;

})(Backbone.View);

MakeModel = (function(superClass) {
  extend(MakeModel, superClass);

  function MakeModel() {
    return MakeModel.__super__.constructor.apply(this, arguments);
  }

  MakeModel.prototype.defaults = {
    id: 0,
    title: '',
    active: false
  };

  return MakeModel;

})(Backbone.Model);

MakeCollection = (function(superClass) {
  extend(MakeCollection, superClass);

  function MakeCollection() {
    return MakeCollection.__super__.constructor.apply(this, arguments);
  }

  MakeCollection.prototype.model = MakeModel;

  return MakeCollection;

})(Backbone.Collection);

MakeView = (function(superClass) {
  extend(MakeView, superClass);

  function MakeView() {
    this.changeState = bind(this.changeState, this);
    this.show = bind(this.show, this);
    this.hide = bind(this.hide, this);
    return MakeView.__super__.constructor.apply(this, arguments);
  }

  MakeView.prototype.initialize = function() {
    this["class"] = 'makes--active';
    this.model.on('hide', this.hide);
    return this.model.on('show', this.show);
  };

  MakeView.prototype.hide = function() {
    return this.$el.css('display', 'none');
  };

  MakeView.prototype.show = function() {
    return this.$el.css('display', 'block');
  };

  MakeView.prototype.events = {
    'click': 'changeState'
  };

  MakeView.prototype.changeState = function() {
    if (!this.model.get('active')) {
      return this.activate();
    } else {
      return this.deactivate();
    }
  };

  MakeView.prototype.activate = function() {
    this.$el.addClass(this["class"]);
    return this.model.set('active', true);
  };

  MakeView.prototype.deactivate = function() {
    this.$el.removeClass(this["class"]);
    return this.model.set('active', false);
  };

  return MakeView;

})(Backbone.View);

MakeList = (function(superClass) {
  extend(MakeList, superClass);

  function MakeList() {
    this.updateIds = bind(this.updateIds, this);
    this.changed = bind(this.changed, this);
    this.error = bind(this.error, this);
    return MakeList.__super__.constructor.apply(this, arguments);
  }

  MakeList.prototype.url = 'api/live-makes';

  MakeList.prototype.home = $('body').data('home');

  MakeList.prototype.ids = [];

  MakeList.prototype.button = $('#show-found-orgs');

  MakeList.prototype.makesElement = $('.makes.makes--live');

  MakeList.prototype.empty = $('.makes_empty');

  MakeList.prototype.initialize = function() {
    this.on('error', this.error);
    this.options.specs.on('changed', this.changed);
    this.collection = new MakeCollection;
    this.collection.on('change', this.updateIds);
    return this.fillCollection();
  };

  MakeList.prototype.error = function() {
    return console.log('please chose make');
  };

  MakeList.prototype.fillCollection = function() {
    return this.$el.children('li').each((function(_this) {
      return function(i, li) {
        var id, m, title, v;
        id = $(li).data('id');
        title = $(li).children('span').html().trim();
        m = new MakeModel({
          id: id,
          title: title
        });
        v = new MakeView({
          model: m,
          el: li
        });
        return _this.collection.add(m);
      };
    })(this));
  };

  MakeList.prototype.changed = function(ids) {
    if (ids === 0 || ids.specs.length === 0) {
      this.hide();
      this.trigger('hideComps');
      return;
    }
    return this.getMakes(ids);
  };

  MakeList.prototype.getMakes = function(ids) {
    var self;
    console.log(ids, 'selected');
    self = this;
    return $.ajax(this.home + "/" + this.url, {
      data: ids
    }).done((function(_this) {
      return function(rids) {
        if (rids.length === 0) {
          _this.empty.show();
          _this.button.hide();
          _this.trigger('hideComps');
        } else {
          _this.empty.hide();
          _this.button.css('display', 'flex');
        }
        return self.updateCollection(rids);
      };
    })(this));
  };

  MakeList.prototype.hide = function() {
    this.makesElement.hide();
    return this.button.hide();
  };

  MakeList.prototype.show = function() {
    return this.makesElement.show();
  };

  MakeList.prototype.updateCollection = function(ids) {
    console.log(ids, 'received');
    this.show();
    return this.collection.each(function(model) {
      if (ids.have(model.get('id'))) {
        return model.trigger('show');
      } else {
        return model.trigger('hide');
      }
    });
  };

  MakeList.prototype.updateIds = function(model) {
    if (model.get('active')) {
      this.ids.push(model.get('id'));
    } else {
      this.ids.remove(model.get('id'));
    }
    return this.trigger('changed', this.ids);
  };

  return MakeList;

})(Backbone.View);

CompanyModel = (function(superClass) {
  extend(CompanyModel, superClass);

  function CompanyModel() {
    return CompanyModel.__super__.constructor.apply(this, arguments);
  }

  CompanyModel.prototype.defaults = {
    address: '',
    description: '',
    excerpt: '',
    logo: '',
    name: '',
    phone: '',
    tags: ''
  };

  return CompanyModel;

})(Backbone.Model);

CompanyView = (function(superClass) {
  extend(CompanyView, superClass);

  function CompanyView() {
    this.showPopup = bind(this.showPopup, this);
    return CompanyView.__super__.constructor.apply(this, arguments);
  }

  CompanyView.prototype.template = Handlebars.compile($('#company-template').html());

  CompanyView.prototype.initialize = function() {
    this.more = this.$el.children('.company-preview_more');
    return this.more.on('click', this.showPopup);
  };

  CompanyView.prototype.showPopup = function() {
    var m, src;
    src = $.parseHTML(this.template({
      logo: this.model.get('logo'),
      name: this.model.get('name'),
      description: this.model.get('description'),
      address: this.model.get('address'),
      phone: this.model.get('phone'),
      excerpt: this.model.get('description').excerpt(),
      tags: this.model.get('tags')
    }));
    return m = $.magnificPopup.open({
      items: {
        src: src,
        type: 'inline',
        closeBtnInside: true
      }
    });
  };

  return CompanyView;

})(Backbone.View);

CompanyCollection = (function(superClass) {
  extend(CompanyCollection, superClass);

  function CompanyCollection() {
    return CompanyCollection.__super__.constructor.apply(this, arguments);
  }

  CompanyCollection.prototype.model = CompanyModel;

  return CompanyCollection;

})(Backbone.Collection);

CompanyList = (function(superClass) {
  extend(CompanyList, superClass);

  function CompanyList() {
    this.makesChanged = bind(this.makesChanged, this);
    this.showMe = bind(this.showMe, this);
    this.hideMe = bind(this.hideMe, this);
    return CompanyList.__super__.constructor.apply(this, arguments);
  }

  CompanyList.prototype.url = 'api/get-companies-by-makes';

  CompanyList.prototype.home = $('body').data('home');

  CompanyList.prototype.button = $('#show-found-orgs');

  CompanyList.prototype.template = Handlebars.compile($('#found-template').html());

  CompanyList.prototype.initialize = function() {
    this.collection = new CompanyCollection;
    this.ids = [];
    this.options.makes.on('changed', this.makesChanged);
    this.button.on('click', this.showMe);
    return this.options.makes.on('hideComps', this.hideMe);
  };

  CompanyList.prototype.hideMe = function() {
    return this.$el.html('');
  };

  CompanyList.prototype.showMe = function() {
    if (this.ids.length === 0) {
      this.options.makes.trigger('error');
      return;
    }
    $('html, body').animate({
      scrollTop: this.$el.offset().top
    }, 500);
    return this.render();
  };

  CompanyList.prototype.render = function() {
    this.$el.html(this.template({
      companies: this.collection.toJSON()
    }));
    this.$el.find('.company-preview').each((function(_this) {
      return function(i, el) {
        var v;
        return v = new CompanyView({
          model: _this.collection.at(i),
          el: el
        });
      };
    })(this));
    return this.$el;
  };

  CompanyList.prototype.makesChanged = function(ids) {
    this.ids = ids;
    return this.get();
  };

  CompanyList.prototype.get = function() {
    return $.ajax(this.home + "/" + this.url, {
      data: {
        ids: this.ids
      }
    }).done((function(_this) {
      return function(comps) {
        return _this.updateCollection(JSON.parse(comps));
      };
    })(this));
  };

  CompanyList.prototype.updateCollection = function(c) {
    var comp, j, len, m, results;
    this.collection.reset();
    results = [];
    for (j = 0, len = c.length; j < len; j++) {
      comp = c[j];
      m = new CompanyModel({
        address: comp.address,
        description: comp.description,
        excerpt: comp.description.excerpt(),
        logo: comp.logo,
        name: comp.name,
        phone: comp.phone,
        tags: comp.tags
      });
      results.push(this.collection.add(m));
    }
    return results;
  };

  return CompanyList;

})(Backbone.View);

types = new TypeList({
  el: '#main-type-list'
});

specs = new SpecList({
  el: '#parts-list',
  types: types
});

makes = new MakeList({
  el: '#main-makes-list',
  specs: specs
});

companies = new CompanyList({
  el: '#found',
  makes: makes
});

},{"./inc/TypeList":3}],6:[function(require,module,exports){
var AddPhotos, Image, ImageCollection, ImageView, ImagesView, List, ListCollection, ListModel, ListView, SelectView, imageCollection, imagesView, make, minuses, model, pluses, type,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

SelectView = require('../inc/SelectView');

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

},{"../inc/SelectView":2}],7:[function(require,module,exports){
require('./search');

require('./reg');

require('./feedback');

},{"./feedback":6,"./reg":8,"./search":9}],8:[function(require,module,exports){
$('#register').magnificPopup({
  type: 'inline',
  closeBtnInside: true
});

},{}],9:[function(require,module,exports){
var SelectView, make, model, type;

SelectView = require('../inc/SelectView');

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

},{"../inc/SelectView":2}]},{},[4]);
