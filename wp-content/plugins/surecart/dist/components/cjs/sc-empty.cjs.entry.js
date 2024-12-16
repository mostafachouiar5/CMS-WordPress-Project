'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scEmptyCss = ":host{display:block}.empty{display:flex;flex-direction:column;align-items:center;padding:var(--sc-spacing-large);text-align:center;gap:var(--sc-spacing-small);color:var(--sc-empty-color, var(--sc-color-gray-500))}.empty sc-icon{font-size:var(--sc-font-size-xx-large);color:var(--sc-empty-icon-color, var(--sc-color-gray-700))}";
const ScEmptyStyle0 = scEmptyCss;

const ScEmpty = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.icon = undefined;
    }
    render() {
        return (index.h("div", { key: '1de7d37f9b92fdddaa89052b103feaa81f3008ee', part: "base", class: "empty" }, !!this.icon && index.h("sc-icon", { key: '1325c620fee40fc5134bf3d9d97cd0360d8158fc', exportparts: "base:icon", name: this.icon }), index.h("slot", { key: '505ffdebf9389abf10e3becd91c61b172af2755a' })));
    }
};
ScEmpty.style = ScEmptyStyle0;

exports.sc_empty = ScEmpty;

//# sourceMappingURL=sc-empty.cjs.entry.js.map