import { r as registerInstance, h, F as Fragment } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { p as productNameWithPrice, i as intervalString } from './price-d5770168.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';
import './currency-a0c9bff4.js';

function formatTime(
	s,
	options = {
		timeStyle: 'medium',
		dateStyle: 'full',
	},
	locale = []
) {
	const dtFormat = new Intl.DateTimeFormat(locale, options);
	return dtFormat.format(new Date(s * 1000));
}

const maybeConvertAmount = (amount, currency) => {
	return [
		'BIF',
		'BYR',
		'CLP',
		'DJF',
		'GNF',
		'ISK',
		'JPY',
		'KMF',
		'KRW',
		'PYG',
		'RWF',
		'UGX',
		'VND',
		'VUV',
		'XAF',
		'XAG',
		'XAU',
		'XBA',
		'XBB',
		'XBC',
		'XBD',
		'XDR',
		'XOF',
		'XPD',
		'XPF',
		'XPT',
		'XTS',
	].includes(currency?.toUpperCase())
		? amount
		: amount / 100;
};

const formatNumber = (value, currency = '') =>
	new Intl.NumberFormat([], {
		style: 'currency',
		currency: currency.toUpperCase(),
		currencyDisplay: 'symbol',
	}).format(maybeConvertAmount(value, currency.toUpperCase()));

const scSubscriptionDetailsCss = ":host{display:block}.subscription-details{display:grid;gap:0.25em;color:var(--sc-input-label-color)}.subscription-details__missing-method{display:flex;align-items:center;gap:var(--sc-spacing-x-small)}";
const ScSubscriptionDetailsStyle0 = scSubscriptionDetailsCss;

