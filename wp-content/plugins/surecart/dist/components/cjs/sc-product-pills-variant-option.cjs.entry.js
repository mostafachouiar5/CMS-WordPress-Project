'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const watchers = require('./watchers-cb566474.js');
require('./index-bcdafe6e.js');
require('./google-03835677.js');
require('./currency-71fce0f0.js');
require('./google-59d23803.js');
require('./utils-ee1bb9d3.js');
require('./util-b877b2bd.js');
require('./index-fb76df07.js');

const scProductPillsVariantOptionCss = ".sc-product-pills-variant-option__wrapper{display:flex;flex-wrap:wrap;gap:var(--sc-spacing-x-small)}";
const ScProductPillsVariantOptionStyle0 = scProductPillsVariantOptionCss;

const ScProductPillsVariantOption = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.label = undefined;
        this.optionNumber = 1;
        this.productId = undefined;
    }
    render() {
        return (index.h("sc-form-control", { key: 'ec5d8b2b4fe1ee30f2c38393afd7680b147cb57e', label: this.label }, index.h("span", { key: '303f09a9939463121839e048555dc629af8fb458', slot: "label" }, this.label), index.h("div", { key: 'a8bbebf0649d154ecf91d58ec22341830cd54d03', class: "sc-product-pills-variant-option__wrapper" }, (watchers.state[this.productId].variant_options[this.optionNumber - 1].values || []).map(value => {
            const isUnavailable = watchers.isOptionSoldOut(this.productId, this.optionNumber, value) || watchers.isOptionMissing(this.productId, this.optionNumber, value);
            return (index.h("sc-pill-option", { isUnavailable: isUnavailable, isSelected: watchers.state[this.productId].variantValues[`option_${this.optionNumber}`] === value, onClick: () => watchers.setProduct(this.productId, {
                    variantValues: {
                        ...watchers.state[this.productId].variantValues,
                        [`option_${this.optionNumber}`]: value,
                    },
                }) }, index.h("span", { "aria-hidden": "true" }, value), index.h("sc-visually-hidden", null, wp.i18n.sprintf(wp.i18n.__('Select %s: %s.', 'surecart'), this.label, value), isUnavailable && index.h(index.Fragment, null, " ", wp.i18n.__('(option unavailable)', 'surecart')), watchers.state[this.productId].variantValues[`option_${this.optionNumber}`] === value && index.h(index.Fragment, null, " ", wp.i18n.__('This option is currently selected.', 'surecart')))));
        }))));
    }
};
ScProductPillsVariantOption.style = ScProductPillsVariantOptionStyle0;

exports.sc_product_pills_variant_option = ScProductPillsVariantOption;

//# sourceMappingURL=sc-product-pills-variant-option.cjs.entry.js.map