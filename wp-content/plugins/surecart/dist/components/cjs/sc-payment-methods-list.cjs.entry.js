'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const lazy = require('./lazy-2b509fa7.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scPaymentMethodsListCss = ":host{display:block;position:relative}.payment-methods-list{display:grid;gap:0.5em}.payment-methods-list sc-heading a{text-decoration:none;font-weight:var(--sc-font-weight-semibold);display:inline-flex;align-items:center;gap:0.25em;color:var(--sc-color-primary-500)}.payment-id{overflow:hidden;white-space:nowrap;text-overflow:ellipsis}";
const ScPaymentMethodsListStyle0 = scPaymentMethodsListCss;

const ScPaymentMethodsList = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.query = undefined;
        this.heading = undefined;
        this.isCustomer = undefined;
        this.canDetachDefaultPaymentMethod = false;
        this.paymentMethods = [];
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
        this.hasTitleSlot = undefined;
        this.editPaymentMethod = false;
        this.deletePaymentMethod = false;
        this.cascadeDefaultPaymentMethod = false;
    }
    /** Only fetch if visible */
    componentWillLoad() {
        lazy.onFirstVisible(this.el, () => this.getPaymentMethods());
        this.handleSlotChange();
    }
    handleSlotChange() {
        this.hasTitleSlot = !!this.el.querySelector('[slot="title"]');
    }
    /**
     * Delete the payment method.
     */
    async deleteMethod() {
        var _a;
        if (!this.deletePaymentMethod)
            return;
        try {
            this.busy = true;
            (await fetch.apiFetch({
                path: `surecart/v1/payment_methods/${(_a = this.deletePaymentMethod) === null || _a === void 0 ? void 0 : _a.id}/detach`,
                method: 'PATCH',
            }));
            // remove from view.
            this.paymentMethods = this.paymentMethods.filter(m => { var _a; return m.id !== ((_a = this.deletePaymentMethod) === null || _a === void 0 ? void 0 : _a.id); });
            this.deletePaymentMethod = false;
        }
        catch (e) {
            alert((e === null || e === void 0 ? void 0 : e.messsage) || wp.i18n.__('Something went wrong', 'surecart'));
        }
        finally {
            this.busy = false;
        }
    }
    /**
     * Set the default payment method.
     */
    async setDefault() {
        var _a, _b, _c;
        if (!this.editPaymentMethod)
            return;
        try {
            this.error = '';
            this.busy = true;
            (await fetch.apiFetch({
                path: `surecart/v1/customers/${(_b = (_a = this.editPaymentMethod) === null || _a === void 0 ? void 0 : _a.customer) === null || _b === void 0 ? void 0 : _b.id}`,
                method: 'PATCH',
                data: {
                    default_payment_method: (_c = this.editPaymentMethod) === null || _c === void 0 ? void 0 : _c.id,
                    cascade_default_payment_method: this.cascadeDefaultPaymentMethod,
                },
            }));
            this.editPaymentMethod = false;
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.busy = false;
        }
        try {
            this.busy = true;
            this.paymentMethods = (await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`surecart/v1/payment_methods/`, {
                    expand: ['card', 'customer', 'billing_agreement', 'paypal_account', 'payment_instrument', 'bank_account'],
                    ...this.query,
                }),
            }));
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.busy = false;
        }
    }
    /** Get all paymentMethods */
    async getPaymentMethods() {
        if (!this.isCustomer) {
            return;
        }
        try {
            this.loading = true;
            this.paymentMethods = (await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`surecart/v1/payment_methods/`, {
                    expand: ['card', 'customer', 'billing_agreement', 'paypal_account', 'payment_instrument', 'bank_account'],
                    ...this.query,
                    per_page: 100,
                }),
            }));
        }
        catch (e) {
            console.error(this.error);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.loading = false;
        }
    }
    renderLoading() {
        return (index.h("sc-card", { noPadding: true }, index.h("sc-stacked-list", null, index.h("sc-stacked-list-row", { style: { '--columns': '4' }, "mobile-size": 500 }, [...Array(4)].map(() => (index.h("sc-skeleton", { style: { width: '100px', display: 'inline-block' } })))))));
    }
    renderEmpty() {
        return (index.h("div", null, index.h("sc-divider", { style: { '--spacing': '0' } }), index.h("slot", { name: "empty" }, index.h("sc-empty", { icon: "credit-card" }, wp.i18n.__("You don't have any saved payment methods.", 'surecart')))));
    }
    renderPaymentMethodActions(paymentMethod) {
        const { id, customer } = paymentMethod;
        // If this is a string, don't show the actions.
        if (typeof customer === 'string')
            return;
        // If this is the default payment method and it cannot be detached, don't show the actions.
        if (customer.default_payment_method === id && !this.canDetachDefaultPaymentMethod)
            return;
        return (index.h("sc-dropdown", { placement: "bottom-end", slot: "suffix" }, index.h("sc-icon", { role: "button", tabIndex: 0, name: "more-horizontal", slot: "trigger" }), index.h("sc-menu", null, customer.default_payment_method !== id && index.h("sc-menu-item", { onClick: () => (this.editPaymentMethod = paymentMethod) }, wp.i18n.__('Make Default', 'surecart')), index.h("sc-menu-item", { onClick: () => (this.deletePaymentMethod = paymentMethod) }, wp.i18n.__('Delete', 'surecart')))));
    }
    renderList() {
        return this.paymentMethods.map(paymentMethod => {
            const { id, card, customer, live_mode, billing_agreement, paypal_account } = paymentMethod;
            return (index.h("sc-stacked-list-row", { style: { '--columns': billing_agreement ? '2' : '3' } }, index.h("sc-payment-method", { paymentMethod: paymentMethod }), index.h("div", { class: "payment-id" }, !!(card === null || card === void 0 ? void 0 : card.exp_month) && (index.h("span", null, wp.i18n.__('Exp.', 'surecart'), card === null || card === void 0 ? void 0 :
                card.exp_month, "/", card === null || card === void 0 ? void 0 :
                card.exp_year)), !!paypal_account && (paypal_account === null || paypal_account === void 0 ? void 0 : paypal_account.email)), index.h("sc-flex", { "justify-content": "flex-start", "align-items": "center", style: { '--spacing': '0.5em', 'marginLeft': 'auto' } }, typeof customer !== 'string' && (customer === null || customer === void 0 ? void 0 : customer.default_payment_method) === id && index.h("sc-tag", { type: "info" }, wp.i18n.__('Default', 'surecart')), !live_mode && index.h("sc-tag", { type: "warning" }, wp.i18n.__('Test', 'surecart'))), this.renderPaymentMethodActions(paymentMethod)));
        });
    }
    renderContent() {
        var _a;
        if (!this.isCustomer) {
            return this.renderEmpty();
        }
        if (this.loading) {
            return this.renderLoading();
        }
        if (((_a = this.paymentMethods) === null || _a === void 0 ? void 0 : _a.length) === 0) {
            return this.renderEmpty();
        }
        return (index.h("sc-card", { "no-padding": true }, index.h("sc-stacked-list", null, this.renderList())));
    }
    handleEditPaymentMethodChange() {
        // reset when payment method edit changes
        this.cascadeDefaultPaymentMethod = false;
    }
    render() {
        return (index.h("sc-dashboard-module", { key: '4c2d389a7640f339a0a2e8971acc4d4e5a6396cf', class: "payment-methods-list", error: this.error }, index.h("span", { key: '499ac2a2d306e1ea84c98aafdc5d49b4717d20cd', slot: "heading" }, index.h("slot", { key: '993d25b876f792c50a1ab41c74379b5c62456ffa', name: "heading" }, this.heading || wp.i18n.__('Payment Methods', 'surecart'))), this.isCustomer && (index.h("sc-flex", { key: 'f4884a81c9042cb60fe4e299880d8aa7c9db7f2d', slot: "end" }, index.h("sc-button", { key: '7ba263b1667ec3a94449a8d1b0b46a03e034f407', type: "link", href: addQueryArgs.addQueryArgs(window.location.href, {
                action: 'index',
                model: 'charge',
            }) }, index.h("sc-icon", { key: 'b871db4e03fefb686f6e71e8fb8dcc5a9b511d18', name: "clock", slot: "prefix" }), wp.i18n.__('Payment History', 'surecart')), index.h("sc-button", { key: 'ebeef8238b15b11aa60df9d7d761cabd9e45f230', type: "link", href: addQueryArgs.addQueryArgs(window.location.href, {
                action: 'create',
                model: 'payment_method',
            }) }, index.h("sc-icon", { key: 'd207eb80c48e7207aea44a27af71c27af107abc5', name: "plus", slot: "prefix" }), wp.i18n.__('Add', 'surecart')))), this.renderContent(), index.h("sc-dialog", { key: '7e2f2f44739ed32333510f0930fa2f47cd01244e', open: !!this.editPaymentMethod, label: wp.i18n.__('Update Default Payment Method', 'surecart'), onScRequestClose: () => (this.editPaymentMethod = false) }, index.h("sc-alert", { key: 'c482ca0b09dbe93c9cc9db4a7a18a5e133213a79', type: "danger", open: !!this.error }, this.error), index.h("sc-flex", { key: '179b64e3800ab92a6c79109ad33338e899d60181', flexDirection: "column", style: { '--sc-flex-column-gap': 'var(--sc-spacing-small)' } }, index.h("sc-alert", { key: '8ee7ae4f067699a6bccb58122153e9deddacad07', type: "info", open: true }, wp.i18n.__('A default payment method will be used as a fallback in case other payment methods get removed from a subscription.', 'surecart')), index.h("sc-switch", { key: 'bbbc6f8cfc9d2fa7ed126a20ac34a9db266a7d47', checked: this.cascadeDefaultPaymentMethod, onScChange: e => (this.cascadeDefaultPaymentMethod = e.target.checked) }, wp.i18n.__('Update All Subscriptions', 'surecart'), index.h("span", { key: 'f2d3ed6827f35fe34a31fbf53daaff32c53a50f5', slot: "description" }, wp.i18n.__('Update all existing subscriptions to use this payment method', 'surecart')))), index.h("div", { key: 'd307179924b8531602b5f6a886c83e81f8f91415', slot: "footer" }, index.h("sc-button", { key: 'e1f357af7f0861e72b8cb02581ac969468239a16', type: "text", onClick: () => (this.editPaymentMethod = false) }, wp.i18n.__('Cancel', 'surecart')), index.h("sc-button", { key: 'fa1f45bb1022a4753a94d0881970dfeb8a71983f', type: "primary", onClick: () => this.setDefault() }, wp.i18n.__('Make Default', 'surecart'))), this.busy && index.h("sc-block-ui", { key: '6a70714c44cbdb2f85d85617c5e19b9abc87fd94', spinner: true })), index.h("sc-dialog", { key: '3cdeb320fcb213100737a8f470d94ed38b03485a', open: !!this.deletePaymentMethod, label: wp.i18n.__('Delete Payment Method', 'surecart'), onScRequestClose: () => (this.deletePaymentMethod = false) }, index.h("sc-alert", { key: 'b372aa4d97b2e6d5b7bfd5a459af035f4ad6519a', type: "danger", open: !!this.error }, this.error), index.h("sc-text", { key: 'e6005f4058ca1bb643253c36e6c5b8f8ab5c5df5' }, wp.i18n.__('Are you sure you want to remove this payment method?', 'surecart')), index.h("div", { key: '90f8211a2373ff182f46a6a20b63fa2fd92347d0', slot: "footer" }, index.h("sc-button", { key: '844190f2c497f4863a3ba56408f107e63653a557', type: "text", onClick: () => (this.deletePaymentMethod = false) }, wp.i18n.__('Cancel', 'surecart')), index.h("sc-button", { key: '2d55d4ab8a5cbf09e202f02e7e94a2f2e69f8726', type: "primary", onClick: () => this.deleteMethod() }, wp.i18n.__('Delete', 'surecart'))), this.busy && index.h("sc-block-ui", { key: '307a3fe39de177d5a41470e3afe03cdbd8833d40', spinner: true })), this.busy && index.h("sc-block-ui", { key: '498adc9f9d6905fe220d3225f92ac11f3fdad312', spinner: true })));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "editPaymentMethod": ["handleEditPaymentMethodChange"]
    }; }
};
ScPaymentMethodsList.style = ScPaymentMethodsListStyle0;

exports.sc_payment_methods_list = ScPaymentMethodsList;

//# sourceMappingURL=sc-payment-methods-list.cjs.entry.js.map