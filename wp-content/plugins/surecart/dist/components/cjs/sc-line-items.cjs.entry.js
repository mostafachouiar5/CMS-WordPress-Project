'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const mutations = require('./mutations-19357660.js');
const index$1 = require('./index-21f8920e.js');
const price = require('./price-653ec1cb.js');
const mutations$1 = require('./mutations-6484d4a1.js');
const getters = require('./getters-690e042a.js');
const quantity = require('./quantity-bff7f892.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./mutations-11c8f9a8.js');
require('./index-771f480e.js');
require('./fetch-f25a0cb0.js');

const scLineItemsCss = ":host{display:block}:slotted(*~*){margin-top:20px}.line-items{display:grid;gap:var(--sc-form-row-spacing)}.line-item{display:grid;gap:var(--sc-spacing-small)}.fee__description{opacity:0.75}";
const ScLineItemsStyle0 = scLineItemsCss;

const ScLineItems = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.editable = undefined;
        this.removable = undefined;
    }
    /**
     * Is the line item editable?
     */
    isEditable(item) {
        var _a;
        // ad_hoc prices and bumps cannot have quantity.
        if (((_a = item === null || item === void 0 ? void 0 : item.price) === null || _a === void 0 ? void 0 : _a.ad_hoc) || (item === null || item === void 0 ? void 0 : item.bump_amount) || (item === null || item === void 0 ? void 0 : item.locked)) {
            return false;
        }
        return this.editable;
    }
    render() {
        var _a, _b, _c, _d, _e;
        if (!!getters.formBusy() && !((_c = (_b = (_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.length)) {
            return (index.h("sc-line-item", null, index.h("sc-skeleton", { style: { 'width': '50px', 'height': '50px', '--border-radius': '0' }, slot: "image" }), index.h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), index.h("sc-skeleton", { slot: "description", style: { width: '60px', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '120px', display: 'inline-block' }, slot: "price" }), index.h("sc-skeleton", { style: { width: '60px', display: 'inline-block' }, slot: "price-description" })));
        }
        return (index.h("div", { class: "line-items", part: "base", tabindex: "0" }, (((_e = (_d = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _d === void 0 ? void 0 : _d.line_items) === null || _e === void 0 ? void 0 : _e.data) || []).map(item => {
            var _a, _b, _c, _d, _e, _f, _g, _h;
            const max = quantity.getMaxStockQuantity((_a = item === null || item === void 0 ? void 0 : item.price) === null || _a === void 0 ? void 0 : _a.product, item === null || item === void 0 ? void 0 : item.variant);
            return (index.h("div", { class: "line-item" }, index.h("sc-product-line-item", { key: item.id, image: item === null || item === void 0 ? void 0 : item.image, name: (_c = (_b = item === null || item === void 0 ? void 0 : item.price) === null || _b === void 0 ? void 0 : _b.product) === null || _c === void 0 ? void 0 : _c.name, priceName: (_d = item === null || item === void 0 ? void 0 : item.price) === null || _d === void 0 ? void 0 : _d.name, variantLabel: ((item === null || item === void 0 ? void 0 : item.variant_options) || []).filter(Boolean).join(' / ') || null, purchasableStatusDisplay: item === null || item === void 0 ? void 0 : item.purchasable_status_display, ...(max ? { max } : {}), editable: this.isEditable(item), removable: !(item === null || item === void 0 ? void 0 : item.locked) && this.removable, quantity: item.quantity, fees: (_e = item === null || item === void 0 ? void 0 : item.fees) === null || _e === void 0 ? void 0 : _e.data, setupFeeTrialEnabled: (_f = item === null || item === void 0 ? void 0 : item.price) === null || _f === void 0 ? void 0 : _f.setup_fee_trial_enabled, amount: item.ad_hoc_amount !== null ? item.ad_hoc_amount : item.subtotal_amount, scratchAmount: item.ad_hoc_amount == null && (item === null || item === void 0 ? void 0 : item.scratch_amount), currency: (_g = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _g === void 0 ? void 0 : _g.currency, trialDurationDays: (_h = item === null || item === void 0 ? void 0 : item.price) === null || _h === void 0 ? void 0 : _h.trial_duration_days, interval: !!(item === null || item === void 0 ? void 0 : item.price) && price.intervalString(item === null || item === void 0 ? void 0 : item.price, { showOnce: index$1.hasSubscription(mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) }), onScUpdateQuantity: e => mutations$1.updateCheckoutLineItem({ id: item.id, data: { quantity: e.detail } }), onScRemove: () => mutations$1.removeCheckoutLineItem(item === null || item === void 0 ? void 0 : item.id), exportparts: "base:line-item, product-line-item, image:line-item__image, text:line-item__text, title:line-item__title, suffix:line-item__suffix, price:line-item__price, price__amount:line-item__price-amount, price__description:line-item__price-description, price__scratch:line-item__price-scratch, static-quantity:line-item__static-quantity, remove-icon__base:line-item__remove-icon, quantity:line-item__quantity, quantity__minus:line-item__quantity-minus, quantity__minus-icon:line-item__quantity-minus-icon, quantity__plus:line-item__quantity-plus, quantity__plus-icon:line-item__quantity-plus-icon, quantity__input:line-item__quantity-input, line-item__price-description:line-item__price-description" })));
        })));
    }
};
ScLineItems.style = ScLineItemsStyle0;

exports.sc_line_items = ScLineItems;

//# sourceMappingURL=sc-line-items.cjs.entry.js.map