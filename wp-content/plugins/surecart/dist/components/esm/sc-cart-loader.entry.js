import { r as registerInstance, h } from './index-745b6bec.js';
import { s as state } from './mutations-d5e8faea.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scCartLoaderCss = ":host{position:absolute;z-index:var(--sc-cart-z-index, 999999);font-family:var(--sc-font-sans)}";
const ScCartLoaderStyle0 = scCartLoaderCss;

const ScCartLoader = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.template = undefined;
    }
    render() {
        var _a;
        // check for forms.
        if (document.querySelector('sc-checkout')) {
            return;
        }
        // clear the order if it's already paid.
        if (((_a = state === null || state === void 0 ? void 0 : state.checkout) === null || _a === void 0 ? void 0 : _a.status) === 'paid') {
            state.checkout = null;
            return null;
        }
        // return the loader.
        return h("div", { innerHTML: this.template || '' });
    }
};
ScCartLoader.style = ScCartLoaderStyle0;

export { ScCartLoader as sc_cart_loader };

//# sourceMappingURL=sc-cart-loader.entry.js.map