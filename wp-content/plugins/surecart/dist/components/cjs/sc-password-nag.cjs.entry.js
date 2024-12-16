'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scPasswordNagCss = ":host{display:block}";
const ScPasswordNagStyle0 = scPasswordNagCss;

const ScPasswordNag = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.open = true;
        this.type = 'primary';
        this.successUrl = undefined;
        this.set = undefined;
        this.loading = undefined;
        this.error = undefined;
        this.success = undefined;
        this.enableValidation = true;
    }
    handleSetChange() {
        setTimeout(() => {
            this.input && this.input.triggerFocus();
        }, 50);
    }
    /** Dismiss the form. */
    async dismiss() {
        this.loading = true;
        this.error = '';
        try {
            await fetch.apiFetch({
                path: `wp/v2/users/me`,
                method: 'PATCH',
                data: {
                    meta: {
                        default_password_nag: false,
                    },
                },
            });
            this.open = false;
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            this.loading = false;
        }
    }
    validatePassword(password) {
        const regex = new RegExp('^(?=.*?[#?!@$%^&*-]).{6,}$');
        if (regex.test(password))
            return true;
        return false;
    }
    /** Handle password submit. */
    async handleSubmit(e) {
        this.loading = true;
        this.error = '';
        try {
            const { password } = await e.target.getFormJson();
            await fetch.apiFetch({
                path: `wp/v2/users/me`,
                method: 'PATCH',
                data: {
                    password,
                    meta: {
                        default_password_nag: false,
                    },
                },
            });
            this.dismiss();
            this.success = true;
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            this.loading = false;
        }
    }
    render() {
        if (this.success) {
            return (index.h("sc-alert", { type: "success", open: true }, index.h("span", { slot: "title" }, wp.i18n.__('Success!', 'surecart')), wp.i18n.__('You have successfully set your password.', 'surecart')));
        }
        return (index.h(index.Host, { tabindex: 0, "aria-label": wp.i18n.__('You have not yet set a password. Please set a password for your account.', 'surecart') }, index.h("sc-alert", { type: this.type, open: this.open, exportparts: "base, icon, text, title, message, close-icon", style: { position: 'relative' } }, !!this.error && this.error, this.set ? (index.h("sc-dashboard-module", { class: "customer-details" }, index.h("span", { slot: "heading" }, wp.i18n.__('Set A Password', 'surecart'), " "), index.h("sc-button", { type: "text", size: "small", slot: "end", onClick: () => (this.set = false) }, index.h("sc-icon", { name: "x", slot: "prefix" }), wp.i18n.__('Cancel', 'surecart')), index.h("sc-card", null, index.h("sc-form", { onScFormSubmit: e => this.handleSubmit(e) }, index.h("sc-password", { enableValidation: this.enableValidation, label: wp.i18n.__('New Password', 'surecart'), name: "password", confirmation: true, ref: el => (this.input = el), required: true }), index.h("div", null, index.h("sc-button", { type: "primary", full: true, submit: true, busy: this.loading }, wp.i18n.__('Set Password', 'surecart'))))))) : (index.h(index.Fragment, null, index.h("slot", { name: "title", slot: "title" }, wp.i18n.__('Reminder', 'surecart')), index.h("slot", null, wp.i18n.__('You have not yet set a password. Please set a password for your account.', 'surecart')), index.h("sc-flex", { "justify-content": "flex-start" }, index.h("sc-button", { size: "small", type: "primary", onClick: () => (this.set = true) }, wp.i18n.__('Set A Password', 'surecart')), index.h("sc-button", { size: "small", type: "text", onClick: () => this.dismiss() }, wp.i18n.__('Dismiss', 'surecart'))))), this.loading && index.h("sc-block-ui", { spinner: true }))));
    }
    static get watchers() { return {
        "set": ["handleSetChange"]
    }; }
};
ScPasswordNag.style = ScPasswordNagStyle0;

exports.sc_password_nag = ScPasswordNag;

//# sourceMappingURL=sc-password-nag.cjs.entry.js.map