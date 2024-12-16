'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const price = require('./price-653ec1cb.js');
require('./currency-71fce0f0.js');

const scRecurringPriceChoiceContainerCss = ".recurring-price-choice{display:flex;justify-content:space-between;gap:var(--sc-spacing-x-small);flex-wrap:wrap}.recurring-price-choice__name{font-weight:var(--sc-font-weight-semibold);cursor:pointer}.recurring-price-choice__control{flex:1;display:flex;flex-direction:column;gap:var(--sc-spacing-x-small);align-self:center}.recurring-price-choice__details{align-self:center;display:flex;align-items:flex-end;flex-direction:column;gap:var(--sc-spacing-xx-small)}.recurring-price-choice__button{font-size:var(--sc-font-size-small);appearance:none;display:flex;align-items:center;gap:var(--sc-spacing-xx-small);text-decoration:none;user-select:none;white-space:var(--sc-recurring-price-choice-white-space, nowrap);text-align:var(--sc-recurring-price-choice-text-align, center);vertical-align:middle;padding:13px;margin:-13px;border:none;background:transparent;font-size:inherit;color:inherit;border-radius:var(--sc-input-border-radius-medium);opacity:0.8;cursor:pointer}.recurring-price-choice__button:focus-visible{outline:1px solid var(--sc-color-primary-500);outline-offset:4px}.recurring-price-choice__trial,.recurring-price-choice__setup-fee,.recurring-price-choice__price{font-size:var(--sc-font-size-small);opacity:0.8}sc-dropdown{width:100%}sc-choice-container:not([checked]) sc-dropdown{pointer-events:none}";
const ScRecurringPriceChoiceContainerStyle0 = scRecurringPriceChoiceContainerCss;

