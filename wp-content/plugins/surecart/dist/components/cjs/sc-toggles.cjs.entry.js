'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scTogglesCss = ":host{display:block;--toggle-spacing:0}::slotted(*){margin-bottom:var(--toggle-spacing)}::slotted(:not(:first-child):not([style*=\"display: none\"])){border-top:1px solid var(--sc-input-border-color)}";
const ScTogglesStyle0 = scTogglesCss;

const ScToggles = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.accordion = false;
        this.collapsible = true;
        this.theme = 'default';
    }
    getToggles() {
        var _a, _b, _c;
        let slotted = this.el.shadowRoot.querySelector('slot');
        if (!slotted)
            return;
        return ((_c = (_b = (_a = slotted === null || slotted === void 0 ? void 0 : slotted.assignedNodes) === null || _a === void 0 ? void 0 : _a.call(slotted)) === null || _b === void 0 ? void 0 : _b.filter) === null || _c === void 0 ? void 0 : _c.call(_b, node => node.nodeName === 'SC-TOGGLE')) || [];
    }
    handleShowChange(e) {
        if (e.target.tagName !== 'SC-TOGGLE')
            return;
        if (this.accordion) {
            this.getToggles().map(details => (details.open = e.target === details));
        }
    }
    handleCollapibleChange() {
        this.getToggles().map(details => (details.collapsible = this.collapsible));
    }
    componentDidLoad() {
        this.handleCollapibleChange();
        const toggles = this.getToggles();
        if ((toggles === null || toggles === void 0 ? void 0 : toggles.length) && !toggles.some(toggle => toggle.open)) {
            toggles[0].open = true;
        }
    }
    render() {
        const Tag = 'container' === this.theme ? 'sc-card' : 'div';
        return (index.h(Tag, { key: '7ff17f26a733b8eea6fca978e25575acfbd90857', class: { toggles: true, [`toggles--theme-${this.theme}`]: true }, part: "base", "no-padding": true }, index.h("slot", { key: 'f6fbb2f94c79320f59f38a196810f62ec1261025' })));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "collapsible": ["handleCollapibleChange"]
    }; }
};
ScToggles.style = ScTogglesStyle0;

exports.sc_toggles = ScToggles;

//# sourceMappingURL=sc-toggles.cjs.entry.js.map