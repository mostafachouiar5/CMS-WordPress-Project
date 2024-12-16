import { r as registerInstance, c as createEvent, h, F as Fragment, H as Host } from './index-745b6bec.js';
import { o as openWormhole } from './consumer-e06b16d3.js';
import { i as isPriceInOrder } from './index-0202319f.js';
import { i as intervalString } from './price-d5770168.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import './currency-a0c9bff4.js';
import './remove-query-args-938c53ea.js';

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

function _inheritsLoose(subClass, superClass) {
  subClass.prototype = Object.create(superClass.prototype);
  subClass.prototype.constructor = subClass;
  subClass.__proto__ = superClass;
}

/**
 * Helpers to enable Immutable compatibility *without* bringing in
 * the 'immutable' package as a dependency.
 */

/**
 * Check if an object is immutable by checking if it has a key specific
 * to the immutable library.
 *
 * @param  {any} object
 * @return {bool}
 */
function isImmutable(object) {
  return !!(object && typeof object.hasOwnProperty === 'function' && (object.hasOwnProperty('__ownerID') || // Immutable.Map
  object._map && object._map.hasOwnProperty('__ownerID'))); // Immutable.Record
}
/**
 * Denormalize an immutable entity.
 *
 * @param  {Schema} schema
 * @param  {Immutable.Map|Immutable.Record} input
 * @param  {function} unvisit
 * @param  {function} getDenormalizedEntity
 * @return {Immutable.Map|Immutable.Record}
 */

function denormalizeImmutable(schema, input, unvisit) {
  return Object.keys(schema).reduce(function (object, key) {
    // Immutable maps cast keys to strings on write so we need to ensure
    // we're accessing them using string keys.
    var stringKey = "" + key;

    if (object.has(stringKey)) {
      return object.set(stringKey, unvisit(object.get(stringKey), schema[stringKey]));
    } else {
      return object;
    }
  }, input);
}

var getDefaultGetId = function getDefaultGetId(idAttribute) {
  return function (input) {
    return isImmutable(input) ? input.get(idAttribute) : input[idAttribute];
  };
};