const ScRecurringPriceChoiceContainer = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scChange = index.createEvent(this, "scChange", 7);
        this.prices = undefined;
        this.selectedPrice = undefined;
        this.selectedOption = undefined;
        this.product = undefined;
        this.label = undefined;
        this.showControl = false;
        this.showAmount = true;
        this.showDetails = true;
    }
    renderPrice(price) {
        return index.h("sc-format-number", { type: "currency", value: price === null || price === void 0 ? void 0 : price.amount, currency: price === null || price === void 0 ? void 0 : price.currency });
    }
    value() {
        return this.prices.find(price => { var _a; return price.id === ((_a = this.selectedPriceState()) === null || _a === void 0 ? void 0 : _a.id); }) || this.prices[0];
    }
    selectedPriceState() {
        return this.prices.find(price => { var _a; return price.id === ((_a = this.selectedPrice) === null || _a === void 0 ? void 0 : _a.id); }) || this.selectedOption || this.prices[0];
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p;
        if (!((_a = this.prices) === null || _a === void 0 ? void 0 : _a.length)) {
            return index.h(index.Host, { style: { display: 'none' } });
        }
        return (index.h("sc-choice-container", { value: (_b = this.selectedPrice) === null || _b === void 0 ? void 0 : _b.id, type: 'radio', showControl: this.showControl, checked: this.prices.some(price => { var _a; return price.id === ((_a = this.selectedPrice) === null || _a === void 0 ? void 0 : _a.id); }), onScChange: e => {
                var _a;
                e.stopPropagation();
                this.scChange.emit((_a = this.value()) === null || _a === void 0 ? void 0 : _a.id);
            }, role: "button" }, index.h("div", { class: "recurring-price-choice" }, index.h("div", { class: "recurring-price-choice__control" }, index.h("div", { class: "recurring-price-choice__name" }, index.h("slot", null, this.label)), ((_c = this.prices) === null || _c === void 0 ? void 0 : _c.length) > 1 && (index.h("div", { class: "recurring-price-choice__description" }, index.h("sc-dropdown", { style: { '--panel-width': 'max(100%, 11rem)', '--sc-menu-item-white-space': 'wrap' } }, index.h("button", { class: "recurring-price-choice__button", slot: "trigger", "aria-label": wp.i18n.__('Press Up/Down Arrow & select the recurring interval you want.', 'surecart') }, ((_d = this.value()) === null || _d === void 0 ? void 0 : _d.name) ||
            (((_e = this.value()) === null || _e === void 0 ? void 0 : _e.recurring_interval)
                ? price.intervalString(this.value(), {
                    showOnce: true,
                    abbreviate: false,
                    labels: {
                        interval: wp.i18n.__('Every', 'surecart'),
                        period: 
                        /** translators: used as in time period: "for 3 months" */
                        wp.i18n.__('for', 'surecart'),
                    },
                })
                : this.product.name), index.h("sc-icon", { style: { minWidth: 'var(--width)' }, name: "chevron-down" })), index.h("sc-menu", { "aria-label": wp.i18n.__('Recurring Interval selection Dropdown opened, Press Up/Down Arrow & select the recurring interval you want.', 'surecart') }, (this.prices || []).map(price$1 => {
            var _a;
            const checked = (price$1 === null || price$1 === void 0 ? void 0 : price$1.id) === ((_a = this.selectedPriceState()) === null || _a === void 0 ? void 0 : _a.id);
            const label = (price$1 === null || price$1 === void 0 ? void 0 : price$1.name) ||
                ((price$1 === null || price$1 === void 0 ? void 0 : price$1.recurring_interval)
                    ? price.intervalString(price$1, {
                        showOnce: true,
                        abbreviate: false,
                        labels: {
                            interval: wp.i18n.__('Every', 'surecart'),
                            period: 
                            /** translators: used as in time period: "for 3 months" */
                            wp.i18n.__('for', 'surecart'),
                        },
                    })
                    : this.product.name);
            return (index.h("sc-menu-item", { onClick: () => {
                    this.selectedOption = price$1;
                    this.scChange.emit(price$1 === null || price$1 === void 0 ? void 0 : price$1.id);
                }, checked: checked, "aria-label": label }, label, this.showAmount && index.h("span", { slot: "suffix" }, this.renderPrice(price$1))));
        })))))), this.showDetails && (index.h("div", { class: "recurring-price-choice__details" }, index.h("div", { class: "recurring-price-choice__price" }, ((_f = this.selectedPriceState()) === null || _f === void 0 ? void 0 : _f.ad_hoc) ? (wp.i18n.__('Custom Amount', 'surecart')) : (index.h(index.Fragment, null, index.h("sc-format-number", { type: "currency", value: (_g = this.selectedPriceState()) === null || _g === void 0 ? void 0 : _g.amount, currency: (_h = this.selectedPriceState()) === null || _h === void 0 ? void 0 : _h.currency }), price.intervalString(this.selectedPriceState(), {
            showOnce: true,
            abbreviate: true,
            labels: {
                interval: '/',
                period: 
                /** translators: used as in time period: "for 3 months" */
                wp.i18n.__('for', 'surecart'),
            },
        })))), !!((_j = this.selectedPriceState()) === null || _j === void 0 ? void 0 : _j.trial_duration_days) && (index.h("div", { class: "recurring-price-choice__trial" }, wp.i18n.sprintf(wp.i18n._n('Starting in %s day', 'Starting in %s days', this.selectedPriceState().trial_duration_days, 'surecart'), this.selectedPriceState().trial_duration_days))), !!((_k = this.selectedPriceState()) === null || _k === void 0 ? void 0 : _k.setup_fee_enabled) && ((_l = this.selectedPriceState()) === null || _l === void 0 ? void 0 : _l.setup_fee_amount) && (index.h("div", { class: "recurring-price-choice__setup-fee" }, index.h("sc-format-number", { type: "currency", value: Math.abs(this.selectedPriceState().setup_fee_amount), currency: (_m = this.selectedPriceState()) === null || _m === void 0 ? void 0 : _m.currency }), ' ', ((_o = this.selectedPriceState()) === null || _o === void 0 ? void 0 : _o.setup_fee_name) || (((_p = this.selectedPriceState()) === null || _p === void 0 ? void 0 : _p.setup_fee_amount) < 0 ? wp.i18n.__('Discount', 'surecart') : wp.i18n.__('Setup Fee', 'surecart')))))))));
    }
};
ScRecurringPriceChoiceContainer.style = ScRecurringPriceChoiceContainerStyle0;

exports.sc_recurring_price_choice_container = ScRecurringPriceChoiceContainer;

//# sourceMappingURL=sc-recurring-price-choice-container.cjs.entry.js.map