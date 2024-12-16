import { r as registerInstance, h, F as Fragment, H as Host } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';

const scPasswordNagCss = ":host{display:block}";
const ScPasswordNagStyle0 = scPasswordNagCss;

const ScPasswordNag = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
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
            await apiFetch({
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
            await apiFetch({
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
            return (h("sc-alert", { type: "success", open: true }, h("span", { slot: "title" }, wp.i18n.__('Success!', 'surecart')), wp.i18n.__('You have successfully set your password.', 'surecart')));
        }
        return (h(Host, { tabindex: 0, "aria-label": wp.i18n.__('You have not yet set a password. Please set a password for your account.', 'surecart') }, h("sc-alert", { type: this.type, open: this.open, exportparts: "base, icon, text, title, message, close-icon", style: { position: 'relative' } }, !!this.error && this.error, this.set ? (h("sc-dashboard-module", { class: "customer-details" }, h("span", { slot: "heading" }, wp.i18n.__('Set A Password', 'surecart'), " "), h("sc-button", { type: "text", size: "small", slot: "end", onClick: () => (this.set = false) }, h("sc-icon", { name: "x", slot: "prefix" }), wp.i18n.__('Cancel', 'surecart')), h("sc-card", null, h("sc-form", { onScFormSubmit: e => this.handleSubmit(e) }, h("sc-password", { enableValidation: this.enableValidation, label: wp.i18n.__('New Password', 'surecart'), name: "password", confirmation: true, ref: el => (this.input = el), required: true }), h("div", null, h("sc-button", { type: "primary", full: true, submit: true, busy: this.loading }, wp.i18n.__('Set Password', 'surecart'))))))) : (h(Fragment, null, h("slot", { name: "title", slot: "title" }, wp.i18n.__('Reminder', 'surecart')), h("slot", null, wp.i18n.__('You have not yet set a password. Please set a password for your account.', 'surecart')), h("sc-flex", { "justify-content": "flex-start" }, h("sc-button", { size: "small", type: "primary", onClick: () => (this.set = true) }, wp.i18n.__('Set A Password', 'surecart')), h("sc-button", { size: "small", type: "text", onClick: () => this.dismiss() }, wp.i18n.__('Dismiss', 'surecart'))))), this.loading && h("sc-block-ui", { spinner: true }))));
    }
    static get watchers() { return {
        "set": ["handleSetChange"]
    }; }
};
ScPasswordNag.style = ScPasswordNagStyle0;

export { ScPasswordNag as sc_password_nag };

//# sourceMappingURL=sc-password-nag.entry.js.map