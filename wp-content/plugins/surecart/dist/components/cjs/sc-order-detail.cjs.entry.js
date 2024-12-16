'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const consumer = require('./consumer-9f4ee0e3.js');

/**
 * Set a value by a dot path.
 * @param obj The object to evaluate.
 * @param prop The path to be set.
 * @param value The value to set.
 */

function set(obj, prop, value) {
	prop = typeof prop === 'number' ? propToArray(prop.toString()) : typeof prop === 'string' ? propToArray(prop) : prop;

	const setPropImmutableRec = (obj, prop, value, i) => {
		let clone, head = prop[i];

		if (prop.length > i) {
			if (Array.isArray(obj)) {
				head = getArrayIndex(head, obj);
				clone = obj.slice();
			} else {
				clone = Object.assign({}, obj);
			}
			clone[head] = setPropImmutableRec(obj[head] !== undefined ? obj[head] : {}, prop, value, i + 1);
			return clone;
		}

		return typeof value === 'function' ? value(obj) : value;
	};

	return setPropImmutableRec(obj, prop, value, 0);
}

/**
 * Get a value by a dot path.
 * @param obj The object to evaluate.
 * @param prop The path to value that should be returned.
 * @param [value] The default value that should be returned when the target doesn't exist.
 */
function get(obj, prop, value) {
	prop = typeof prop === 'number' ? propToArray(prop.toString()) : typeof prop === 'string' ? propToArray(prop) : prop;

	for (var i = 0; i < prop.length; i++) {
		if (obj === null || typeof obj !== 'object') {
			return value;
		}
		let head = prop[i];
		if (Array.isArray(obj) && head === '$end') {
			head = obj.length - 1;
		}
		obj = obj[head];
	}

	if (typeof obj === 'undefined') {
		return value;
	}

	return obj;
}

/**
 * Delete a property by a dot path.
 * If target container is an object, the property is deleted.
 * If target container is an array, the index is deleted.
 * If target container is undefined, nothing is deleted.
 * @param obj The object to evaluate.
 * @param prop The path to the property or index that should be deleted.
 */
function _delete(obj, prop) {
	prop = typeof prop === 'number' ? propToArray(prop.toString()) : typeof prop === 'string' ? propToArray(prop) : prop;

	const deletePropImmutableRec = (obj, prop, i) => {
		let clone, head = prop[i];

		if (obj === null || typeof obj !== 'object' ||
			!Array.isArray(obj) && obj[head] === undefined) {

			return obj;
		}

		if (prop.length - 1 > i) {
			if (Array.isArray(obj)) {
				head = getArrayIndex(head, obj);
				clone = obj.slice();
			} else {
				clone = Object.assign({}, obj);
			}

			clone[head] = deletePropImmutableRec(obj[head], prop, i + 1);
			return clone;
		}

		if (Array.isArray(obj)) {
			head = getArrayIndex(head, obj);
			clone = [].concat(obj.slice(0, head), obj.slice(head + 1));
		} else {
			clone = Object.assign({}, obj);
			delete clone[head];
		}

		return clone;
	};

	return deletePropImmutableRec(obj, prop, 0);
}

/**
 * Toggles a value.  The target value is evaluated using Boolean(currentValue).  The result will always be a JSON boolean.
 * Be careful with strings as target value, as "true" and "false" will toggle to false, but "0" will toggle to true.
 * Here is what Javascript considers false:  0, -0, null, false, NaN, undefined, and the empty string ("")
 * @param obj The object to evaluate.
 * @param prop The path to the value.
 */
function toggle(obj, prop) {
	const curVal = get(obj, prop);
	return set(obj, prop, !Boolean(curVal));
}

/**
 * Merges a value.  The target value must be an object, array, null, or undefined.
 * If target is an object, Object.assign({}, target, param) is used.
 * If target an array, target.concat(param) is used.
 * If target is null or undefined, the value is simply set.
 * @param obj The object to evaluate.
 * @param prop The path to the value.
 * @param val The value to merge into the target value.
 */
