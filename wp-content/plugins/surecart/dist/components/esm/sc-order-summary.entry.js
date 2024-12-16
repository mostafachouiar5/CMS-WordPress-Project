import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';
import { s as speak } from './index-c5a96d53.js';
import { s as state } from './mutations-d5e8faea.js';
import { f as formBusy, a as formLoading } from './getters-929aa1df.js';
import { s as setDefaultAnimation, b as stopAnimations, g as getAnimation, a as animateTo, c as shimKeyframesHeightAuto } from './animation-registry-12eed2e3.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';

const scOrderSummaryCss = ":host{display:block;font-family:var(--sc-font-sans);font-size:var(--sc-checkout-font-size, 16px)}.collapse-link{display:flex;align-items:center;gap:0.35em}.summary__content--empty{display:none}.collapse-link__icon{width:18px;height:18px;color:var(--sc-order-collapse-link-icon-color, var(--sc-color-gray-500))}.item__product+.item__product{margin-top:20px}.empty{color:var(--sc-order-summary-color, var(--sc-color-gray-500))}.price{display:inline-block;opacity:0;visibility:hidden;transform:translateY(5px);transition:var(--sc-input-transition, var(--sc-transition-medium)) visibility ease, var(--sc-input-transition, var(--sc-transition-medium)) opacity ease, var(--sc-input-transition, var(--sc-transition-medium)) transform ease}.price--collapsed{opacity:1;visibility:visible;transform:translateY(0)}.summary{position:relative;user-select:none;cursor:pointer}.summary .collapse-link__icon{transition:transform 0.25s ease-in-out}.summary .scratch-price{text-decoration:line-through;color:var(--sc-color-gray-500);font-size:var(--sc-font-size-small);margin-right:var(--sc-spacing-xx-small)}.summary--open .collapse-link__icon{transform:rotate(180deg)}::slotted(*){margin:4px 0 !important}::slotted(sc-divider){margin:16px 0 !important}sc-line-item~sc-line-item{margin-top:14px}.total-price{white-space:nowrap}";
const ScOrderSummaryStyle0 = scOrderSummaryCss;

