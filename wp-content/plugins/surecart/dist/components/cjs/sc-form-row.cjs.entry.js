'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scFormRowCss = ".form-row{display:flex;align-items:flex-start;justify-content:space-between;gap:calc(var(--sc-form-row-spacing, 0.75em) * 2.5)}::slotted(*){flex:1;width:0}";
const ScFormRowStyle0 = scFormRowCss;

const ScFormRow = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.width = undefined;
    }
    componentDidLoad() {
        if ('ResizeObserver' in window) {
            this.observer = new window.ResizeObserver(entries => {
                this.width = entries === null || entries === void 0 ? void 0 : entries[0].contentRect.width;
            });
            this.observer.observe(this.el);
        }
    }
    render() {
        return (index.h("div", { key: 'acde5fa60dd3083d7be57070037eb1b2265fa559', part: "base", class: {
                'form-row': true,
                'breakpoint-sm': this.width < 384,
                'breakpoint-md': this.width >= 384 && this.width < 576,
                'breakpoint-lg': this.width >= 576 && this.width < 768,
                'breakpoint-xl': this.width >= 768,
            } }, index.h("slot", { key: '4ffb49a0555e9401eeb3d72b0776a8f96e5ea531' })));
    }
    get el() { return index.getElement(this); }
};
ScFormRow.style = ScFormRowStyle0;

exports.sc_form_row = ScFormRow;

//# sourceMappingURL=sc-form-row.cjs.entry.js.map