var EntitySchema = /*#__PURE__*/function () {
  function EntitySchema(key, definition, options) {
    if (definition === void 0) {
      definition = {};
    }

    if (options === void 0) {
      options = {};
    }

    if (!key || typeof key !== 'string') {
      throw new Error("Expected a string key for Entity, but found " + key + ".");
    }

    var _options = options,
        _options$idAttribute = _options.idAttribute,
        idAttribute = _options$idAttribute === void 0 ? 'id' : _options$idAttribute,
        _options$mergeStrateg = _options.mergeStrategy,
        mergeStrategy = _options$mergeStrateg === void 0 ? function (entityA, entityB) {
      return _extends({}, entityA, entityB);
    } : _options$mergeStrateg,
        _options$processStrat = _options.processStrategy,
        processStrategy = _options$processStrat === void 0 ? function (input) {
      return _extends({}, input);
    } : _options$processStrat,
        _options$fallbackStra = _options.fallbackStrategy,
        fallbackStrategy = _options$fallbackStra === void 0 ? function (key, schema) {
      return undefined;
    } : _options$fallbackStra;
    this._key = key;
    this._getId = typeof idAttribute === 'function' ? idAttribute : getDefaultGetId(idAttribute);
    this._idAttribute = idAttribute;
    this._mergeStrategy = mergeStrategy;
    this._processStrategy = processStrategy;
    this._fallbackStrategy = fallbackStrategy;
    this.define(definition);
  }

  var _proto = EntitySchema.prototype;

  _proto.define = function define(definition) {
    this.schema = Object.keys(definition).reduce(function (entitySchema, key) {
      var _extends2;

      var schema = definition[key];
      return _extends({}, entitySchema, (_extends2 = {}, _extends2[key] = schema, _extends2));
    }, this.schema || {});
  };

  _proto.getId = function getId(input, parent, key) {
    return this._getId(input, parent, key);
  };

  _proto.merge = function merge(entityA, entityB) {
    return this._mergeStrategy(entityA, entityB);
  };

  _proto.fallback = function fallback(id, schema) {
    return this._fallbackStrategy(id, schema);
  };

  _proto.normalize = function normalize(input, parent, key, visit, addEntity, visitedEntities) {
    var _this = this;

    var id = this.getId(input, parent, key);
    var entityType = this.key;

    if (!(entityType in visitedEntities)) {
      visitedEntities[entityType] = {};
    }

    if (!(id in visitedEntities[entityType])) {
      visitedEntities[entityType][id] = [];
    }

    if (visitedEntities[entityType][id].some(function (entity) {
      return entity === input;
    })) {
      return id;
    }

    visitedEntities[entityType][id].push(input);

    var processedEntity = this._processStrategy(input, parent, key);

    Object.keys(this.schema).forEach(function (key) {
      if (processedEntity.hasOwnProperty(key) && typeof processedEntity[key] === 'object') {
        var schema = _this.schema[key];
        var resolvedSchema = typeof schema === 'function' ? schema(input) : schema;
        processedEntity[key] = visit(processedEntity[key], processedEntity, key, resolvedSchema, addEntity, visitedEntities);
      }
    });
    addEntity(this, processedEntity, input, parent, key);
    return id;
  };

  _proto.denormalize = function denormalize(entity, unvisit) {
    var _this2 = this;

    if (isImmutable(entity)) {
      return denormalizeImmutable(this.schema, entity, unvisit);
    }

    Object.keys(this.schema).forEach(function (key) {
      if (entity.hasOwnProperty(key)) {
        var schema = _this2.schema[key];
        entity[key] = unvisit(entity[key], schema);
      }
    });
    return entity;
  };

  _createClass(EntitySchema, [{
    key: "key",
    get: function get() {
      return this._key;
    }
  }, {
    key: "idAttribute",
    get: function get() {
      return this._idAttribute;
    }
  }]);

  return EntitySchema;
}();

var PolymorphicSchema = /*#__PURE__*/function () {
  function PolymorphicSchema(definition, schemaAttribute) {
    if (schemaAttribute) {
      this._schemaAttribute = typeof schemaAttribute === 'string' ? function (input) {
        return input[schemaAttribute];
      } : schemaAttribute;
    }

    this.define(definition);
  }

  var _proto = PolymorphicSchema.prototype;

  _proto.define = function define(definition) {
    this.schema = definition;
  };

  _proto.getSchemaAttribute = function getSchemaAttribute(input, parent, key) {
    return !this.isSingleSchema && this._schemaAttribute(input, parent, key);
  };

  _proto.inferSchema = function inferSchema(input, parent, key) {
    if (this.isSingleSchema) {
      return this.schema;
    }

    var attr = this.getSchemaAttribute(input, parent, key);
    return this.schema[attr];
  };

  _proto.normalizeValue = function normalizeValue(value, parent, key, visit, addEntity, visitedEntities) {
    var schema = this.inferSchema(value, parent, key);

    if (!schema) {
      return value;
    }

    var normalizedValue = visit(value, parent, key, schema, addEntity, visitedEntities);
    return this.isSingleSchema || normalizedValue === undefined || normalizedValue === null ? normalizedValue : {
      id: normalizedValue,
      schema: this.getSchemaAttribute(value, parent, key)
    };
  };

  _proto.denormalizeValue = function denormalizeValue(value, unvisit) {
    var schemaKey = isImmutable(value) ? value.get('schema') : value.schema;

    if (!this.isSingleSchema && !schemaKey) {
      return value;
    }

    var id = this.isSingleSchema ? undefined : isImmutable(value) ? value.get('id') : value.id;
    var schema = this.isSingleSchema ? this.schema : this.schema[schemaKey];
    return unvisit(id || value, schema);
  };

  _createClass(PolymorphicSchema, [{
    key: "isSingleSchema",
    get: function get() {
      return !this._schemaAttribute;
    }
  }]);

  return PolymorphicSchema;
}();