const ScSubscriptionDetails = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.subscription = undefined;
        this.pendingPrice = undefined;
        this.hideRenewalText = undefined;
        this.activationsModal = undefined;
        this.loading = undefined;
        this.hasPendingUpdate = undefined;
    }
    renderName() {
        var _a, _b, _c;
        if (typeof ((_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.price) === null || _b === void 0 ? void 0 : _b.product) !== 'string') {
            return productNameWithPrice((_c = this.subscription) === null || _c === void 0 ? void 0 : _c.price);
        }
        return wp.i18n.__('Subscription', 'surecart');
    }
    async handleSubscriptionChange() {
        var _a, _b, _c, _d;
        this.hasPendingUpdate = !!((_b = Object.keys(((_a = this === null || this === void 0 ? void 0 : this.subscription) === null || _a === void 0 ? void 0 : _a.pending_update) || {})) === null || _b === void 0 ? void 0 : _b.length);
        if (((_d = (_c = this === null || this === void 0 ? void 0 : this.subscription) === null || _c === void 0 ? void 0 : _c.pending_update) === null || _d === void 0 ? void 0 : _d.price) && !(this === null || this === void 0 ? void 0 : this.pendingPrice) && !this.hideRenewalText) {
            this.pendingPrice = await this.fetchPrice(this.subscription.pending_update.price);
        }
    }
    componentWillLoad() {
        this.handleSubscriptionChange();
    }
    async fetchPrice(price_id) {
        try {
            this.loading = true;
            const price = await apiFetch({
                path: addQueryArgs(`surecart/v1/prices/${price_id}`, {
                    expand: ['product'],
                }),
            });
            return price;
        }
        catch (e) {
            console.error(e);
        }
        finally {
            this.loading = false;
        }
    }
    renderRenewalText() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u, _v, _w, _x, _y, _z;
        const tag = h("sc-subscription-status-badge", { subscription: this === null || this === void 0 ? void 0 : this.subscription });
        if (((_a = this === null || this === void 0 ? void 0 : this.subscription) === null || _a === void 0 ? void 0 : _a.cancel_at_period_end) && ((_b = this === null || this === void 0 ? void 0 : this.subscription) === null || _b === void 0 ? void 0 : _b.current_period_end_at)) {
            return (h("span", { "aria-label": wp.i18n.sprintf(wp.i18n.__('Renewal Update - Your plan will be canceled on %s', 'surecart'), formatTime(this.subscription.current_period_end_at)) }, tag, " ", wp.i18n.sprintf(wp.i18n.__('Your plan will be canceled on', 'surecart')), ' ', h("sc-format-date", { date: this.subscription.current_period_end_at * 1000, month: "long", day: "numeric", year: "numeric" })));
        }
        if (this.hasPendingUpdate) {
            if (!this.pendingPrice && !((_d = (_c = this.subscription) === null || _c === void 0 ? void 0 : _c.pending_update) === null || _d === void 0 ? void 0 : _d.ad_hoc_amount)) {
                return h("sc-skeleton", null);
            }
            if ((_f = (_e = this.subscription) === null || _e === void 0 ? void 0 : _e.pending_update) === null || _f === void 0 ? void 0 : _f.ad_hoc_amount) {
                return (h("span", { "aria-label": wp.i18n.sprintf(wp.i18n.__('Renewal Update - Your plan switches to %1$s on %2$s', 'surecart'), formatNumber((_h = (_g = this.subscription) === null || _g === void 0 ? void 0 : _g.pending_update) === null || _h === void 0 ? void 0 : _h.ad_hoc_amount, ((_j = this.pendingPrice) === null || _j === void 0 ? void 0 : _j.currency) || ((_l = (_k = this.subscription) === null || _k === void 0 ? void 0 : _k.price) === null || _l === void 0 ? void 0 : _l.currency)), formatTime(this.subscription.current_period_end_at)) }, wp.i18n.__('Your plan switches to', 'surecart'), ' ', h("strong", null, h("sc-format-number", { type: "currency", currency: ((_m = this.pendingPrice) === null || _m === void 0 ? void 0 : _m.currency) || ((_p = (_o = this.subscription) === null || _o === void 0 ? void 0 : _o.price) === null || _p === void 0 ? void 0 : _p.currency), value: (_r = (_q = this.subscription) === null || _q === void 0 ? void 0 : _q.pending_update) === null || _r === void 0 ? void 0 : _r.ad_hoc_amount }), ' ', intervalString(this.pendingPrice || ((_s = this.subscription) === null || _s === void 0 ? void 0 : _s.price))), ' ', wp.i18n.__('on', 'surecart'), ' ', h("sc-format-date", { date: this.subscription.current_period_end_at, type: "timestamp", month: "long", day: "numeric", year: "numeric" })));
            }
            return (h("span", { "aria-label": wp.i18n.sprintf(wp.i18n.__('Renewal Update - Your plan switches to %1$s on %2$s', 'surecart'), this.pendingPrice.product.name, formatTime(this.subscription.current_period_end_at)) }, wp.i18n.__('Your plan switches to', 'surecart'), " ", h("strong", null, this.pendingPrice.product.name), " ", wp.i18n.__('on', 'surecart'), ' ', h("sc-format-date", { date: this.subscription.current_period_end_at, type: "timestamp", month: "long", day: "numeric", year: "numeric" })));
        }
        if (((_t = this === null || this === void 0 ? void 0 : this.subscription) === null || _t === void 0 ? void 0 : _t.status) === 'trialing' && ((_u = this === null || this === void 0 ? void 0 : this.subscription) === null || _u === void 0 ? void 0 : _u.trial_end_at)) {
            return (h("span", { "aria-label": wp.i18n.sprintf(wp.i18n.__('Renewal Update - Your plan begins on %s.', 'surecart'), formatTime(this.subscription.trial_end_at)) }, tag, " ", wp.i18n.sprintf(wp.i18n.__('Your plan begins on', 'surecart')), ' ', h("sc-format-date", { date: (_v = this === null || this === void 0 ? void 0 : this.subscription) === null || _v === void 0 ? void 0 : _v.trial_end_at, type: "timestamp", month: "long", day: "numeric", year: "numeric" })));
        }
        if (((_w = this.subscription) === null || _w === void 0 ? void 0 : _w.status) === 'active' && ((_x = this.subscription) === null || _x === void 0 ? void 0 : _x.current_period_end_at)) {
            return (h("span", { "aria-label": wp.i18n.sprintf(wp.i18n.__('Renewal Update - Your next payment is on %s', 'surecart'), formatTime(this.subscription.current_period_end_at)) }, tag, " ", ((_y = this.subscription) === null || _y === void 0 ? void 0 : _y.remaining_period_count) === null ? wp.i18n.__('Your plan renews on', 'surecart') : wp.i18n.__('Your next payment is on', 'surecart'), ' ', h("sc-format-date", { date: (_z = this === null || this === void 0 ? void 0 : this.subscription) === null || _z === void 0 ? void 0 : _z.current_period_end_at, type: "timestamp", month: "long", day: "numeric", year: "numeric" })));
        }
        return tag;
    }
    getActivations() {
        var _a, _b, _c, _d;
        return (((_d = (_c = (_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.purchase) === null || _b === void 0 ? void 0 : _b.license) === null || _c === void 0 ? void 0 : _c.activations) === null || _d === void 0 ? void 0 : _d.data) || []).filter(activation => {
            return activation === null || activation === void 0 ? void 0 : activation.counted;
        });
    }
    renderActivations() {
        var _a;
        const activations = this.getActivations();
        if (!(activations === null || activations === void 0 ? void 0 : activations.length))
            return null;
        return (h("sc-flex", { justifyContent: "flex-start", alignItems: "center" }, h("sc-tag", { size: "small" }, (_a = activations === null || activations === void 0 ? void 0 : activations[0]) === null || _a === void 0 ? void 0 : _a.name), (activations === null || activations === void 0 ? void 0 : activations.length) > 1 && (h("sc-text", { style: { '--font-size': 'var(--sc-font-size-small)', 'cursor': 'pointer' }, onClick: e => {
                e.preventDefault();
                e.stopImmediatePropagation();
                this.activationsModal = true;
            } }, "+ ", (activations === null || activations === void 0 ? void 0 : activations.length) - 1, " More"))));
    }
    showWarning() {
        var _a, _b, _c, _d, _e, _f, _g;
        // no payment method.
        if (((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.payment_method) || this.subscription.manual_payment) {
            return false;
        }
        // don't show if not looking for payment.
        if (!['active', 'past_due', 'unpaid', 'incomplete'].includes((_b = this.subscription) === null || _b === void 0 ? void 0 : _b.status)) {
            return false;
        }
        // handle ad_hoc.
        if ((_d = (_c = this.subscription) === null || _c === void 0 ? void 0 : _c.price) === null || _d === void 0 ? void 0 : _d.ad_hoc) {
            return ((_e = this.subscription) === null || _e === void 0 ? void 0 : _e.ad_hoc_amount) !== 0;
        }
        // show the warning if the subscription is not free.
        return ((_g = (_f = this.subscription) === null || _f === void 0 ? void 0 : _f.price) === null || _g === void 0 ? void 0 : _g.amount) !== 0;
    }
    render() {
        return (h("div", { key: 'b36abe13480088de76ca6316f718a3e57fe30460', class: "subscription-details" }, this.hasPendingUpdate && (h("div", { key: '579bb7fb96b8ccc7affd6aeab3721c378f9eedb2' }, h("sc-tag", { key: '13af9cd0198606d4dae16383f2f7da5be4c1b956', size: "small", type: "warning" }, wp.i18n.__('Update Scheduled', 'surecart')))), h("sc-flex", { key: '73608895b32a191b388c10fd42901053e679bda3', alignItems: "center", justifyContent: "flex-start" }, h("sc-text", { key: '037006c291a1dcb4b14c3cdf1afd6e940f361eba', "aria-label": wp.i18n.sprintf(wp.i18n.__('Plan name - %s', 'surecart'), this.renderName()), style: { '--font-weight': 'var(--sc-font-weight-bold)' } }, this.renderName()), this.renderActivations()), !this.hideRenewalText && h("div", { key: '3fa3d2b627e068310a583d97b00a3ce300cd4c8c' }, this.renderRenewalText(), " "), h("slot", { key: '165e93dbc2aa65ffdd093bf5f413aa09b3011310' }), h("sc-dialog", { key: '24c0e4e7157a4f8ac1875cc169a0bfe782f7d2b3', label: wp.i18n.__('Activations', 'surecart'), onScRequestClose: () => (this.activationsModal = false), open: !!this.activationsModal }, h("sc-card", { key: '89b8147fa47934c1dc4f13a71378f4930abd6704', "no-padding": true, style: { '--overflow': 'hidden' } }, h("sc-stacked-list", { key: '1fd44c8cc0e78d728837a68e1812f9b95c59e5d4' }, (this.getActivations() || []).map(activation => {
            return (h("sc-stacked-list-row", { style: { '--columns': '2' }, mobileSize: 0 }, h("sc-text", { style: { '--line-height': 'var(--sc-line-height-dense)' } }, h("strong", null, activation === null || activation === void 0 ? void 0 : activation.name), h("div", null, h("sc-text", { style: { '--color': 'var(--sc-color-gray-500)' } }, activation === null || activation === void 0 ? void 0 : activation.fingerprint))), h("sc-text", { style: { '--color': 'var(--sc-color-gray-500)' } }, h("sc-format-date", { type: "timestamp", month: "short", day: "numeric", year: "numeric", date: activation === null || activation === void 0 ? void 0 : activation.created_at }))));
        })))), this.showWarning() && (h("div", { key: '9150a04f32fcf63527712d83d787ab95cfcd935f' }, h("sc-tag", { key: '5bbc7131e1ec3485529dbe91f03f3941c8cda449', type: "warning" }, h("div", { key: 'f8b38c1fe9198c4d48c854cc1462ddbd922d0d84', class: "subscription-details__missing-method" }, h("sc-icon", { key: 'ac9059aa2b58a2d0e8ea7d8276e2642832db78f9', name: "alert-triangle" }), wp.i18n.__('Payment Method Missing', 'surecart')))))));
    }
    static get watchers() { return {
        "subscription": ["handleSubscriptionChange"]
    }; }
};
ScSubscriptionDetails.style = ScSubscriptionDetailsStyle0;

