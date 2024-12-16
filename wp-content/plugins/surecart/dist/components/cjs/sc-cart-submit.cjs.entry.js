'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const getters = require('./getters-690e042a.js');
require('./store-1fb3d249.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');

const scCartSubmitCss = "sc-cart-submit{position:relative;width:100%}sc-cart-submit a.wp-block-button__link{position:relative;text-decoration:none;width:100%;display:block;box-sizing:border-box;text-align:center}sc-cart-submit sc-spinner::part(base){--indicator-color:currentColor;--spinner-size:12px;position:absolute;top:calc(50% - var(--spinner-size) + var(--spinner-size) / 4);left:calc(50% - var(--spinner-size) + var(--spinner-size) / 4)}sc-cart-submit [data-text],sc-cart-submit [data-loader]{transition:opacity var(--sc-transition-fast) ease-in-out, visibility var(--sc-transition-fast) ease-in-out}sc-cart-submit [data-loader]{opacity:0;visibility:hidden}sc-cart-submit.is-disabled{pointer-events:none}sc-cart-submit.is-busy [data-text]{opacity:0;visibility:hidden}sc-cart-submit.is-busy [data-loader]{opacity:1;visibility:visible}";
const ScCartSubmitStyle0 = scCartSubmitCss;

const ScCartSubmit = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.busy = undefined;
    }
    render() {
        return (index.h(index.Host, { key: 'affd83b8029488b9c6e0b7bef95ed68342e41644', class: { 'is-busy': getters.formBusy() || this.busy, 'is-disabled': getters.formBusy() || this.busy }, onClick: () => {
                this.busy = true;
                return true;
            } }, index.h("slot", { key: 'fa74d83d564f24ba76bb3efbbe940e09df8d16d3' })));
    }
};
ScCartSubmit.style = ScCartSubmitStyle0;

exports.sc_cart_submit = ScCartSubmit;

//# sourceMappingURL=sc-cart-submit.cjs.entry.js.map