var UnionSchema = /*#__PURE__*/function (_PolymorphicSchema) {
  _inheritsLoose(UnionSchema, _PolymorphicSchema);

  function UnionSchema(definition, schemaAttribute) {
    if (!schemaAttribute) {
      throw new Error('Expected option "schemaAttribute" not found on UnionSchema.');
    }

    return _PolymorphicSchema.call(this, definition, schemaAttribute) || this;
  }

  var _proto = UnionSchema.prototype;

  _proto.normalize = function normalize(input, parent, key, visit, addEntity, visitedEntities) {
    return this.normalizeValue(input, parent, key, visit, addEntity, visitedEntities);
  };

  _proto.denormalize = function denormalize(input, unvisit) {
    return this.denormalizeValue(input, unvisit);
  };

  return UnionSchema;
}(PolymorphicSchema);

var ValuesSchema = /*#__PURE__*/function (_PolymorphicSchema) {
  _inheritsLoose(ValuesSchema, _PolymorphicSchema);

  function ValuesSchema() {
    return _PolymorphicSchema.apply(this, arguments) || this;
  }

  var _proto = ValuesSchema.prototype;

  _proto.normalize = function normalize(input, parent, key, visit, addEntity, visitedEntities) {
    var _this = this;

    return Object.keys(input).reduce(function (output, key, index) {
      var _extends2;

      var value = input[key];
      return value !== undefined && value !== null ? _extends({}, output, (_extends2 = {}, _extends2[key] = _this.normalizeValue(value, input, key, visit, addEntity, visitedEntities), _extends2)) : output;
    }, {});
  };

  _proto.denormalize = function denormalize(input, unvisit) {
    var _this2 = this;

    return Object.keys(input).reduce(function (output, key) {
      var _extends3;

      var entityOrId = input[key];
      return _extends({}, output, (_extends3 = {}, _extends3[key] = _this2.denormalizeValue(entityOrId, unvisit), _extends3));
    }, {});
  };

  return ValuesSchema;
}(PolymorphicSchema);

var validateSchema = function validateSchema(definition) {
  var isArray = Array.isArray(definition);

  if (isArray && definition.length > 1) {
    throw new Error("Expected schema definition to be a single schema, but found " + definition.length + ".");
  }

  return definition[0];
};

var getValues = function getValues(input) {
  return Array.isArray(input) ? input : Object.keys(input).map(function (key) {
    return input[key];
  });
};

var normalize = function normalize(schema, input, parent, key, visit, addEntity, visitedEntities) {
  schema = validateSchema(schema);
  var values = getValues(input); // Special case: Arrays pass *their* parent on to their children, since there
  // is not any special information that can be gathered from themselves directly

  return values.map(function (value, index) {
    return visit(value, parent, key, schema, addEntity, visitedEntities);
  });
};

var ArraySchema = /*#__PURE__*/function (_PolymorphicSchema) {
  _inheritsLoose(ArraySchema, _PolymorphicSchema);

  function ArraySchema() {
    return _PolymorphicSchema.apply(this, arguments) || this;
  }

  var _proto = ArraySchema.prototype;

  _proto.normalize = function normalize(input, parent, key, visit, addEntity, visitedEntities) {
    var _this = this;

    var values = getValues(input);
    return values.map(function (value, index) {
      return _this.normalizeValue(value, parent, key, visit, addEntity, visitedEntities);
    }).filter(function (value) {
      return value !== undefined && value !== null;
    });
  };

  _proto.denormalize = function denormalize(input, unvisit) {
    var _this2 = this;

    return input && input.map ? input.map(function (value) {
      return _this2.denormalizeValue(value, unvisit);
    }) : input;
  };

  return ArraySchema;
}(PolymorphicSchema);

var _normalize = function normalize(schema, input, parent, key, visit, addEntity, visitedEntities) {
  var object = _extends({}, input);

  Object.keys(schema).forEach(function (key) {
    var localSchema = schema[key];
    var resolvedLocalSchema = typeof localSchema === 'function' ? localSchema(input) : localSchema;
    var value = visit(input[key], input, key, resolvedLocalSchema, addEntity, visitedEntities);

    if (value === undefined || value === null) {
      delete object[key];
    } else {
      object[key] = value;
    }
  });
  return object;
};