const ScOrderSummary = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scShow = createEvent(this, "scShow", 7);
        this.scHide = createEvent(this, "scHide", 7);
        this.order = undefined;
        this.busy = undefined;
        this.orderSummaryText = wp.i18n.__('Summary', 'surecart');
        this.invoiceSummaryText = wp.i18n.__('Invoice Summary', 'surecart');
        this.collapsible = false;
        this.collapsedOnMobile = false;
        this.collapsedOnDesktop = undefined;
        this.collapsed = false;
    }
    isMobileScreen() {
        var _a, _b;
        const bodyRect = (_a = document.body) === null || _a === void 0 ? void 0 : _a.getClientRects();
        return (bodyRect === null || bodyRect === void 0 ? void 0 : bodyRect.length) && ((_b = bodyRect[0]) === null || _b === void 0 ? void 0 : _b.width) < 781;
    }
    componentWillLoad() {
        if (this.isMobileScreen()) {
            this.collapsed = this.collapsed || this.collapsedOnMobile;
        }
        else {
            this.collapsed = this.collapsed || this.collapsedOnDesktop;
        }
        this.handleOpenChange();
    }
    handleClick(e) {
        e.preventDefault();
        if (this.empty() && !formBusy())
            return;
        this.collapsed = !this.collapsed;
    }
    /** It's empty if there are no items or the mode does not match. */
    empty() {
        var _a, _b, _c, _d;
        return !((_c = (_b = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.pagination) === null || _c === void 0 ? void 0 : _c.count) || (((_d = state === null || state === void 0 ? void 0 : state.checkout) === null || _d === void 0 ? void 0 : _d.live_mode) ? (state === null || state === void 0 ? void 0 : state.mode) === 'test' : (state === null || state === void 0 ? void 0 : state.mode) === 'live');
    }
    getSummaryText() {
        var _a, _b;
        // If we have an invoice, show the invoice summary text instead.
        if ((_b = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.invoice) === null || _b === void 0 ? void 0 : _b.id) {
            return this.invoiceSummaryText || wp.i18n.__('Invoice Summary', 'surecart');
        }
        return this.orderSummaryText || wp.i18n.__('Summary', 'surecart');
    }
    renderHeader() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l;
        // busy state
        if ((formBusy() || formLoading()) && !((_c = (_b = (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.line_items) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.length)) {
            return (h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "price", style: { 'width': '70px', 'display': 'inline-block', '--border-radius': '6px' } }), h("sc-skeleton", { slot: "currency", style: { width: '30px', display: 'inline-block' } })));
        }
        return (h("sc-line-item", { style: { '--price-size': 'var(--sc-font-size-x-large)' } }, h("span", { class: "collapse-link", slot: "title", onClick: e => this.handleClick(e), tabIndex: 0, "aria-label": wp.i18n.sprintf(wp.i18n.__('Order Summary %s', 'surecart'), this.collapsed ? wp.i18n.__('collapsed', 'surecart') : wp.i18n.__('expanded', 'surecart')), onKeyDown: e => {
                if (e.key === ' ') {
                    this.handleClick(e);
                    speak(wp.i18n.sprintf(wp.i18n.__('Order Summary %s', 'surecart'), this.collapsed ? wp.i18n.__('collapsed', 'surecart') : wp.i18n.__('expanded', 'surecart')), 'assertive');
                }
            } }, this.getSummaryText(), h("svg", { xmlns: "http://www.w3.org/2000/svg", class: "collapse-link__icon", fill: "none", viewBox: "0 0 24 24", stroke: "currentColor" }, h("path", { "stroke-linecap": "round", "stroke-linejoin": "round", "stroke-width": "2", d: "M19 9l-7 7-7-7" }))), h("span", { slot: "description" }, h("slot", { name: "description" })), ((_d = state.checkout) === null || _d === void 0 ? void 0 : _d.total_amount) !== ((_e = state.checkout) === null || _e === void 0 ? void 0 : _e.amount_due) ? (h("span", { slot: "price", class: { 'price': true, 'price--collapsed': this.collapsed } }, h("sc-format-number", { class: "total-price", type: "currency", currency: (_f = state.checkout) === null || _f === void 0 ? void 0 : _f.currency, value: (_g = state.checkout) === null || _g === void 0 ? void 0 : _g.amount_due }))) : (h("span", { slot: "price", class: { 'price': true, 'price--collapsed': this.collapsed } }, !!((_h = state.checkout) === null || _h === void 0 ? void 0 : _h.total_savings_amount) && (h("sc-format-number", { class: "total-price scratch-price", type: "currency", value: -((_j = state.checkout) === null || _j === void 0 ? void 0 : _j.total_savings_amount) + ((_k = state.checkout) === null || _k === void 0 ? void 0 : _k.total_amount), currency: ((_l = state.checkout) === null || _l === void 0 ? void 0 : _l.currency) || 'usd' })), h("sc-total", { class: "total-price", total: 'total', order: state.checkout })))));
    }
    async handleOpenChange() {
        if (!this.collapsed) {
            this.scShow.emit();
            await stopAnimations(this.body);
            this.body.hidden = false;
            this.body.style.overflow = 'hidden';
            const { keyframes, options } = getAnimation(this.el, 'summary.show');
            await animateTo(this.body, shimKeyframesHeightAuto(keyframes, this.body.scrollHeight), options);
            this.body.style.height = 'auto';
            this.body.style.overflow = 'visible';
        }
        else {
            this.scHide.emit();
            await stopAnimations(this.body);
            this.body.style.overflow = 'hidden';
            const { keyframes, options } = getAnimation(this.el, 'summary.hide');
            await animateTo(this.body, shimKeyframesHeightAuto(keyframes, this.body.scrollHeight), options);
            this.body.hidden = true;
            this.body.style.height = 'auto';
            this.body.style.overflow = 'visible';
        }
    }
    render() {
        return (h("div", { key: '2ae437329482f57d435583148a674b458dd3ef49', class: { 'summary': true, 'summary--open': !this.collapsed } }, this.collapsible && this.renderHeader(), h("div", { key: 'd564d8c19d31812788c1f109f256f3a53e217b7a', ref: el => (this.body = el), class: {
                'summary__content': true,
                'summary__content--empty': this.empty() && !formBusy(),
            } }, h("slot", { key: '28814560b628989d65877253c603d16a064e1c26' })), this.empty() && !formBusy() && h("p", { key: 'fcc3be315d9b0a5f3e297de3926c912460fa4d26', class: "empty" }, wp.i18n.__('Your cart is empty.', 'surecart'))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "collapsed": ["handleOpenChange"]
    }; }
};
setDefaultAnimation('summary.show', {
    keyframes: [
        { height: '0', opacity: '0' },
        { height: 'auto', opacity: '1' },
    ],
    options: { duration: 250, easing: 'ease' },
});
setDefaultAnimation('summary.hide', {
    keyframes: [
        { height: 'auto', opacity: '1' },
        { height: '0', opacity: '0' },
    ],
    options: { duration: 250, easing: 'ease' },
});
ScOrderSummary.style = ScOrderSummaryStyle0;

export { ScOrderSummary as sc_order_summary };

//# sourceMappingURL=sc-order-summary.entry.js.map