function merge(obj, prop, val) {
	const curVal = get(obj, prop);
	if (typeof curVal === 'object') {
		if (Array.isArray(curVal)) {
			return set(obj, prop, curVal.concat(val));
		} else if (curVal === null) {
			return set(obj, prop, val);
		}
		else {
			let merged = Object.assign({}, curVal, val);
			return set(obj, prop, merged);
		}
	} else if (typeof curVal === 'undefined') {
		return set(obj, prop, val);
	}
	else {
		return obj;
	}
}

function getArrayIndex(head, obj) {
	if (head === '$end') {
		head = Math.max(obj.length - 1, 0);
	}
	if (!/^\+?\d+$/.test(head)) {
		throw new Error(`Array index '${head}' has to be an integer`);
	}
	return parseInt(head);
}

function propToArray(prop) {
	return prop.split('.').reduce((ret, el, index, list) => {
		const last = index > 0 && list[index - 1];
		if (last && /(?:^|[^\\])\\$/.test(last)) {
			const prev = ret.pop();
			ret.push(prev.slice(0, -1) + '.' + el);
		} else {
			ret.push(el);
		}
		return ret;
	}, []);
}

var lib = {
	set,
	get,
	delete: _delete,
	toggle,
	merge
};

const scOrderDetailCss = ":host{display:block}.order-detail__value{display:block;font-weight:var(--sc-font-weight-semibold);line-height:var(--sc-line-height-dense)}.order-detail__label{display:block;color:var(--sc-color-gray-500);line-height:var(--sc-line-height-dense)}";
const ScOrderDetailStyle0 = scOrderDetailCss;

const ScSessionDetail = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.order = undefined;
        this.value = undefined;
        this.fallback = undefined;
        this.metaKey = undefined;
        this.loading = undefined;
        this.label = undefined;
    }
    getPropByPath(object, path, defaultValue) {
        if (object && path.length)
            return this.getPropByPath(object[path.shift()], path, defaultValue);
        return object === undefined ? defaultValue : object;
    }
    getValue() {
        var _a, _b;
        if (!this.value) {
            return;
        }
        let value = '';
        // get metadata value
        if (this.value === 'metadata') {
            return lib.get((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.metadata, this.value || '');
        }
        // get value
        value = lib.get(this === null || this === void 0 ? void 0 : this.order, this.value || '');
        // if number, format it
        if (typeof value === 'number') {
            value = index.h("sc-format-number", { type: "currency", currency: (_b = this === null || this === void 0 ? void 0 : this.order) === null || _b === void 0 ? void 0 : _b.currency, value: value });
        }
        return value;
    }
    render() {
        if (this.loading) {
            return (index.h("div", { part: "base", class: {
                    'order-detail': true,
                } }, index.h("span", { part: "label", class: "order-detail__label" }, index.h("sc-skeleton", { style: { width: '60px', height: '8px', display: 'inline-block' } })), index.h("span", { part: "value", class: "order-detail__value" }, index.h("sc-skeleton", { style: { width: '120px', display: 'inline-block' } }))));
        }
        const value = this.getValue();
        if (!value) {
            if (!this.fallback) {
                return;
            }
        }
        return (index.h("div", { part: "base", class: {
                'order-detail': true,
            } }, index.h("span", { part: "label", class: "order-detail__label" }, index.h("slot", { name: "label" }, this.label)), index.h("span", { part: "value", class: "order-detail__value" }, index.h("slot", { name: "value" }, value || this.fallback))));
    }
};
consumer.openWormhole(ScSessionDetail, ['order', 'loading'], false);
ScSessionDetail.style = ScOrderDetailStyle0;

exports.sc_order_detail = ScSessionDetail;

//# sourceMappingURL=sc-order-detail.cjs.entry.js.map