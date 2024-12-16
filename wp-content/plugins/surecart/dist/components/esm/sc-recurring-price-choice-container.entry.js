import { r as registerInstance, c as createEvent, h, F as Fragment, H as Host } from './index-745b6bec.js';
import { i as intervalString } from './price-d5770168.js';
import './currency-a0c9bff4.js';

const scRecurringPriceChoiceContainerCss = ".recurring-price-choice{display:flex;justify-content:space-between;gap:var(--sc-spacing-x-small);flex-wrap:wrap}.recurring-price-choice__name{font-weight:var(--sc-font-weight-semibold);cursor:pointer}.recurring-price-choice__control{flex:1;display:flex;flex-direction:column;gap:var(--sc-spacing-x-small);align-self:center}.recurring-price-choice__details{align-self:center;display:flex;align-items:flex-end;flex-direction:column;gap:var(--sc-spacing-xx-small)}.recurring-price-choice__button{font-size:var(--sc-font-size-small);appearance:none;display:flex;align-items:center;gap:var(--sc-spacing-xx-small);text-decoration:none;user-select:none;white-space:var(--sc-recurring-price-choice-white-space, nowrap);text-align:var(--sc-recurring-price-choice-text-align, center);vertical-align:middle;padding:13px;margin:-13px;border:none;background:transparent;font-size:inherit;color:inherit;border-radius:var(--sc-input-border-radius-medium);opacity:0.8;cursor:pointer}.recurring-price-choice__button:focus-visible{outline:1px solid var(--sc-color-primary-500);outline-offset:4px}.recurring-price-choice__trial,.recurring-price-choice__setup-fee,.recurring-price-choice__price{font-size:var(--sc-font-size-small);opacity:0.8}sc-dropdown{width:100%}sc-choice-container:not([checked]) sc-dropdown{pointer-events:none}";
const ScRecurringPriceChoiceContainerStyle0 = scRecurringPriceChoiceContainerCss;

const ScRecurringPriceChoiceContainer = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scChange = createEvent(this, "scChange", 7);
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
        return h("sc-format-number", { type: "currency", value: price === null || price === void 0 ? void 0 : price.amount, currency: price === null || price === void 0 ? void 0 : price.currency });
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
            return h(Host, { style: { display: 'none' } });
        }
        return (h("sc-choice-container", { value: (_b = this.selectedPrice) === null || _b === void 0 ? void 0 : _b.id, type: 'radio', showControl: this.showControl, checked: this.prices.some(price => { var _a; return price.id === ((_a = this.selectedPrice) === null || _a === void 0 ? void 0 : _a.id); }), onScChange: e => {
                var _a;
                e.stopPropagation();
                this.scChange.emit((_a = this.value()) === null || _a === void 0 ? void 0 : _a.id);
            }, role: "button" }, h("div", { class: "recurring-price-choice" }, h("div", { class: "recurring-price-choice__control" }, h("div", { class: "recurring-price-choice__name" }, h("slot", null, this.label)), ((_c = this.prices) === null || _c === void 0 ? void 0 : _c.length) > 1 && (h("div", { class: "recurring-price-choice__description" }, h("sc-dropdown", { style: { '--panel-width': 'max(100%, 11rem)', '--sc-menu-item-white-space': 'wrap' } }, h("button", { class: "recurring-price-choice__button", slot: "trigger", "aria-label": wp.i18n.__('Press Up/Down Arrow & select the recurring interval you want.', 'surecart') }, ((_d = this.value()) === null || _d === void 0 ? void 0 : _d.name) ||
            (((_e = this.value()) === null || _e === void 0 ? void 0 : _e.recurring_interval)
                ? intervalString(this.value(), {
                    showOnce: true,
                    abbreviate: false,
                    labels: {
                        interval: wp.i18n.__('Every', 'surecart'),
                        period: 
                        /** translators: used as in time period: "for 3 months" */
                        wp.i18n.__('for', 'surecart'),
                    },
                })
                : this.product.name), h("sc-icon", { style: { minWidth: 'var(--width)' }, name: "chevron-down" })), h("sc-menu", { "aria-label": wp.i18n.__('Recurring Interval selection Dropdown opened, Press Up/Down Arrow & select the recurring interval you want.', 'surecart') }, (this.prices || []).map(price => {
            var _a;
            const checked = (price === null || price === void 0 ? void 0 : price.id) === ((_a = this.selectedPriceState()) === null || _a === void 0 ? void 0 : _a.id);
            const label = (price === null || price === void 0 ? void 0 : price.name) ||
                ((price === null || price === void 0 ? void 0 : price.recurring_interval)
                    ? intervalString(price, {
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
            return (h("sc-menu-item", { onClick: () => {
                    this.selectedOption = price;
                    this.scChange.emit(price === null || price === void 0 ? void 0 : price.id);
                }, checked: checked, "aria-label": label }, label, this.showAmount && h("span", { slot: "suffix" }, this.renderPrice(price))));
        })))))), this.showDetails && (h("div", { class: "recurring-price-choice__details" }, h("div", { class: "recurring-price-choice__price" }, ((_f = this.selectedPriceState()) === null || _f === void 0 ? void 0 : _f.ad_hoc) ? (wp.i18n.__('Custom Amount', 'surecart')) : (h(Fragment, null, h("sc-format-number", { type: "currency", value: (_g = this.selectedPriceState()) === null || _g === void 0 ? void 0 : _g.amount, currency: (_h = this.selectedPriceState()) === null || _h === void 0 ? void 0 : _h.currency }), intervalString(this.selectedPriceState(), {
            showOnce: true,
            abbreviate: true,
            labels: {
                interval: '/',
                period: 
                /** translators: used as in time period: "for 3 months" */
                wp.i18n.__('for', 'surecart'),
            },
        })))), !!((_j = this.selectedPriceState()) === null || _j === void 0 ? void 0 : _j.trial_duration_days) && (h("div", { class: "recurring-price-choice__trial" }, wp.i18n.sprintf(wp.i18n._n('Starting in %s day', 'Starting in %s days', this.selectedPriceState().trial_duration_days, 'surecart'), this.selectedPriceState().trial_duration_days))), !!((_k = this.selectedPriceState()) === null || _k === void 0 ? void 0 : _k.setup_fee_enabled) && ((_l = this.selectedPriceState()) === null || _l === void 0 ? void 0 : _l.setup_fee_amount) && (h("div", { class: "recurring-price-choice__setup-fee" }, h("sc-format-number", { type: "currency", value: Math.abs(this.selectedPriceState().setup_fee_amount), currency: (_m = this.selectedPriceState()) === null || _m === void 0 ? void 0 : _m.currency }), ' ', ((_o = this.selectedPriceState()) === null || _o === void 0 ? void 0 : _o.setup_fee_name) || (((_p = this.selectedPriceState()) === null || _p === void 0 ? void 0 : _p.setup_fee_amount) < 0 ? wp.i18n.__('Discount', 'surecart') : wp.i18n.__('Setup Fee', 'surecart')))))))));
    }
};
ScRecurringPriceChoiceContainer.style = ScRecurringPriceChoiceContainerStyle0;

export { ScRecurringPriceChoiceContainer as sc_recurring_price_choice_container };

//# sourceMappingURL=sc-recurring-price-choice-container.entry.js.map