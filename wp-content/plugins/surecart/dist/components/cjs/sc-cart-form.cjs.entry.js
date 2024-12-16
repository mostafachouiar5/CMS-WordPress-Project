'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const index$1 = require('./index-21f8920e.js');
const index$2 = require('./index-771f480e.js');
const mutations = require('./mutations-19357660.js');
require('./fetch-f25a0cb0.js');
require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');

const query = {
    expand: [
        'line_items',
        'line_item.price',
        'price.product',
        'customer',
        'customer.shipping_address',
        'payment_intent',
        'discount',
        'discount.promotion',
        'discount.coupon',
        'shipping_address',
        'tax_identifier',
    ],
};
const ScCartForm = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.quantity = 1;
        this.priceId = undefined;
        this.variantId = undefined;
        this.mode = 'live';
        this.formId = undefined;
        this.busy = undefined;
        this.error = undefined;
    }
    /** Find a line item with this price. */
    getLineItem() {
        var _a, _b, _c;
        const lineItem = (((_b = (_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) || []).find(item => {
            var _a, _b, _c;
            if (this.variantId) {
                return ((_a = item.variant) === null || _a === void 0 ? void 0 : _a.id) === this.variantId && ((_b = item.price) === null || _b === void 0 ? void 0 : _b.id) === this.priceId;
            }
            return ((_c = item.price) === null || _c === void 0 ? void 0 : _c.id) === this.priceId;
        });
        if (!(lineItem === null || lineItem === void 0 ? void 0 : lineItem.id)) {
            return false;
        }
        return {
            id: lineItem === null || lineItem === void 0 ? void 0 : lineItem.id,
            price_id: (_c = lineItem === null || lineItem === void 0 ? void 0 : lineItem.price) === null || _c === void 0 ? void 0 : _c.id,
            quantity: lineItem === null || lineItem === void 0 ? void 0 : lineItem.quantity,
        };
    }
    /** Add the item to cart. */
    async addToCart() {
        const { price } = await this.form.getFormJson();
        try {
            mutations.updateFormState('FETCH');
            // if it's ad_hoc, update the amount. Otherwise increment the quantity.
            mutations.state.checkout = await this.addOrUpdateLineItem({
                ...(!!price ? { ad_hoc_amount: parseInt(price) || null } : {}),
                ...(!!this.variantId ? { variant_id: this.variantId || null } : {}),
            });
            mutations.updateFormState('RESOLVE');
            // store the checkout in localstorage and open the cart
            mutations.store.set('cart', { ...mutations.store.state.cart, ...{ open: true } });
        }
        catch (e) {
            mutations.updateFormState('REJECT');
            console.error(e);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
    }
    async addOrUpdateLineItem(data = {}) {
        var _a, _b;
        // get the current line item from the price id.
        let lineItem = this.getLineItem();
        // convert line items response to line items post.
        let existingData = index$1.convertLineItemsToLineItemData(((_a = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) || []);
        // Line item does not exist. Add it.
        return (await index$2.createOrUpdateCheckout({
            id: (_b = mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.checkout) === null || _b === void 0 ? void 0 : _b.id,
            data: {
                live_mode: this.mode === 'live',
                line_items: [
                    ...(existingData || []).map((item) => {
                        // if the price ids match (we have already a line item)
                        const priceOrVariantMatches = this.variantId ? item.price_id === this.priceId && item.variant_id === this.variantId : item.price_id === this.priceId;
                        if (priceOrVariantMatches) {
                            return {
                                ...item,
                                ...(!!(data === null || data === void 0 ? void 0 : data.ad_hoc_amount) ? { ad_hoc_amount: data === null || data === void 0 ? void 0 : data.ad_hoc_amount } : {}),
                                ...(!!(data === null || data === void 0 ? void 0 : data.variant_id) ? { variant_id: data === null || data === void 0 ? void 0 : data.variant_id } : {}),
                                quantity: !(item === null || item === void 0 ? void 0 : item.ad_hoc_amount) ? (item === null || item === void 0 ? void 0 : item.quantity) + 1 : 1, // only increase quantity if not ad_hoc.
                            };
                        }
                        // return item.
                        return item;
                    }),
                    // add a line item if one does not exist.
                    ...(!lineItem
                        ? [
                            {
                                price_id: this.priceId,
                                variant_id: this.variantId,
                                ...(!!(data === null || data === void 0 ? void 0 : data.ad_hoc_amount) ? { ad_hoc_amount: data === null || data === void 0 ? void 0 : data.ad_hoc_amount } : {}),
                                quantity: 1,
                            },
                        ]
                        : []),
                ],
            },
            query: {
                ...query,
                form_id: this.formId,
            },
        }));
    }
    render() {
        return (index.h("sc-form", { key: '7520eac4e53e3ce0ff66a59e666cfd63084cf7d2', ref: el => (this.form = el), onScSubmit: () => {
                this.addToCart();
            } }, this.error && (index.h("sc-alert", { key: '4462fdd6c86f6ee8701c58706c1e72161cdcc0d6', open: !!this.error, type: "danger" }, index.h("span", { key: '65b2e9a851c8b73208550a9d48cfe0bc0e01dc11', slot: "title" }, wp.i18n.__('Error', 'surecart')), this.error)), index.h("slot", { key: '203c38679031ffa6a07f3705927fe643a52a4237' })));
    }
};
ScCartForm.style = "sc-cart-form { display: inline-block }";

exports.sc_cart_form = ScCartForm;

//# sourceMappingURL=sc-cart-form.cjs.entry.js.map