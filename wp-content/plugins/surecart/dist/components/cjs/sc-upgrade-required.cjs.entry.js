'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scUpgradeRequiredCss = ":host{display:inline-block;color:var(--sc-color-gray-900);cursor:pointer}p,::slotted(p){font-size:var(--sc-font-size-medium) !important;font-weight:var(--sc-font-weight-normal);margin:0 0 var(--sc-spacing-medium) 0 !important;line-height:var(--sc-line-height-dense);white-space:normal}.trigger{pointer-events:auto}.trigger__disabled{pointer-events:none}.dialog__title{display:flex;gap:0.5em;align-items:center}.dialog__title sc-icon{font-size:18px;width:22px;stroke-width:4;color:var(--sc-color-primary-500)}";
const ScUpgradeRequiredStyle0 = scUpgradeRequiredCss;

const ScUpgradeRequired = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.size = 'small';
        this.required = true;
        this.open = false;
    }
    render() {
        var _a;
        if (!this.required) {
            return (index.h(index.Host, null, index.h("slot", null)));
        }
        return (index.h(index.Host, { onClick: () => (this.open = true) }, index.h("span", { class: "trigger" }, index.h("span", { class: "trigger__disabled" }, index.h("slot", null, index.h("sc-premium-badge", null)))), index.h("sc-dialog", { label: wp.i18n.__('Boost Your Revenue', 'surecart'), open: this.open, onScRequestClose: () => {
                this.open = false;
                return true;
            }, style: { '--width': '21rem', 'fontSize': '15px', '--body-spacing': '2rem' } }, index.h("span", { class: "dialog__title", slot: "label" }, index.h("sc-icon", { name: "zap" }), index.h("span", null, wp.i18n.__('Boost Your Revenue', 'surecart'))), index.h("slot", { name: "content" }, index.h("p", null, wp.i18n.__('Unlock revenue boosting features when you upgrade your plan!', 'surecart'))), index.h("sc-button", { href: `https://app.surecart.com/plans?switch_account_id=${(_a = window === null || window === void 0 ? void 0 : window.scData) === null || _a === void 0 ? void 0 : _a.account_id}`, type: "primary", target: "_blank", full: true }, wp.i18n.__('Upgrade Now', 'surecart'), index.h("sc-icon", { name: "arrow-right", slot: "suffix" })))));
    }
};
ScUpgradeRequired.style = ScUpgradeRequiredStyle0;

exports.sc_upgrade_required = ScUpgradeRequired;

//# sourceMappingURL=sc-upgrade-required.cjs.entry.js.map