const scSubscriptionStatusBadgeCss = ":host{display:inline-block}";
const ScSubscriptionStatusBadgeStyle0 = scSubscriptionStatusBadgeCss;

const ScSubscriptionStatusBadge = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.status = undefined;
        this.subscription = undefined;
        this.size = 'medium';
        this.pill = false;
        this.clearable = false;
    }
    getType() {
        var _a, _b, _c;
        if ((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.cancel_at_period_end) {
            return 'info';
        }
        switch (this.status || ((_b = this.subscription) === null || _b === void 0 ? void 0 : _b.status)) {
            case 'incomplete':
                return 'warning';
            case 'trialing':
                return 'info';
            case 'active':
                return 'success';
            case 'completed':
                return 'success';
            case 'past_due':
                return 'warning';
            case 'canceled':
                if ((_c = this.subscription) === null || _c === void 0 ? void 0 : _c.restore_at) {
                    return 'info';
                }
                return 'danger';
            case 'unpaid':
                return 'warning';
        }
    }
    getText() {
        var _a, _b, _c, _d, _e;
        if (((_a = this.subscription) === null || _a === void 0 ? void 0 : _a.cancel_at_period_end) && this.subscription.current_period_end_at && ((_b = this.subscription) === null || _b === void 0 ? void 0 : _b.status) !== 'canceled') {
            return (h(Fragment, null, !!((_c = this.subscription) === null || _c === void 0 ? void 0 : _c.restore_at) ? wp.i18n.__('Pauses', 'surecart') : wp.i18n.__('Cancels', 'surecart'), ' ', h("sc-format-date", { type: "timestamp", date: this.subscription.current_period_end_at, month: "short", day: "numeric" })));
        }
        switch (this.status || ((_d = this.subscription) === null || _d === void 0 ? void 0 : _d.status)) {
            case 'incomplete':
                return wp.i18n.__('Incomplete', 'surecart');
            case 'trialing':
                return wp.i18n.__('Trialing', 'surecart');
            case 'active':
                return wp.i18n.__('Active', 'surecart');
            case 'past_due':
                return wp.i18n.__('Past Due', 'surecart');
            case 'canceled':
                if ((_e = this.subscription) === null || _e === void 0 ? void 0 : _e.restore_at) {
                    return 'Paused';
                }
                return wp.i18n.__('Canceled', 'surecart');
            case 'completed':
                return wp.i18n.__('Completed', 'surecart');
            case 'unpaid':
                return wp.i18n.__('Unpaid', 'surecart');
        }
    }
    render() {
        return (h("sc-tag", { key: 'a9f516f11c01753465954c777e5fc01ace3f4920', "aria-label": wp.i18n.sprintf(wp.i18n.__('Plan Status - %s', 'surecart'), this.getText()), type: this.getType() }, this.getText()));
    }
};
ScSubscriptionStatusBadge.style = ScSubscriptionStatusBadgeStyle0;

export { ScSubscriptionDetails as sc_subscription_details, ScSubscriptionStatusBadge as sc_subscription_status_badge };

//# sourceMappingURL=sc-subscription-details_2.entry.js.map