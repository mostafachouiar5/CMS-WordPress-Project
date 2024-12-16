'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scProvisionalBannerCss = ".sc-banner{background-color:var(--sc-color-brand-primary);color:white;display:flex;align-items:center;justify-content:center}.sc-banner>p{font-size:14px;line-height:1;margin:var(--sc-spacing-small)}.sc-banner>p a{color:inherit;font-weight:600;margin-left:10px;display:inline-flex;align-items:center;gap:8px;text-decoration:none;border-bottom:1px solid;padding-bottom:2px}";
const ScProvisionalBannerStyle0 = scProvisionalBannerCss;

const ScProvisionalBanner = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.claimUrl = '';
    }
    render() {
        return (index.h("div", { key: 'a8dfc6e10ce931434f2094313ed744ea895bce66', class: { 'sc-banner': true } }, index.h("p", { key: 'a73fe6c543dada145568886bf06f5caefa9f8752' }, wp.i18n.__('Complete your store setup to go live.', 'surecart'), index.h("a", { key: '47459d392df1e28b787c1b15af6382e4dc15afa4', href: this.claimUrl }, wp.i18n.__('Complete Setup', 'surecart'), " ", index.h("sc-icon", { key: 'd128652fdbbe8dc83313a670767fabadad46a586', name: "arrow-right" })))));
    }
};
ScProvisionalBanner.style = ScProvisionalBannerStyle0;

exports.sc_provisional_banner = ScProvisionalBanner;

//# sourceMappingURL=sc-provisional-banner.cjs.entry.js.map