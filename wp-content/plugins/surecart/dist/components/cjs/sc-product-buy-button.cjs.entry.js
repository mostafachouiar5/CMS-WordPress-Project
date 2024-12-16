'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const error = require('./error-0ea77dbe.js');
const watchers = require('./watchers-cb566474.js');
require('./mutations-19357660.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');
require('./mutations-6484d4a1.js');
require('./mutations-11c8f9a8.js');
require('./index-771f480e.js');
require('./fetch-f25a0cb0.js');
require('./google-03835677.js');
require('./util-b877b2bd.js');

const scProductBuyButtonCss = "sc-product-buy-button{position:relative}sc-product-buy-button a.wp-block-button__link{position:relative;text-decoration:none}sc-product-buy-button .sc-block-button--sold-out,sc-product-buy-button .sc-block-button--unavailable{display:none !important}sc-product-buy-button.is-unavailable a{display:none !important}sc-product-buy-button.is-unavailable .sc-block-button--unavailable{display:initial !important}sc-product-buy-button.is-sold-out a{display:none !important}sc-product-buy-button.is-sold-out .sc-block-button--sold-out{display:initial !important}sc-product-buy-button sc-spinner::part(base){--indicator-color:currentColor;--spinner-size:12px;position:absolute;top:calc(50% - var(--spinner-size) + var(--spinner-size) / 4);left:calc(50% - var(--spinner-size) + var(--spinner-size) / 4)}sc-product-buy-button [data-text],sc-product-buy-button [data-loader]{transition:opacity var(--sc-transition-fast) ease-in-out, visibility var(--sc-transition-fast) ease-in-out}sc-product-buy-button [data-loader]{opacity:0;visibility:hidden}sc-product-buy-button.is-disabled{pointer-events:none}sc-product-buy-button.is-busy [data-text]{opacity:0;visibility:hidden}sc-product-buy-button.is-busy [data-loader]{opacity:1;visibility:visible}sc-product-buy-button sc-alert{margin-bottom:var(--sc-spacing-medium)}sc-product-buy-button.is-out-of-stock [data-text]{opacity:0.6}";
const ScProductBuyButtonStyle0 = scProductBuyButtonCss;

const ScProductBuyButton = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.addToCart = undefined;
        this.productId = undefined;
        this.formId = undefined;
        this.mode = 'live';
        this.checkoutLink = undefined;
        this.error = undefined;
    }
    async handleCartClick(e) {
        var _a, _b, _c, _d, _e;
        e.preventDefault();
        console.log(e);
        // already busy, do nothing.
        if ((_a = watchers.state[this.productId]) === null || _a === void 0 ? void 0 : _a.busy)
            return;
        // ad hoc price, use the dialog.
        if ((_c = (_b = watchers.state[this.productId]) === null || _b === void 0 ? void 0 : _b.selectedPrice) === null || _c === void 0 ? void 0 : _c.ad_hoc) {
            watchers.setProduct(this.productId, { dialog: this.addToCart ? 'ad_hoc_cart' : 'ad_hoc_buy' });
            return;
        }
        // if add to cart is undefined/false navigate to buy url
        if (!this.addToCart) {
            const checkoutUrl = (_e = (_d = window === null || window === void 0 ? void 0 : window.scData) === null || _d === void 0 ? void 0 : _d.pages) === null || _e === void 0 ? void 0 : _e.checkout;
            if (!checkoutUrl)
                return;
            return window.location.assign(error.getProductBuyLink(this.productId, checkoutUrl, { no_cart: !this.addToCart }));
        }
        // submit the cart form.
        try {
            await error.submitCartForm(this.productId);
        }
        catch (e) {
            console.error(e);
            this.error = e;
        }
    }
    componentDidLoad() {
        this.link = this.el.querySelector('a');
        this.updateProductLink();
        watchers.onChange(this.productId, () => this.updateProductLink());
    }
    updateProductLink() {
        var _a, _b;
        const checkoutUrl = (_b = (_a = window === null || window === void 0 ? void 0 : window.scData) === null || _a === void 0 ? void 0 : _a.pages) === null || _b === void 0 ? void 0 : _b.checkout;
        if (!checkoutUrl || !this.link)
            return;
        this.link.href = error.getProductBuyLink(this.productId, checkoutUrl, !this.addToCart ? { no_cart: true } : {});
    }
    render() {
        var _a, _b;
        return (index.h(index.Host, { key: 'f0a2bcfca4d423833c052cf222864069893a1dbc', class: {
                'is-busy': ((_a = watchers.state[this.productId]) === null || _a === void 0 ? void 0 : _a.busy) && !!this.addToCart,
                'is-disabled': (_b = watchers.state[this.productId]) === null || _b === void 0 ? void 0 : _b.disabled,
                'is-sold-out': watchers.isProductOutOfStock(this.productId) && !watchers.isSelectedVariantMissing(this.productId),
                'is-unavailable': watchers.isSelectedVariantMissing(this.productId),
            }, onClick: e => this.handleCartClick(e) }, !!this.error && (index.h("sc-alert", { key: '99f8fdeb43f53ec697114bdd2ea2fe2149847b71', onClick: event => {
                event.stopPropagation();
            }, type: "danger", scrollOnOpen: true, open: !!this.error, closable: false }, !!error.getTopLevelError(this.error) && index.h("span", { key: '96532621b9db52b646b0a1491f9cd80f42f0ec60', slot: "title", innerHTML: error.getTopLevelError(this.error) }), (error.getAdditionalErrorMessages(this.error) || []).map((message, index$1) => (index.h("div", { innerHTML: message, key: index$1 }))))), index.h("slot", { key: '60ed01cfba9379cc0c6e63b1ecec78d88e3a2b5c' })));
    }
    get el() { return index.getElement(this); }
};
ScProductBuyButton.style = ScProductBuyButtonStyle0;

exports.sc_product_buy_button = ScProductBuyButton;

//# sourceMappingURL=sc-product-buy-button.cjs.entry.js.map