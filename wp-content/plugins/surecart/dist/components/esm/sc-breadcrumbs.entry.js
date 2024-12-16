import { r as registerInstance, h, F as Fragment, a as getElement } from './index-745b6bec.js';

const scBreadcrumbsCss = ":host{display:block}.breadcrumb{display:flex;align-items:center;flex-wrap:wrap}";
const ScBreadcrumbsStyle0 = scBreadcrumbsCss;

const ScBreadcrumbs = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.label = 'Breadcrumb';
    }
    // Generates a clone of the separator element to use for each breadcrumb item
    getSeparator() {
        const slotted = this.el.shadowRoot.querySelector('slot[name=separator]');
        const separator = slotted.assignedElements({ flatten: true })[0];
        // Clone it, remove ids, and slot it
        const clone = separator.cloneNode(true);
        [clone, ...clone.querySelectorAll('[id]')].forEach(el => el.removeAttribute('id'));
        clone.slot = 'separator';
        return clone;
    }
    handleSlotChange() {
        const slotted = this.el.shadowRoot.querySelector('.breadcrumb slot');
        const items = slotted.assignedElements().filter(node => {
            return node.nodeName === 'CE-BREADCRUMB';
        });
        items.forEach((item, index) => {
            // Append separators to each item if they don't already have one
            const separator = item.querySelector('[slot="separator"]');
            if (separator === null) {
                item.append(this.getSeparator());
            }
            // The last breadcrumb item is the "current page"
            if (index === items.length - 1) {
                item.setAttribute('aria-current', 'page');
            }
            else {
                item.removeAttribute('aria-current');
            }
        });
    }
    render() {
        return (h(Fragment, { key: 'f33708c21b9951084724cd207b13a3ef14f70420' }, h("nav", { key: 'ef776f07eec4d5a2e754a7895c6e43308d02b7b7', part: "base", class: "breadcrumb", "aria-label": this.label }, h("slot", { key: '8c4efc22225ef46e2c423bae78d9396067ef08bb', onSlotchange: () => this.handleSlotChange() })), h("div", { key: '109e7ec38dc3d0a598f473d5422ab4dfb5d134b2', part: "separator", hidden: true, "aria-hidden": "true" }, h("slot", { key: 'a663890c8aa67f710a9818c3d12c0db54348f7ff', name: "separator" }, h("sc-icon", { key: 'dbb8393d11f1a9f3fe5585e7caf3380e9fb5f2aa', name: "chevron-right" })))));
    }
    get el() { return getElement(this); }
};
ScBreadcrumbs.style = ScBreadcrumbsStyle0;

export { ScBreadcrumbs as sc_breadcrumbs };

//# sourceMappingURL=sc-breadcrumbs.entry.js.map