var _denormalize = function denormalize(schema, input, unvisit) {
  if (isImmutable(input)) {
    return denormalizeImmutable(schema, input, unvisit);
  }

  var object = _extends({}, input);

  Object.keys(schema).forEach(function (key) {
    if (object[key] != null) {
      object[key] = unvisit(object[key], schema[key]);
    }
  });
  return object;
};

var ObjectSchema = /*#__PURE__*/function () {
  function ObjectSchema(definition) {
    this.define(definition);
  }

  var _proto = ObjectSchema.prototype;

  _proto.define = function define(definition) {
    this.schema = Object.keys(definition).reduce(function (entitySchema, key) {
      var _extends2;

      var schema = definition[key];
      return _extends({}, entitySchema, (_extends2 = {}, _extends2[key] = schema, _extends2));
    }, this.schema || {});
  };

  _proto.normalize = function normalize() {
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    return _normalize.apply(void 0, [this.schema].concat(args));
  };

  _proto.denormalize = function denormalize() {
    for (var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
      args[_key2] = arguments[_key2];
    }

    return _denormalize.apply(void 0, [this.schema].concat(args));
  };

  return ObjectSchema;
}();

var visit = function visit(value, parent, key, schema, addEntity, visitedEntities) {
  if (typeof value !== 'object' || !value) {
    return value;
  }

  if (typeof schema === 'object' && (!schema.normalize || typeof schema.normalize !== 'function')) {
    var method = Array.isArray(schema) ? normalize : _normalize;
    return method(schema, value, parent, key, visit, addEntity, visitedEntities);
  }

  return schema.normalize(value, parent, key, visit, addEntity, visitedEntities);
};

var addEntities = function addEntities(entities) {
  return function (schema, processedEntity, value, parent, key) {
    var schemaKey = schema.key;
    var id = schema.getId(value, parent, key);

    if (!(schemaKey in entities)) {
      entities[schemaKey] = {};
    }

    var existingEntity = entities[schemaKey][id];

    if (existingEntity) {
      entities[schemaKey][id] = schema.merge(existingEntity, processedEntity);
    } else {
      entities[schemaKey][id] = processedEntity;
    }
  };
};

var schema = {
  Array: ArraySchema,
  Entity: EntitySchema,
  Object: ObjectSchema,
  Union: UnionSchema,
  Values: ValuesSchema
};
var normalize$1 = function normalize(input, schema) {
  if (!input || typeof input !== 'object') {
    throw new Error("Unexpected input given to normalize. Expected type to be \"object\", found \"" + (input === null ? 'null' : typeof input) + "\".");
  }

  var entities = {};
  var addEntity = addEntities(entities);
  var visitedEntities = {};
  var result = visit(input, input, null, schema, addEntity, visitedEntities);
  return {
    entities: entities,
    result: result
  };
};

const entities = {
	integration: new schema.Entity('integration'),
	account: new schema.Entity('account'),
	price: new schema.Entity('price'),
	product: new schema.Entity('product'),
	product_group: new schema.Entity('product_group'),
	purchase: new schema.Entity('purchase'),
	payment_method: new schema.Entity('payment_method'),
	card: new schema.Entity('card'),
	invoice: new schema.Entity('invoice'),
	current_period: new schema.Entity('current_period'),
	refund: new schema.Entity('refund'),
	charge: new schema.Entity('charge'),
	coupon: new schema.Entity('coupon'),
	promotion: new schema.Entity('promotion'),
	order: new schema.Entity('order'),
	customer: new schema.Entity('customer'),
	subscription: new schema.Entity('subscription'),
	product_group: new schema.Entity('product_group'),
};

const {
	price,
	product,
	purchase,
	payment_method,
	card,
	invoice,
	refund,
	charge,
	coupon,
	promotion,
	order,
	integration,
	customer,
	product_group,
	subscription,
} = entities;

