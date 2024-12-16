'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scSpacingCss = ":host{display:block}::slotted(*:not(:last-child)){margin-bottom:var(--spacing)}";
const ScSpacingStyle0 = scSpacingCss;

const ScSpacing = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
    }
    render() {
        return (index.h(index.Host, { key: '5f3c4a8928871fd96d152719324e577f423583dc' }, index.h("slot", { key: '7bde8828c21dfd2711ebc5364b1c7dda7d1773a5' })));
    }
};
ScSpacing.style = ScSpacingStyle0;

exports.sc_spacing = ScSpacing;

//# sourceMappingURL=sc-spacing.cjs.entry.js.map