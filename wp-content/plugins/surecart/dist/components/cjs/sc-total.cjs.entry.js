'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const consumer = require('./consumer-9f4ee0e3.js');

const scTotalCss = ":host{display:block}.total-amount{display:inline-block}";
const ScTotalStyle0 = scTotalCss;

const ScTotal = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.order_key = {
            total: 'total_amount',
            subtotal: 'subtotal_amount',
            amount_due: 'amount_due',
        };
        this.total = 'amount_due';
        this.order = undefined;
    }
    render() {
        var _a, _b, _c, _d, _e;
        if (!((_a = this.order) === null || _a === void 0 ? void 0 : _a.currency))
            return;
        if (!((_d = (_c = (_b = this.order) === null || _b === void 0 ? void 0 : _b.line_items) === null || _c === void 0 ? void 0 : _c.data) === null || _d === void 0 ? void 0 : _d.length))
            return;
        return index.h("sc-format-number", { type: "currency", currency: this.order.currency, value: (_e = this.order) === null || _e === void 0 ? void 0 : _e[this.order_key[this.total]] });
    }
};
consumer.openWormhole(ScTotal, ['order'], false);
ScTotal.style = ScTotalStyle0;

exports.sc_total = ScTotal;

//# sourceMappingURL=sc-total.cjs.entry.js.map