product.define({
	prices: {
		data: [price],
	},
	product_group,
});

price.define({
	product,
});

invoice.define({
	purchases: {
		data: [purchase],
	},
	charge,
	customer,
	subscription,
});

order.define({
	purchases: {
		data: [purchase],
	},
	charge,
	customer,
	subscription,
});

charge.define({
	order,
	invoice,
});

subscription.define({
	current_period: invoice,
	purchase,
	price,
	payment_method,
	order,
	customer,
});

refund.define({
	charge,
	customer,
});

purchase.define({
	order,
	product,
	subscription,
});

payment_method.define({
	card,
});

coupon.define({
	promotions: {
		data: [promotion],
	},
});

product_group.define({});
integration.define({});

const normalizeEntities = (data) => {
	if (entities?.[data?.[0]?.object]) {
		return normalize$1(data, [entities[data?.[0]?.object]]);
	}
	return {};
};

const getPricesAndProducts = async ({ ids, archived = false }) => {
    const prices = (await apiFetch({
        path: addQueryArgs('surecart/v1/prices/', {
            ids,
            archived,
            expand: ['product'],
        }),
    }));
    return normalizePrices(prices);
};
const normalizePrices = (prices) => {
    const { entities } = normalizeEntities(prices);
    return {
        prices: entities === null || entities === void 0 ? void 0 : entities.price,
        products: entities === null || entities === void 0 ? void 0 : entities.product,
    };
};

const scPriceChoiceCss = ":host {\n  display: block;\n  min-width: 0;\n  width: 100%;\n}\n\nsc-choice-container {\n  container-type: inline-size;\n}\n\n.price-choice {\n  display: flex;\n  align-items: center;\n  justify-content: space-between;\n  line-height: var(--sc-line-height-dense);\n  gap: var(--sc-spacing-small);\n}\n.price-choice__name {\n  color: var(--sc-price-choice-name-color, var(--sc-input-label-color));\n  font-size: var(--sc-price-choice-name-size, var(--sc-input-label-font-size-medium));\n  font-weight: var(--sc-price-choice-name-font-weight, var(--sc-font-weight-bold));\n  text-transform: var(--sc-price-choice-text-transform, var(--sc-input-label-text-transform, none));\n  display: -webkit-box;\n  display: -moz-box;\n  -webkit-box-orient: vertical;\n  -moz-box-orient: vertical;\n  -webkit-line-clamp: 3;\n  -moz-box-lines: 3;\n  overflow: hidden;\n  text-overflow: ellipsis;\n}\n.price-choice__description {\n  color: var(--sc-input-help-text-color);\n}\n.price-choice > *:not(:first-child):last-child {\n  text-align: right;\n}\n.price-choice__details {\n  flex: 1 0 50%;\n  display: grid;\n  gap: var(--sc-spacing-xxx-small);\n}\n.price-choice__trial, .price-choice__setup-fee, .price-choice__price {\n  font-size: var(--sc-font-size-small);\n  color: var(--sc-input-help-text-color);\n}\n.price-choice__price {\n  color: var(--sc-input-label-color);\n  font-weight: var(--sc-price-choice-price-font-weight, var(--sc-font-weight-normal));\n}\n\n@container (max-width: 325px) {\n  .price-choice {\n    flex-direction: column;\n    align-items: flex-start;\n    gap: var(--sc-spacing-xx-small);\n  }\n  .price-choice > *:not(:first-child):last-child {\n    text-align: initial;\n  }\n}";
const ScPriceChoiceStyle0 = scPriceChoiceCss;

