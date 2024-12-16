'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const index$1 = require('./index-21f8920e.js');
const mutations = require('./mutations-19357660.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');
require('./remove-query-args-b57e8cd3.js');
require('./add-query-args-49dcb630.js');
require('./index-fb76df07.js');
require('./google-59d23803.js');
require('./currency-71fce0f0.js');
require('./store-1fb3d249.js');
require('./price-653ec1cb.js');

const scPriceChoicesCss = "sc-price-choices{display:block;position:relative}sc-block-ui{z-index:9}";
const ScPriceChoicesStyle0 = scPriceChoicesCss;

const ScPriceChoices = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scRemoveLineItem = index.createEvent(this, "scRemoveLineItem", 7);
        this.scUpdateLineItem = index.createEvent(this, "scUpdateLineItem", 7);
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
                const lineItem = index$1.getLineItemByPriceId((_a = mutations.state.checkout) === null || _a === void 0 ? void 0 : _a.line_items, choice.value);
                this.scUpdateLineItem.emit({ price_id: priceChoice.priceId, quantity: (lineItem === null || lineItem === void 0 ? void 0 : lineItem.quantity) || (priceChoice === null || priceChoice === void 0 ? void 0 : priceChoice.quantity) || 1 });
            }
        });
    }
    render() {
        return (index.h(index.Fragment, { key: 'e70d6ebfce58c91e8150b536e395b21da02229e9' }, index.h("sc-choices", { key: '0341d15d7b9f01bd49570f777bd411de318fa752', label: this.label, required: this.required, class: "loaded price-selector", style: { '--columns': this.columns.toString() } }, index.h("slot", { key: '9b74bb26fd5629592d460b36a847074eec60df5c' }))));
    }
    get el() { return index.getElement(this); }
};
ScPriceChoices.style = ScPriceChoicesStyle0;

exports.sc_price_choices = ScPriceChoices;

//# sourceMappingURL=sc-price-choices.cjs.entry.js.map