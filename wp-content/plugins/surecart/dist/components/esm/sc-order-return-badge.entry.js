import { r as registerInstance, h } from './index-745b6bec.js';

const scOrderReturnBadgeCss = ":host{display:inline-block}";
const ScOrderReturnBadgeStyle0 = scOrderReturnBadgeCss;

const status = {
    open: wp.i18n.__('Return in progress', 'surecart'),
    completed: wp.i18n.__('Returned', 'surecart'),
};
const type = {
    open: 'warning',
    completed: 'success',
};
const ScOrderReturnBadge = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.status = undefined;
        this.size = 'medium';
        this.pill = false;
        this.clearable = false;
    }
    render() {
        return (h("sc-tag", { key: 'bae24922b7ee77d821455a17d4b66e4afc596bc2', type: type === null || type === void 0 ? void 0 : type[this === null || this === void 0 ? void 0 : this.status], pill: this.pill }, (status === null || status === void 0 ? void 0 : status[this.status]) || this.status));
    }
};
ScOrderReturnBadge.style = ScOrderReturnBadgeStyle0;

export { ScOrderReturnBadge as sc_order_return_badge };

//# sourceMappingURL=sc-order-return-badge.entry.js.map