const ScPriceChoice = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scUpdateLineItem = createEvent(this, "scUpdateLineItem", 7);
        this.scRemoveLineItem = createEvent(this, "scRemoveLineItem", 7);
        this.scAddEntities = createEvent(this, "scAddEntities", 7);
        this.priceId = undefined;
        this.price = undefined;
        this.product = undefined;
        this.loading = false;
        this.label = undefined;
        this.showLabel = true;
        this.showPrice = true;
        this.showControl = true;
        this.description = undefined;
        this.prices = {};
        this.products = {};
        this.order = undefined;
        this.quantity = 1;
        this.type = undefined;
        this.checked = false;
        this.error = undefined;
        this.isAdHoc = undefined;
        this.blank = false;
        this.errorMessage = undefined;
        this.adHocErrorMessage = undefined;
    }
    /** Refetch if price changes */
    handlePriceIdChage() {
        var _a;
        if (this.price && ((_a = this.price) === null || _a === void 0 ? void 0 : _a.id) === this.priceId)
            return;
        this.fetchPriceWithProduct();
    }
    /** Keep price up to date. */
    handlePricesChange() {
        var _a, _b, _c;
        if (!Object.keys(this.prices || {}).length || !Object.keys(this.products || {}).length)
            return;
        this.price = (_a = this === null || this === void 0 ? void 0 : this.prices) === null || _a === void 0 ? void 0 : _a[this.priceId];
        this.product = (_b = this === null || this === void 0 ? void 0 : this.products) === null || _b === void 0 ? void 0 : _b[(_c = this === null || this === void 0 ? void 0 : this.price) === null || _c === void 0 ? void 0 : _c.product];
    }
    handlePriseChange() {
        var _a;
        this.isAdHoc = (_a = this === null || this === void 0 ? void 0 : this.price) === null || _a === void 0 ? void 0 : _a.ad_hoc;
    }
    handleErrorsChange() {
        var _a;
        const error = (((_a = this === null || this === void 0 ? void 0 : this.error) === null || _a === void 0 ? void 0 : _a.additional_errors) || []).find(error => { var _a; return ((_a = error === null || error === void 0 ? void 0 : error.data) === null || _a === void 0 ? void 0 : _a.attribute) === 'line_items.ad_hoc_amount'; });
        this.adHocErrorMessage = (error === null || error === void 0 ? void 0 : error.message) ? error === null || error === void 0 ? void 0 : error.message : '';
    }
    handleCheckedChange() {
        var _a;
        if (((_a = this.price) === null || _a === void 0 ? void 0 : _a.ad_hoc) && this.choice.checked) {
            setTimeout(() => {
                this.adHocInput.triggerFocus();
            }, 50);
            return;
        }
    }
    /** Fetch on load */
    componentWillLoad() {
        if (!this.price) {
            this.fetchPriceWithProduct();
        }
    }
    /** Fetch prices and products */
    async fetchPriceWithProduct() {
        if (!this.priceId)
            return;
        try {
            this.loading = true;
            const { products, prices } = await getPricesAndProducts({
                archived: false,
                ids: [this.priceId],
            });
            // add to central store.
            this.scAddEntities.emit({ prices, products });
        }
        catch (err) {
        }
        finally {
            this.loading = false;
        }
    }
    /** Is this price in the checkout session. */
    isInOrder() {
        return isPriceInOrder(this.price, this.order);
    }
    /** Is this checked */
    isChecked() {
        return this.isInOrder();
    }
    onChangeAdHoc(e) {
        this.scUpdateLineItem.emit({ price_id: this.priceId, quantity: this.quantity, ad_hoc_amount: e.target.value });
    }
    getLineItem() {
        var _a, _b;
        return (((_b = (_a = this.order) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) || []).find(lineItem => lineItem.price.id === this.priceId);
    }
    /** Show we show the ad hoc price box */
    showAdHoc() {
        var _a, _b;
        if (!((_a = this.price) === null || _a === void 0 ? void 0 : _a.ad_hoc)) {
            return false;
        }
        if (this.isInOrder()) {
            return true;
        }
        return (_b = this === null || this === void 0 ? void 0 : this.choice) === null || _b === void 0 ? void 0 : _b.checked;
    }
    renderEmpty() {
        var _a;
        if ((_a = window === null || window === void 0 ? void 0 : window.wp) === null || _a === void 0 ? void 0 : _a.blocks) {
            return (h("sc-alert", { type: "danger", open: true, style: { margin: '0px' } }, wp.i18n.__('This product has been archived.', 'surecart')));
        }
        return h(Host, { style: { display: 'none' } });
    }
    renderPrice() {
        return (h(Fragment, null, h("sc-format-number", { type: "currency", value: this.price.amount, currency: this.price.currency }), intervalString(this.price, {
            showOnce: true,
            abbreviate: true,
            labels: {
                interval: '/',
                period: 
                /** translators: used as in time period: "for 3 months" */
                wp.i18n.__('for', 'surecart'),
            },
        })));
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h;
        if (this.loading) {
            return (h("sc-choice-container", { showControl: this.showControl, name: "loading", disabled: true }, h("div", { class: "price-choice" }, h("sc-skeleton", { style: { width: '60px', display: 'inline-block' } }), h("sc-skeleton", { style: { width: '80px', display: 'inline-block' } }))));
        }
        // we need an active price.
        if (!((_a = this === null || this === void 0 ? void 0 : this.price) === null || _a === void 0 ? void 0 : _a.id) || ((_b = this.price) === null || _b === void 0 ? void 0 : _b.archived))
            return this.renderEmpty();
        // product needs to be active
        if ((_c = this.product) === null || _c === void 0 ? void 0 : _c.archived) {
            return this.renderEmpty();
        }
        return (h("sc-choice-container", { ref: el => (this.choice = el), value: this.priceId, type: this.type, showControl: this.showControl, checked: this.isChecked() }, h("div", { class: "price-choice" }, this.showLabel && (h("div", { class: "price-choice__title" }, h("div", { class: "price-choice__name" }, this.label || ((_d = this === null || this === void 0 ? void 0 : this.price) === null || _d === void 0 ? void 0 : _d.name) || ((_e = this === null || this === void 0 ? void 0 : this.product) === null || _e === void 0 ? void 0 : _e.name)), !!this.description && h("div", { class: "price-choice__description" }, this.description))), this.showPrice && (h("div", { class: "price-choice__details" }, h("div", { class: "price-choice__price" }, ((_f = this.price) === null || _f === void 0 ? void 0 : _f.ad_hoc) ? (wp.i18n.__('Custom Amount', 'surecart')) : (h(Fragment, null, h("sc-format-number", { type: "currency", value: this.price.amount, currency: this.price.currency }), intervalString(this.price, {
            showOnce: true,
            abbreviate: true,
            labels: {
                interval: '/',
                period: 
                /** translators: used as in time period: "for 3 months" */
                wp.i18n.__('for', 'surecart'),
            },
        })))), !!this.price.trial_duration_days && (h("div", { class: "price-choice__trial" }, wp.i18n.sprintf(wp.i18n._n('Starting in %s day', 'Starting in %s days', this.price.trial_duration_days, 'surecart'), this.price.trial_duration_days))), !!this.price.setup_fee_enabled && ((_g = this.price) === null || _g === void 0 ? void 0 : _g.setup_fee_amount) && (h("div", { class: "price-choice__setup-fee" }, h("sc-format-number", { type: "currency", value: Math.abs(this.price.setup_fee_amount), currency: this.price.currency }), ' ', this.price.setup_fee_name || (((_h = this.price) === null || _h === void 0 ? void 0 : _h.setup_fee_amount) < 0 ? wp.i18n.__('Discount', 'surecart') : wp.i18n.__('Setup Fee', 'surecart')))))))));
    }
    static get watchers() { return {
        "priceId": ["handlePriceIdChage"],
        "prices": ["handlePricesChange"],
        "products": ["handlePricesChange"],
        "price": ["handlePriseChange"],
        "error": ["handleErrorsChange"],
        "checked": ["handleCheckedChange"]
    }; }
};
openWormhole(ScPriceChoice, ['prices', 'products', 'order', 'error'], false);
ScPriceChoice.style = ScPriceChoiceStyle0;

export { ScPriceChoice as sc_price_choice };

//# sourceMappingURL=sc-price-choice.entry.js.map