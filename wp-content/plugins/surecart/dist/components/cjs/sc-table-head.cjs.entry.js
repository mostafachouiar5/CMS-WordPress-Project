'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scTableHeadCss = ":host{display:table-header-group}::slotted(*){display:table-row}";
const ScTableHeadStyle0 = scTableHeadCss;

const ScTable = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
    }
    render() {
        return (index.h(index.Host, { key: '65f2fcdb62dc59a7825e979ed815c1622c56f8a4' }, index.h("slot", { key: '56350bd6b72e3837ebc8ad92174c8e63143b03d4' })));
    }
};
ScTable.style = ScTableHeadStyle0;

exports.sc_table_head = ScTable;

//# sourceMappingURL=sc-table-head.cjs.entry.js.map