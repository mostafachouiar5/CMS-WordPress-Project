import { r as registerInstance, c as createEvent, h, F as Fragment, a as getElement } from './index-745b6bec.js';
import { g as getLineItemByPriceId } from './index-0202319f.js';
import { s as state } from './mutations-d5e8faea.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scPriceChoicesCss = "sc-price-choices{display:block;position:relative}sc-block-ui{z-index:9}";
const ScPriceChoicesStyle0 = scPriceChoicesCss;

const ScPriceChoices = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scRemoveLineItem = createEvent(this, "scRemoveLineItem", 7);
        this.scUpdateLineItem = createEvent(this, "scUpdateLineItem", 7);
        this.label = undefined;
        this.columns = 1;
        this.required = true;
    }
    handleChange() {
        this.el.querySelectorAll('sc-price-choice').forEach(priceChoice => {
            var _a;
            const choice = priceChoice.querySelector('sc-choice') || priceChoice.querySelector('sc-choice-container');
            if (!(choice === null || choice === void 0 ? void 0 : choice.checked)) {
                this.scRemoveLineItem.emit({ price_id: priceChoice.priceId, quantity: priceChoice.quantity });
            }
            else {
                const lineItem = getLineItemByPriceId((_a = state.checkout) === null || _a === void 0 ? void 0 : _a.line_items, choice.value);
                this.scUpdateLineItem.emit({ price_id: priceChoice.priceId, quantity: (lineItem === null || lineItem === void 0 ? void 0 : lineItem.quantity) || (priceChoice === null || priceChoice === void 0 ? void 0 : priceChoice.quantity) || 1 });
            }
        });
    }
    render() {
        return (h(Fragment, { key: 'e70d6ebfce58c91e8150b536e395b21da02229e9' }, h("sc-choices", { key: '0341d15d7b9f01bd49570f777bd411de318fa752', label: this.label, required: this.required, class: "loaded price-selector", style: { '--columns': this.columns.toString() } }, h("slot", { key: '9b74bb26fd5629592d460b36a847074eec60df5c' }))));
    }
    get el() { return getElement(this); }
};
ScPriceChoices.style = ScPriceChoicesStyle0;

export { ScPriceChoices as sc_price_choices };

//# sourceMappingURL=sc-price-choices.entry.js.map