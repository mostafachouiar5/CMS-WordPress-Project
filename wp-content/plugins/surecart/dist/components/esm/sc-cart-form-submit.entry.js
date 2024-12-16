import { r as registerInstance, h } from './index-745b6bec.js';
import { f as formBusy } from './getters-929aa1df.js';
import './store-7020541e.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';

const scCartFormSubmitCss = "sc-order-submit{display:block;width:auto}";
const ScCartFormSubmitStyle0 = scCartFormSubmitCss;

const ScCartFormSubmit = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.type = 'primary';
        this.size = 'medium';
        this.full = true;
        this.icon = undefined;
    }
    render() {
        return (h("sc-button", { key: '0271855c9ef605213b047fa5efd8ba751c680004', submit: true, type: this.type, size: this.size, full: this.full, loading: formBusy(), disabled: formBusy() }, !!this.icon && h("sc-icon", { key: 'e59ce21998399b6a77636b0a32e53f92f67eaf0f', name: this.icon, slot: "prefix" }), h("slot", { key: '1575bba984f73e6e4ab160599871b073caf4d0e6' })));
    }
};
ScCartFormSubmit.style = ScCartFormSubmitStyle0;

export { ScCartFormSubmit as sc_cart_form_submit };

//# sourceMappingURL=sc-cart-form-submit.entry.js.map